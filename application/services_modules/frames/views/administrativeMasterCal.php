
<style>
#calendar{
	max-width:70%;
}
.mPagesPage{
	cursor:pointer;
}

</style>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-2 col-xs-10 col-xs-offset-2 col-sm-12">
			<div id="calendar" style="margin-top:10px;"></div>
		</div>
	</div>
	
</div>

<!-- Modal -->
<div class="modal fade" id="appointmentDetailsModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Appointment Details</h4>
      </div>
      <div class="modal-body">
       		<div id="appointmentForm">
				<div class="alert alert-warning alert-dismissible" role="alert" id="AppointmentError" style="display:none;">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Errors !!!</strong> <span id="AppointmentEMsg"></span>
				</div>
				<div class="alert alert-success alert-dismissible" role="alert" id="AppointmentSuccess" style="display:none;">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Success !!!</strong> <span id="AppointmentSMsg"></span>
				</div>
				<div class="alert alert-info alert-dismissible" role="alert" id="redirectionMsg" style="display:none;">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>You will be redirected from this page in <span id="redirectionTime"></span></strong>
				</div>
				<!-- BEGIN FORM-->
				<form role="form" method="post" id="frmAppointment">
				  <div class="form-group">
					<label for="title">Subject<sup>*</sup></label>
					<input type="text" class="form-control" name="title" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?> id="title" placeholder="What is the meeting about?">
					<input type="hidden" name="start" id="startdate">
					<input type="hidden" name="timezone" id="timezone">
					<input type="hidden" name="appId" id="appId">
					<input type="hidden" name="pageId" id="pageId">
				  </div>
				  <div class="form-group">
					<label for="title">Name<sup></sup></label>
					<input type="text" class="form-control" name="name" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?> id="name" placeholder="Enter your name">
				  </div>
				  <div class="form-group">
					<label for="title">Email<sup>*</sup></label>
					<input type="text" class="form-control" name="email" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?> id="email" placeholder="Enter your email">
					<p class="help-block">The scheduling confirmation will be sent to this email</p>
				  </div>
				  <div class="form-group">
					<label for="title">Phone<sup>*</sup></label>
					<input type="text" class="form-control" name="phone" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?> id="phone" placeholder="Enter your phone">
				  </div>
				  <div class="form-group">
					<label for="title">Location<sup></sup></label>
					<input type="text" class="form-control" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?> name="location" id="location">
				  </div>  
				  <div class="form-group">
					<label for="startdate">Note</label>
					<textarea class="form-control" name="desc" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?> id="desc" rows="3"></textarea>
				  </div>
				  <div class="form-group">
					<label for="bPages">Booking Page</label>
					<select class="form-control" name="bPages" id="bPages" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?>>
						<?php if(isset($bookingPages) && $bookingPages):
							foreach($bookingPages as $pages):						
						?>
					  	<option value="<?php echo $pages->org_user_id;?>"><?php echo $pages->booking_url; ?></option>
					  	<?php endforeach; endif;?>
					</select>
				  </div>
				  <div class="form-group">
					<label for="date">Date</label>
					<div class="input-group">
					  <input type="text" name="date" <?php if((isset($allowAppointmentEdit) && $allowAppointmentEdit=='false') || (isset($showAvailability) && $showAvailability=='false'))echo "disabled='disabled'";?> id="date" placeholder="Select Date" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
					</div>
				  </div>
				  <div class="form-group">
				  	<label>Available Slots</label>
				  	<select class="form-control" name="dateAvailableSlots" id="dateAvailableSlots" <?php if((isset($allowAppointmentEdit) && $allowAppointmentEdit=='false') || (isset($showAvailability) && $showAvailability=='false'))echo "disabled='disabled'";?>>
				  		
				  	</select>
				  </div>
				 <div class="form-group">
					<label for="duration">duration</label>
					<div class="bfh-timepicker" data-name="duration" data-time="00:30" id="durationpicker" data-align='right'></div>
				  </div>
				  <div class="form-group">
					<label for="appStatus">Appointment Status</label>
					<select class="form-control" name="appStatus" id="appStatus" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?>>
					  <option value="1">Confirmed</option>
					  <option value="3">Pending</option>
					  <option value="0">Canceled</option>
					  <option value="0">Declined</option>
					</select>
				  </div>
				  <div class="form-group">
					<label for="sendNotif">Send Notification ?</label>
					<select class="form-control" name="sendNotif" <?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='false')echo "disabled='disabled'";?> id="sendNotif">
					  <option value="1">Yes</option>
					  <option value="0">No</option>
					</select>
				  </div>
				</form>
				<!-- END FORM-->
			</div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      	<?php if(isset($allowCancel) && $allowCancel=='true'):?>
      		<button type="button" class="btn btn-danger" id="btnCancelApp">Cancel Appointment</button>
      	<?php endif;?>
      	<?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit=='true'):?>
        	<button type="button" id="btnAddAppointment" class="btn btn-primary">Save Changes</button>
        <?php endif;?>
		<i id="btnAppointmentLoader" class="fa fa-spinner fa-spin fa-2x pull-right" style="display:none;"></i>
      </div>
    </div>
  </div>
