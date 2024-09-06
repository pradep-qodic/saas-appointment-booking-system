$(document).ready(function() {
	$("#calendarAdminDashboard").on("click",".fc-basicWeek-button",function(){
		$('#calendarAdminDashboard').fullCalendar('destroy');
		adminDashboardCalendar('basicWeek');
	});
	$("#calendarAdminDashboard").on("click",".fc-basicDay",function(){
		$('#calendarAdminDashboard').fullCalendar('destroy')
		adminDashboardCalendar('basicDay');
	});
	
	$('body').on("change","#dropdownPageList",function(){
		$('#calendarAdminDashboard').fullCalendar('destroy');
		adminDashboardCalendar('month');
	});
	$('body').on("click",".linkClick",function(){
		window.open($(this).attr("dataVal"));
	});
	$('body').on("click","#closeLinks",function(){
		$("#bookingPageLinks").popover("hide");
	});
	$('body').on("click","#sendRescheduleRequest",function(){
		sendRescheduleRequest($(this).attr("data"));
	});
	$('body').on("click","#sendRequestNewTime",function(){
		sendRequestNewTime($(this).attr("data"));
	});
	$('body').on("click","#cancelActivity",function(){
		cancelActivity($(this).attr("data"));
	});
	/* schedule app	  */
	$("#ApproveAppointment").click(function(){
		allocateUserAppointment($(this).attr("data-id"));
	});
	$("#RejectAppointment").click(function(){
		$("#appReason").toggle('slow');
	});
	$("#rejectionEmail").click(function(){
		rejectAppointment($(this).attr("data-id"));
	});
	/* schedule app end */
	var popupHTML='<div><a href="#" id="closeLinks"><span class="fa fa-times pull-right"></span></a>'+
		'<div><b>Copy and send to your customers</b></div>'+
		'<div><div style="background-color: #ebebeb;margin: 6px 0px 6px 0px;padding: 1px 0px 1px 5px;"><b>Master booking page links</b></div><div id="masterLinks"></div></div>'+
		'<div><div style="background-color: #ebebeb;margin: 6px 0px 6px 0px;padding: 1px 0px 1px 5px;"><b>Booking page links</b></div><div id="bookingLinks"></div></div>'+
		'</div>';
	$("#bookingPageLinks").popover({
		content:popupHTML,
		placement:"bottom",
		trigger:"click",
		html:true,
	});
	
	$('#bookingPageLinks').on('show.bs.popover', function () {
		getLinks();
	});
	$('body').on("click",".activityStreamData",function(){
		var id=$(this).attr("data-id");
		showActivityInfo(id);
	});
	$('body').on("click",".trashActivityStreamData",function(){
		var id=$(this).attr("data-id");
		showTrashActivityInfo(id);
	});
	$("#dlActivity").click(function(){
		deleteActivity($(this).attr("data"));
	});
	
	$("#btnRefresh").click(function(){
		loadActivities();
	});
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  var current=$("#current_url").val()+"#trash";
		  if(e.target==current){
			  loadTrash();
		  }
	});
	adminDashboardCalendar('month');
	loadTrash();
});
function allocateUserAppointment(){
	$("#emailApproveLoader").fadeIn();
	$("#ApproveAppointment").attr('disabled','disabled');
	var uID=$("#Allocateuser_id").val();
	var allocateDate=$("#AllocateDate").val();
	var appID=$("#app_id").val();
	var slotVal=$("input[name='slot']:checked").val();
	if(!slotVal){
		$("#emailApproveLoader").fadeOut();
		$("#ApproveAppointment").removeAttr('disabled');
		$("#sEMsg").html("Please Select Slot.");
        $('#sError').fadeIn().delay(3000).fadeOut();
		return;
	}
	var dt=allocateDate.split(' ')[0];
	allocateDate=dt+" "+slotVal;
	$.ajax({
        type:"post",
        data:{'app_id':appID,'allocatedUserId':uID,'allocatedOn':allocateDate},
        url: $("#base_url").val()+'/allocateAppointment',
        success: function(data){
			if(data.status=="success"){
				$("#emailApproveLoader").fadeOut();
				$("#ApproveAppointment").removeAttr('disabled');
				$("#sSMsg").html(data.message);
                $('#sSuccess').fadeIn().delay(3000).fadeOut(function(){$('#scheduleActivityModel').modal('hide');loadActivities();});
			}
			if(data.status=="error"){
				$("#emailApproveLoader").fadeOut();
				$("#ApproveAppointment").removeAttr('disabled');
				$("#sError").html(data.message);
                $('#sEMsg').fadeIn().delay(3000).fadeOut();
			}
			$("#emailApproveLoader").fadeOut();
			$("#ApproveAppointment").removeAttr('disabled');
        }
    });	
}
function rejectAppointment(){
	var appID=$("#app_id").val();
	var reason=$("#reasonText").val();
	$("#emailRejectLoader").fadeIn();
	$("#rejectionEmail").attr('disabled','disabled');
	
	$.ajax({
        type:"post",
        data:{'app_id':appID,'reason':reason},
        url: $("#base_url").val()+'/rejectMasterpageAppointment',
        success: function(data){
			if(data.status=="success"){
				$("#emailRejectLoader").fadeOut();
				$("#rejectionEmail").removeAttr('disabled');
				$("#sSMsg").html(data.message);
                $('#sSuccess').fadeIn().delay(3000).fadeOut(function(){$('#scheduleActivityModel').modal('hide');loadActivities();});
			}
			if(data.status=="error"){
				$("#emailRejectLoader").fadeOut();
				$("#rejectionEmail").removeAttr('disabled');
				$("#sError").html(data.message);
                $('#sEMsg').fadeIn().delay(3000).fadeOut();
			}
			$("#emailRejectLoader").fadeOut();
			$("#rejectionEmail").removeAttr('disabled');
        }
    });	
}
function loadPageAvailableSlots(id){
	$.ajax({
        type:"post",
        data:{"app_id":id},
        url: $("#base_url").val()+'/loadPageAvailableSlots',
        success: function(data){
			if(data.status=="success"){
				$("#appSlots").fadeIn();
				$("#appSlots").html("");
				for(var i=0;i<data.data.loadAvailableSlots.length;i++){
					$("#appSlots").append('<label><input type="radio" name="slot" value="'+data.data.loadAvailableSlots[i]+'">'+data.data.loadAvailableSlots[i]+'</label>&nbsp;&nbsp;');
				}
				$("#Allocateuser_id").val(data.data.allocateToUsetId);
				$("#AllocateDate").val(data.data.allocatedOn);
				$("#app_id").val(data.data.appId);
			}
			if(data.status=="error"){
				$("#sEMsg").html(data.message);
                $('#sError').fadeIn().delay(3000).fadeOut();
			}
			
        }
    });	
}
function showTrashActivityInfo(id){
	$.ajax({
		url: $("#base_url").val()+'/appointmentTrashInfo',
		type:"post",
		data:{appId:id},
		success: function(data) {
			var name=data.data.appInfo[0].app_title;
			var status='';
			if(data.data.appInfo[0].isApproved==1)
				status="Scheduled";
			else if(data.data.appInfo[0].isApproved==0)
				status="Canceled";
			else if(data.data.appInfo[0].isApproved==-1)
				status="Not Defined";
			else if(data.data.appInfo[0].isApproved==2)
				status="Rescheduled";
			else if(data.data.appInfo[0].isApproved==3)
				status="Requested";
			 
			$("#trashActivityDetail").html('<strong>'+name+'</strong> ('+data.data.time+' min)'+
					'<p>'+status+'</p>' +
					'<p>'+data.data.appTime+'</p>' +
					'<strong>Booking page</strong> ' +
					'<p> '+data.data.pageInfo[0].booking_url+' </p>' +
					'<strong>Attendees</strong> '+
					'<p>'+data.data.appInfo[0].applicant_name + ' ('+data.data.appInfo[0].applicant_email +')</p>'+
					'<strong>Note From '+data.data.appInfo[0].applicant_name+'</strong> '+
					'<p>'+data.data.appInfo[0].app_desc +'</p>');
		}
	});
}
function showActivityInfo(id){
	$.ajax({
		url: $("#base_url").val()+'/appointmentInfo',
		type:"post",
		data:{appId:id},
		success: function(data) {
			var name=data.data.appInfo[0].app_title;
			var status='';
			if(data.data.appInfo[0].isApproved==1)
				status="Scheduled";
			else if(data.data.appInfo[0].isApproved==0)
				status="Canceled";
			else if(data.data.appInfo[0].isApproved==-1)
				status="Not Defined";
			else if(data.data.appInfo[0].isApproved==2)
				status="Rescheduled";
			else if(data.data.appInfo[0].isApproved==3)
				status="Requested";
			 
			$("#activityDetail").html('<strong>'+name+'</strong> ('+data.data.time+' min)'+
					'<p>'+status+'</p>' +
					'<p>'+data.data.appTime+'</p>' +
					'<strong>Booking page</strong> ' +
					'<p> '+data.data.pageInfo[0].booking_url+' </p>' +
					'<strong>Attendees</strong> '+
					'<p>'+data.data.appInfo[0].applicant_name + ' ('+data.data.appInfo[0].applicant_email +')</p>'+
					'<strong>Note From '+data.data.appInfo[0].applicant_name+'</strong> '+
					'<p>'+data.data.appInfo[0].app_desc +'</p>');
		}
	});
}
function displayDeleteActivity(id){
	$('#deleteActivityModel').modal('show');
	$("#dlActivity").attr("data",id);
}
function displayRescheduleActivity(id){
	$('#rescheduleActivityModel').modal('show');
	$("#sendRescheduleRequest").attr("data",id);
	getAppInfo(id,".appName");
}
function displayScheduleActivity(id){
	$('#scheduleActivityModel').modal('show');
	$("#rejectionEmail").attr("data-id",id);
	$("#ApproveAppointment").attr("data-id",id);
	getAppInfo(id,".appName");
	loadPageAvailableSlots(id);
}
function displayRequestNewTimeActivity(id){
	$('#requestNewTimeActivityModel').modal('show');
	$("#sendRequestNewTime").attr("data",id);
	getAppInfo(id,".appName");
}
function displayCancelActivity(id){
	$('#cancelActivityModel').modal('show');
	$("#cancelActivity").attr("data",id);
	getAppInfo(id,".appName");
}
function getAppInfo(id,name){
	$.ajax({
        type:"post",
        data:{appId:id},
        url: $("#base_url").val()+"/getAppInfo",
        success: function(data){
            if(data.status=="success"){
            	var app=data.data.appInfo;
            	$(name).html(app[0].applicant_name);
            }
        }
    });
}
function sendRescheduleRequest(id){
	$("#rescheduleSpinner").fadeIn();
	var reason=$("#rescheduleReason").val();
	$.ajax({
        type:"post",
        data:{appointmentID:id,reschedule_reson:reason},
        url: $("#base_url").val()+"/sendRescheduleRequest",
        success: function(data){
            if(data.status=="success"){
            	$("#rescheduleSpinner").fadeOut();
            	$('#rescheduleActivityModel').modal('hide');
            	loadActivities();
            }
			if(data.status=="error"){
				$("#rescheduleSpinner").fadeOut();
                $("#errorReMSG").html(data.message);
                $('#errorRe').fadeIn().delay(3000).fadeOut();
			}
			$("#rescheduleSpinner").fadeOut();
			$('#rescheduleActivityModel').modal('hide');
        }
    });
}
function sendRequestNewTime(id){
	$("#rescheduleSpinner").fadeIn();
	var reason=$("#requestNewTime_reson").val();
	$.ajax({
        type:"post",
        data:{appointmentID:id,requestNewTime_reson:reason},
        url: $("#base_url").val()+"/sendRequestNewTime",
        success: function(data){
            if(data.status=="success"){
            	$("#requestNewTimeSpinner").fadeOut();
            	$('#requestNewTimeActivityModel').modal('hide');
            	loadActivities();
            }
			if(data.status=="error"){
				$("#requestNewTimeSpinner").fadeOut();
                $("#errorReNTimeMSG").html(data.message);
                $('#errorReNTime').fadeIn().delay(3000).fadeOut();
			}
			$("#requestNewTimeSpinner").fadeOut();
			$('#requestNewTimeActivityModel').modal('hide');
        }
    });
}
function cancelActivity(id){
	var reason=$("#cancelReason").val();
	var deleted=false,emailSent=false;
	if($("#sendCancelEmail").is(":checked")){
		emailSent=false;
    }
    else if($("#sendCancelEmail").is(":not(:checked)")){
    	emailSent=true;
    }
	if($("#moveTrash").is(":checked")){
		deleted=true;
    }
    else if($("#moveTrash").is(":not(:checked)")){
    	deleted=false;
    }
	$("#cancelSpinner").fadeIn();
	$.ajax({
        type:"post",
        data:{'app_id':id,'reason':reason,'is_deleted':deleted,'isEmailSent':emailSent},
        url: $("#base_url").val()+'/rejectMasterpageAppointment',
        success: function(data){
			if(data.status=="success"){
				$("#cancelSpinner").fadeOut();
				$('#cancelActivityModel').modal('hide');
				loadActivities();
			}
			if(data.status=="error"){
				$("#cancelSpinner").fadeOut();
				$("#errorCMSG").html(data.message);
                $('#errorC').fadeIn().delay(3000).fadeOut();
			}
			$("#cancelSpinner").fadeOut();
			//$('#cancelActivityModel').modal('hide');
        }
    });	
}
function deleteActivity(ID){
	$.ajax({
        type:"post",
        data:{appointmentID:ID},
        url: $("#base_url").val()+"/deleteAppointment",
        success: function(data){
            if(data.status=="success"){
            	$('#deleteActivityModel').modal('hide');
            	loadActivities();
            }
			if(data.status=="error"){
                $("#errorMSG").html(data.message);
                $('#error').fadeIn().delay(3000).fadeOut();
			}
			$('#deleteActivityModel').modal('hide');
        }
    });
}
function loadActivities(){
	var sts=$("select#StatusFilter option:selected").val();
	var src=$("select#SourceFilter option:selected").val();
	$("#activities").html("<span class='fa fa-spin fa-spinner fa-2x'></span><span> Loading data...</span>");
	$("#activities").css("text-align","center");
	$.ajax({
        type:"post",
        data:{status:sts,source:src},
        url: $("#base_url").val()+"/loadActivities",
        success: function(data){
        	if($.trim(data)){
        		$("#activities").html(data);
        		$("#activities").css("text-align","left");
				loadTrash();
        	}else{
        		$("#activities").html("<h2 class='text-center'>No Data Found<h2>");
        	}
        }
    });
}
function loadTrash(){
	$("#trashActivities").html("<span class='fa fa-spin fa-spinner fa-2x'></span><span> Loading data...</span>");
	$("#trashActivities").css("text-align","center");
	$.ajax({
        type:"post",
        data:{},
        url: $("#base_url").val()+"/loadTrash",
        success: function(data){
        	if($.trim(data)){
        		$("#trashActivities").html(data);
        		$("#trashActivities").css("text-align","left");
        	}
        	else{
        		$("#trashActivities").html("<h2 class='text-center'>No Trash Data Found<h2>");
        	}
        }
    });
}

