<div id="bookingLoader" style="position: fixed; text-align: center; top: 40%; width: 100%; height: 100%; z-index: 9999; display: none;"><i class="fa fa-spinner fa-spin fa-4x"></i></div>
<!-- Begin Body -->
<style>
#bookingPageModal .modal-dialog  {width:60%;}

.tab-paneNew {

    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    border-radius: 0px 0px 5px 5px;
    padding: 10px;
}
.nav-tabsNew {
    margin-bottom: 0;
}

</style>
<div class="container">
	<div class="row" id="containerRow">
  			<div class="col-md-2" id="leftCol">
				<div class="form-group">
					<button type="button" class="btn btn-info" data-toggle="modal" id="newBookingPage" data-target="#bookingPageModal">
					  New Booking Page
					</button>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-info" style="display:none;" data-toggle="modal" id="newMasterBookingPage" data-target="#masterBookingPageModal">
					  New Master Booking Page
					</button>
				</div>
              	<ul class="nav nav-pills nav-stacked" id="sidebarBookingPages" style="overflow: hidden;">
                <!-- Ajax Side Menu Will Be Displayed Here-->
              	</ul>
				<ul class="nav nav-pills nav-stacked" id="sidebarMasterBookingPages" style="overflow: hidden;">
                <!-- Ajax Side Menu Will Be Displayed Here-->
              	</ul>
      		</div>  
      		<div class="col-md-10">
              	<div id="rightCol">
					<ul class="nav nav-tabs nav-tabsNew" role="tablist" id="myConfigurationTab">
						<li role="presentation" class="active"><a href="#manageBookingPages" role="tab" data-toggle="tab">Booking pages</a></li>
						<li role="presentation"><a href="#manageMasterBookingPages" role="tab" data-toggle="tab">Master booking pages</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane tab-paneNew fade in active" id="manageBookingPages">
							<div id="noBookingPages" style="display:none;"><h2 class='well text-center'>There are no booking pages.</h2></div>
							<div id="manageBookingPagesTab">
								<div class="form-group well" style="margin-top:20px;">
									<div class="form-group">
										<button type="button" class="btn btn-primary" id="duplicateBookingPage" data-toggle="modal" data-target="#bookingPageModal">
										  Duplicate page
										</button>
										<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#deleteBookingPageModel" id="deleteBookingPage">
										  Delete page
										</button>
									</div>
									<div>
										<h3>Booking page : <label id="bookingPageHeading"></label></h3>
										<h4>Owner : <label id="bookingPageOwner"></label>&nbsp;
											<i class="fa fa-pencil-square-o" id="editpageOwner" style="display:none;"></i>
											<span style="display:none;"><input type="text">&nbsp;<button class="btn btn-primary">Save</button>&nbsp;<button class="btn btn-primary">Cancel</button></span>
										</h4>
									</div>
									<hr style="color: #eee;background-color: #eee;height: 2px;"/>
									
									<div class="alert alert-warning alert-dismissible" role="alert" id="linkError" style="display:none;">
											<strong>This Booking page is disabled</strong> </br><span id="linkEMsg"></span>
									</div>
									<div id="applicantLink"><h3>Customer Link</h3></div>
								</div>
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								  <div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
									  <h3 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" style="text-decoration:none;" href="#collapseBooking" aria-expanded="true" aria-controls="collapseBooking">
										  <i class="fa fa-minus-circle" id="iconBooking"></i> Booking &nbsp;&nbsp;
										</a>
										<button type="button" class="btn btn-primary btn-xs" disabled id="btnBooking">Save Changes</button>
									  </h3>
									</div>
									<div id="collapseBooking" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
									  <div class="panel-body" id="bookingPanel">
										<div class="alert alert-warning alert-dismissible" role="alert" id="bookingError" style="display:none;">
												<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<strong>Errors !!!</strong> <span id="bookingEMsg"></span>
										</div>
										<div class="alert alert-success alert-dismissible" role="alert" id="bookingSuccess" style="display:none;">
												<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<strong>Success !!!</strong> <span id="bookingSMsg"></span>
										</div>
										<div class="form-group">
											<label>Automatic booking or with approval?</label>
										</div>
										<div class="radio">
										 <label>
											<input type="radio" name="bookingAuto" id="bookingAuto" value="1" checked>
											Automatic booking - Booking are automatically created.
										 </label>
										</div>
										<div class="radio">
										  <label>
											<input type="radio" name="bookingAuto" id="bookingApproval" value="0">
											Booking with approval - Need admin approval.
										  </label>
									  	</div>
									  	<hr>
									  	<div class="form-group">
											<label>Automatic Redirect</label>
											<div>Create an automatic redirect when a booking is submitted</div>
										</div>
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="checkRedirect">
											Show the Scheduler confirmation page for 
											<select id="redirectVal">
												<option value="-1">None</option>
												<option value="0">0</option>
												<option value="3">3</option>
												<option value="5">5</option>
												<option value="10">10</option>
												<option value="15">15</option>
												<option value="20">20</option>
											</select> seconds and then redirect to
										  </label>
										</div>
										<div class="form-group">
											<input type="text" class="form-control" style="max-width:50%;" name="redirectionUrl" id="redirectionUrl" placeholder="Enter Redirection Url">
										</div>
									</div>
								  </div>
								  </div>
								  <div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingTwo">
									  <h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" style="text-decoration:none;" data-parent="#accordion" href="#collapseAvailability" aria-expanded="false" aria-controls="collapseAvailability">
										  <i class="fa fa-plus-circle" id="iconAvailability"></i> Availability &nbsp;&nbsp;
										</a>
										<button type="button" style="display:none;" class="btn btn-primary btn-xs" id="btnAvailability">Save Changes</button>
										<input type="hidden" id="current_url" value="<?php echo current_url();?>"/>
									  </h4>
									</div>
									<div id="collapseAvailability" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
									  <div class="panel-body" id="availabilityPanel">
										<ul class="nav nav-tabs" role="tablist" id="collapseAvailabilityTab">
										  <li role="presentation" class="active"><a href="#weeklyRecurringTab" aria-controls="weeklyRecurringTab" role="tab" data-toggle="tab">Weekly recurring</a></li>
										  <li role="presentation"><a href="#dateSpecificTab" aria-controls="dateSpecificTab" role="tab" data-toggle="tab">Date-specific</a></li>
										  <li role="presentation"><a href="#manageHolidays" aria-controls="manageHolidays" role="tab" data-toggle="tab">Manage Holidays</a></li>
										</ul>

										<div class="tab-content">
										  <div role="tabpanel" class="tab-pane fade in active" style="margin-top:20px;" id="weeklyRecurringTab">
											<form>
												<div class="alert alert-warning alert-dismissible" role="alert" id="businessError" style="display:none;">
														<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<strong>Errors !!!</strong> <span id="businessEMsg"></span>
												</div>
												<div class="alert alert-success alert-dismissible" role="alert" id="businessSuccess" style="display:none;">
														<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<strong>Success !!!</strong> <span id="businessSMsg"></span>
												</div>
												<span class="help-block">
													Mark below the days and hours that your Organization will accept appointments.Applicants will not be able to book appointments by themselves in non working periods. This working plan will be the default for every new applicants.
												</span>
												
												<table class="table table-striped">
													<thead>
														<tr>
															<th>Day</th>
															<th>Start</th>
															<th>End</th>
															<th>Appointment Gap</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="monday" />Monday</label></td>
															<td class="working-plan"><input type="text" class="form-control" id="monday-start"/></td>
															<td class="working-plan"><input type="text" class="form-control" id="monday-end"/></td>
															<td><input type="text" class="form-control" id="monday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
														</tr>
														<tr>
															<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="tuesday" />Tuesday</label></td>
															<td class="working-plan"><input type="text" class="form-control" id="tuesday-start"/></td>
															<td class="working-plan"><input type="text" class="form-control" id="tuesday-end"/></td>
															<td><input type="text" class="form-control" id="tuesday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
														</tr>
														<tr>
															<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="wednesday" />Wednesday</label></td>
															<td class="working-plan"><input type="text" class="form-control" id="wednesday-start"/></td>
															<td class="working-plan"><input type="text" class="form-control" id="wednesday-end"/></td>
															<td><input type="text" class="form-control" id="wednesday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
														</tr>
														<tr>
															<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="thursday" />Thursday</label></td>
															<td class="working-plan"><input type="text" class="form-control" id="thursday-start"/></td>
															<td class="working-plan"><input type="text" class="form-control" id="thursday-end"/></td>
															<td><input type="text" class="form-control" id="thursday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
														</tr>
														<tr>
															<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="friday" />Friday</label></td>
															<td class="working-plan"><input type="text" class="form-control" id="friday-start"/></td>
															<td class="working-plan"><input type="text" class="form-control" id="friday-end"/></td>
															<td><input type="text" class="form-control" id="friday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
														</tr>
														<tr>
															<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="saturday" />Saturday</label></td>
															<td class="working-plan"><input type="text" class="form-control" id="saturday-start"/></td>
															<td class="working-plan"><input type="text" class="form-control" id="saturday-end"/></td>
															<td><input type="text" class="form-control" id="saturday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
														</tr>
														<tr>
															<td class="working-plan"><label class="checkbox-inline"><input type="checkbox" id="sunday" />Sunday</label></td>
															<td class="working-plan"><input type="text" class="form-control" id="sunday-start"/></td>
															<td class="working-plan"><input type="text" class="form-control" id="sunday-end"/></td>
															<td><input type="text" class="form-control" id="sunday-gap" placeholder="Appt's Gap(in Minutes)"/></td>
														</tr>
													</tbody>
												</table>
											</form>
										  </div>
										  <div role="tabpanel" class="tab-pane fade" style="margin-top:20px;" id="dateSpecificTab">
											<fieldset class="span6 pull-left">
												<div id="dateSpecificCalendar"></div>
											</fieldset>
											<fieldset class="span3 pull-right">
											 <form id="frmPlan">
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
												<div class="form-group">
													<label></label>
													<button type="button" class="form-control btn btn-danger" id="WorkingPlanDelete" onClick="displayDeleteWorkingPlan();" style="display:none;"> <i class="fa fa-trash-o fa-lg"></i> Delete Working Plan</button>	
												</div>
											</form>
											</fieldset>
										  </div>
										  <div role="tabpanel" class="tab-pane fade" style="margin-top:20px;" id="manageHolidays">
											<fieldset class="span6 pull-left">
												<div>
													<table class="table">
														<thead>
															<tr>
																<th>Sr.No</th>
																<th>Title</th>
																<th>Start Date</th>
																<th>End Date</th>
																<th>Edit</th>
																<th>Delete</th>
															</tr>
														</thead>
														<tbody id="holiData">
															<!--<?php if(isset($holidays) && $holidays && count($holidays)>0):
																foreach($holidays as $index=>$holi): ?>
																<tr>
																	<td><?php echo ($index+1); ?></td>
																	<td><a href="javascript:void(0);" onClick="displayUpdateHoliday(<?php echo $holi->id; ?>);"><?php echo $holi->title; ?></a></td>
																	<td><?php echo $holi->startdate; ?></td>
																	<td><?php echo $holi->enddate; ?></td>
																	<td><a href="javascript:void(0);" onClick="displayUpdateHoliday(<?php echo $holi->id; ?>);"><i class="fa fa-pencil"></i></a></td>
																	<td><a href="javascript:void(0);" onClick="displayDeleteHoliday(<?php echo $holi->id; ?>);"><i class="fa fa-times"></i></a></td>
																</tr>
															<?php endforeach;?>
															<?php else:?>
																	
															<?php endif; ?>-->
														</tbody>
													</table>
												</div>
											</fieldset>
											<fieldset class="span3 pull-right">
											 <form id="frmHoliDay">
												<div class="form-group">
													<div class="alert alert-warning alert-dismissible" role="alert" id="HolidayError" style="display:none;">
															<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															<strong>Errors !!!</strong> <span id="HolidayEMsg"></span>
													</div>
													<div class="alert alert-success alert-dismissible" role="alert" id="HolidaySuccess" style="display:none;">
															<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															<strong>Success !!!</strong> <span id="HolidaySMsg"></span>
													</div>
												</div>
						
												  <div class="form-group">
													<label for="title">Holiday Title</label>
													<input type="text" class="form-control" name="title" id="title" placeholder="Title">
													<input type="hidden" name="org_id">
													<input type="hidden" name="hId" id="hId">
													<input type="hidden" id="hpageId" name="hpageId"/>
												  </div>
												  <div class="form-group">
													<label for="startdate">Start Date</label>
													<div class="input-group date schedular">
													  <input type="text" name="startdate" id="startdate" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
													</div>
												  </div>
												  <div class="form-group">
													<label for="enddate">End Date</label>
													<div class="input-group date schedular">
													  <input type="text" name="enddate" id="enddate" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
													</div>
												  </div>
															  
												  <button type="button" id="btnAddHoliday" class="btn btn-primary">Submit</button>
												  <button type="button" id="btnUpdateHoliday" class="btn btn-primary" style="display:none;">Update</button>
												  <button type="button" id="btnCancelHoliday" class="btn btn-primary" data-dismiss="modal">Cancel</button>
											</form>
											</fieldset>
										  </div>
										</div>
									  </div>
									</div>
								  </div>
								  <div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingSixth">
									  <h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" style="text-decoration:none;" data-parent="#accordion" href="#collapseLocation" aria-expanded="false" aria-controls="collapseLocation">
										  <i class="fa fa-plus-circle" id="iconLocation"></i> Location &nbsp;&nbsp;
										</a>
										<button type="button" style="display:none;" class="btn btn-primary btn-xs" id="btnLocation">Save Changes</button>
									  </h4>
									</div>
									<div id="collapseLocation" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSixth">
									  <div class="panel-body" id="locationPanel">
										<div class="row">
											<form role="form" class="span6" id="location_frm">
												<div class="form-group">
													<div class="alert alert-warning alert-dismissible" role="alert" id="locationError" style="display:none;">
															<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															<strong>Errors !!!</strong> <span id="locationEMsg"></span>
													</div>
													<div class="alert alert-success alert-dismissible" role="alert" id="locationSuccess" style="display:none;">
															<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															<strong>Success !!!</strong> <span id="locationSMsg"></span>
													</div>
												</div>
												<input type="hidden" id="pageIdLocation" name="pageIdLocation">
											  <div class="form-group">
												<label for="location">Enter address or any other location information</label>
												<input type="text" class="form-control" id="location" name="location" placeholder="Enter Location">
											  </div>
											</form>
										</div>
									  </div>
									</div>
								  </div>
								  <div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingThree">
									  <h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" style="text-decoration:none;" data-parent="#accordion" href="#collapseUserNotification" aria-expanded="false" aria-controls="collapseUserNotification">
										  <i class="fa fa-plus-circle" id="iconUsernotification"></i> User notifications &nbsp;&nbsp;
										</a>
										<button type="button" style="display:none;" class="btn btn-primary btn-xs" id="btnUsernotification">Save Changes</button>
									  </h4>
									</div>
									<div id="collapseUserNotification" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
									  <div class="panel-body" id="userNotificationPanel">
										<div class="span9">
											<h4>Notifications</h4>
											<div class="form-group">
												<div class="alert alert-warning alert-dismissible" role="alert" id="userNError" style="display:none;">
														<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<strong>Errors !!!</strong> <span id="userNEMsg"></span>
												</div>
												<div class="alert alert-success alert-dismissible" role="alert" id="userNSuccess" style="display:none;">
														<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<strong>Success !!!</strong> <span id="userNSMsg"></span>
												</div>
											</div>
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr class="info">
															<th>User</th>
															<th>Notify on bookings</th>
															<th>Notify on booking requests</th>
															<th>Notify on cancellations</th>
															<th>CC on customer reminders</th>
															<th>CC on follow-up emails</th>
														</tr>
													</thead>
													<tbody>
														<tr>
														<td id="uName"></td>
														<td><input type="checkbox" id="no_on_booking"></td>
														<td><input type="checkbox" id="no_on_booking_req"></td>
														<td><input type="checkbox" id="no_on_cancel"></td>
														<td><input type="checkbox" id="cc_on_cus_rem"></td>
														<td><input type="checkbox" id="cc_on_follow_email"></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									  </div>
									</div>
								  </div>
								  <div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingFour">
									  <h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" style="text-decoration:none;" data-parent="#accordion" href="#collapseCustomerNotification" aria-expanded="false" aria-controls="collapseCustomerNotification">
										  <i class="fa fa-plus-circle" id="iconCustomernotification"></i> Customer notifications &nbsp;&nbsp;
										</a>
										<button type="button" style="display:none;" class="btn btn-primary btn-xs" id="btnCustomernotification">Save Changes</button>
									  </h4>
									</div>
									<div id="collapseCustomerNotification" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
									  <div class="panel-body" id="customerNotificationPanel">
										<h4>Email reminders</h4>
										<div class="form-group">
											<div class="alert alert-warning alert-dismissible" role="alert" id="CusNError" style="display:none;">
													<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<strong>Errors !!!</strong> <span id="CusNEMsg"></span>
											</div>
											<div class="alert alert-success alert-dismissible" role="alert" id="CusNSuccess" style="display:none;">
													<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
													<strong>Success !!!</strong> <span id="CusNSMsg"></span>
											</div>
										</div>
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="checkReminder0">
											Reminder #1 -&nbsp;&nbsp;
											<select id="reminderVal0">
												<option value="none">Not Set</option>
												<option value="5_min">5 mins</option>
												<option value="15_min">15 mins</option>
												<option value="25_min">25 mins</option>
												<option value="40_min">40 mins</option>
												<option value="50_min">50 mins</option>
												<option value="1_hour">1 hours</option>
												<option value="2_hour">2 hours</option>
												<option value="5_hour">5 hours</option>
												<option value="7_hour">7 hours</option>
												<option value="15_hour">15 hours</option>
												<option value="24_hour">24 hours</option>
												<option value="1_day">1 days</option>
												<option value="2_day">2 days</option>	
											</select>
										  </label>
										</div>
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="checkReminder1">
											Reminder #2 -&nbsp;&nbsp;
											<select id="reminderVal1">
												<option value="none">Not Set</option>
												<option value="5_min">5 mins</option>
												<option value="15_min">15 mins</option>
												<option value="25_min">25 mins</option>
												<option value="40_min">40 mins</option>
												<option value="50_min">50 mins</option>
												<option value="1_hour">1 hours</option>
												<option value="2_hour">2 hours</option>
												<option value="5_hour">5 hours</option>
												<option value="7_hour">7 hours</option>
												<option value="15_hour">15 hours</option>
												<option value="24_hour">24 hours</option>
												<option value="1_day">1 days</option>
												<option value="2_day">2 days</option>	
											</select>
										  </label>
										</div>
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="checkReminder2">
											Reminder #3 -&nbsp;&nbsp;
											<select id="reminderVal2">
												<option value="none">Not Set</option>
												<option value="5_min">5 mins</option>
												<option value="15_min">15 mins</option>
												<option value="25_min">25 mins</option>
												<option value="40_min">40 mins</option>
												<option value="50_min">50 mins</option>
												<option value="1_hour">1 hours</option>
												<option value="2_hour">2 hours</option>
												<option value="5_hour">5 hours</option>
												<option value="7_hour">7 hours</option>
												<option value="15_hour">15 hours</option>
												<option value="24_hour">24 hours</option>
												<option value="1_day">1 days</option>
												<option value="2_day">2 days</option>	
											</select>
										  </label>
										</div>
										<div class="form-group">
											<div class="form-group">
												<label for="reminderNote">The complete scheduling confirmation email will be sent. Add an optional note:</label>
												<textarea class="form-control" id="reminderNote" rows="3" style="width: 60%;" placeholder="Text that you type here will show at the beginning of the reminder email."></textarea>
											</div>
										</div>
										<hr/>
										<h4>Follow-up email</h4>
										<div class="checkbox">
										  <label>
											<input type="checkbox" id="checkFollowup">
											 Send a follow-up email - &nbsp;&nbsp;
											<select id="followReminderVal">
												<option value="none">Not Set</option>
												<option value="5_min">5 mins</option>
												<option value="15_min">15 mins</option>
												<option value="25_min">25 mins</option>
												<option value="40_min">40 mins</option>
												<option value="50_min">50 mins</option>
												<option value="1_hour">1 hours</option>
												<option value="2_hour">2 hours</option>
												<option value="5_hour">5 hours</option>
												<option value="7_hour">7 hours</option>
												<option value="15_hour">15 hours</option>
												<option value="24_hour">24 hours</option>
												<option value="1_day">1 days</option>
												<option value="2_day">2 days</option>	
											</select> &nbsp;&nbsp;after the meeting ends
										  </label>
										</div>
										<div class="form-group">
											<div class="form-group">
												<label for="followEmailNote">Enter the text for your follow-up email:</label>
												<textarea class="form-control" id="followEmailNote" rows="3" style="width: 60%;"></textarea>
											</div>
										</div>
									  </div>
									</div>
								  </div>
								  <div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingFifth">
									  <h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" style="text-decoration:none;" data-parent="#accordion" href="#collapseBookingPageDetails" aria-expanded="false" aria-controls="collapseBookingPageDetails">
										  <i class="fa fa-plus-circle" id="iconBookingPageDetails"></i> Booking page details &nbsp;&nbsp;
										</a>
										<button type="button" style="display:none;" class="btn btn-primary btn-xs" id="btnBookingPageDetails">Save Changes</button>
									  </h4>
									</div>
									<div id="collapseBookingPageDetails" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
									  <div class="panel-body" id="bookingPageDetailsPanel">
										<fieldset class="span6 pull-left">
											<h4>Page information</h4>
											<p class="help-block">People see these details when they click the Booking page link:</p>
											<div class="row">
												<form role="form" class="span6" id="bookingPagefrm">
													<div class="form-group">
														<div class="alert alert-warning alert-dismissible" role="alert" id="pageError" style="display:none;">
																<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
																<strong>Errors !!!</strong> <span id="pageEMsg"></span>
														</div>
														<div class="alert alert-success alert-dismissible" role="alert" id="pageSuccess" style="display:none;">
																<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
																<strong>Success !!!</strong> <span id="pageSMsg"></span>
														</div>
													</div>
													<input type="hidden" id="pageId" name="pageId">
												  <div class="form-group">
													<label for="name">Name</label>
													<input type="text" class="form-control" id="bookingPageName" name="bookingPageName" placeholder="Enter Name">
												  </div>
												  <div class="form-group">
													<label for="phone">Phone</label>
													<input type="text" class="form-control" id="pagePhone" name="pagePhone" placeholder="Enter Phone Number">
												  </div>
												  <div class="form-group">
													<label for="email">Email</label>
													<input type="text" class="form-control" id="pageEmail" name="pageEmail" placeholder="Enter Email">
												  </div>
												   <div class="form-group">
													<label for="welcomeMsg">Welcome message</label>
													<textarea class="form-control" id="pageWelcomeMsg" name="pageWelcomeMsg" placeholder="Enter Welcome Message" rows="3"></textarea>
												  </div>
												</form>
											</div>
										</fieldset>
										<fieldset class="span3 pull-right">
											<div class="row">
												<div class="form-group">
													<label for="userfile">Booking Page Image</label>
													<input type="hidden" id="pageName" value="bookingPage"/>
												</div>
												<?php echo Modules::run('upload'); ?>
											</div>
										</fieldset>
									  </div>
									</div>
								  </div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane tab-paneNew fade" id="manageMasterBookingPages">
							<div id="noMasterBookingPages" style="display:none;"><h2 class='well text-center'>There are no master booking pages.</h2></div>
							<div id="manageMasterBookingPagesTab">
								<div class="form-group well" style="margin-top:20px;">
									<div class="form-group">
										<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#deleteMasterBookingPageModel" id="deleteMasterBookingPage">
										  Delete page
										</button>
									</div>
									<div><h3>Master booking page : <label id="mBookingPageHeading"></label></h3></div><hr style="color: #eee;background-color: #eee;height: 2px;"/>
									<div class="alert alert-warning alert-dismissible" role="alert" id="linkMasterError" style="display:none;">
											<strong>This Master booking page is disabled</strong><br><span id="linkMasterEMsg"></span>
									</div>
									<div id="applicantMasterLink"><h3>Customer Link</h3></div>
								</div>
								<div class="panel-group" id="accordionMaster" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="masterHeadingOne">
									  <h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" style="text-decoration:none;" data-parent="#accordionMaster" href="#collapseMasterBookingPageSetup" aria-expanded="false" aria-controls="collapseMasterBookingPageSetup">
										  <i class="fa fa-plus-circle" id="iconMasterBookingPageSetup"></i> Master booking page setup &nbsp;&nbsp;
										</a>
										<button type="button" class="btn btn-primary btn-xs" id="btnMasterBookingPagesetup">Save Changes</button>
									  </h4>
									</div>
									<div id="collapseMasterBookingPageSetup" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="masterHeadingOne">
									  <div class="panel-body" id="masterBookingPageSetupPanel">
										<div class="row">
											<form role="form" class="span8" id="masterBookingPageSetupfrm">
												<div class="form-group">
													<div class="alert alert-warning alert-dismissible" role="alert" id="masterPageError" style="display:none;">
															<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															<strong>Errors !!!</strong> <span id="masterPageEMsg"></span>
													</div>
													<div class="alert alert-success alert-dismissible" role="alert" id="masterPageSuccess" style="display:none;">
															<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
															<strong>Success !!!</strong> <span id="masterPageSMsg"></span>
													</div>
												</div>
											  <div class="form-group">
												<h4><i class="fa fa-hand-o-right"></i>&nbsp;Name label</h4>
												<label for="name">Booking page label (Provider, member, resource, etc.)</label>
												<input type="text" class="form-control" id="masterBookingPageLabel" name="masterBookingPageLabel" placeholder="Enter Name">
												<p class="help-block">The name label will be used to title the customer's selection</p>
											  </div><hr/>
											  <div class="form-group">
												<h4><i class="fa fa-hand-o-right"></i>&nbsp;Included Booking pages</h4>
												<div class="table-responsive">
													<table class="table">
														<thead>
															<tr>
																<th>Booking page link</th>
																<th>Page name</th>
															</tr>
														</thead>
														<tbody id="bookingPageLinks">
														</tbody>
													</table>
												</div>
											  </div><hr/>
											  <div class="form-group" id="selectionInstructionDiv">
												<h4><i class="fa fa-hand-o-right"></i>&nbsp;Selection instructions</h4>
												<input type="text" class="form-control" id="masterPageInstruction" name="masterPageInstruction" placeholder="Selection Instruction">
											  </div>
											</form>
										</div>
									  </div>
									</div>
								  </div>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="masterHeadingTwo">
									  <h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse" style="text-decoration:none;" data-parent="#accordionMaster" href="#collapseMasterBookingPageDetails" aria-expanded="false" aria-controls="collapseMasterBookingPageDetails">
										  <i class="fa fa-plus-circle" id="iconMasterBookingPageDetails"></i> Master booking page details &nbsp;&nbsp;
										</a>
										<button type="button" style="display:none;" class="btn btn-primary btn-xs" id="btnMasterBookingPageDetails">Save Changes</button>
									  </h4>
									</div>
									<div id="collapseMasterBookingPageDetails" class="panel-collapse collapse" role="tabpanel" aria-labelledby="masterHeadingTwo">
									  <div class="panel-body" id="masterBookingPageDetailsPanel">
										<fieldset class="span6 pull-left">
											<h4>Master booking page details</h4>
											<p class="help-block">People see these details when they click the Master Booking page link</p>
											<div class="row">
												<form role="form" class="span6" id="masterBookingPagefrm">
													<div class="form-group">
														<div class="alert alert-warning alert-dismissible" role="alert" id="masterPageDetailsError" style="display:none;">
																<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
																<strong>Errors !!!</strong> <span id="masterPageDetailsEMsg"></span>
														</div>
														<div class="alert alert-success alert-dismissible" role="alert" id="masterPageDetailsSuccess" style="display:none;">
																<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
																<strong>Success !!!</strong> <span id="masterPageDetailsSMsg"></span>
														</div>
													</div>
													<input type="hidden" id="masterPageId" name="masterPageId">
												  <div class="form-group">
													<label for="name">Name</label>
													<input type="text" class="form-control" id="masterBookingPageName" name="masterBookingPageName" placeholder="Enter Name">
												  </div>
												  <div class="form-group">
													<label for="phone">Phone</label>
													<input type="text" class="form-control" id="masterPagePhone" name="masterPagePhone" placeholder="Phone Number">
												  </div>
												  <div class="form-group">
													<label for="email">Email</label>
													<input type="text" class="form-control" id="masterPageEmail" name="masterPageEmail" placeholder="Email">
												  </div>
												   <div class="form-group">
													<label for="welcomeMsg">Welcome message</label>
													<textarea class="form-control" id="masterPageWelcomeMsg" name="masterPageWelcomeMsg" placeholder="Welcome Message" rows="3"></textarea>
												  </div>
												</form>
											</div>
										</fieldset>
										<fieldset class="span3 pull-right">
											<div class="row">
												<div class="form-group">
													<label for="userfile">Master booking Page Image</label>
													<input type="hidden" id="masterPageName" value="masterBookingPage"/>
													<input type="hidden" id="mPageId" value="mPageId"/>
												</div>
												<?php echo Modules::run('upload/uploadMaster'); ?>
											</div>
										</fieldset>
									  </div>
									</div>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
      		</div> 
  	</div>
