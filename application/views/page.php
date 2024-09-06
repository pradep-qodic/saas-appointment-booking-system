<?php

    if (strpos(site_url(),'superadmin') !== false) {
        $this->load->view('includes/adminHeader');
    }else{
        $this->load->view('includes/header');
    }
 ?>
<div class="container" style="min-height:400px;">
	<?php echo modules::run("menu"); ?>
	<?php if(isset($main_content) && $main_content):?>
		<?php $this->load->view($main_content); ?>
	<?php endif; ?>
</div>
<?php $this->load->view('includes/footer'); ?>