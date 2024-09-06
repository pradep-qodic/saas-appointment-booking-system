<?php $this->load->view('includes/header'); ?>
<div class="container" style="min-height:400px;">
	<!-- Fixed navbar -->
	<style>body {padding-top: 60px;padding-bottom: 40px;}</style>
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="navbar-inner">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo base_url($this->schedular_auth->makeBaseURL("dashboard")); ?>">
					   <?php if(isset($organizationLogoURL) && $organizationLogoURL): ?><img alt="Brand" style="max-width:30px;" title="Scheduler Admin Panel" src="<?php echo $organizationLogoURL; ?>"><?php else:?><span class="fa fa-bank"></span><?php endif;?> Scheduler
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row span12">
		<div class="text-center" style="margin-top:50px;color:red;">
			<i class="fa fa-warning fa-5x"></i>
		</div>
		<div class="text-center">
			<h1>Page Not Found</h1>
			<h3>Unauthorized Request</h3>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>