<style>

.mPagesPage{
	cursor:pointer;
}

</style>

<div id="appointmentLoader" style="position: fixed; text-align: center; top: 40%; width: 100%; height: 100%; z-index: 9999; display: none;"><i class="fa fa-spinner fa-spin fa-4x"></i></div>
<div class="container" style="padding:9px;">
<?php  $overLay=$this->input->get("overlay",true);
	if(isset($overLay) && $overLay=='true'):?>
	<div class="row">
		<?php if(isset($changeResource) && $changeResource && isset($pageInfo) && $pageInfo && isset($pageInfo[0]->booking_url) && $pageInfo[0]->booking_url):?>
				<h2 class="text-center" id="appDashboardHead"> <?php echo $bookingLbl." : ".$pageInfo[0]->booking_url."&nbsp;"; ?><span style="font-size: 15px;"><a href="./<?php echo $backUrl; ?>" id="changebookingPage">( change booking page)</a></span>
				<h4 class="text-center" style="padding: 10px;"><span id="timeZoneData"></span> &nbsp;&nbsp;<a href="javascript:void(0);" id="changeTimezone" style="display:none;" onClick="showTimeZoneModal();">( change )</a></h4>
			<?php else : ?>
				<h4 class="text-center" style="padding: 10px;"><span id="timeZoneData"></span> &nbsp;&nbsp;<a href="javascript:void(0);" id="changeTimezone" style="display:none;" onClick="showTimeZoneModal();">( change )</a></h4>
				</h2>
		<?php endif; ?>
	</div>
	<?php endif;?>
	<div class="row" id="containerAppointmentRow">
			<div class="col-xs-3 col-md-3 col-sm-3" id="leftSide">
				<div style="font-size: 30px;"><?php if(isset($pageInfo) && $pageInfo && isset($pageInfo[0]->name) && $pageInfo[0]->name): echo $pageInfo[0]->name;else: echo $pageInfo[0]->typeName; endif;?></div>
				<div class="well" style="min-height: 372px;overflow: auto;">
					<div class="form-group">
						<?php if(isset($PageLogo) && $PageLogo): ?>
							<img src="<?php echo $PageLogo; ?>" title="Master Booking Page Logo"/>
						<?php endif; ?>
						<h4>
							<?php if(isset($pageInfo) && $pageInfo && isset($pageInfo[0]->name) && $pageInfo[0]->name)echo $pageInfo[0]->name;else echo $pageInfo[0]->typeName;?>
						</h4>
					</div>
					<hr/>
					<?php if(isset($pageInfo) && $pageInfo):?>
					<div class="form-group">
						<p>
						<?php if(isset($pageInfo) && $pageInfo)echo $pageInfo[0]->pageInfo;?>
						</p>
					</div>
					<?php endif;?>
					<?php if(isset($pageInfo) && $pageInfo && (isset($pageInfo[0]->mobileNo) && $pageInfo[0]->mobileNo || isset($pageInfo[0]->phone) && $pageInfo[0]->phone)):?>
					<div class="form-group">
						<label>Phone</label>
						<h5><?php if(isset($pageInfo) && $pageInfo && isset($pageInfo[0]->mobileNo) && $pageInfo[0]->mobileNo)echo $pageInfo[0]->mobileNo;else echo $pageInfo[0]->phone;?></h5>
					</div>
					<?php endif;?>
					<?php if(isset($pageInfo) && $pageInfo && isset($pageInfo[0]->email) && $pageInfo[0]->email):?>
					<div class="form-group">
						<label>Email</label>
						<h5><?php if(isset($pageInfo) && $pageInfo)echo $pageInfo[0]->email;?></h5>
					</div>
					<?php endif;?>
					<hr/>
				</div>
			</div>
			<?php if(isset($pageDisabled) && $pageDisabled): ?>
				<div class="col-md-9 col-xs-9 col-sm-9">
					<div id="masterPagePages" class="text-center"><h1 class="fa fa-lock fa-5x"></h1><h2>Sorry, no more bookings can be accepted at this time</h2></div>
				</div>
			<?php elseif(isset($overLay) && $overLay=='true'):?>
					<div class="col-xs-9 col-sm-9 col-md-9 well" id="middleSide" style="border-color: #759696;border-radius: 4px;">
						<div class="col-xs-7 col-sm-7 col-md-7">
							<div id="calendarMaster"></div>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 pull-right" style="border: 1px solid #ebebeb;overflow: auto;">
							<div style="margin-top: 20px;">
									<div class="alert alert-warning alert-dismissible" role="alert" id="TimeError" style="display:none;">
											<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<span id="TimeEMsg"></span>
									</div>
									<div class="radio" id="orgslots" style="height: 338px;overflow: auto;min-width: 110px;"></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #c8c8c8; margin: 3px 3px 3px 3px;">
							<div class="form-group" style="padding: 4px 0px 23px 0px;">
								<button class="btn btn-primary pull-right" id="btnNextStep">Next</button>
							</div>
						</div>
						<legend></legend>
						<div class="form-group">
							<h3>Selected time</h3>
							<span id="selectedTimeSlot">No time selected</span>
						</div>
					</div>
					
					<div class="well col-xs-9 col-sm-9 col-md-9" id="appointmentForm" style="display:none;">
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
							<input type="text" class="form-control" name="title" value="<?php echo $this->input->get("subject",true); ?><?php if(isset($title) && $title) echo $title;?>" id="title" placeholder="What is the meeting about?">
							<input type="hidden" name="start" id="startdate">
							<input type="hidden" name="timezone" id="timezone" value="<?php if(isset($timezone) && $timezone)echo $timezone;?>">
							<input type="hidden" name="mPageId" id="mPageId" value="<?php if(isset($mPageId) && $mPageId)echo $mPageId;?>">
							<input type="hidden" name="appId" id="appId" value="<?php if(isset($appId) && $appId)echo $appId;?>">
						  </div>
						  <div class="form-group">
							<label for="title">Your name<sup></sup></label>
							<input type="text" class="form-control" name="name" value="<?php echo $this->input->get("name",true); ?><?php if(isset($name) && $name) echo $name;?>" id="name" placeholder="Enter your name">
						  </div>
						  <div class="form-group">
							<label for="title">Your email<sup>*</sup></label>
							<input type="text" class="form-control" name="email" value="<?php echo $this->input->get("email",true); ?><?php if(isset($email) && $email) echo $email;?>" id="email" placeholder="Enter your email">
							<p class="help-block">The scheduling confirmation will be sent to this email</p>
						  </div>
						  <div class="form-group">
							<label for="title">Phone<sup>*</sup></label>
							<input type="text" class="form-control" name="phone" value="<?php echo $this->input->get("phone",true); ?><?php if(isset($phone) && $phone) echo $phone;?>" id="phone" placeholder="Enter your phone">
						  </div>
						  <div class="form-group">
							<label for="title">Location<sup></sup></label>
							<input type="text" class="form-control" disabled="disabled" name="location" value="<?php if($this->input->get("location",true)){ echo  $this->input->get("location",true);} else {if(isset($location) && $location) echo $location ;} ?>" id="location">
						  </div>  
						  <div class="form-group">
							<label for="startdate">Your note</label>
							<textarea class="form-control" name="desc" id="desc" value="<?php if(isset($desc) && $desc) echo $desc;?>" rows="3"></textarea>
						  </div>
						  <div class="form-group">
							  <button type="button" id="btnAddAppointment" class="btn btn-primary pull-right">Done</button>
							  <i id="btnAppointmentLoader" class="fa fa-spinner fa-spin fa-2x pull-right" style="display:none;"></i>
						  </div>
						</form>
						<!-- END FORM-->
					</div>
				<?php elseif(isset($overLay) && $overLay=='false' || isset($masterPagePages) && $masterPagePages && count($masterPagePages)>0):?>
					<div id="masterPagePages" class="col-md-9 col-xs-9 col-sm-9">
						<div class='text-center' style="font-size: 30px;" id="appDashboardHead"><?php if(!isset($pageDisabled) || !$pageDisabled): ?><?php if(isset($pageInfo) && $pageInfo && isset($pageInfo[0]->instruction) && $pageInfo[0]->instruction)echo $pageInfo[0]->instruction;else echo "Select Team Member";?><?php else: echo ""; endif; ?></div>
						<div class="span9 table-responsive">
							<table class="table table-hover">
								<tbody>
									<?php foreach($masterPagePages as $i=>$pages):?>
										<form name="frmSendPageId" id="<?php echo "frm_".$pages[0]->org_user_id; ?>" method="post"><tr class="mPagesPage" data-id="<?php echo $pages[0]->org_user_id; ?>"><td><input type="hidden" name="pageId" value="<?php echo $pages[0]->org_user_id; ?>"/><label><?php echo $pages[0]->name; ?></label><p class="help-block"><?php echo $pages[0]->pageInfo; ?></p></td><td><button class="btn btn-primary pull-right">Book Now</button></td></tr></form>
									<?php endforeach;?>
								</tbody>
							</table>	
						</div>
					</div>
				<?php endif;?>
	</div>