function getLinks(){
	$("#masterLinks").html("");
	$("#bookingLinks").html("");
	$.ajax({
		url: $("#base_url").val()+'/getLinks',
		type:"post",
		data:{},
		success: function(data) {
			for(var i=0;i<data.data.bookingLinks.length;i++){
				$("#bookingLinks").append('<span style="word-wrap: break-word;"><a href="#" class="linkClick" dataVal="'+data.data.bookingLinks[i].booking_url+'" id="cp_'+data.data.bookingLinks[i].org_user_id+'">'+data.data.bookingLinks[i].booking_url+'</a>&nbsp;&nbsp;<button type="button" data-id="cp_'+data.data.bookingLinks[i].org_user_id+'" class="btn btn-primary btn-xs copyClick">Copy</button></span>');
			}
			for(var i=0;i<data.data.masterLinks.length;i++){
				$("#masterLinks").append('<span style="word-wrap: break-word;"><a href="#"  class="linkClick" dataVal="'+data.data.masterLinks[i].booking_url+'" id="cp_'+data.data.masterLinks[i].inspectionTypeId+'">'+data.data.masterLinks[i].booking_url+'</a>&nbsp;&nbsp;<button type="button" data-id="cp_'+data.data.masterLinks[i].inspectionTypeId+'" class="btn btn-primary btn-xs copyClick">Copy</button></span>');
			}
			var zPath=$("#base_url1").val();
			 $(".copyClick").zclip({
			        path:zPath+'themes/admin/js/ZeroClipboard.swf',
			        copy:function(){return $("#"+$(this).attr('data-id')).text();},
			        beforeCopy:function(){
			        	//link="#"+$(this).attr('data-id');
			        },  
			 });
		}
	});
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
function calInfo(){
	var pId=$("select#dropdownPageList option:selected").val();
	$.ajax({
		url: $("#base_url").val()+'/getCalInfo',
		type:"post",
		data:{calId:pId},
		success: function(data) {
			var pageInfo=data.data.CalInfo;
			var owner='',name='',location='',bookUrl='',email='';
			if(pageInfo[0].owner)
				owner='<div class="form-group"><label>Owner</label><br>'+pageInfo[0].owner+'</div>';
			if(pageInfo[0].name)
				name='<div class="form-group"><label>Name</label><br>'+pageInfo[0].name+'</div>';
			if(pageInfo[0].location)
				location='<div class="form-group"><label>Location</label><br>'+pageInfo[0].location+'</div>';
			if(pageInfo[0].booking_url)
				bookUrl='<div class="form-group" style="word-wrap: break-word;"><label>Customer Link</label><br>'+pageInfo[0].booking_url+'</div>';
			if(pageInfo[0].email)
				email='<div class="form-group"><label>Email</label><br>'+pageInfo[0].email+'</div>';
			if(pageInfo){
				$("#pageInfoTable").html('<legend>Booking Page Details</legend>'+owner+name+location+bookUrl+email);
			}
		}
	});
}
function calHolidays(start, end, timezone, callback) {
	var pId=$("select#dropdownPageList option:selected").val();
	$.ajax({
		url: $("#base_url").val()+'/loadholidaysData',
		type:"post",
		data:{pageId:pId},
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
			callback();
		}
	});
}
function loadCalAppointments(start, end, timezone, callback) {
	var pId=$("select#dropdownPageList option:selected").val();
	$.ajax({
		url: $("#base_url").val()+'/loadAppointments',
		type:"post",
		data:{pageId:pId},
		success: function(data) {
			appointments=data.data.appointments;
			callback(appointments);
		}
	});
}
function calNotWorkingDays(start, end, timezone, callback) {
	var pId=$("select#dropdownPageList option:selected").val();
	$.ajax({
		url: $("#base_url").val()+'/loadPageNotWorkingDays',
		type:"post",
		data:{pageId:pId},
		success: function(data) {
			if(data.status=='success'){
				weekEnds=data.data.notWorkingDays;
				if(weekEnds && weekEnds.length>0){
					$(weekEnds).each(function( index, element ) {
						var dayVal = element.substring(0, 3);
						$('.fc-day.fc-'+dayVal+'').css('background',"#ebebeb");
				    });
				}
				callback();
			}
		}
	});
}
function adminDashboardCalendar(view){
	$('#calendarAdminDashboard').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		height: "auto",
		contentHeight:"auto",
		defaultView:view,
		theme:true,
		themeButtonIcons:false,
		firstDay:1,
		//eventClick: calendarAppointmentClick,
		eventSources: [
        // your event source
        {
            events:calNotWorkingDays,
            color: '#ebebeb',     // an option!
            textColor: 'black', // an option!
			className:'notWorking',
			editable: false
        },
        {
			events: calHolidays,
            color: '#ebebeb',     // an option!
            textColor: 'black', // an option!
			className:'notWorking',
			editable: false
        },
		{
            events: loadCalAppointments,
			editable: false,
			eventLimit: true // allow "more" link when too many events
        }
    ]
	});
	//$('#calendarAdminDashboard').fullCalendar( 'addEventSource', calNotWorkingDays );
	$(".fc-center>h2").css("font-size","13px");
	$(".fc-center>h2").css("margin-top","5px");
	calInfo();
}
calendarAppointmentClick = function(event, jsEvent, view) {	
		if(event.id !=='undefined' && event.id !==undefined)
			loadUserAppointmentPage(event.id);
}
function loadUserAppointmentPage(id){
	$.ajax({
		type:"post",
		data:{app_id:id},
		url: $("#base_url").val()+'/userAppPage',
		success: function(data){
			if(data){
				$("body").html(data);
				$("#loader").fadeOut();
				$("#fade").fadeOut();
			}	
		}
	});
}
function getDayVal(v){
	switch(v.toUpperCase()){
		case "SUNDAY":
			return "0";
			break;
		case "MONDAY":
			return "1";
			break;
		case "TUESDAY":
			return "2";
			break;
		case "WEDNESDAY":
			return "3";
			break;
		case "THURSDAY":
			return "4";
			break;
		case "FRIDAY":
			return "5";
			break;
		case "SATURDAY":
			return "6";
			break;
		default:
			return "";
	}
}