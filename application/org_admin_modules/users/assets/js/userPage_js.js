var leaves=new Array();
$(document).ready(function() {
	loadUserCalData($("#uProfileId").val());
	$("#userInfo").click(function(){
		updateUser();
	});
	$("#leaveInfo").click(function(){
		createLeave();
	});
	$("#savePlan").click(function(){
		createPlan();
	});
	$("#leaveUpdateInfo").click(function(){
		updateLeave();
	});
	$("#dlLeave").click(function(){
		deleteLeave($(this).attr('data'));
	});
	$("#dlPlan").click(function(){
		deleteWorkingPlan($(this).attr('data'));
	});
	$('body').on("click",".updateLeave",function(){
		loadLeave($($(this)[0].outerHTML).attr('data'));
	});
	$('#startDate').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$('#endDate').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$('#workingDate').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true
	});
	$('#startTime').timepicker({
			'timeFormat': 'HH:mm',
			currentText: "Now",
			closeText:"Close",
			timeOnlyTitle: "Select Time (24-Hour)",
			timeText: "Time",
			hourText: "Hour",
			minuteText: "Minutes",
			
			'onSelect': function(datetime, inst) {
				// Start time must be earlier than end time. 
				var start = Date.parse($(this).parent().parent().find('.work-start').val());
				var end = Date.parse($(this).parent().parent().find('.work-end').val());

				if (start > end) {
					$(this).parent().parent().find('.work-end').val(start.addHours(1).toString('HH:mm'));
				}
			}
	 });
	 $('#endTime').timepicker({
			'timeFormat': 'HH:mm',
			currentText: "Now",
			closeText:"Close",
			timeOnlyTitle: "Select Time (24-Hour)",
			timeText: "Time",
			hourText: "Hour",
			minuteText: "Minutes",
			
			'onSelect': function(datetime, inst) {
				// Start time must be earlier than end time. 
				var start = Date.parse($(this).parent().parent().find('.work-start').val());
				var end = Date.parse($(this).parent().parent().find('.work-end').val());

				if (start > end) {
					$(this).parent().parent().find('.work-end').val(start.addHours(1).toString('HH:mm'));
				}
			}
	 });
	
	$("#leaveUpdateCancel").click(function(){
		$("#leaveUpdateInfo").fadeOut('fast');
		$("#leaveUpdateCancel").fadeOut('fast');
		$("#leaveDelete").fadeOut('fast');
		$("#leaveInfo").fadeIn();
		$("#leave_id").val("");
		$("#leaveTitle").val("");
		$("#startDate").val("");
		$("#endDate").val("");
	});
	$("#WorkingPlanCancel").click(function(){
		$(this).fadeOut('fast');
		$("#WorkingPlanDelete").fadeOut('fast');
		$("#savePlan").fadeIn();
		$("#workingDate").val("");
		$("#startTime").val("");
		$("#endTime").val("");
	});
});
function loadUserCalData(id){
	loadLeaves(id);
	loadUserWorkingPlans(id);
}