</div>



<?php //if(!isset($pageDisabled) || !$pageDisabled): ?>
	<input type="hidden" id="showAppointments" value="<?php if(isset($showAppointments) && $showAppointments)echo $showAppointments;?>" />
	<input type="hidden" id="showAvailability" value="<?php if(isset($showAvailability) && $showAvailability)echo $showAvailability;?>" />
	<input type="hidden" id="showUnavailability" value="<?php if(isset($showUnavailability) && $showUnavailability)echo $showUnavailability;?>" />
	<input type="hidden" id="allowAppointmentEdit" value="<?php if(isset($allowAppointmentEdit) && $allowAppointmentEdit)echo $allowAppointmentEdit;?>" />
	<input type="hidden" id="allowCancel" value="<?php if(isset($allowCancel) && $allowCancel)echo $allowCancel;?>" />
	<input type="hidden" id="allowSetUnavailability" value="<?php if(isset($allowSetUnavailability) && $allowSetUnavailability)echo $allowSetUnavailability;?>" />
	<input type="hidden" id="MasterCalId" value="<?php if(isset($MasterCalId) && $MasterCalId)echo $MasterCalId;?>" />
	<input type="hidden" id="authToken" value="<?php if(isset($authToken) && $authToken)echo $authToken;?>" />
	<input type="hidden" id="current_url" value="<?php  echo base_url()."frames/"; ?>"/>
	<input type="hidden" id="loadHolidayURL" value="<?php echo base_url().'frames/loadMasterholidaysData'; ?>"/>
	<input type="hidden" id="AddAppURL" value="<?php echo base_url().'frames/createAppointment'; ?>"/>
	<link href='<?php echo base_url().'frames/assets/css/fullcalendar.css'; ?>' rel='stylesheet' />
	<link href='<?php echo base_url().'frames/assets/css/bootstrap-formhelpers.min.css'; ?>' rel='stylesheet' />
	<!-- <link href='<?php echo base_url().'frames/assets/css/jquery-ui.min.css'; ?>' rel='stylesheet' /> -->
	<link href='<?php echo base_url().'frames/assets/css/jquery-ui.theme.min.css'; ?>' rel='stylesheet' />
	<link href='<?php echo base_url().'frames/assets/css/fullcalendar.print.css'; ?>' rel='stylesheet' media='print' />
	<link href='<?php echo base_url().'frames/assets/css/datepicker3.css'; ?>' rel='stylesheet' />
	<script type="text/javascript" src="<?php echo base_url().'frames/assets/js/bootstrap-datepicker.js'; ?>"></script>
	<script type="text/javascript" src='<?php echo base_url().'frames/assets/js/moment.min.js'; ?>'></script>
	<script type="text/javascript" src='<?php echo base_url().'frames/assets/js/fullcalendar.min.js'; ?>'></script>
	<script type="text/javascript" src='<?php echo base_url().'frames/assets/js/jquery.cookie.js'; ?>'></script>
	<script type="text/javascript" src='<?php echo base_url().'frames/assets/js/bootstrap-formhelpers.js'; ?>'></script>
	<!-- <script type="text/javascript" src="<?php echo base_url().'frames/assets/js/jquery-ui.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'frames/assets/js/jquery-ui-timepicker-addon.js'; ?>"></script> -->
	<script type="text/javascript" src='<?php echo base_url().'frames/assets/js/administrativeMasterCal.js'; ?>'></script>
	
<?php //endif;?>
