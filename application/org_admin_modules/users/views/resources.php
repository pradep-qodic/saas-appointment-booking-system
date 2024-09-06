	<div class="pull-right">
		<button class="btn btn-primary" data-toggle="modal" data-target="#userModel">
		  Add Resource
		</button>
	</div>
	<div class="row">
		<div class="alert alert-warning alert-dismissible" role="alert" id="error" style="display:none;">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<strong>Errors !!!</strong> <span id="errorMSG"></span>
		</div>
		<div class="span12">
			<table class="table">
				<thead>
					<tr>
						<th>Sr.No</th>
						<th>Name</th>
						<th>Email To Send Notification</th>
						<th>Phone To send Notification</th>
						<th>Active/Inactive</th>
						<th>Created On</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($users) && $users): foreach($users as $index=>$user): ?>
					<tr>
						<td><?php echo ($index+1); ?></td>
						<td><form method="post" action='<?php echo base_url($this->schedular_auth->makeBaseURL("manageCalendars")); ?>'><input type="hidden" name="id" value="<?php echo $user->org_user_id; ?>"/><input type="submit" class="btn btn-link" style="padding:0;" value="<?php echo $user->name; ?>"></form></td>
						<td><?php echo $user->email; ?></td>
						<td><?php echo $user->mobileNo; ?></td>
						<td><?php echo ($user->status==1)?"Active":"Inactive"; ?></td>
						<td><?php echo $user->createdOn; ?></td>
						<td><form method="post" action='<?php echo base_url($this->schedular_auth->makeBaseURL("resourcePage")); ?>'><input type="hidden" name="id" value="<?php echo $user->org_user_id; ?>"/><button type="submit" class="btn btn-link" style="padding:0;"><i class="fa fa-pencil"></i></button></form></td>
						<td><a href="javascript:void(0);" onClick="displayDeleteUser('<?php echo $user->org_user_id; ?>');"><i class="fa fa-times"></i></a></td>
					</tr>
					<?php endforeach;endif; ?>
				</tbody>
			</table>
			
		</div>
	</div>
<!-- Modal User-->
<div class="modal fade" id="userModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Resource</h4>
      </div>
      <div class="modal-body" id="userModelBody">
					<div class="alert alert-warning alert-dismissible" role="alert" id="ajaxError" style="display:none;">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Errors !!!</strong> <span id="eMsg"></span>
					</div>
					<div class="alert alert-success alert-dismissible" role="alert" id="ajaxSuccess" style="display:none;">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Success !!!</strong> <span id="sMsg"></span>
					</div>
					<!-- BEGIN FORM-->
					<form role="form" method="post" id="frmUser">
						<input type="hidden" value="<?php echo base_url(); ?>" id="base_url">
						<!--<div class="form-group">
							<label for="exampleInputEmail1">Select Inspection Type</label>
							<select class="form-control" name="insp_type_id" id="insp_type_id"></select>
						</div>-->
					  <div class="form-group">
						<label for="inputName">Name</label>
						<input type="text" id="name" class="form-control" value="" name="name" id="inputName" placeholder="Name">
					  </div>
					  <div class="form-group">
						<label for="inputEmail">Email To Send Notification</label>
						<input type="email" id="email" class="form-control" value="" name="email" id="inputEmail" placeholder="Email To Send Notification">
						<input type="hidden" name="org_id" value="<?php echo $org_id; ?>">
						<input type="hidden" id="uemail" name="uemail" value="">
					  </div>
					  <div class="form-group">
						<label for="inputPhone">Phone To Send Notification</label>
						<input type="text" id="mobileno" class="form-control" value="" name="mobileno"  id="inputPhone" placeholder="Phone To Send Notification">
					  </div>
					  <div class="form-group">
						<label class="radio-inline">
						  <input type="radio" name="status" id="statusActive" value="1"> Active
						</label>
						<label class="radio-inline">
						  <input type="radio" name="status" id="statusInactive" value="0"> Inactive
						</label>
						
					  </div>
					<button type="button" id="btnAddUser" class="btn btn-primary">Submit</button>
					<button type="button" id="btnUpdateUser" class="btn btn-primary" style="display:none;">Update</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
					</form>
					<!-- END FORM-->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteUserModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Resource</h4>
      </div>
      <div class="modal-body">
					Are You Sure ? You Want To Delete This Resource.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlUser">Delete</button>
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(function() {
	//loadAppointmentTypes();
	$("#btnAddUser").click(function(){
		addUser();
	});
	/*$("#btnUpdateUser").click(function(){
		updateUser();
	});*/
	$('#userModel').on('hidden.bs.modal', function (e) {
		$("#btnAddUser").show();
		$("#btnUpdateUser").fadeOut();
		$("#email").val("");
		$("#email").removeAttr("disabled");
		$("#firstname").val("");
		$("#lastname").val("");
		$("#mobileno").val("");
	});
	$("#dlUser").click(function(){
		deleteUser($(this).attr("data"));
	});
});
function loadUserPage(Email){
	$.ajax({
        type:"post",
        data:{email:Email},
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("userPage")); ?>',
        success: function(data){
			$("body").html(data);
			$("#loader").remove();
        }
    });	
}
function loadAppointmentTypes(){
	$.ajax({
        type:"get",
        data:{},
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("loadAppointmentTypes")); ?>',
        success: function(data){
			$("#insp_type_id").html("");
           for(var i=0;i<data.data.app_types.length;i++){
				$("#insp_type_id").append("<option value='"+data.data.app_types[i]['inspectionTypeId']+"'>"+data.data.app_types[i]['typeName']+"</option>");
		   }
        }
    });	
}
function addUser(){
	var d = $("#frmUser").serializeArray();
	$.ajax({
        type:"post",
        data:d,
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("createResource")); ?>',
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
function loadUser(uEmail){
	$.ajax({
        type:"post",
        data:{email:uEmail},
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("loadUserData")); ?>',
        success: function(data){
			if(data.status=="success"){
				$("#btnAddUser").hide();
				$("#btnUpdateUser").fadeIn();
				$("#uemail").val(data.data.userData[0]['email']);
				$('#userModel').modal('show');
				$("#email").val(data.data.userData[0]['email']);
				$("#email").attr("disabled","disabled");
				$("#firstname").val(data.data.userData[0]['firstname']);
				$("#lastname").val(data.data.userData[0]['lastname']);
				$("#mobileno").val(data.data.userData[0]['mobileNo']);
				$("#uemail").val(data.data.userData[0]['email']);	
				if(data.data.userData[0]['gender']==1){
					$("#genderMale").attr("checked","checked");
				}else{
					$("#genderFemale").attr("checked","checked");
				}
            }
			
        }
    });
}

function displayDeleteUser(id){
	$('#deleteUserModel').modal('show');
	$("#dlUser").attr("data",id);
}
function deleteUser(ID){
	$.ajax({
        type:"post",
        data:{id:ID},
        url: '<?php echo base_url($this->schedular_auth->makeBaseURL("deleteResource")); ?>',
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

</script>