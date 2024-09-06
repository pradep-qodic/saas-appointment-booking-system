var weekEnds=[];
$(document).ready(function() {
	
	$("#btnAddAppointment").click(function(){
		addAppointment();
	});
	$("#btnCancelApp").click(function(){
		cancelAppointment();
	});
	$('body').on("change","#dateAvailableSlots",function() {
		$("#startdate").val("");
		$("#startdate").val($("#date").val()+" "+this.value);
	});
	$('body').on("change","#bPages",function() {
		$("#pageId").val(this.value);
	});
	$("#calendar").on("click",".fc-basicWeek-button",function(){
		$(this).fullCalendar('destroy');
		fullCal('basicWeek');
	});
	$("#calendar").on("click",".fc-basicDay",function(){
		$(this).fullCalendar('destroy')
		fullCal('basicDay');
	});
	$("body").on("click","#btnAddHoliday",function(){
		addHoliday($(this).attr('data-dt'),$("#MasterCalId").val());
	});
	$("body").on("click","#btnSetUnavailable",function(){
		//addHoliday($(this).attr('data-dt'));
		$("#divUnavailability").toggle('slow');
	});
	$("body").on("click","#btnMarkUnavailable",function(){
		markUnavailable($(this).attr('data-dt'),$("select#bPagesForUnavailable option:selected").val());
	});
	$("body").on("click","#btnRemoveHoliday",function(){
		removeHoliday($(this).attr('data-id'),$("#MasterCalId").val());
	});
	$("body").on("click","#btnSetAvailable",function(){
		removeHoliday($(this).attr('data-id'));
	});
	$('#date').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
	});
	$('#date').datepicker().on('changeDate', function(e){
		loadTimeSlots($('#date').val());
    });
	/*$('#durationpicker').on("change.bfhtimepicker",function(e){
		
    });*/
	/*$('#duration').timepicker({
        'timeFormat': 'HH:mm',
        currentText: "Now",
        closeText:"Close",
        timeOnlyTitle: "Select Time (24-Hour)",
        timeText: "Time",
        hourText: "Hour",
        minuteText: "Minutes",
       
	});*/
	
	fullCal('month');
	
	
	$("body").on("click",".timesClass",function(){
		$('.popover').remove(); 
	});
	
});

function showTimeZoneModal(){
	$('#TimezoneModel').modal({
		show:true,
		backdrop: false,
		keyboard:false
	});
	$("select[name='timezones']").attr('class','form-control');
	$("#fade").fadeIn();
	$("#calendar").html("<h2 id='loadingCal' class='text-center'>Loading Calendar...<span class='fa fa-cog fa-spin'></span></h2>");
}
function loadTimeSlots(DATE){
	var timezn="";
	var id=$("select#bPages option:selected").val();
	timezn=$("#timezone").val();
	var token=$("#authToken").val();
	$.ajax({
        type:"post",
        data:{selected_date:DATE,pageId:id,timezone:timezn},
        url: $("#current_url").val()+'loadTimeSlots',
        beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
        success: function(data){
			$("#dateAvailableSlots").html("");
			if(data.status=="error"){
                $("#AppointmentEMsg").html(data.message);
                $('#AppointmentError').fadeIn().delay(5000).fadeOut();
				$("#dateAvailableSlots").html('<option>No slots available for this day.</option>');
				return;
			}
			if(data.data.slots.length>0){
				/*$("#dateAvailableSlots").append("<b><h4 style='margin-bottom:20px;font-size: 15px;' id='sDate' dt='"+data.data.selectedDate+"'>Availability for "+data.data.availability+"</h4></b>");*/
				$("#dateAvailableSlots").html('<option>Select Slot</option>');
				for(var i=0;i<data.data.slots.length;i++){
					$("#dateAvailableSlots").append("<option value='"+data.data.slots[i]+"'>"+data.data.slots[i]+"</option>");
				}
			}
			
        }
    });
}
function replaceQueryParam(param, newval, search) {
    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?")
    var query = search.replace(regex, "$1").replace(/&$/, '')
    return (query.length > 2 ? query + "&" : "?") + param + "=" + newval
 }
