<div id="userAppPage">
<script>
  $(function () {
    $('#myTab a:first').tab('show');
  })
</script>
<div class="span12">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
		<li role="presentation" class="active"><a href="#userProfile" role="tab" data-toggle="tab">Appointment Details</a></li>
		<li role="presentation"><a href="#configuration" role="tab" data-toggle="tab"><?php if(isset($isAutoBooking) && $isAutoBooking):?>Appointment Status<?php else: ?>Appointment Allotment<?php endif;?></a></li>
    </ul>
	<?php if(isset($unAuthorizedEmail) && $unAuthorizedEmail):?>
		<div class="alert alert-warning alert-dismissible" role="alert" style="margin-top:20px;">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<strong>Error !!!</strong> <?php echo $unAuthorizedEmail; ?>
		</div>
	<?php else:?>
		<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="userProfile" style="margin-top:20px;">
			<input type="hidden" value="<?php echo base_url($this->schedular_auth->makeBaseURL()); ?>" id="base_url"/>
			<div class="span7">
				<div class="alert alert-warning alert-dismissible" role="alert" id="generalError" style="display:none;">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Errors !!!</strong> <span id="generalEMsg"></span>
				</div>
				<div class="alert alert-success alert-dismissible" role="alert" id="generalSuccess" style="display:none;">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Success !!!</strong> <span id="generalSMsg"></span>
				</div>
			</div>
			<form role="form" id="frmUserProfile">
				<fieldset class="span5">
					<legend>
						<?php echo "Appointment Information"; ?>
					</legend>
					
					<div class="form-group">
						<div class="alert alert-warning alert-dismissible" role="alert" id="userError" style="display:none;">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong>Errors !!!</strong> <span id="userEMsg"></span>
						</div>
						<div class="alert alert-success alert-dismissible" role="alert" id="userSuccess" style="display:none;">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong>Success !!!</strong> <span id="userSMsg"></span>
						</div>
					</div>
					<input type="hidden" id="app_id" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->app_id; ?>" />
					<input type="hidden" id="pageId" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->user_id; ?>" />
					<div class="form-group">
						<label for="title">Appointment Title</label>
						<input type="text" class="form-control" name="title" id="title" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->app_title;?>" disabled placeholder="Appointment Title">
					</div>
					<div class="form-group">
						<label for="name">Name </label>
						<input type="text" class="form-control" name="name" id="name" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->applicant_name;?>" disabled placeholder="Applicant Name">
					</div>
					<div class="form-group">
						<label for="email">Email </label>
						<input type="text" class="form-control" name="email" id="email" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->applicant_email;?>" disabled placeholder="Applicant Email">
					</div>
					<div class="form-group">
						<label for="start">Start </label>
						<input type="text" class="form-control" name="start" id="start" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->app_start;?>" disabled placeholder="Appointment Start Date">
					</div>
					<div class="form-group">
						<label for="end">End </label>
						<input type="text" class="form-control" name="end" id="end" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->app_end;?>" disabled placeholder="Appointment End Date">
					</div>
					<div class="form-group">
						<label for="createdon">Appointment CreatedOn </label>
						<input type="text" class="form-control" name="createdon" id="createdon" value="<?php if(isset($appInfo) && $appInfo){$this->load->helper('timezoneformater');echo unix_to_local($appInfo[0]->appointmentCreatedOn,$appInfo[0]->app_timezone,false);}?>" disabled placeholder="Appointment CreatedOn">
					</div>
				</fieldset>
			</form>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="configuration" style="margin-top:20px;">
			<form class="row-fluid" id="frmAllocateApp">
			<?php if((isset($isAutoBooking) && $isAutoBooking) || (isset($rejected) && $rejected)):?>
				<fieldset class="span12 pull-left" id="isAutoBookingDiv">
						<legend>
							<?php if(isset($rejected) && $rejected):?> 
								<div class="alert alert-warning alert-dismissible" role="alert">
										<strong>This Booking Is Rejected</strong>
								</div>
								Booking Details
							<?php else:?>
								Booking Scheduled
							<?php endif;?>
						</legend>
						<div class="form-group">
							<?php 
								$startDT=0;$endDT=0;
								if(isset($allocatedApp) && $allocatedApp && isset($allocatedApp[0]->allocatedDate) && $allocatedApp[0]->allocatedDate){
									$startDT=strtotime($allocatedApp[0]->allocatedDate);
								}
								if(isset($allocatedApp) && $allocatedApp && isset($allocatedApp[0]->allocatedDateEnd) && $allocatedApp[0]->allocatedDateEnd){
									$endDT=strtotime($allocatedApp[0]->allocatedDateEnd);
								}
							?>
							<strong><?php if(isset($appInfo) && $appInfo && isset($appInfo[0]->app_title) && $appInfo[0]->app_title)echo $appInfo[0]->app_title." (".round(abs($endDT - $startDT) / 60,2). " min )"; ?></strong> 
							<p><?php if(isset($rejected) && $rejected)echo "Rejected"; else echo "Scheduled"; ?></p>
							<p><?php if(isset($allocatedApp) && $allocatedApp && isset($allocatedApp[0]->allocatedDate) && $allocatedApp[0]->allocatedDate)echo date("D, M d, Y, h:i a",strtotime($allocatedApp[0]->allocatedDate));if(isset($allocatedApp) && $allocatedApp && isset($allocatedApp[0]->allocatedDateEnd) && $allocatedApp[0]->allocatedDateEnd)echo " - ".date("h:i a",strtotime($allocatedApp[0]->allocatedDateEnd));?></p>
							<strong>Booking page</strong> 
							<p><?php if(isset($pageInfo) && $pageInfo && isset($pageInfo[0]->booking_url) && $pageInfo[0]->booking_url)echo $pageInfo[0]->booking_url;?></p>

							<strong>Applicant</strong> 
							<p><?php if(isset($appInfo) && $appInfo && isset($appInfo[0]->applicant_name) && $appInfo[0]->applicant_name)echo $appInfo[0]->applicant_name; if(isset($appInfo) && $appInfo && isset($appInfo[0]->applicant_email) && $appInfo[0]->applicant_email)echo " (".$appInfo[0]->applicant_email.")";?></p>
						</div>	
				</fieldset>
				<?php else:?>
				<fieldset class="span12 pull-left" id="isManualBookingDiv">
					<legend>
						<?php echo "Allocate Available Slot For Appointment"; ?>
					</legend>
						<input type="hidden" id="Allocateuser_id" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->user_id; ?>"/>
						<input type="hidden" id="AllocateDate" value="<?php if(isset($appInfo) && $appInfo)echo $appInfo[0]->app_start;?>"/>
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
							<?php if(isset($loadUserSlots) && $loadUserSlots):
								foreach($loadUserSlots as $slots):
							?>
								<label><input type="radio" name="slot" value="<?php echo $slots;?>"><?php echo $slots;?>&nbsp;</label>
								
							<?php endforeach;endif;?>
						</div>
						<div class="form-group" id="appReason" style="display:none;">
							<label for="createdon">Reason For Appointment Rejection * 
								<button type="button" class="save-settings btn btn-primary  btn-xs" id="rejectionEmail">
								 Save & Send Rejection Email
								</button>&nbsp;<span id="emailRejectLoader" class="fa fa-spinner fa-spin" style="display:none;"></span> 
							</label>
							<input type="text" class="form-control" name="reasonText" id="reasonText" placeholder="Rejection Reason">
						</div>
						<button type="button" class="btn btn-primary" id="ApproveAppointment">Approve Appointment </button>
						&nbsp;<span id="emailApproveLoader" class="fa fa-spinner fa-spin" style="display:none;"></span> 
						<button type="button" class="btn btn-danger" id="RejectAppointment">Reject Appointment </button>	
				</fieldset>
				<?php endif;?>
			</form>
		</div>
    </div>
	<?php endif;?> 
</div>
<script type="text/javascript" src="<?php echo base_url1().'appointments/assets/js/userAppointmentPage_js.js'; ?>"></script>