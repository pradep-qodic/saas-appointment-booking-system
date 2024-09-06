<style>
body {
	margin: 40px 10px;
	padding: 0;
	font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
	font-size: 14px;
}
.mPagesPage{
	cursor:pointer;
}

</style>
<div id="appointmentLoader" style="position: fixed; text-align: center; top: 40%; width: 100%; height: 100%; z-index: 9999; display: none;"><i class="fa fa-spinner fa-spin fa-4x"></i></div>
<div class="container" style="padding:9px;">
	<div class="row" id="containerAppointmentRow">
		<div class="span12" style="margin-top: 10px;">
			<div class="col-md-3" style="font-size: 30px;"><?php if(isset($pageInfo) && $pageInfo && isset($pageInfo[0]->name) && $pageInfo[0]->name): echo $pageInfo[0]->name;else: echo $pageInfo[0]->typeName; endif;?></div>
			<div class='col-md-9 text-center' style="font-size: 30px;" id="appDashboardHead"><?php if(!isset($pageDisabled) || !$pageDisabled): ?><?php if(isset($pageInfo) && $pageInfo && isset($pageInfo[0]->instruction) && $pageInfo[0]->instruction)echo $pageInfo[0]->instruction;else echo "Select Team Member";?><?php else: echo ""; endif; ?></div>
		</div>
			<div class="col-md-3 well" id="leftSide">
				<div style="min-height: 320px;">
					<div class="form-group">
						<h4>
						<?php if(isset($PageLogo) && $PageLogo): ?>
							<img src="<?php echo $PageLogo; ?>" title="Master Booking Page Logo"/>
						<?php endif; ?>
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
				<div class="col-md-9">
					<div id="masterPagePages" class="text-center"><h1 class="fa fa-lock fa-5x"></h1><h2>Sorry, no more bookings can be accepted at this time</h2></div>
				</div>
			<?php else: ?>
				<?php if(isset($masterPagePages) && $masterPagePages && count($masterPagePages)>0):?>
					<div id="masterPagePages" class="col-md-9">
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
			<?php endif;?>
	</div>
</div>
<!-- Modal Holiday-->
<input type="hidden" id="current_url" value="<?php echo current_url(); ?>"/>
<script type="text/javascript">
	$(".mPagesPage").click(function(){
		var id=$(this).attr('data-id');
		document.getElementById("frm_"+id).submit();
	});
</script>