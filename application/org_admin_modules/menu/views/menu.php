<!-- Fixed navbar -->
<?php
$this->load->library('session');
$isLive=$this->config->item('is_live');
$url='';
$user='';
if(isset($username) && $username){$user=$username;}
if(isset($organizationURL) && $organizationURL){$url="/schedular/".$organizationURL."/admin/signin";}
if(isset($isLive) && $isLive){$url="/admins/signin";}
if(isset($isloggedIn) && $isloggedIn):?>
<style>body {padding-top: 60px;padding-bottom: 40px;}</style>
<?php $timezone=$this->session->userdata('timezone');?>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-inner">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Scheduler</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url($this->schedular_auth->makeBaseURL("dashboard")); ?>">
				   <?php if(isset($organizationLogoURL) && $organizationLogoURL): ?><img alt="Brand" style="max-width:30px;" title="Scheduler" src="<?php echo $organizationLogoURL; ?>"><?php else:?><i class="fa fa-bank"></i><?php endif;?> Scheduler
				</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user; ?>  <i class="caret"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url($this->schedular_auth->makeBaseURL("account")); ?>">Account</a></li>
							<li><a id="schedulerLogout" href="<?php echo base_url()."logout";?>">Signout</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Help</li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-left">
					<li>
						<a href="<?php echo base_url($this->schedular_auth->makeBaseURL("dashboard"));?>">Dashboard</a>
					</li>
					<li>
							<a href="<?php echo base_url($this->schedular_auth->makeBaseURL("configuration"));?>">Configuration</a>
					</li>
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Settings <i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li>
								<a tabindex="-1" href="<?php echo base_url($this->schedular_auth->makeBaseURL("settings"));?>">General Settings</a>
							</li>
							<li>
								<a tabindex="-1" href="<?php echo base_url($this->schedular_auth->makeBaseURL("manageHolidays"));?>">Manage Holidays</a>
							</li>
							<!--<li>
								<a tabindex="-1" href="<?php echo base_url($this->schedular_auth->makeBaseURL("manageCalendars"));?>">Manage Calendars</a>
							</li>-->
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
   /* $(document).ready(function() {
        if("<?php echo $timezone; ?>".length==0){
			var tz = jstz.determine();
			var timez = tz.name();
			var currentDate = new Date()
			var tmrDate = new Date(new Date().getTime() + 24 * 60 * 60 * 1000)
			var userCDate=currentDate.getDate() + "-" + (currentDate.getMonth()+1) + "-" + currentDate.getFullYear();
			var userTDate=tmrDate.getDate() + "-" + (tmrDate.getMonth()+1) + "-" + tmrDate.getFullYear();
            $.ajax({
                type: "post",
                url: "<?php echo base_url().'events/eventsTimeZone';?>",
                data: {cDate:userCDate,tDate:userTDate,timezone:timez},
                success: function(){location.reload();}
            });
        }
    });*/
</script>
<?php
elseif($_SERVER['REQUEST_URI']!=$url):
 ?>
    <style>body {padding-top: 60px;padding-bottom: 40px;}</style>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-inner">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo base_url($this->schedular_auth->makeBaseURL("signin")); ?>">
				   <i class="fa fa-bank"></i>Scheduler
				</a>
			</div>
			<!--<div class="navbar-collapse collapse">
				<a href="<?php echo current_url()."/admin/signin"; ?>" class="btn btn-primary pull-right" style="margin-top: 10px;">Login</a>
			</div>-->
		</div>
	</div>
</div>
<?php
endif;  ?>