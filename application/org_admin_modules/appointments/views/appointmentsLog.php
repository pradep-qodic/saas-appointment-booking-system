<div class="row">
	<div class="span12">
		<fieldset>
			<legend>Appointments Log </legend>
			<table class="table">
				<tbody id="appLogList">
					<input type="hidden" value="<?php echo base_url($this->schedular_auth->makeBaseURL("")); ?>" id="base_url">
					<?php if(isset($appointmentsLog) && $appointmentsLog && count($appointmentsLog)>0): ?>
					<?php foreach($appointmentsLog as $index=>$appointment): ?>
					<tr>
						<?php if($appointment->isApproved==1):?>
							<td class="success"><?php echo $appointment->app_title." ( ".$appointment->app_start." - ".$appointment->app_end." ) is approved for ".$appointment->applicant_name." ( ".$appointment->applicant_email." )";?></td>
						<?php elseif($appointment->isApproved==0):?>
							<td class="danger"><?php echo $appointment->app_title." ( ".$appointment->app_start." - ".$appointment->app_end." ) is rejected for ".$appointment->applicant_name." ( ".$appointment->applicant_email." ) due to ".$appointment->rejectReason;?></td>
						
						<?php endif; ?>
					</tr>
					<?php  endforeach;?>
					<?php else: ?>
					<tr><td class="text-center">No log available for this time.</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</fieldset>
	</div>
</div>