</div>
<!-- Modal Holiday-->
<!-- Modal Timezones-->
<?php if(isset($displayTimezone) && $displayTimezone):?>
<div class="modal fade" id="TimezoneModel" tabindex="-1" role="dialog" aria-labelledby="timezoneLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
			<!-- BEGIN FORM-->
			<form role="form" method="post">
			  <div class="form-group">
				<label for="title">All times will be displayed according to your time zone:</label>
				<?php  echo timezone_menu();?>
			  </div>			  
			  <button type="button" id="btnSetTimezone" class="btn btn-primary">Next</button>
			</form>
			<!-- END FORM-->
      </div>
    </div>
  </div>
</div>
<?php endif;?>
<!-- <input type="hidden" id="current_url" value="<?php //echo current_url(); ?>"/> -->
<?php if(!isset($pageDisabled) || !$pageDisabled): ?>
<?php 
	$cUrl=$this->uri->segment_array();
	$cUrl=base_url1().$cUrl[1]."/".$cUrl[2];
?>

<input type="hidden" id="slotsGap"/>
<input type="hidden" id="loadHolidayURL" value="<?php echo $cUrl."/loadholidaysData"; ?>"/>
<input type="hidden" id="AddAppURL" value="<?php echo $cUrl."/createAppointmentMaster"; ?>"/>
<input type="hidden" id="current_url" value="<?php echo $cUrl; ?>"/>
<link href='<?php echo base_url1().'admins/assets/css/fullcalendar.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'applicant/assets/css/jquery-ui.theme.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'admins/assets/css/fullcalendar.print.css'; ?>' rel='stylesheet' media='print' />
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/moment.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/fullcalendar.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/jquery.cookie.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'applicant/assets/js/masterCal.js'; ?>'></script>


	<?php if(isset($displayTimezone) && $displayTimezone):?>
		<script type="text/javascript">
			$(function() {
				$("#calendarMaster").html("<h2 id='loadingCal' class='text-center'>Loading Calendar...<span class='fa fa-cog fa-spin'></span></h2>");
				var url=$("#current_url").val();
				var tCookieVal=$.cookie("yourTimeZoneVal");
				var tCookieText=$.cookie("yourTimeZoneText");
				var token=$("#authToken").val();
				if(!tCookieVal) {
					showTimeZoneModal();
				}else{
					$.ajax({
						type:"post",
						data:{timezone:tCookieVal,timezoneText:tCookieText},
						url: url+'/setTimeZone',
						beforeSend: function (xhr) {
							xhr.setRequestHeader ("Authorization", "Basic "+token);
						},
						success: function(data){
							if(data.status=="success"){
								$("#fade").fadeOut();
								fullCal();
								$("#timeZoneData").html(data.data.timezoneText);
								$("#timezone").val(data.data.timezone);
								$("#changeTimezone").fadeIn();
							}
							if(data.status=="error"){
								$("#calendarMaster").html("<h2 id='loadingCal' class='text-center'>Loading Calendar...<span class='fa fa-cog fa-spin'></span></h2>");
							}
						}
					});
				}
				  $("#btnSetTimezone").click(function(){
					var timeVal=$("select[name='timezones']").val();
					var timeText=$("select.form-control option:selected").text();
					var token=$("#authToken").val();
					$.ajax({
						type:"post",
						data:{timezone:timeVal,timezoneText:timeText},
						url: url+'/setTimeZone',
						beforeSend: function (xhr) {
							xhr.setRequestHeader ("Authorization", "Basic "+token);
						},
						success: function(data){
							if(data.status=="success"){
								$("#fade").fadeOut();
								$('#TimezoneModel').modal('hide');
								fullCal();
								$("#timeZoneData").html(data.data.timezoneText);
								$("#timezone").val(data.data.timezone);
								$("#changeTimezone").fadeIn();
							}
							if(data.status=="error"){
								$("#calendarMaster").html("<h2 id='loadingCal' class='text-center'>Loading Calendar...<span class='fa fa-cog fa-spin'></span></h2>");
							}
						}
					});
					$.cookie("yourTimeZoneVal", timeVal);
					$.cookie("yourTimeZoneText", timeText);
				});
			});
		</script>
	<?php else:?>
		<script type="text/javascript">
			$(window).load(function() {
				fullCal();
				$("#fade").fadeOut();
			});
		</script>
	<?php endif; ?>
<?php endif;?>
<script type="text/javascript">
	$(".mPagesPage").click(function(){
		var id=$(this).attr('data-id');
		document.getElementById("frm_"+id).submit();
	});
</script>