
	
	<div class="row">
		<div class="span6 offset3">
			<h1>Sign in</h1>

            <?php if(@$error): ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Errors !!!</strong> <?php echo $error; ?>
                </div>
            <?php endif; ?>
			<div class="well">
                <form role="form" method="post">
                    <input type="hidden" name="public_key" value="<?php echo $this->config->item('public_key'); ?>"/>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="Enter Email" name="user_email" value="<?php if(isset($_COOKIE['synchdremember_me'])) {echo $_COOKIE['synchdremember_me'];} ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" <?php if(isset($_COOKIE['synchdremember_me'])) {echo 'checked="checked"';}else {echo '';}?> > Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                    <button type="submit" class="btn btn-primary" name="back">Back</button>
                    <div class="checkbox">
                            <a style="margin-top: 5px;" href="<?php echo base_url()."forgotpassword"; ?>">Forgot Password?</a>
                    </div>
                </form>
			</div>
			
		</div>
	</div>