</div>
<!-- Modal Booking Page -->
<div class="modal fade" id="bookingPageModal" tabindex="-1" role="dialog" aria-labelledby="myModalBookingLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalBookingLabel">New Booking Page</h4>
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
			<div class="form-group"><label>Create a new booking page</label></div>
			<div class="well">
				<!-- BEGIN FORM-->
				<form class="form-horizontal" id="frmBookingPage" role="form" method="post">
				  <div class="form-group">
				  	<label for="owner" class="col-sm-7 control-label">Owner</label>
					<div class="col-sm-5 col-md-5">
					  <input type="text" class="form-control" name="owner" id="owner" placeholder="Enter Owner Name">
					</div>
				  </div>
				  <div class="form-group">
					<?php if(isset($org_url) && $org_url)$oUrl=$org_url;else $oUrl="";?>
					<label for="bookingPage" style="WORD-WRAP: break-word;" class="col-sm-7 control-label"><?php echo base_url().$oUrl."/"; ?></label>
					<div class="col-sm-5 col-md-5">
					  <input type="hidden" name="bookingPageId" id="bookingPageId">
					  <input type="text" class="form-control" name="bookingPage" id="bookingPage" placeholder="Enter Booking Page Name">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-7 col-sm-5 col-md-5">
					  <button type="button" id="btnAddBookingPage" class="btn btn-primary">Create</button>
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
<!-- Modal Master Booking Page -->
<div class="modal fade" id="masterBookingPageModal" tabindex="-1" role="dialog" aria-labelledby="myModalMasterBookingLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalMasterBookingLabel">New Master Booking Page</h4>
      </div>
      <div class="modal-body" id="userModelBody">
			<div class="alert alert-warning alert-dismissible" role="alert" id="ajaxMError" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="eMMsg"></span>
			</div>
			<div class="alert alert-success alert-dismissible" role="alert" id="ajaxMSuccess" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Success !!!</strong> <span id="sMMsg"></span>
			</div>
			<div class="form-group"><label>Create a new master booking page</label></div>
			<div class="well">
				<!-- BEGIN FORM-->
				<form class="form-horizontal" id="frmMasterBookingPage" role="form" method="post">
				  <div class="form-group">
					<?php if(isset($org_url) && $org_url)$oUrl=$org_url;else $oUrl="";?>
					<label for="masterBookingPage" style="WORD-WRAP: break-word;" class="col-sm-7 control-label"><?php echo base_url().$oUrl."/"; ?></label>
					<div class="col-sm-5">
					  <input type="text" class="form-control" name="masterBookingPage" id="masterBookingPage" placeholder="Master Booking Page Name">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-7 col-sm-5">
					  <button type="button" id="btnAddMasterBookingPage" class="btn btn-primary">Create</button>
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
<!-- Delete Booking Page Model-->
<div class="modal fade" id="deleteBookingPageModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Booking Page</h4>
      </div>
      <div class="modal-body">
					Are You Sure ? You Want To Delete This Booking Page.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlPage">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete Master Booking Page Model-->
