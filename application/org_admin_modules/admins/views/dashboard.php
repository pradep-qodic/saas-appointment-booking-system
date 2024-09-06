<style>
.tab-pane {

    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    border-radius: 0px 0px 5px 5px;
    padding: 10px;
}

.nav-tabs {
    margin-bottom: 0;
}
#calendarAdminDashboard {
	max-width: 900px;
	margin: 0 auto;
}
.activityStreamData,.trashActivityStreamData{
	
}
.activityStreamData:hover,.trashActivityStreamData:hover{
	background-color: aliceblue;
	cursor: pointer;
}
</style>
<div style="margin-top: 20px;">
	<div class="">
		<fieldset class="col-md-8">
			<span style="font-size: 22px;">Welcome to Scheduler</span>
			<p class="help-block">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p>
		</fieldset>
		<fieldset class="well col-md-4">
			<i class="fa fa-chain-broken fa-2x" style=""></i>
			<a href="#" id="bookingPageLinks">Your Booking page links</a>
		</fieldset>
	</div>
	<div class="col-md-12">
		<div role="tabpanel">
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#activity_stream" aria-controls="activity_stream" role="tab" data-toggle="tab"><b>Activity Stream</b></a></li>
		    <li role="presentation"><a href="#trash" aria-controls="trash" role="tab" data-toggle="tab"><b>Trash</b></a></li>
		  </ul>
		
		  <!-- Tab panes -->
		  <div class="tab-content" style="/*margin-top: 20px;border: 1px solid black; min-height: 450px; */">
		    <div role="tabpanel" class="tab-pane active" id="activity_stream">
		    	<div class="well" style="background-color:lightblue;">
		    		<div class="row">
		    			<div class="form-group col-md-1" style="margin-top: 25px;">
						  <button class="btn btn-primary btn-sm" id="btnRefresh"><i class="fa fa-refresh"></i>&nbsp;Refresh</button>
						</div>
						<!--
		    			<div class="form-group col-md-2">
						   <label for="inputPassword3" class="control-label">View by</label>
						   <select class="form-control input-sm">
								  <option>Last updated</option>
								  <option>Meeting time</option>
							</select>
						</div>
						 <div class="form-group col-md-2">
						   <label for="inputPassword3" class="control-label">Updated</label>
						   <select id="dateFilter" onchange="DateFilter()" class="form-control input-sm">
								<option value="0">Today</option>
								<option value="-1">Yesterday</option>
								<option value="-2">Last 2 days</option>
								<option value="-3" selected="selected">Last 3 days</option>
								<option value="-4">Last 4 days</option>
								<option value="-7">Last week</option>
								<option value="-14">Last 2 weeks</option>
								<option value="-21">Last 3 weeks</option>
								<option value="-30">Last month</option>
								<option value="-60">Last 2 months</option>
								<option value="1">Anytime</option>
						 </select>
						</div> -->
						<div class="form-group col-md-2">
						   <label for="inputPassword3" class="control-label">Status</label>
						   <select id="StatusFilter" onchange="loadActivities()" class="form-control input-sm">
								<option selected="selected" value="-2">All</option>
								<option value="-1">Requested</option>
								<option value="1">Scheduled</option>
								<option value="2">Rescheduled</option>
								<!-- <option value="4">Completed</option> -->
								<option value="0">Canceled</option>
								<!-- <option value="6">No-show</option> -->
						  </select>
						</div>
						<!-- <div class="form-group col-md-2">
						   <label for="inputPassword3" class="control-label">Service</label>
						   <select id="ServiceFilter" onchange="rebuildTable()" class="form-control input-sm">
								<option value="ALL" selected="selected">No filter</option>
								<option value="SER_LjzTnlsZdQgnrV4qVG/rrOXmrcwzYWUnFUA9f091Erj85IrtQM/F6Qqualqual">first service</option>
								<option value="SER_/blNXN6v6i4nrV4qVG/rrOXmrcwzYWUnFUA9f091Erj85IrtQM/F6Qqualqual">second services</option>
						   </select>
						</div>-->
						<div class="form-group col-md-2">
						   <label for="inputPassword3" class="control-label">Source</label>
						   <select id="SourceFilter" onchange="loadActivities()" class="form-control input-sm">
								<option value="ALL" selected="selected">All</option>
								<option value="ALL_BP">All Booking pages</option>
								<?php if(isset($BPages)):?>
									<?php foreach($BPages as $b):?>
										<option value="BP_<?php echo $b->org_user_id; ?>"> - <?php echo $b->name; ?></option>
									<?php endforeach;?>
								<?php endif;?>
								<option value="ALL_MBP">All Master booking pages</option>
								<?php if(isset($MBPages)):?>
									<?php foreach($MBPages as $mb):?>
										<option value="MBP_<?php echo $mb->inspectionTypeId; ?>"> - <?php echo $mb->typeName; ?></option>
									<?php endforeach;?>
								<?php endif;?>
						  </select>
						</div> 
		    		</div>	
		    	</div>
		    	<div class="row" style="margin-right: 0px;margin-left: 0px;">
		    		<div class="col-md-8" id="activities" style="background-color: #f5f5f5;border: 1px solid #e3e3e3;border-radius: 4px;overflow: auto;max-height: 300px;">
		    			<?php $this->load->view('dashboard_activities');?>
			    	</div>
		    		<div class="col-xs-12 col-md-4 well pull-right" id="activityDetail" style="min-height: 300px;">
		    			<i class="fa fa-reply fa-4x"></i>
		    			<h3>Click an activity to see its details</h3>
		    		</div>
		    	</div>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="trash">
		    	<div class="row" style="margin-right: 0px;margin-left: 0px;">
		    		<div class="col-md-8" id="trashActivities" style="background-color: #f5f5f5;border: 1px solid #e3e3e3;border-radius: 4px;overflow: auto;max-height: 300px;">
		    			<?php $this->load->view('trash_activities');?>
			    	</div>
		    		<div class="col-xs-12 col-md-4 well pull-right" id="trashActivityDetail" style="min-height: 300px;">
		    			<i class="fa fa-reply fa-4x"></i>
		    			<h3>Click an activity to see its details</h3>
		    		</div>
		    	</div>
		    </div>
		  </div>
		</div>
	</div>
	<div class="col-md-12" style="margin-top: 20px;">
		<legend></legend>
		<fieldset class="col-md-4">
			<div class="form-group" style="max-width: 500px;">
				<label>Select Booking Page</label>
				<select class="form-control" id="dropdownPageList">
					<?php if(isset($pageList) && $pageList): ?>
				  		<?php foreach($pageList as $page):?>
				  		<option value="<?php echo $page->org_user_id; ?>"><?php echo $page->name." (".$page->booking_url." )"; ?></option>
				  		<?php endforeach;?>
				  	<?php endif; ?>
				</select>
			</div>
			<div id="pageInfoTable">
				
			</div>
		</fieldset>
		<fieldset class="col-md-8">
			<div class="form-group">
				<div id="calendarAdminDashboard"></div>
			</div>
		</fieldset>
	</div>
