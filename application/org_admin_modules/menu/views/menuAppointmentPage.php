<!-- Fixed navbar -->
<style>body {margin-top:40px; padding-bottom: 40px;}</style>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-inner">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo base_url($this->schedular_auth->makeBaseURL("dashboard")); ?>">
				   <?php if(isset($organizationLogoURL) && $organizationLogoURL): ?><img alt="Brand" style="max-width:30px;" title="Scheduler" src="<?php echo $organizationLogoURL; ?>"><?php else:?><span class="fa fa-bank"></span><?php endif;?> Scheduler
				</a>
			</div>
		</div>
	</div>
</div>
