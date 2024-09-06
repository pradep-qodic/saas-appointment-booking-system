<div class="span12">
	<table class="table">
		<thead>
			<tr>
				<th>Sr.No</th>
				<th>Title</th>
				<th>Start</th>
				<th>End</th>
				<th>Applicant Name</th>
				<th>Applicant Email</th>
				<th>Status</th>
				<th><input type="checkbox" id="selecctall" /> <label
					for="selecctall">Mark As Read</label></th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody id="appList">
			<input type="hidden"
				value="<?php echo base_url($this->schedular_auth->makeBaseURL("")); ?>"
				id="base_url">
					<?php if(isset($appointments) && $appointments && count($appointments)>0): ?>
					<input type="hidden" id="pendingApp"
				value="<?php echo $pendingApp; ?>" />
					<?php foreach($appointments as $index=>$appointment): ?>
					<tr>
				<td <?php if($appointment->is_viewed==0){echo 'class="warning"';}?>><?php echo ($index+1); ?></td>
				<td <?php if($appointment->is_viewed==0){echo 'class="warning"';}?>><form
						method="post"
						action='<?php echo base_url($this->schedular_auth->makeBaseURL("userAppointmentPage")); ?>'>
						<input type="hidden" name="app_id"
							value="<?php echo $appointment->app_id; ?>" /><input
							type="submit" class="btn btn-link"
							value="<?php echo $appointment->app_title; ?>">
					</form></td>
				<td <?php if($appointment->is_viewed==0){echo 'class="warning"';}?>><?php echo $appointment->app_start; ?></td>
				<td <?php if($appointment->is_viewed==0){echo 'class="warning"';}?>><?php echo $appointment->app_end; ?></td>
				<td <?php if($appointment->is_viewed==0){echo 'class="warning"';}?>><?php echo $appointment->applicant_name; ?></td>
				<td <?php if($appointment->is_viewed==0){echo 'class="warning"';}?>><?php echo $appointment->applicant_email; ?></td>
						<?php if($appointment->isApproved==1):?>
							<td class="bg-success">Confirmed</td>
						<?php elseif($appointment->isApproved==0):?>
							<td class="bg-danger">Rejected</td>
						<?php elseif($appointment->isApproved==3):?>
							<td class="bg-info">Requested</td>
						<?php elseif($appointment->isApproved==2):?>
							<td class="bg-primary">Rescheduled</td>
						<?php endif; ?>
						<td
					<?php if($appointment->is_viewed==0){echo 'class="warning"';}?>><input
					type="checkbox" id="<?php echo $appointment->app_id; ?>"
					value="<?php echo $appointment->is_viewed; ?>" class="checkbox"
					<?php if($appointment->is_viewed==1){echo "checked";}?> /></td>
				<td <?php if($appointment->is_viewed==0){echo 'class="warning"';}?>><a
					href="javascript:void(0);"
					onClick="displayDeleteAppointment('<?php echo $appointment->app_id; ?>');"><i
						class="fa fa-times"></i></a></td>
			</tr>
					<?php  endforeach;?>
					<?php else: ?>
					<script>$("#saveAppointmentChanges").prop("disabled",true);</script>
			<tr>
				<td colspan="9" class="text-center">No appointments found.</td>
			</tr>
					<?php endif; ?>
				</tbody>
	</table>
</div>