<div class="modal fade" id="deleteMasterBookingPageModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Master Booking Page</h4>
      </div>
      <div class="modal-body">
					Are You Sure ? You Want To Delete This Master Booking Page.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlMasterPage">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- Delete Holiday Model-->
<div class="modal fade" id="deleteHolidayModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Holiday</h4>
      </div>
      <div class="modal-body">
			<div class="alert alert-warning alert-dismissible" role="alert" id="error" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="errorMSG"></span>
			</div>
					Are You Sure ? You Want To Delete This Holiday.
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="dlHoliday">Delete</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="base_url" value="<?php echo base_url($this->schedular_auth->makeBaseURL()); ?>"/>
<input type="hidden" id="resource_id"/>
<input type="hidden" id="masterPage_id"/>


<link href='<?php echo base_url1().'admins/assets/css/fullcalendar.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'admins/assets/css/fullcalendar.print.css'; ?>' rel='stylesheet' media='print' />
<link href='<?php echo base_url1().'admins/assets/css/datepicker3.css'; ?>' rel='stylesheet' media='print' />
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/moment.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/fullcalendar.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/bootstrap-datepicker.js'; ?>'></script>
<link href='<?php echo base_url1().'admins/assets/css/jquery-ui.min.css'; ?>' rel='stylesheet' />
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery-ui.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery-ui-timepicker-addon.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/jquery.jeditable.min.js'; ?>"></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/configuration_js.js'; ?>'></script>