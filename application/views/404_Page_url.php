<?php $this->load->view('includes/header'); ?>
<div class="container" style="min-height:400px;">
	<?php echo modules::run("menu"); ?>
	<div class="row span12">
		<div class="text-center" style="margin-top:50px;color:red;">
			<i class="fa fa-warning fa-5x"></i>
		</div>
		<div class="text-center">
			<h1>Page Not Found</h1>
			<h3>Unauthorized Request</h3>
		</div>
		<div class="text-center" style="margin-top:50px;">
			<a href ="<?php echo $RedirectUrl; ?>"class="btn btn-primary">Click Here</a>
		</div>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>