</div>
<!-- delete activity -->
<div class="modal fade" id="deleteActivityModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Activity</h4>
      </div>
      <div class="modal-body">
					<div class="alert alert-warning alert-dismissible" role="alert" id="error" style="display:none;">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Errors !!!</strong> <span id="errorMSG"></span>
					</div>
					Are You Sure ? You Want To Delete This Activity.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlActivity">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- schedule acitity -->
<div class="modal fade" id="scheduleActivityModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">schedule request</h4>
      </div>
      <div class="modal-body">
			<fieldset>
				<legend>
					<?php echo "Allocate Available Slot For Appointment"; ?>
				</legend>
					<input type="hidden" id="app_id"/>
					<input type="hidden" id="Allocateuser_id"/>
					<input type="hidden" id="AllocateDate"/>
					<div class="form-group">
						<div class="alert alert-warning alert-dismissible" role="alert" id="sError" style="display:none;">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong>Errors !!!</strong> <span id="sEMsg"></span>
						</div>
						<div class="alert alert-success alert-dismissible" role="alert" id="sSuccess" style="display:none;">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong>Success !!!</strong> <span id="sSMsg"></span>
						</div>
					</div>
					<div class="radio" style="max-width:400px;" id="appSlots">
						<label><input type="radio" name="slot">&nbsp;</label>
					</div>
					<div class="form-group" id="appReason" style="display:none;">
						<label for="createdon">Reason For Appointment Cancel * 
							<button type="button" class="save-settings btn btn-primary  btn-xs" id="rejectionEmail">
							 Save & Send Cancel Email
							</button>&nbsp;<span id="emailRejectLoader" class="fa fa-spinner fa-spin" style="display:none;"></span> 
						</label>
						<input type="text" class="form-control" name="reasonText" id="reasonText" placeholder="Rejection Reason">
					</div>
					<button type="button" class="btn btn-primary" id="ApproveAppointment">Approve Appointment </button>
					&nbsp;<span id="emailApproveLoader" class="fa fa-spinner fa-spin" style="display:none;"></span> 
					<button type="button" class="btn btn-danger" id="RejectAppointment">Cancel Appointment </button>	
			</fieldset>			 
      </div>
    </div>
  </div>
