$(document).ready(function() {
	//loadAvailableUsers($("#resourceId").val());
	//loadUserAvailableSlots($("#pageId").val(),$("#start").val());
	$("body").on("click","#availableUsers .btn",function(){
		loadUserAvailableSlots($($(this)[0].outerHTML).attr('data'),$("#start").val());
		$("#Allocateuser_id").val($($(this)[0].outerHTML).attr('data'));
		$("#AllocateDate").val($("#start").val());
	});
	$("#ApproveAppointment").click(function(){
		allocateUserAppointment();
	});
	$("#RejectAppointment").click(function(){
		$("#appReason").toggle('slow');
	});
	$("#rejectionEmail").click(function(){
		rejectAppointment();
	});
	$('.dropdown-toggle').dropdown();
	markAsReadAppointment($("#app_id").val());
});
function markAsReadAppointment(id){
	var readids=[id];
	$.ajax({
        type:"post",
        data:{appointmentReadIDs:readids},
        url: $("#base_url").val()+"/markAsReadAppointment",
        success: function(data){
        }
    });
}
function loadUserAvailableSlots(userID,selectedDate){
	$.ajax({
        type:"post",
        data:{'selected_date':selectedDate,'user_id':userID},
        url: $("#base_url").val()+'/loadUserAvailableSlots',
        success: function(data){
			if(data.status=="success"){
				$("#appSlots").fadeIn();
				$("#appSlots").html("");
				for(var i=0;i<data.data.userAvailableSlots.length;i++){
					$("#appSlots").append('<label><input type="radio" name="slot" value="'+data.data.userAvailableSlots[i]+'">'+data.data.userAvailableSlots[i]+'</label>&nbsp;&nbsp;');
				}
			}
			if(data.status=="error"){
				$("#sEMsg").html(data.message);
                $('#sError').fadeIn().delay(3000).fadeOut();
			}
			
        }
    });	
}
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
                $('#sSuccess').fadeIn().delay(3000).fadeOut(function(){window.location=$("#base_url").val()+'/appointments';});
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
	if(!reason){
		$("#sEMsg").html("Please Provide Any Reason For Reject Appointment");
        $('#sError').fadeIn().delay(3000).fadeOut();
		$("#emailRejectLoader").fadeOut();
		$("#rejectionEmail").removeAttr('disabled');
		return;
	}
	$.ajax({
        type:"post",
        data:{'app_id':appID,'reason':reason},
        url: $("#base_url").val()+'/rejectAppointment',
        success: function(data){
			if(data.status=="success"){
				$("#emailRejectLoader").fadeOut();
				$("#rejectionEmail").removeAttr('disabled');
				$("#sSMsg").html(data.message);
                $('#sSuccess').fadeIn().delay(3000).fadeOut(function(){window.location=$("#base_url").val()+'/appointments';});
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