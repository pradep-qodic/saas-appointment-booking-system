<form method="post" action="" id="upload_file">
	<div class="form-group" id="LogoImage">
	</div>
	<div class="form-group">
		<input type="file" name="userfile" id="userfile" size="20">
		<p class="help-block">select to set logo</p>
	</div>
	<input type="submit" name="submit" value="Upload" class="btn btn-primary" id="submit" />
</form>
<script src="<?php echo base_url1().'upload/assets/js/site.js'; ?>"></script>
<script src="<?php echo base_url1().'upload/assets/js/ajaxfileupload.js'; ?>"></script>