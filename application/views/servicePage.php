<?php $this->load->view('includes/header'); ?>
<div class="container">
	<?php if(isset($main_content) && $main_content):?>
		<?php $this->load->view($main_content); ?>
	<?php endif; ?>
</div>
<?php $this->load->view('includes/footer'); ?>