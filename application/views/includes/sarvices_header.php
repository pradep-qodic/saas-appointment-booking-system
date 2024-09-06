<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Scheduler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="scheduler"/>
    <meta name="author" content="scheduler"/>
    <!-- Le styles -->
    <link href="http://schedule.datatechsols.com/themes/admin/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="http://schedule.datatechsols.com/themes/admin/css/bootstrap-social.css" rel="stylesheet"/>
    <link href="http://schedule.datatechsols.com/themes/admin/css/bootstrap-responsive.min.css" rel="stylesheet"/>
    <link href="http://schedule.datatechsols.com/themes/admin/css/font-awesome.css" rel="stylesheet"/>
    <!-- Javascript -->
    <script src="http://schedule.datatechsols.com/themes/admin/js/jquery_min.js"></script>
    <script src="http://schedule.datatechsols.com/themes/admin/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
			$("#fade").fadeOut("slow");
            $("#loader").fadeOut("slow");
			$('body').css('overflow','auto'); 
        });
    </script>
  </head>
  <body>
  <div id="loader" style="position: fixed;text-align: center;top: 40%;width: 100%;height: 100%;z-index: 9999;"><p class="fa fa-spinner fa-5x fa-spin"></p></div>
  <div id="fade" style="position:absolute;top: 0%;left: 0%;width: 100%;height: 100%;background-color: #ababab;z-index: 1001;-moz-opacity: 0.8;opacity: .70;filter: alpha(opacity=80);"></div>