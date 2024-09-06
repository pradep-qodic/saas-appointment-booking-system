
	
	<div class="row">
		<div class="span6 offset3">
			<h1>Sign up</h1>
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
                        <label for="inputFullName">Fullname</label>
                        <input type="text" class="form-control" id="inputFullName" value="<?php echo set_value('fullname'); ?>" name="fullname"/>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="text" class="form-control" id="inputEmail" value="<?php echo set_value('email'); ?>" name="email"/>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign up</button>
                    <button type="submit" class="btn btn-primary" name="back">Back</button>
                </form>
			</div>
		</div>
	</div>
