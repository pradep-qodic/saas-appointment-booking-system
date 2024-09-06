$(document).ready(function() {
	$("#personalInfo").click(function(){
		updateUser();
	});
	$("#passwordInfo").click(function(){
		updatePass();
	});
});
function updateUser(){
	var d = $("#frmAdmin").serializeArray();
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:d,
        url: url+"/updateUser",
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
function updatePass(){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{curpassword:$('#curpassword').val(),npassword:$('#npassword').val(),cpassword:$('#cpassword').val()},
        url: url+"/changePassword",
        success: function(data){
            if(data.status=="success"){
                $("#passwordSMsg").html(data.message);
                $('#passwordSuccess').fadeIn().delay(3000).fadeOut(function(){location.reload();});
            }
			if(data.status=="error"){
                $("#passwordEMsg").html(data.message);
                $('#passwordError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}