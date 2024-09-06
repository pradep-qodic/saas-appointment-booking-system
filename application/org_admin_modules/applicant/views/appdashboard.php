<style>
body {
	margin: 40px 10px;
	padding: 0;
	font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
	font-size: 14px;
}

#calendar {
	max-width: 900px;
	margin: 0 auto;
}

</style>
<h2 class='text-center'>Appointment Dashboard</h2>
<div class="row" style="margin-left:90px;">
	<div class="form-group span5">
		<label for="title">Select Master Calendar</label>
		<select class="form-control" id="insp_type_id"></select>
	 </div>
</div>
<div id="calendar"></div>


<!-- Modal Holiday-->
<div class="modal fade" id="AppointmentModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Appointment</h4>
      </div>
      <div class="modal-body">
			<div class="alert alert-warning alert-dismissible" role="alert" id="AppointmentError" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Errors !!!</strong> <span id="AppointmentEMsg"></span>
			</div>
			<div class="alert alert-success alert-dismissible" role="alert" id="AppointmentSuccess" style="display:none;">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Success !!!</strong> <span id="AppointmentSMsg"></span>
			</div>
			<!-- BEGIN FORM-->
			<form role="form" method="post" id="frmAppointment">
				<div class="form-group">
					<label for="exampleInputEmail1">Calendar Type</label>
					<input type="text" class="form-control" name="insp_type_id" id="inspTypeID" disabled>
					<input type="hidden" name="inspTypeId" id="inspID">
				</div>
			  <div class="form-group">
				<label for="title">Appointment Title</label>
				<input type="text" class="form-control" name="title" id="title" placeholder="Title">
				<input type="hidden" name="org_id" value="<?php if(isset($org_id) && $org_id)echo $org_id; ?>">
			  </div>
			  <div class="form-group">
				<label for="title">Name</label>
				<input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name">
			  </div>
			  <div class="form-group">
				<label for="title">Email</label>
				<input type="text" class="form-control" name="email" id="email" placeholder="Enter Your Email">
			  </div>
			 <!-- <div class="form-group">
				<label for="title">Appointment Description</label>
				<input type="text" class="form-control" name="desc" id="desc" placeholder="Descrption">
			  </div>-->
			  
			  <div class="form-group">
				<label for="startdate">Appointment Date</label>
				<div class="input-group date schedularApp">
				  <input type="text" name="start" id="startdate" class="form-control">
				</div>
			  </div>
				<div class="form-group">
					<a href="javascript:void(0);" id="selectSlots">Click to select your slots</a>
					<div class="radio" id="orgslots" style="display:none;">
				  </div>
				</div>			  
			  <button type="button" id="btnAddAppointment" class="btn btn-primary">Submit</button>
			  <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
			</form>
			<!-- END FORM-->
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="current_url" value="<?php echo current_url(); ?>"/>
<input type="hidden" id="loadHolidayURL" value="<?php echo current_url()."/loadholidaysData"; ?>"/>
<input type="hidden" id="loadAppURL" value="<?php echo current_url()."/loadAppointments"; ?>"/>
<input type="hidden" id="AddAppURL" value="<?php echo current_url()."/createAppointment"; ?>"/>
<input type="hidden" id="AddAppTypeURL" value="<?php echo current_url()."/loadAppointmentTypes"; ?>"/>
<link href='<?php echo base_url1().'admins/assets/css/fullcalendar.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'applicant/assets/css/jquery-ui.theme.css'; ?>' rel='stylesheet' />
<link href='<?php echo base_url1().'admins/assets/css/fullcalendar.print.css'; ?>' rel='stylesheet' media='print' />
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/moment.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/fullcalendar.min.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'admins/assets/js/jquery.cookie.js'; ?>'></script>
<script type="text/javascript" src='<?php echo base_url1().'applicant/assets/js/applicant.js'; ?>'></script>