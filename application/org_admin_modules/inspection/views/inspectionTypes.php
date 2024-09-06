	<div class="pull-right">
		<button class="btn btn-primary" data-toggle="modal" data-target="#inspectionModel" id="btnAddAppointmetType">
		  Add Master Calendar
		</button>
	</div>
	<input type="hidden" value="<?php echo base_url($this->schedular_auth->makeBaseURL()); ?>" id="base_url"/>
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
						<th>Master Calendars</th>
						<th>Created On</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php if(isset($inspections) && $inspections && count($inspections)>0): 
							foreach($inspections as $index=>$insp): ?>
							<tr>
								<td><?php echo ($index+1); ?></td>
								<td><a href="javascript:void(0);" onClick="loadInspectionType('<?php echo $insp->inspectionTypeId; ?>');"><?php echo $insp->typeName; ?></a></td>
								<td><?php echo $insp->createdOn; ?></td>
								<td><a href="javascript:void(0);" onClick="displayDeleteInspection('<?php echo $insp->inspectionTypeId; ?>');"><i class="fa fa-times"></i></a></td>
							</tr>
					<?php endforeach;?>
					<?php else:?>
							<tr>
								<td colspan=4><h3 class="text-center">There is No Master Calendar Found.</h3></td>	
							</tr>
					<?php endif; ?>
				</tbody>
			</table>
			
		</div>
	</div>
<!-- Modal User-->
<div class="modal fade" id="inspectionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Master Calendar</h4>
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
					<form role="form" method="post" id="frmInspection">
						<input type="hidden" value="<?php echo base_url(); ?>" id="base_url">
					  <div class="form-group">
						<label for="inspectionType">Master Calendar Name</label>
						<input type="text" class="form-control" name="inspectionType" id="inspectionType" placeholder="Master Calendar Name">
						<input type="hidden" name="inspectionTypeId" id="inspectionTypeId">
					  </div>
                        <div class="form-group" id="appUsers" style="display:none;"> </div>
                        <div class="form-group" id="addMoreAppUsers" style="display:none;"></div>
                        <div class="form-group">  
                            <button type="button" id="btnAddUsers" class="btn btn-link" style="display:none;">Add More Calendars</button>
					   </div>
					<button type="button" id="btnAddInspection" class="btn btn-primary">Submit</button>
					<button type="button" id="btnUpdateInspection" class="btn btn-primary" style="display:none;">Update</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
					</form>
					<!-- END FORM-->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteInspectionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Master Calendar</h4>
      </div>
      <div class="modal-body">
					Are You Sure ? You Want To Delete This Master Calendar.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlInsp">Delete</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url1().'inspection/assets/js/appointmentTypes.js'; ?>"></script>