function loadLeave(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{'leaveId':id},
        url: url+"/loadLeave",
        success: function(data){
            if(data.status=="success"){
				$("#leaveInfo").fadeOut('fast');
				if(!$("#collapseOne").hasClass("collapse in"))
					$("#collapseOne").collapse('show');
				$("#collapseTwo").collapse('hide');
				$("#leaveUpdateInfo").fadeIn();
				$("#leaveUpdateCancel").fadeIn();
				$("#leaveDelete").fadeIn();
				$("#leaveDelete").attr("data-id",data.data.leaveInfo[0]['userLeaveId']);
				$("#leave_id").val(data.data.leaveInfo[0]['userLeaveId']);
				$("#leaveTitle").val(data.data.leaveInfo[0]['leaveTitle']);
				$("#startDate").val(data.data.leaveInfo[0]['leaveStartDate']);
				$("#endDate").val(data.data.leaveInfo[0]['leaveEndDate']);
            }
			if(data.status=="error"){
                
			}
        }
    });
}
function loadLeaves(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{'user_id':id},
		async:false,
        url: url+"/loadLeaves",
        success: function(data){
            if(data.status=="success"){
				leaves=data.data.leaves;
            }
        }
    });
}
function loadUserWorkingPlan(dt,id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{'planDate':dt,'user_id':id},
        url: url+"/loadResourceWorkingPlan",
        success: function(data){
            if(data.status=="success"){
				if(!$("#collapseTwo").hasClass("collapse in")){
					$("#collapseTwo").collapse('show');
				}
				$("#collapseOne").collapse('hide');
				$("#WorkingPlanCancel").fadeIn();
				$("#WorkingPlanDelete").fadeIn();
				$("#WorkingPlanDelete").attr("data-id",data.data.planInfo.date);
				$("#workingDate").val(data.data.planInfo.date);
				$("#startTime").val(data.data.planInfo.start);
				$("#endTime").val(data.data.planInfo.end);
            }
			if(data.status=="error"){
                
			}
        }
    });
}
function loadUserWorkingPlans(id){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{'user_id':id},
		async:false,
        url: url+"/loadResourceWorkingPlans",
        success: function(data){
            if(data.status=="success"){
				leaveCal(leaves,data.data.userWorkingPlans);
            }
        }
    });
}
function updateUser(){
	var d = $("#frmUserProfile").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/updateResource",
        success: function(data){
            if(data.status=="success"){
                $("#userSMsg").html(data.message);
                $('#userSuccess').fadeIn().delay(3000).fadeOut();
            }
			if(data.status=="error"){
                $("#userEMsg").html(data.message);
                $('#userError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function updateLeave(){
	var d = $("#frmLeave").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/updateResourceLeave",
        success: function(data){
            if(data.status=="success"){
                $("#leaveSMsg").html(data.message);
				$("#leaveTitle").val("");
				$("#startDate").val("");
				$("#endDate").val("");
                $('#leaveSuccess').fadeIn().delay(3000).fadeOut();
				$('#leaveCalendar').fullCalendar('destroy');
				loadUserCalData($("#uProfileId").val());
            }
			if(data.status=="error"){
                $("#leaveEMsg").html(data.message);
                $('#leaveError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function createLeave(){
	var d = $("#frmLeave").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/createResourceLeave",
        success: function(data){
            if(data.status=="success"){
                $("#leaveSMsg").html(data.message);
				$("#leaveTitle").val("");
				$("#startDate").val("");
				$("#endDate").val("");
                $('#leaveSuccess').fadeIn().delay(3000).fadeOut();
				$('#leaveCalendar').fullCalendar('destroy');
				loadUserCalData($("#uProfileId").val());
            }
			if(data.status=="error"){
                $("#leaveEMsg").html(data.message);
                $('#leaveError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function createPlan(){
	var d = $("#frmPlan").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/createResourceWorkingPlan",
        success: function(data){
            if(data.status=="success"){
                $("#planSMsg").html(data.message);
				$("#workingDate").val("");
				$("#startTime").val("");
				$("#endTime").val("");
                $('#planSuccess').fadeIn().delay(3000).fadeOut();
				$('#leaveCalendar').fullCalendar('destroy');
				loadUserCalData($("#uProfileId").val());
            }
			if(data.status=="error"){
                $("#planEMsg").html(data.message);
                $('#planError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function displayDeleteLeave(){
	$('#deleteLeaveModel').modal('show');
	$("#dlLeave").attr("data",$("#leaveDelete").attr("data-id"));
}
function deleteLeave(ID){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{id:ID},
        url: url+"/deleteLeave",
        success: function(data){
            if(data.status=="success"){
                $('#deleteLeaveModel').modal('hide');
				$('#leaveCalendar').fullCalendar('destroy');
				$('#leaveUpdateCancel').click();
				loadUserCalData($("#uProfileId").val());
            }
			if(data.status=="error"){
                $('#deleteLeaveModel').modal('hide');
				$("#leaveEMsg").html(data.message);
                $('#leaveError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function displayDeleteWorkingPlan(){
	$('#deleteWorkingPlanModel').modal('show');
	$("#dlPlan").attr("data",$("#WorkingPlanDelete").attr("data-id"));
}
function deleteWorkingPlan(dt){
	var url=$("#base_url").val();
	var uid=$("#uID").val();
	$.ajax({
        type:"post",
        data:{workingDate:dt,uID:uid},
        url: url+"/deleteResourceWorkingPlan",
        success: function(data){
            if(data.status=="success"){
                $('#deleteWorkingPlanModel').modal('hide');
				$('#leaveCalendar').fullCalendar('destroy');
				$('#WorkingPlanCancel').click();
				loadUserCalData($("#uProfileId").val());
            }
			if(data.status=="error"){
                $('#deleteWorkingPlanModel').modal('hide');
				$("#planEMsg").html(data.message);
                $('#planError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function leaveCal(leave,working){
	$('#leaveCalendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		firstDay:1,
		editable:true,
		eventClick: calendarEventClick,
		eventSources: [
        // your event source
        {
			events: leave,
            color: 'green',     // an option!
            textColor: 'white', // an option!
        },
		{
			events: working,
            color: 'yellow',     // an option!
            textColor: 'black', // an option!
        }
    ]
	});
}
calendarEventClick = function(event, jsEvent, view) {
		if(event.id){
			loadLeave(event.id);
		}else{
			var startDT=new Date(event.start);
			var d = startDT.getDate();
			var m = startDT.getMonth();
			var y = startDT.getFullYear();
			loadUserWorkingPlan(y+"-"+(m+1)+"-"+d,$("#uProfileId").val());
		}
}