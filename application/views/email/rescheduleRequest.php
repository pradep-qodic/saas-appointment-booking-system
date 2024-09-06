<html>
<title>Reschedule request for <?php if(isset($app_title) && $app_title)echo $app_title;?></title>
<head>

</head>
<body>
<div style="-moz-box-shadow:inset 0 0 10px #000066;-webkit-box-shadow: inset 0 0 10px #000066;box-shadow:inset 0 0 10px #000066;padding: 20px;border: 1px solid #000066;border-radius: 5px 5px 5px 5px;line-height: 26px;width: 80%;">
    <div style="background-color: #f5f5f5;margin-bottom: 10px;"><img style="margin: 3px 0px 3px 10px;" src="<?php echo $logo; ?>"/></div>
    <b>Dear  <?php if(isset($applicant_name) && $applicant_name)echo $applicant_name.","; ?><br /></b>
    <div style="margin: 20px 0px 0px 30px;">
       <h2> <?php if(isset($admin_name) && $admin_name)echo $admin_name.","; ?>  has canceled your booking and would like you to reschedule. </h2>
	   <h2>Note:</h2>
	   <h3><?php if(isset($rescheduled_reason) && $rescheduled_reason)echo $rescheduled_reason; ?></h3>
	   <div style="background-color:darkcyan;padding:10px;border-radius:3px;text-align:center;width:150px"><a href="<?php if(isset($scheduleUrl) && $scheduleUrl)echo $scheduleUrl; ?>" style="text-decoration:none;color:#fff;font-weight:bold" target="_blank">Schedule a new time</a></div>
	   <h2>Canceled booking details</h2>
	   <h3>Subject: <?php if(isset($app_title) && $app_title)echo $app_title;?></h3>
	   <h3>Time: <span style="text-decoration: line-through;"><?php if(isset($time) && $time)echo $time;?></span></h3>
    </div>
    <div>
        Thanks,<br />
        Scheduler Team
    </div>
</div>
</body>
</html>