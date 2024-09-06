var weekEnds=[];
$(document).ready(function() {
	$("#orgslots").html("<h3>Click on dates in white cells to see available times</h3><i class='fa fa-reply fa-4x fa-flip-vertical'></i>");
	
	$("#btnAddAppointment").click(function(){
		addAppointment();
	});
	$('body').on("change","input[type=radio][name=slt]",function() {
		$("#startdate").val("");
		$("#startdate").val($("#sDate").attr("dt")+" "+this.value);
		getTime($("#sDate").attr("dt")+" "+this.value,$("#slotsGap").val());
	});
	
	$("#btnNextStep").click(function(){
		$("#startdate").val();
		var saveChecked={};
		saveChecked.isChecked=[];
		$("#orgslots input:radio").each(function(){
			var $this = $(this);
			if($this.is(":checked")){
				saveChecked.isChecked.push($this.val());
			}
		});
		if(saveChecked.isChecked.length==0){
			$("#TimeEMsg").html("Please select a time.");
			$('#TimeError').fadeIn().delay(3000).fadeOut();
			return;
		}
		$("#containerAppointmentRow").hide();
		$("#appointmentLoader").fadeIn();
		setTimeout(function(){
			$("#appointmentLoader").fadeOut();
			$("#containerAppointmentRow").fadeIn();
		}, 500);
		$("#middleSide").fadeOut();
		$("#appointmentForm").fadeIn();
	});
	
});

function getTime(dt,gp){
	$.ajax({
        type:"post",
        data:{dateVal:dt,timeGap:gp},
        url: $("#current_url").val()+'/getTime',
        success: function(data){
			$("#selectedTimeSlot").html(data.data);
        }
    });
}
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
	var id=$("#pageId").val();
	timezn=$("#timezone").val();
	$("#orgslots").html('<span class="fa fa-circle-o-notch fa-spin fa-4x" style="margin-top:40%;margin-left:40%;"></span>');
	$.ajax({
        type:"post",
        data:{selected_date:DATE,pageId:id,timezone:timezn},
        url: $("#current_url").val()+'/loadTimeSlots',
        success: function(data){
			$("#orgslots").html("");
			if(data.status=="error"){
                $("#AppointmentEMsg").html(data.message);
                $('#AppointmentError').fadeIn().delay(5000).fadeOut();
				$("#orgslots").html('<p style="color:red;"><b>'+data.message+'</b></p>');
				return;
			}
			if(data.data.slots.length>0){
				$("#orgslots").append("<b><h4 style='margin-bottom:10px;font-size: 17px;' id='sDate' dt='"+data.data.selectedDate+"'>Availability for "+data.data.availability+"</h4></b>");
				for(var i=0;i<data.data.slots.length;i++){
					$("#orgslots").append("<label style='font-size:19px;'><input type='radio' value='"+data.data.slots[i]+"' name='slt'>&nbsp;&nbsp;"+data.data.slots[i]+"&nbsp;&nbsp;</label>");
				}
				$("#selectedDateSlot").html(data.data.availability+", ");
				$("#slotsGap").val(data.data.slotsGap);
			}else{
				$("#orgslots").html('<p style="color:red;"><b>There are no slots available for this day. Please choose another day for appointment.</b></p>');
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
	$.ajax({
        type:"post",
        data:d,
        url: $("#AddAppURL").val(),
        success: function(data){
            if(data.status=="success"){
				$("#btnAppointmentLoader").fadeOut();
                $("#AppointmentSMsg").html(data.message);
				$("#btnAddAppointment").prop("disabled",false);
				$("#redirectionMsg").fadeIn();
				$("#redirectionTime").html(data.data.redirectionTime+" sec");
                $('#AppointmentSuccess').fadeIn().delay(3000).fadeOut(function(){});
                var newUrl=replaceQueryParam('appointmentId', data.data.appointmentId, data.data.redirectionUrl);
                //console.log(newUrl);
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

function fullCal(){
	var date = new Date();
    var d = date.getDate();
    var mon = date.getMonth();
    var y = date.getFullYear();
 
	$("#loadingCal").remove();
	$('#calendar').fullCalendar('destroy');
	$('#calendar').fullCalendar({
		theme:true,
		defaultView:'month',
		themeButtonIcons:false,
		height:'auto',
		header: {
			left: 'prev today',
			center: 'title',
			right: 'next'
		},
		disableDragging: true,
		selectable:true,
		firstDay:1,
		dayClick: function(date, jsEvent, view) {
			
			if(new Date(date.format()) >= new Date(y+"/"+(mon+1)+"/"+d) && $('.fc-day[data-date="' + date.format() + '"]').attr("holiday") !="true"){
				loadTimeSlots(date.format());
			}else{
				$("#orgslots").html('<p style="color:red;"><b>There are no slots available for this day. Please choose another day for appointment.</b></p>');
			}
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
		{
			events: resourceNotWorkingDays,
            color: '#ebebeb',     // an option!
            textColor: 'black', // an option!
        }
    ]
	});
	$(".fc-center>h2").css("font-size","13px");
	$(".fc-center>h2").css("margin-top","5px");
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
	$.ajax({
		url: $("#loadHolidayURL").val(),
		type:"get",
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
					}
				}
			}
			callback(holidays);
		}
	});
}

function resourceNotWorkingDays(start, end, timezone, callback) {
	var id=$("#pageId").val();
	$.ajax({
		url: $("#current_url").val()+'/loadPageNotWorkingDays',
		type:"post",
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
					};
				}
			}
		}
	});
}