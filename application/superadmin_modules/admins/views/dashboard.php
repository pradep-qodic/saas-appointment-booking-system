<div id="LoadOrg">
<fieldset>
<legend><h1>Organizations</h1></legend>
	<div class="row">
		<div class="span12">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Desc</th>
						<th>org_url</th>
						<th>is_deleted</th>
						<th>status</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($organizations as $org): ?>
					<tr>
						<td><?php echo $org->org_id; ?></td>
						<td><?php echo $org->org_title; ?></td>
						<td><?php echo $org->org_description; ?></td>
						<td><?php echo base_url1().$org->org_url; ?></td>
						<td><?php echo $org->is_deleted; ?></td>
						<td><?php echo $org->status; ?></td>
						<td><a href=""class="org_edit" data_org_status="<?php echo $org->status; ?>" data_org_url="<?php echo $org->org_url; ?>"  data_org_description="<?php echo $org->org_description; ?>" data_org_title="<?php echo $org->org_title; ?>" data_id="<?php echo $org->org_id; ?>" data-toggle="modal"  data-target="#bookingPageModal"><span class="fa fa-pencil"></span></a></td>
						<td><a href="" class="org_delete" data_id="<?php echo $org->org_id; ?>" data-toggle="modal" data-target="#deleteWorkingPlanModel"><span class="fa fa-trash-o"></span></a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</fieldset>
</div>
<!-- Modal Master Booking Page -->
<div class="modal fade" id="bookingPageModal" tabindex="-1" role="dialog" aria-labelledby="myModalMasterBookingLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalMasterBookingLabel">Organizations Page</h4>
      </div>
      <div class="modal-body" id="userModelBody">
			<div class="alert alert-warning alert-dismissible" role="alert" id="generalError" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="generalEMsg"></span>
			</div>
			<div class="alert alert-success alert-dismissible" role="alert" id="generalSuccess" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Success !!!</strong> <span id="generalSMsg"></span>
			</div>
			<div class="form-group"><label>Update Organizations page</label></div>
			<div class="well">
				<!-- BEGIN FORM-->
				<form class="form-horizontal" id="frmUpdateOrg" role="form" method="post">				  				  
				   <div class="form-group">					
					<label for="urlPage" style="WORD-WRAP: break-word;" class="col-sm-6 control-label"> Organizations Name</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control" name="org_name" id="org_name" placeholder="Organizations Name">
					</div>
				  </div>
				   <div class="form-group">					
					<label for="urlPage" style="WORD-WRAP: break-word;" class="col-sm-6 control-label"> Organizations Desc</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control" name="org_desc" id="org_desc" placeholder="Organizations Desc">
					</div>
				  </div>
				   <div class="form-group">					
					<label for="urlPage" style="WORD-WRAP: break-word;" class="col-sm-6 control-label">Organizations url</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control" name="org_url" id="org_url" placeholder="Organizations url">
					  <input type="hidden" class="form-control" name="org_id" id="org_id">
					</div>
				  </div>
				  <div class="form-group">					
					<label for="urlPage" style="WORD-WRAP: break-word;" class="col-sm-6 control-label">Organizations status</label>
					<div class="col-sm-6">					    
						<input type="radio" name="org_status" id="Active" value='1'><label style="margin-left: 8px;margin-right: 10px;">Acitve</label>
					    <input type="radio" name="org_status" id="InActive" value='0'><label style="margin-left: 8px;margin-right: 10px;">InActive</label>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-7 col-sm-5">
					  <button type="button" id="btnupdateOrg" class="btn btn-primary">Update</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
					</div>
				  </div>
				</form>
				<!-- END FORM-->
			</div>	
      </div>
    </div>
  </div>
</div>
<!-- Delete Plan Model-->
<div class="modal fade" id="deleteWorkingPlanModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Organizations</h4>
      </div>
      <div class="modal-body">
					Are You Sure ? You Want To Delete This Organizations.
      </div>
	  <input type="hidden" class="form-control" name="orgid" id="orgid">
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlPlan">Delete</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" value="<?php echo base_url();?>" id="base_url">
<script type="text/javascript" src="<?php echo admin_base_url().'admins/assets/js/super_admin.js'; ?>"></script>