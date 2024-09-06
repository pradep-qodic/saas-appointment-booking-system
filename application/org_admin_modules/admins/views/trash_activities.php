    		
<?php if(isset($appointments) && $appointments):?>
    <?php foreach($appointments as $app):?>
		<fieldset class="trashActivityStreamData" style="border-bottom: 1px solid #e3e3e3;" data-id="<?php echo $app['app_id'];?>">
			<div class="col-xs-2 col-md-2" style="margin-top: 10px; margin-bottom: 10px;">
				<span class="fa-stack">
					  <i class="fa fa-user fa-stack-2x"></i>
					  <i class="fa fa-calendar fa-stack-1x" style="position: absolute;margin-left: 10px;margin-top: 10px;color: #A3A3A3;"></i>
				</span>
				<br>
				<?php echo date("h:i A",strtotime($app['appointmentCreatedOn']));?>
			</div>
			<div class="col-xs-7 col-md-7" style="margin-top: 10px; margin-bottom: 10px;">
				<div>
					<span id="fromID_0" class=""
						style="color: rgb(28, 50, 97); font-size: 14px; font-weight: normal;"><?php echo $app['applicant_name']; ?> </span>( <?php echo $app['applicant_email'];?> )<br>
					<span style="color: #1c3261; font-size: 14px;"><?php echo $app['app_title'];?> <span
						style="font-size: 12px">(<?php echo round(abs(strtotime($app['app_end']) - strtotime($app['app_start'])) / 60,2). " min"; ?>)</span></span><br>
					<span><?php echo date("D, M d, Y, h:i A",strtotime($app['app_start']));if(isset($app) && $app && isset($app['app_end']) && $app['app_end'])echo " - ".date("h:i A",strtotime($app['app_end']));?></span>
				</div>
			</div>
			<div class="col-xs-3 col-md-3" style="margin-top: 10px; margin-bottom: 10px;">
		    	<?php if($app['isApproved']==-1):?>
					<i class="fa fa-calendar"> Not Defined</i>
				<?php elseif($app['isApproved']==0):?>
					<i class="fa fa-calendar"> Canceled</i>
				<?php elseif($app['isApproved']==1):?>
					<i class="fa fa-calendar"> Scheduled</i>
				<?php elseif($app['isApproved']==2):?>
					<i class="fa fa-calendar"> Rescheduled</i>
				<?php elseif($app['isApproved']==3):?>
					<i class="fa fa-calendar"> Requested</i>
				<?php endif; ?> <br>
				
			</div>
		</fieldset>
	<?php endforeach;?>
<?php endif; ?>