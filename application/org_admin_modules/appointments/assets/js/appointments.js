$(document).ready(function() {
	$("#appPending").html($("#pendingApp").val());
	$('#selecctall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
	
	$("#dlAppointment").click(function(){
		deleteAppointment($(this).attr("data"));
	});
	$("#saveAppointmentChanges").click(function(){
		markAsRead();
	});
	$('body').on("change","#dropdownPageList",function(){
		$("#saveAppointmentChanges").prop("disabled",false);
		loadPageAppointments();
	});
});
function loadPageAppointments(){
	var pId=$("select#dropdownPageList option:selected").val();
	$.ajax({
        type:"post",
        data:{pageId:pId},
        url: $("#base_url").val()+"/appointments",
        success: function(data){
        	$("#pageAppointmentTable").html(data);
        }
    });
}
function displayDeleteAppointment(id){
	$('#deleteAppointmentModel').modal('show');
	$("#dlAppointment").attr("data",id);
}
function deleteAppointment(ID){
	$.ajax({
        type:"post",
        data:{appointmentID:ID},
        url: $("#base_url").val()+"/deleteAppointment",
        success: function(data){
            if(data.status=="success"){
                location.reload();
            }
			if(data.status=="error"){
                $("#errorMSG").html(data.message);
                $('#error').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function markAsRead(){
	var markRead={};
	markRead.isViewed=[];
	markRead.isNotViewed=[];
	$("#appList input:checkbox").each(function(){
		var $this = $(this);
		if($this.is(":checked")){
			markRead.isViewed.push($this.attr("id"));
		}else{
			markRead.isNotViewed.push($this.attr("id"));
		}
	});
	$.ajax({
        type:"post",
        data:{appointmentReadIDs:markRead.isViewed,appointmentUnReadIDs:markRead.isNotViewed},
        url: $("#base_url").val()+"/markAsReadAppointments",
        success: function(data){
            if(data.status=="success"){
                location.reload();
            }
			if(data.status=="error"){
			}
        }
    });
}
