<!-- Fixed navbar -->
<?php
$this->load->library('session');
$isLive=$this->config->item('is_live');
$url='';
$user='';
if(isset($username) && $username){$user=$username;}
if(isset($isLive) && $isLive){$url="/superadmin/signin";}
if(isset($isloggedIn) && $isloggedIn):?>
<style>
body {
	padding-top: 60px;
	padding-bottom: 40px;
}
</style>
<?php $timezone=$this->session->userdata('timezone');?>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-inner">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse">
					<span class="sr-only">Scheduler</span> <span class="icon-bar"></span>
					<span class="icon-bar"></span> <span class="icon-bar"></span>
				</button>
				<a class="navbar-brand"
					href="<?php echo base_url($this->schedular_auth->makeBaseURL("dashboard")); ?>">
					<span class="fa fa-bank"></span>Scheduler Super Admin Panel
				</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user; ?>  <i
							class="caret"></i></a>
						<ul class="dropdown-menu" role="menu">
							<!-- <li><a href="<?php //echo base_url($this->schedular_auth->makeBaseURL("account")); ?>">Account</a></li> -->
							<li><a id="schedulerLogout"
								href="<?php echo base_url()."logout";?>">Signout</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Help</li>
						</ul></li>
				</ul>
				<ul class="nav navbar-nav navbar-left">
					<li><a
						href="<?php echo base_url($this->schedular_auth->makeBaseURL("dashboard"));?>">Dashboard</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php
elseif($_SERVER['REQUEST_URI']!=$url):
 ?>
<style>
body {
	padding-top: 60px;
	padding-bottom: 40px;
}
</style>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-inner">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand"
					href="<?php echo base_url($this->schedular_auth->makeBaseURL("superadmin")); ?>">
					<span class="fa fa-bank"></span> Scheduler Super Admin Panel
				</a>
			</div>
		</div>
	</div>
</div>
<?php
endif;  ?>