function addAppointment(){
	var d = $("#frmAppointment").serializeArray();
	$("#btnAppointmentLoader").fadeIn();
	$("#btnAddAppointment").prop("disabled",true);
	var token=$("#authToken").val();
	$.ajax({
        type:"post",
        data:d,
        url: $("#current_url").val()+'updateAppointment',
        beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
        success: function(data){
            if(data.status=="success"){
            	$("#btnAppointmentLoader").fadeOut();
                $("#AppointmentSMsg").html(data.message);
				$("#btnAddAppointment").prop("disabled",false);
				$("#redirectionMsg").fadeIn();
				$("#redirectionTime").html(data.data.redirectionTime+" sec");
                $('#AppointmentSuccess').fadeIn().delay(3000).fadeOut(function(){$("#btnAddAppointment").remove();});
                var newUrl=data.data.redirectionUrl + replaceQueryParam('appointmentId', data.data.appointmentId, window.location.search);
                if(data.data.redirectionUrl){
                	window.setTimeout(function() {
                		window.location.href = newUrl;
                        // window.location.href = data.data.redirectionUrl;
                         //window.parent.postMessage(data.data.redirectionUrl, '*');
                    }, parseInt(data.data.redirectionTime) * 1000);
                }
            }
			if(data.status=="error"){
				$("#btnAppointmentLoader").fadeOut();
                $("#AppointmentEMsg").html(data.message);
				$("#btnAddAppointment").prop("disabled",false);
                $('#AppointmentError').fadeIn().delay(3000).fadeOut();
			}
			$("#btnAppointmentLoader").fadeOut();
			$("#btnAddAppointment").prop("disabled",false);
        }
    });
}
function cancelAppointment(){
	$("#btnAppointmentLoader").fadeIn();
	$("#btnCancelApp").prop("disabled",true);
	$("#btnAddAppointment").prop("disabled",true);
	var notif=$("select#sendNotif option:selected").val();
	var token=$("#authToken").val();
	var pid=$("#pageId").val();
	var id=$("#appId").val();
	$.ajax({
        type:"post",
        data:{pageId:pid,appId:id,sendNotif:notif},
        url: $("#current_url").val()+'cancelAppointment',
        beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
        success: function(data){
            if(data.status=="success"){
            	$("#btnAppointmentLoader").fadeOut();
            	$("#btnCancelApp").prop("disabled",false);
            	$("#btnAddAppointment").prop("disabled",false);
                $("#AppointmentSMsg").html(data.message);
				$("#redirectionMsg").fadeIn();
				$("#redirectionTime").html(data.data.redirectionTime+" sec");
                $('#AppointmentSuccess').fadeIn().delay(3000).fadeOut(function(){$("#btnAddAppointment").remove();});
                var newUrl=data.data.redirectionUrl + replaceQueryParam('appointmentId', data.data.appointmentId, window.location.search);
                if(data.data.redirectionUrl){
                	window.setTimeout(function() {
                		window.location.href = newUrl;
                        // window.location.href = data.data.redirectionUrl;
                         //window.parent.postMessage(data.data.redirectionUrl, '*');
                    }, parseInt(data.data.redirectionTime) * 1000);
                }
            }
			if(data.status=="error"){
				$("#btnAppointmentLoader").fadeOut();
                $("#AppointmentEMsg").html(data.message);
                $("#btnCancelApp").prop("disabled",false);
                $("#btnAddAppointment").prop("disabled",false);
                $('#AppointmentError').fadeIn().delay(3000).fadeOut();
			}
			
        }
    });
}
function fullCal(view){
	var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
	$("#loadingCal").remove();
	$('#calendar').fullCalendar('destroy');
	$('#calendar').fullCalendar({
		theme:true,
		defaultView:view,
		themeButtonIcons:false,
		height:'auto',
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		disableDragging: true,
		selectable:true,
		firstDay:1,
		dayClick: function(date, jsEvent, view) {
			$('.popover').remove(); 
			if(new Date(date.format()) >= new Date(y+"/"+(m+1)+"/"+d) && $('.fc-day[data-date="' + date.format() + '"]').attr("holiday") !="true" && $('.fc-day[data-date="' + date.format() + '"]').attr("weekends") !="true"){
				var unavailability='';
				var isUnavai=$("#allowSetUnavailability").val();
				if(isUnavai=='true')
					unavailability='<div><button id="btnSetUnavailable" data-dt="'+date.format()+'" class="btn btn-primary">Set unavailability</button></div>'+
						'<div style="margin-top:5px;display:none;" id="divUnavailability"><select class="form-control" id="bPagesForUnavailable"></select><button class="btn btn-danger" data-dt="'+date.format()+'" style="margin-top:5px;" id="btnMarkUnavailable">mark as unavailable</button></div>';
				var popupHTML='<div class="alert alert-success alert-dismissible" role="alert" id="markUnavailableMsgSuccess" style="display:none;">'+
				'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
				'<strong>Success !!!</strong> <span id="markUnavailableMsg"></span>'+
				'</div><div><a href="#" class="timesClass"><span class="fa fa-times pull-right"></span></a><br>'+
				'<div><button id="btnAddHoliday" data-dt="'+date.format()+'" class="btn btn-primary">Set as holiday</button></div>&nbsp;'+
				unavailability+
				'</div>';
				$(this).popover({
					title:'Set unavailability',
					content:popupHTML,
		            container:'body',
					placement:"top",
					html:true,
				}).popover('show');
			}
			if($('.fc-day[data-date="' + date.format() + '"]').attr("holiday") =="true"){
				var hId=$(this).attr('data-hid');
				var unavailability='';
				var isUnavai=$("#allowSetUnavailability").val();
				if(isUnavai=='true')
					unavailability='<div><button id="btnSetAvailable" data-id="'+hId+'" class="btn btn-danger">Mark as available</button></div>';
				var popupHTML='<div class="alert alert-success alert-dismissible" role="alert" id="markAvailableMsgSuccess" style="display:none;">'+
				'<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
				'<strong>Success !!!</strong> <span id="markAvailableMsg"></span>'+
				'</div><div><a href="#" class="timesClass"><span class="fa fa-times pull-right"></span></a><br>'+
				'<div><button id="btnRemoveHoliday" data-id="'+hId+'" class="btn btn-danger">Remove holiday</button></div>&nbsp;'+
				unavailability+
				'</div>';
				$(this).popover({
					title:'Set availability',
					content:popupHTML,
		            container:'body',
					placement:"top",
					html:true,
				}).popover('show');
			}
			loadbPages($("#MasterCalId").val());
		},
		eventClick: function(calEvent, jsEvent, view) {
	        /*alert('Event: ' + calEvent.title);
	        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
	        alert('View: ' + view.name);*/
			getAppointmentInfo(calEvent.id);
			$("#date").val('');
			$("#dateAvailableSlots").html('<option>No Slots</option>');
			$('#appointmentDetailsModel').modal('show');
	    },
	    eventMouseover :function( event, jsEvent, view ) { 
	    	$(this).css("cursor","pointer");
	    },
		dayRender: function (date, cell) {
			$("#calendar .fc-day.fc-past").css('background',"#ebebeb");
		},
		eventSources: [
        // your event source
        {
			events: orgHolidays,
            color: '#ebebeb',     // an option!
            textColor: 'black', // an option!
        },
        /*{
			events: resourceNotWorkingDays,
            color: '#ebebeb',     // an option!
            textColor: 'black', // an option!
        },*/
        ,
        {
        	events:loadCalConfirmAppointments,
        	color: '#5cb85c',     // an option!
            textColor: 'white', // an option!
        	editable: false,
        },
        {
        	events:loadCalCancelAppointments,
        	color: '#d9534f',     // an option!
            textColor: 'white', // an option!
        	editable: false,
        },
        {
        	events:loadCalPendingAppointments,
        	color: '#5bc0de',     // an option!
            textColor: 'black', // an option!
        	editable: false,
        }
    ]
	});
	$(".fc-center>h2").css("font-size","13px");
	$(".fc-center>h2").css("margin-top","5px");
	$("#fade").fadeOut();
	//$('#showAppointments').remove();
	$('#showAvailability').remove();
	$('#showUnavailability').remove();
	$('#allowAppointmentEdit').remove();
	$('#allowCancel').remove();
	//$('#allowSetUnavailability').remove();
}

