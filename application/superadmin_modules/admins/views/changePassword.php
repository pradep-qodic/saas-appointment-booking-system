	<div class="row">
		<div class="span6 offset3">
			<h1>Change Password</h1>
            <?php if(@$error): ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Errors !!!</strong> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <?php if(@$message): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Success !!!</strong> <?php echo $message; ?>
                </div>
            <?php endif; ?>
			<div class="well">
				<form role="form" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Old Password</label>
                        <input type="password" class="form-control" id="opassword" placeholder="Old Password" name="opassword" value="<?php echo set_value('opassword');?>" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" class="form-control" id="npassword" placeholder="New Password" name="npassword" value="<?php echo set_value('npassword');?>" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" value="<?php echo set_value('cpassword');?>" />
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                    <button type="submit" name="cancelChangePassword" class="btn btn-primary" name="back">Cancel</button>
                </form>
            </div>
		</div>
	</div>

