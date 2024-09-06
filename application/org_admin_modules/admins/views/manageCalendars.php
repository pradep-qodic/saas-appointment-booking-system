<div id="settings-page" class="span12">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
		<li role="presentation" class="active"><a href="#manageCalendars" role="tab" data-toggle="tab">Manage Calendars</a></li>
		<li role="presentation"><a href="#manageMasterCalendars" role="tab" data-toggle="tab">Manage Master Calendars</a></li>
    </ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="manageCalendars" style="margin-top:20px;">
			<div id="resourceInfo" class="span12">
				<input type="hidden" value="<?php echo base_url($this->schedular_auth->makeBaseURL()); ?>" id="base_url"/>
				<div id="resourcesDropdown">
					<div class="form-group span5">
						<label for="resourceID" class="control-label">Select Resource</label>
						<select class="form-control" id="resourceID">
							<?php if(isset($resources) && $resources && count($resources)>0):
								foreach($resources as $res):
							?>
								<option value="<?php echo $res->org_user_id;?>" <?php if(isset($calendarSelectedId) && $calendarSelectedId && $res->org_user_id==$calendarSelectedId){echo "selected='selected'";}else {echo "";}?>><?php echo $res->name; ?></option>
							<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div id="resourceCal">
					<fieldset class="span7 pull-left">
						<div id="leaveCalendar"></div>
					</fieldset>
					<fieldset class="span4 pull-right">
						<form class="row-fluid" id="frmLeave">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							  <div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
								  <h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									  User Leave Details
									</a>
								  </h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								  <div class="panel-body">
									<div class="form-group">
										<div class="alert alert-warning alert-dismissible" role="alert" id="leaveError" style="display:none;">
												<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<strong>Errors !!!</strong> <span id="leaveEMsg"></span>
										</div>
										<div class="alert alert-success alert-dismissible" role="alert" id="leaveSuccess" style="display:none;">
												<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<strong>Success !!!</strong> <span id="leaveSMsg"></span>
										</div>
									</div>
									<input type="hidden" name="leave_id" id="leave_id"/>
									<input type="hidden" id="luserID" name="luserID"/>
									<div class="form-group">
										<label for="leaveTitle">Leave Title *</label>
										<input type="text" class="form-control" name="leaveTitle" id="leaveTitle" placeholder="Leave Title">
									</div>
									<div class="form-group">
										<label for="startDate">Start Date</label>
										<div class="input-group date">
										  <input type="text" style="z-index: 0;" class="form-control" name="startDate" id="startDate" placeholder="Select Start Date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<div class="form-group">
										<label for="endDate">End Date *</label>
										<div class="input-group date">
										  <input type="text" style="z-index: 0;" class="form-control" name="endDate" id="endDate" placeholder="Select End Date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
										</div>
									</div>
									<button type="button" class="btn btn-primary" id="leaveInfo">Create Leave</button>
									<button type="button" class="btn btn-primary" id="leaveUpdateInfo" style="display:none;">Update Leave</button>
									<button type="button" class="btn btn-primary" id="leaveUpdateCancel" style="display:none;">Cancel</button>	
									<button type="button" class="btn btn-danger" id="leaveDelete" onClick="displayDeleteLeave();" style="display:none;">Delete Leave</button>	
								  </div>
								</div>
							  </div>
							  </form>
							  <form id="frmPlan">
							  <div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingTwo">
								  <h4 class="panel-title">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									  User Working Plan
									</a>
								  </h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
								  <div class="panel-body">
									<div class="form-group">
										<div class="alert alert-warning alert-dismissible" role="alert" id="planError" style="display:none;">
												<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<strong>Errors !!!</strong> <span id="planEMsg"></span>
										</div>
										<div class="alert alert-success alert-dismissible" role="alert" id="planSuccess" style="display:none;">
												<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<strong>Success !!!</strong> <span id="planSMsg"></span>
										</div>
									</div>
									<input type="hidden" id="uID" name="uID"/>
									<div class="form-group">
										<label for="workingDate">Date *</label>
										<input type="text" class="form-control" name="workingDate" id="workingDate" placeholder="Select Date">
									</div>
									<div class="form-group time">
										<label for="startTime">Start Time</label>
										<input type="text" class="form-control" name="startTime" id="startTime" placeholder="Select Start Time">
									</div>
									<div class="form-group time">
										<label for="endTime">End Time *</label>
										<input type="text" class="form-control" name="endTime" id="endTime" placeholder="Select End Time">
									</div>
									<button type="button" class="btn btn-primary" id="savePlan">Save WorkingPlan</button>
									<button type="button" class="btn btn-primary" id="WorkingPlanCancel" style="display:none;">Cancel</button>	
									<button type="button" class="btn btn-danger" id="WorkingPlanDelete" onClick="displayDeleteWorkingPlan();" style="display:none;">Delete</button>	
								  </div>
								</div>
							  </div>
							  </form>
							</div>
					</fieldset>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="manageMasterCalendars" style="margin-top:20px;">
			<?php $this->load->view('inspection/inspectionTypes');?>
		</div>
    </div>
</div>

<!-- delete Leave Model-->
<div class="modal fade" id="deleteLeaveModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Leave</h4>
      </div>
      <div class="modal-body">
					Are You Sure ? You Want To Delete This Leave.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlLeave">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete Working Plan Model-->
<div class="modal fade" id="deleteWorkingPlanModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Working Plan</h4>
      </div>
      <div class="modal-body">
					Are You Sure ? You Want To Delete This Working Plan.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlPlan">Delete</button>
      </div>
    </div>
  </div>
</div>

<link href='<?php echo base_url1().'admins/assets/css/jquery-ui.min.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'users/assets/css/fullcalendar.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'users/assets/css/fullcalendar.print.css'; ?>' rel='stylesheet' media='print' />
<link href='<?php echo base_url1().'users/assets/css/datepicker3.css'; ?>' rel='stylesheet' media='print' />
<script type="text/javascript" src='<?php echo base_url1().'users/assets/js/moment.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'users/assets/js/fullcalendar.min.js'; ?>'></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery-ui.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery-ui-timepicker-addon.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery.jeditable.min.js'; ?>"></script>
<script type="text/javascript" src='<?php echo base_url1().'users/assets/js/bootstrap-datepicker.js'; ?>'></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/manageCalendars_js.js'; ?>"></script>