
<html>
<title><?php if(isset($applicantName) && $applicantName)echo $applicantName;?> has rescheduled a booking</title>
<head>

</head>
<body>
<div style="-moz-box-shadow:inset 0 0 10px #000066;-webkit-box-shadow: inset 0 0 10px #000066;box-shadow:inset 0 0 10px #000066;padding: 20px;border: 1px solid #000066;border-radius: 5px 5px 5px 5px;line-height: 26px;width: 80%;">
    <div style="background-color: #f5f5f5;margin-bottom: 10px;"><img style="margin: 3px 0px 3px 10px;" src="<?php echo $logo; ?>"/></div>
    <div style="margin: 20px 0px 0px 30px;">
       <h2><?php if(isset($applicantName) && $applicantName)echo $applicantName;if(isset($applicantEmail) && $applicantEmail)echo "( ".$applicantEmail." )";?> has rescheduled a booking. </h2>
	   <h2>New booking details</h2>
	   <table cellspacing="0" cellpadding="4" border="0" style="font-size:12px;font-family:Tahoma,sans-serif;width:100%;padding-bottom:10px;padding-top:10px;">
		   <tr>
				<td style="white-space:nowrap;width:10%;padding-right:16px;font-weight:bold;vertical-align:top" align="left">Subject :</td>
				<td><?php if(isset($AppointmentTitle) && $AppointmentTitle)echo $AppointmentTitle; ?> </td>
		   </tr>
		   <tr>
				<td style="white-space:nowrap;width:10%;padding-right:16px;font-weight:bold;vertical-align:top" align="left">Booking Page :</td>
				<td><?php if(isset($bookingPage) && $bookingPage)echo $bookingPage; ?> </td>
		   </tr>
		   <tr>
				<td style="white-space:nowrap;width:10%;padding-right:16px;font-weight:bold;vertical-align:top" align="left">Booking Date :</td>
				<td><?php if(isset($scheduleDate) && $scheduleDate)echo $scheduleDate; ?> </td>
		   </tr>
	   </table>
    </div>
    <div>
        Thanks,<br />
        Scheduler Team
    </div>
</div>
</body>
</html>