
<html>
<title>Following up on your booking</title>
<head>

</head>
<body>
<div style="-moz-box-shadow:inset 0 0 10px #000066;-webkit-box-shadow: inset 0 0 10px #000066;box-shadow:inset 0 0 10px #000066;padding: 20px;border: 1px solid #000066;border-radius: 5px 5px 5px 5px;line-height: 26px;width: 80%;">
    <div style="background-color: #f5f5f5;margin-bottom: 10px;"><img style="margin: 3px 0px 3px 10px;" src="<?php echo $logo; ?>"/></div>
    <b>Hello <?php if(isset($user_email) && $user_email)echo $user_email.","; ?><br /></b>
    <div style="margin: 20px 0px 0px 30px;">
       <h1> Thank you for your time</h1>  
	   <h3>This is a follow-up to your Meeting that took place on <?php if(isset($bookingDate) && $bookingDate)echo $bookingDate; ?></h3>
	   <h4> <?php if(isset($reminderNote) && $reminderNote)echo $reminderNote; ?> </h4>
    </div>
    <div>
        Thanks,<br />
        Scheduler Team
    </div>
</div>
</body>
</html>