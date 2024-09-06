<html>
<title>Forgot Password Link</title>
<head>

</head>
<body>
<div style="-moz-box-shadow:inset 0 0 10px #000066;-webkit-box-shadow: inset 0 0 10px #000066;box-shadow:inset 0 0 10px #000066;padding: 20px;border: 1px solid #000066;border-radius: 5px 5px 5px 5px;line-height: 26px;width: 80%;">
    <div style="background-color: #f5f5f5;margin-bottom: 10px;"><img style="margin: 3px 0px 3px 10px;" src="<?php echo $logo; ?>"/></div>
    <b>Dear <?php echo $user_email.","; ?><br /></b>
    <div style="margin: 20px 0px 0px 30px;">
        Click on Link To Recover Your Password <a href="<?php echo $recovery_key;?>">Password Recovery Link<br /> </a>
        If above Link is not working then copy below url and paste it in your browser to activate your account.
        <b><br /><?php echo $recovery_key; ?><br /><br /><br /></b>
    </div>
    <div>
        Thanks,<br />
        Synchd Up Team
    </div>
</div>
</body>
</html>