function betweenDates(start,end){
	var d = start.substr(8, 2);
	var m = start.substr(5, 2) - 1;
	var y = start.substr(0, 4);
	
	var d1 = end.substr(8, 2);
	var m1 = end.substr(5, 2) - 1;
	var y1 = end.substr(0, 4);
	var currentDate = new Date(y, m, d),
        between = []
    ;
		
    while (new Date(y, m, d) <= new Date(y1, m1, d1)) {
		var date = new Date(currentDate);
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		var p=m+1;
		if(p<10){
			p="0"+p;
		}
		if(d<10){
			d="0"+d;
		}
		
        between.push(y+"-"+p+"-"+d);
        currentDate.setDate(currentDate.getDate() + 1);
    }
   return between;
}
function orgHolidays(start, end, timezone, callback) {
	var token=$("#authToken").val();
	$.ajax({
		url: $("#loadHolidayURL").val(),
		beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
		type:"post",
		data:{},
		success: function(data) {
			holidays=data.data.holidays;
			if(holidays.length>0){
				for(var i=0;i<holidays.length;i++){
					var bDates=betweenDates(holidays[i].start,holidays[i].end);
					bDates.pop();
					for(var j=0;j<bDates.length;j++){
						$('.fc-day[data-date="' + bDates[j] + '"]').css('background',"#ebebeb");
						$('.fc-day[data-date="' + bDates[j] + '"]').attr("holiday","true");
						$('.fc-day[data-date="' + bDates[j] + '"]').attr("data-hid",holidays[i].id);
					}
				}
			}
			callback();
		}
	});
}

