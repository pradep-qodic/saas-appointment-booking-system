	<div class="row">
		<div  class="span12">
			<h1>Account settings</h1>
            <div id="userAccount">
				<form class="row-fluid" id="frmAdmin">
					<fieldset class="span5 pull-left">
						<legend>
							<?php echo "Personal Information"; ?>
						</legend>
							<input type="hidden" value="<?php echo base_url($this->schedular_auth->makeBaseURL()); ?>" id="base_url"/>
							<input type="hidden" id="user_id" value="<?php if(isset($userInfo) && $userInfo)echo $userInfo[0]->org_user_id; ?>" />
							<div class="form-group">
								<div class="alert alert-warning alert-dismissible" role="alert" id="userError" style="display:none;">
										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<strong>Errors !!!</strong> <span id="userEMsg"></span>
								</div>
								<div class="alert alert-success alert-dismissible" role="alert" id="userSuccess" style="display:none;">
										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<strong>Success !!!</strong> <span id="userSMsg"></span>
								</div>
							</div>
							<div class="form-group">
							<label for="email">Email *</label>
							<input type="text" class="form-control" name="email" id="email" value="<?php if(isset($userInfo) && $userInfo)echo $userInfo[0]->email;?>" disabled placeholder="Email">
							<input type="hidden" id="uemail" name="uemail" value="<?php if(isset($userInfo) && $userInfo)echo $userInfo[0]->email;?>">
							</div>
							<div class="form-group">
								<label for="name">Name *</label>
								<input type="text" class="form-control" name="name" id="name" value="<?php if(isset($userInfo) && $userInfo)echo $userInfo[0]->name;?>" placeholder="Name">
							</div>
							
							<div class="form-group">
								<label for="mobileno">Mobile Number</label>
								<input type="text" class="form-control" name="mobileno" id="mobileno" value="<?php if(isset($userInfo) && $userInfo)echo $userInfo[0]->mobileNo;?>" placeholder="Mobile Number">
							</div>
							<label for="mobileno">Status</label>
							<div class="form-group">
								<label class="radio-inline">
								  <input type="radio" name="status" id="inlineRadio1" value="1" <?php if(isset($userInfo) && $userInfo && $userInfo[0]->status==1)echo "checked"; ?>> Active
								</label>
								<label class="radio-inline">
								  <input type="radio" name="status" id="inlineRadio2" value="0" <?php if(isset($userInfo) && $userInfo && $userInfo[0]->status==0)echo "checked"; ?>> Inactive
								</label>
							</div>
							<button type="button" class="btn btn-primary" id="personalInfo">Save Changes</button>
					</fieldset>
					<fieldset class="span5 pull-right">
						<legend>
							<?php echo "Password Change"; ?>
						</legend>
							<input type="hidden" id="user_id" name="user_id" value="<?php if(isset($userInfo) && $userInfo)echo $userInfo[0]->org_user_id; ?>" />
							<div class="form-group">
								<div class="alert alert-warning alert-dismissible" role="alert" id="passwordError" style="display:none;">
										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<strong>Errors !!!</strong> <span id="passwordEMsg"></span>
								</div>
								<div class="alert alert-success alert-dismissible" role="alert" id="passwordSuccess" style="display:none;">
										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<strong>Success !!!</strong> <span id="passwordSMsg"></span>
								</div>
							</div>
							<div class="form-group">
								<label for="curpassword">Current Password *</label>
								<input type="password" class="form-control" name="curpassword" id="curpassword" placeholder="Current Password">
							</div>
							<div class="form-group">
								<label for="npassword">New Password *</label>
								<input type="password" class="form-control" name="npassword" id="npassword" placeholder="New Password">
							</div>
							<div class="form-group">
								<label for="cpassword">Confirm Pasword *</label>
								<input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm Password">
							</div>
							<button type="button" class="btn btn-primary" id="passwordInfo">Save Password</button>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
<script type="text/javascript" src="<?php echo base_url1().'admins/assets/js/account_js.js'; ?>"></script>
