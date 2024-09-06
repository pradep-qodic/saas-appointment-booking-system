<h1 class="text-center">Please Sign in</h1>
<div class="well" style="max-width:500px;margin:0 auto 20px;">
	<?php if(isset($error) && $error): ?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
			<strong>Errors !!!</strong> <?php echo $error; ?>
		</div>
	<?php endif; ?>
	
	<?php echo form_open(); ?>
	  <div class="form-group">
	    <label for="exampleInputEmail1">Email address</label>
	    <input type="email" class="form-control" name="email" value="<?php $ck=$this->input->cookie('schedularremember_me');if(isset($ck) && $ck) {echo $this->input->cookie('schedularremember_me');}else{echo set_value('email');}?>" id="exampleInputEmail1" placeholder="Enter email">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Password</label>
	    <input type="password" class="form-control" name="password" value="<?php echo set_value('password');?>" id="exampleInputPassword1" placeholder="Password">
	  </div>
	  <div class="checkbox">
	    <label>
	      <input type="checkbox" name="remember" <?php $ck=$this->input->cookie('schedularremember_me');if(isset($ck) && $ck) {echo 'checked="checked"';}else {echo '';}?> > Remember me
	    </label>
	  </div>
	  <button type="submit" class="btn btn-primary">Submit</button>
	  <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
	<?php echo form_close(); ?>
</div>