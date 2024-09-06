<h1 class="text-center">Please Sign Up</h1>
<div class="well" style="max-width:500px;margin:0 auto 20px;">
<?php if(@$error): ?>
	<div class="alert alert-warning alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
		<strong>Errors !!!</strong> <?php echo $error; ?>
	</div>
<?php endif; ?> 
  <form role="form" method="post">
  <?php if(@$message): ?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
			<strong>Success !!!</strong> <?php echo $message; ?>
			<?php if(!isset($orgID) || $orgID ==0):?>
				<button class="btn btn-primary" type="submit" name="login">Login</button>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if(!isset($orgID) || $orgID ==0):?>
	<input type="hidden" value="<?php echo base_url();?>" id="base_url"/>
	<div class="form-group">
		<label for="exampleInputtitle">Organization Title</label>
		<input type="text" class="form-control" name="org_title" value="<?php echo set_value('org_title');?>" id="exampleInputtitle" placeholder="Your Organization Title">
	</div>
	<div class="form-group">
		<label for="exampleInputurl">Organization URL</label>
		<input type="text" class="form-control" name="org_url" id="org_url" value="<?php echo set_value('org_url');?>" id="exampleInputurl" placeholder="Organization URL Name Ex.(xyz)">
		<p class="help-block" id="orgURLHelp">Your Url Will Be (<?php echo base_url();?>xyz)</p>
	</div>
	<?php endif; ?>
	<input type="hidden" value="<?php if(isset($orgID) && $orgID)echo $orgID; ?>" name="org_id">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="<?php echo set_value('email');?>" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1" value="<?php echo set_value('password');?>" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword2">Confirm Password</label>
    <input type="password" class="form-control" name="cpassword" id="exampleInputPassword2" value="<?php echo set_value('cpassword');?>" placeholder="Confirm Password">
  </div>
  <div class="form-group">
    <label for="exampleInputfirstname">First Name</label>
    <input type="text" class="form-control" name="firstname" id="exampleInputfirstname" value="<?php echo set_value('firstname');?>" placeholder="First Name">
  </div>
  <div class="form-group">
    <label for="exampleInputlastname">Last Name</label>
    <input type="text" class="form-control" name="lastname" id="exampleInputlastname" value="<?php echo set_value('lastname');?>" placeholder="Last Name">
  </div>
  <div class="form-group">
    <label for="exampleInputmobileno">Mobile No</label>
    <input type="text" class="form-control" name="mobileno" id="exampleInputmobileno" value="<?php echo set_value('mobileno');?>" placeholder="Mobile No">
  </div>
  <div class="form-group">
	  <label class="radio-inline">
		  <input type="radio" name="gender" id="inlineRadio1" value="1" checked="checked"> Male
		</label>
		<label class="radio-inline">
		  <input type="radio" name="gender" id="inlineRadio2" value="0"> Female
		</label>
	</div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <button type="submit" class="btn btn-primary" name="back">Back</button>
</form>
</div> 
<script>
	$( "#org_url" ).keyup(function() {
	  $("#orgURLHelp").html("Your Url Will Be ( "+$("#base_url").val()+$(this).val()+" )");
	  if($(this).val()==""){
		$("#orgURLHelp").html("Your Url Will Be ( "+$("#base_url").val()+"xyz )");
	  }
	});
</script>