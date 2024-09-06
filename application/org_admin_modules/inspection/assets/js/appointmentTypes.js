$(document).ready(function() {
	$("#btnAddInspection").click(function(){
		addInspectionType();
	});
	$("#btnUpdateInspection").click(function(){
		updateInspectionType();
	});
	$("#btnAddAppointmetType").click(function(){
		$("#inspectionTypeId").val("");
		$("#btnAddUsers").fadeIn();
		$("#addMoreAppUsers").fadeIn();
		listMoreUsers();
	});
	$('#inspectionModel').on('hidden.bs.modal', function (e) {
		$("#btnAddUser").show();
		$("#btnUpdateUser").fadeOut();
		$("#email").val("");
		$("#email").removeAttr("disabled");
		$("#firstname").val("");
		$("#lastname").val("");
		$("#mobileno").val("");
	});
	$("#dlInsp").click(function(){
		deleteInspectionType($(this).attr("data"));
	});
    $('#inspectionModel').on('hidden.bs.modal', function (e) {
		$("#inspectionType").val("");
		$("#addMoreAppUsers").html("");
		$("#addMoreAppUsers").hide();
		$("#appUsers").html("");
		$("#appUsers").hide();
		$("#btnUpdateInspection").hide();
		$("#btnAddInspection").show();
        $("#myModalLabel").html("Add Master Calendar");
    });
    $("#btnAddUsers").click(function(){
        $("#addMoreAppUsers").toggle('slow');
    });
    $("body").on("click","#addUsr",function(){
            addUsr($($(this)[0].outerHTML).attr('data-id'),$($(this)[0].outerHTML).attr('data-appID'));
    });
    $("body").on("click","#deleteUsr",function(){
            deleteUsr($($(this)[0].outerHTML).attr('data-id'),$($(this)[0].outerHTML).attr('data-appID'));
    });
});

function addInspectionType(){
	var url=$("#base_url").val();
	var typeId=$("#inspectionTypeId").val();
	var typeName=$("#inspectionType").val();
	var resourceVals = [];
	$("#checkResources input:checkbox").each(function(){
		var $this = $(this);
		if($this.is(":checked")){
			resourceVals.push($this.val());
		}
	});
	$.ajax({
        type:"post",
        data:{inspectionTypeId:typeId,inspectionType:typeName,resourceIds:resourceVals},
        url: url+'/createInspectionType',
        success: function(data){
            if(data.status=="success"){
                $("#sMsg").html(data.message);
                $('#ajaxSuccess').fadeIn().delay(3000).fadeOut(function(){location.reload();});
            }
			if(data.status=="error"){
                $("#eMsg").html(data.message);
                $('#ajaxError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function updateInspectionType(){
	var url=$("#base_url").val();
	var typeId=$("#inspectionTypeId").val();
	var typeName=$("#inspectionType").val();
	var resourceVals = [];
	$("#checkResources input:checkbox").each(function(){
		var $this = $(this);
		if($this.is(":checked")){
			resourceVals.push($this.val());
		}
	});
	$.ajax({
        type:"post",
        data:{inspectionTypeId:typeId,inspectionType:typeName,resourceIds:resourceVals},
        url:url+'/updateInspectionType', 
        success: function(data){
            if(data.status=="success"){
                $("#sMsg").html(data.message);
                $('#ajaxSuccess').fadeIn().delay(3000).fadeOut(function(){location.reload();});
            }
			if(data.status=="error"){
                $("#eMsg").html(data.message);
                $('#ajaxError').fadeIn().delay(3000).fadeOut();
			}
        }
    });
}
function loadAppUsers(ID){
var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{id:ID},
        url: url+'/loadAppointmentTypeUsers',
        success: function(data){
             $("#appUsers").html("");
			if(data.status=="success"){
				if(data.data.appTypeUsers.length>0){
                    for(var i=0;i<data.data.appTypeUsers.length;i++){
                        $("#appUsers").append("<div class='table-responsive'><table class='table table-condensed' style='margin-bottom: 2px;'><tbody><tr><td>"+data.data.appTypeUsers[i]['name']+"</td><td><a href='javascript:void(0);' class='pull-right' id='deleteUsr' data-id="+data.data.appTypeUsers[i]['org_user_id']+" data-appID="+data.data.appTypeUsers[i]['inspectionTypeId']+"><i class='fa fa-times'></i></a></td></tr></tbody></table></div>");
                    }
                }
            }
        }
    });
}
function addUsr(userID,TypeID){
var url=$("#base_url").val();
    $.ajax({
        type:"post",
        data:{user_id:userID,inspectionTypeId:TypeID},
        url: url+'/addAppointmentTypeUsers',
        success: function(data){
			if(data.status=="success"){
                loadAppUsers(TypeID);
                listMoreUsers();
            }
        }
    }); 
 }
function deleteUsr(userID,TypeID){
	var url=$("#base_url").val();
    $.ajax({
        type:"post",
        data:{user_id:userID},
        url: url+'/deleteAppointmentTypeUsers',
        success: function(data){
			if(data.status=="success"){
                loadAppUsers(TypeID);
                listMoreUsers();
            }
        }
    }); 
 }
function loadInspectionType(ID){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{id:ID},
        url: url+'/loadInspTypes',
        success: function(data){
			if(data.status=="success"){
				$("#appUsers").fadeIn();
				$("#btnAddUsers").fadeIn();
				$("#btnAddInspection").hide();
				$("#btnUpdateInspection").fadeIn();
				$("#inspectionType").val(data.data.inspectionType[0]['typeName']);
				$("#inspectionTypeId").val(data.data.inspectionType[0]['inspectionTypeId']);
                $("#myModalLabel").html("Update Master Calendar");
                loadAppUsers(data.data.inspectionType[0]['inspectionTypeId']);
                listMoreUsers();
				$('#inspectionModel').modal('show');
            }
        }
    });
}
function listMoreUsers(){
	var url=$("#base_url").val();
    $.ajax({
        type:"get",
        data:{},
        url: url+'/loadMoreAppointmentTypeUsers',
        success: function(data){
            $("#addMoreAppUsers").html("");
			if(data.status=="success"){
				if(data.data.appTypeUsers.length>0){
					$("#addMoreAppUsers").append('<label>Select resource to add in your master calendar</label></br><div id="checkResources">');
                    for(var i=0;i<data.data.appTypeUsers.length;i++){
                        $("#checkResources").append('<label class="checkbox-inline"><input type="checkbox" id="inlineCheckbox1" value="'+data.data.appTypeUsers[i]["user_id"]+'"> '+data.data.appTypeUsers[i]["userName"]+'</label>');
                    }
					$("#addMoreAppUsers").append('</div>');
                }else{
					$("#addMoreAppUsers").html("No More Resources Found.");
				}
            }
        }
    });
}
function deleteInspectionType(ID){
	var url=$("#base_url").val();
	$.ajax({
        type:"post",
        data:{inspectionTypeId:ID},
        url: url+'/deleteInspectionType',
        success: function(data){
            if(data.status=="success"){
                location.reload();
            }
        }
    });
}
function displayDeleteInspection(id){
	$('#deleteInspectionModel').modal('show');
	$("#dlInsp").attr("data",id);
}