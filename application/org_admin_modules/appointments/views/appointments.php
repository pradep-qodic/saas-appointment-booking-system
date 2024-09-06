<div id="pageAppointments">
	<div class="row">
		<div class="form_group span4 pull-left">
			<label>Select Booking Page</label>
			<select class="form-control" id="dropdownPageList">
				<option value="-1">All Appointments</option>
				<?php if(isset($pageList) && $pageList): ?>
			  		<?php foreach($pageList as $page):?>
			  		<option value="<?php echo $page->org_user_id; ?>"><?php echo $page->name." (".$page->booking_url." )"; ?></option>
			  		<?php endforeach;?>
			  	<?php endif; ?>
			</select>
		</div>
		<div class="form_group span7 pull-right">
			<button class="btn btn-primary pull-right" style="margin-top: 20px;" id="saveAppointmentChanges">
			  Save Changes
			</button>
		</div>
		<div id="pageAppointmentTable"><?php $this->load->view('appointmentsPageTable');?></div>
	</div>
	<div class="modal fade" id="deleteAppointmentModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Delete Appointment</h4>
	      </div>
	      <div class="modal-body">
						<div class="alert alert-warning alert-dismissible" role="alert" id="error" style="display:none;">
								<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<strong>Errors !!!</strong> <span id="errorMSG"></span>
						</div>
						Are You Sure ? You Want To Delete This Appointment.
	      </div>
		  <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
	        <button type="button" class="btn btn-primary" id="dlAppointment">Delete</button>
	      </div>
	    </div>
	  </div>
	</div>
	<script type="text/javascript" src="<?php echo base_url1().'appointments/assets/js/appointments.js'; ?>"></script>
</div>