function resourceNotWorkingDays(start, end, timezone, callback) {
	var id=$("#MasterCalId").val();
	var token=$("#authToken").val();
	$.ajax({
		url: $("#current_url").val()+'loadPageNotWorkingDays',
		type:"post",
		beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
		data:{pageId:id},
		success: function(data) {
			if(data.status=='success'){
				orgNotWorking=data.data.notWorkingDays;
				weekEnds=orgNotWorking;
				if(weekEnds && weekEnds.length>0){
					for(var i=0;i<weekEnds.length;i++) {
						var day=weekEnds[i];
						var dayVal = day.substring(0, 3);
						$('.fc-day.fc-'+dayVal+'').css('background',"#ebebeb");
						$('.fc-day.fc-'+dayVal+'').attr("weekends","true");
					};
				}
				callback();
			}
		}
	});
}

function loadCalConfirmAppointments(start, end, timezone, callback) {
	var pId=$("#MasterCalId").val();
	var token=$("#authToken").val();
	var showAppointments=$("#showAppointments").val();
	if(showAppointments=='true'){
		$.ajax({
			url: $("#current_url").val()+'/loadMasterPageAppointments/Confirm',
			type:"post",
			beforeSend: function (xhr) {
				xhr.setRequestHeader ("Authorization", "Basic "+token);
			},
			data:{pageId:pId},
			success: function(data) {
				appointments=data.data.appointments;
				callback(appointments);
			}
		});
	}
	
}
function loadCalCancelAppointments(start, end, timezone, callback) {
	var pId=$("#MasterCalId").val();
	var token=$("#authToken").val();
	var showAppointments=$("#showAppointments").val();
	if(showAppointments=='true'){
		$.ajax({
			url: $("#current_url").val()+'/loadMasterPageAppointments/Cancel',
			type:"post",
			beforeSend: function (xhr) {
				xhr.setRequestHeader ("Authorization", "Basic "+token);
			},
			data:{pageId:pId},
			success: function(data) {
				appointments=data.data.appointments;
				callback(appointments);
			}
		});
	}
	
}
function loadCalPendingAppointments(start, end, timezone, callback) {
	var pId=$("#MasterCalId").val();
	var token=$("#authToken").val();
	var showAppointments=$("#showAppointments").val();
	if(showAppointments=='true'){
		$.ajax({
			url: $("#current_url").val()+'/loadMasterPageAppointments/Pending',
			type:"post",
			beforeSend: function (xhr) {
				xhr.setRequestHeader ("Authorization", "Basic "+token);
			},
			data:{pageId:pId},
			success: function(data) {
				appointments=data.data.appointments;
				callback(appointments);
			}
		});
	}
	
}
function getAppointmentInfo(id){
	var token=$("#authToken").val();
	$.ajax({
		url: $("#current_url").val()+'/getAppointmentInfo',
		type:"post",
		beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
		data:{appId:id},
		success: function(data) {
			appointment=data.data.appInfo;
			$("#appId").val(id);
			$("#pageId").val(appointment[0].calendarId);
			$("#timezone").val(appointment[0].app_timezone);
			$("#title").val(appointment[0].app_title);
			$("#name").val(appointment[0].applicant_name);
			$("#email").val(appointment[0].applicant_email);
			$("#phone").val(appointment[0].applicant_phone);
			$("#location").val(appointment[0].applicant_location);
			$("#desc").val(appointment[0].app_desc);
			$("#appStatus").val(appointment[0].isApproved);
			$("#startdate").val(appointment[0].app_start);
		}
	});
}
function addHoliday(dt,id){
	var token=$("#authToken").val();
	$.ajax({
		url: $("#current_url").val()+'/addHoliday',
		type:"post",
		beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
		data:{/*hpageId:id,*/date:dt},
		success: function(data) {
			$("#markUnavailableMsg").html(data.message);
			$('#markUnavailableMsgSuccess').fadeIn().delay(3000).fadeOut(function(){
				$("#btnAddAppointment").remove();
				$("#calendar").fullCalendar('destroy');
				fullCal('month');
				$('.popover').remove();
			});
		}
	});
}
function markUnavailable(dt,id){
	var token=$("#authToken").val();
	$.ajax({
		url: $("#current_url").val()+'/markUnavailable',
		type:"post",
		beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
		data:{hpageId:id,date:dt},
		success: function(data) {
			$("#markUnavailableMsg").html(data.message);
			$('#markUnavailableMsgSuccess').fadeIn().delay(3000).fadeOut(function(){
				$("#btnAddAppointment").remove();
				$("#calendar").fullCalendar('destroy');
				fullCal('month');
				$('.popover').remove();
			});
			 
			
		}
	});
}
function removeHoliday(ID){
	var token=$("#authToken").val();
	var url=$("#current_url").val();
	$.ajax({
        type:"post",
        data:{hId:ID},
        beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
        url: url+'/removeHoliday',
        success: function(data){
            if(data.status=="success"){
            	$("#markAvailableMsg").html(data.message);
    			$('#markAvailableMsgSuccess').fadeIn().delay(3000).fadeOut(function(){
    				$("#btnAddAppointment").remove();
    				$("#calendar").fullCalendar('destroy');
    				fullCal('month');
    				$('.popover').remove();
    			});
            }
			
        }
    });
}
function loadbPages(id){
	var token=$("#authToken").val();
	var url=$("#current_url").val();
	$.ajax({
        type:"post",
        data:{mCalId:id},
        beforeSend: function (xhr) {
			xhr.setRequestHeader ("Authorization", "Basic "+token);
		},
        url: url+'/loadMasterBookingPagePages',
        success: function(data){
            if(data.status=="success"){
            	$("#bPagesForUnavailable").html("");
            	for(var i=0;i<data.data.bookingPages.length;i++){
            		$("#bPagesForUnavailable").append("<option value='"+data.data.bookingPages[i][0].org_user_id+"'>"+data.data.bookingPages[i][0].booking_url+"</option>");
            	}
            	
            }
			
        }
    });
}