</div>
<!-- reschedule acitity -->
<div class="modal fade" id="rescheduleActivityModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Reschedule request</h4>
      </div>
      <div class="modal-body">
			<div class="alert alert-warning alert-dismissible" role="alert" id="errorRe" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="errorReMSG"></span>
			</div>
			<h4><i class="fa fa-calendar fa-2x"></i>&nbsp;Cancel the booking and send a reschedule request to <span class="appName"></span></h4>
			<div class="form-group" style="width:460px;">
				<label>Tell <span class="appName"></span> why you need to reschedule:</label>
				<textarea class="form-control" id="rescheduleReason" rows="3"></textarea>
			</div>
			<button type="button" class="btn btn-primary" id="sendRescheduleRequest">Cancel & send request&nbsp;<i class="fa fa-spin fa-spinner" id="rescheduleSpinner" style="display: none;"></i></button>			 
      </div>
    </div>
  </div>
</div>
<!-- request New Time acitity -->
<div class="modal fade" id="requestNewTimeActivityModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Request new times</h4>
      </div>
      <div class="modal-body">
			<div class="alert alert-warning alert-dismissible" role="alert" id="errorReNTime" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="errorReNTimeMSG"></span>
			</div>
			<h4><i class="fa fa-calendar fa-2x"></i>&nbsp;Cancel the booking request and send a request for new times to <span class="appName"></span> </h4>
			<div class="form-group" style="width:460px;">
				<label>Tell <span class="appName"></span> why you are requesting new times:</label>
				<textarea class="form-control" id="requestNewTime_reson" rows="3"></textarea>
			</div>
			<button type="button" class="btn btn-primary" id="sendRequestNewTime">Cancel & send a new time request&nbsp;<i class="fa fa-spin fa-spinner" id="requestNewTimeSpinner" style="display: none;"></i></button>			 
      </div>
    </div>
  </div>
</div>
<!-- cancel acitity -->
<div class="modal fade" id="cancelActivityModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">You are about to cancel <span></span></h4>
      </div>
      <div class="modal-body">
			<div class="alert alert-warning alert-dismissible" role="alert" id="errorC" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="errorCMSG"></span>
			</div>
			<h4><i class="fa fa-calendar fa-2x"></i>&nbsp;Cancel the booking and send a reschedule request</h4>
			<div class="form-group" style="width:460px;">
				<label>Tell <span class="appName"></span> why you need to cancel:</label>
				<textarea class="form-control" id="cancelReason" rows="3"></textarea>
			</div>
			<div class="checkbox">
			  <label>
			    <input type="checkbox" id="moveTrash">
			      Move this activity to the trash
			  </label>
			</div>
			<div class="checkbox">
			  <label>
			    <input type="checkbox" id="sendCancelEmail">
			    Don't send a Scheduler cancellation email
			  </label>
			</div>
			
			<button type="button" class="btn btn-primary" id="cancelActivity">Cancel activity&nbsp;<i class="fa fa-spin fa-spinner" id="cancelSpinner" style="display: none;"></i></button>			 
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="current_url" value="<?php echo current_url(); ?>"/>
<input type="hidden" id="base_url" value="<?php echo base_url($this->schedular_auth->makeBaseURL()); ?>"/>
<input type="hidden" id="loadHolidayURL" value="<?php echo base_url($this->schedular_auth->makeBaseURL("loadholidaysData")); ?>"/>
<input type="hidden" id="base_url1" value="<?php echo base_url1(); ?>"/>
<link href='<?php echo base_url1().'admins/assets/css/fullcalendar.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'admins/assets/css/jquery-ui.theme.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'admins/assets/css/fullcalendar.print.css'; ?>' rel='stylesheet' media='print' />
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/jquery.zclip.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/moment.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/fullcalendar.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/admins_js.js'; ?>'></script>

