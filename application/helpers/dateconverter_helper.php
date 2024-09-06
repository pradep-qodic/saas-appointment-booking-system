<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/*
Author: Mitesh Patel
Date: 8/5/2014
Version: 1.0
*/

/* convert date in millie seconds */
if (! function_exists('date_to_millisec')) {
	function date_to_millisec($datestr = '')
	{
		if ($datestr == '')
			return '';

		return strtotime($datestr) * 1000;
	}
}
/* convert millie seconds to date*/
if (! function_exists('millisec_to_date')) {
	function millisec_to_date($mSec = '')
	{
		if ($mSec == '')
			return '';

		$timestamp = $mSec / 1000;
		return date("d-m-Y", $timestamp);
	}
}
if (! function_exists('userCurrentDate')) {
	function userCurrentDate()
	{
		$CI = &get_instance();
		return $CI->session->userdata('currentDate');
	}
}
if (! function_exists('userTomorrowDate')) {
	function userTomorrowDate()
	{
		$CI = &get_instance();
		return $CI->session->userdata('tomorrowDate');
	}
}
if (! function_exists('userTimeZone')) {
	function userTimeZone()
	{
		$CI = &get_instance();
		return $CI->session->userdata('timezone');
	}
}
if (! function_exists('do_events_filter')) {
	function do_events_filter($events = array())
	{
		$f = "d-m-Y";
		$x = date($f);
		if (userCurrentDate()) {
			$tDate = date_to_millisec(userCurrentDate());
		} else {
			$tDate = date_to_millisec($x);
		}
		$dttomm = new DateTime('tomorrow');
		$sdt = $dttomm->format($f);
		if (userTomorrowDate()) {
			$tmwDate = date_to_millisec(userTomorrowDate());
		} else {
			$tmwDate = date_to_millisec($sdt);
		}
		$todayEvents = array();
		$tomorrowEvents = array();
		$futureEvents = array();
		$other = array();
		foreach ($events as $value) {
			$dbDate = $value->event_date;
			if ($dbDate == $tDate) {
				$value->event_date = millisec_to_date($dbDate);
				array_push($todayEvents, $value);
			} else if ($value->event_date == $tmwDate) {
				$value->event_date = millisec_to_date($dbDate);
				array_push($tomorrowEvents, $value);
			} else if ($value->event_date != $tDate && $value->event_date != $tmwDate && $value->event_date > $tmwDate) {
				$value->event_date = millisec_to_date($dbDate);
				array_push($futureEvents, $value);
			} else {
				$value->event_date = millisec_to_date($dbDate);
				array_push($other, $value);
			}
		}
		return array("today" => $todayEvents, "tomorrow" => $tomorrowEvents, "future" => $futureEvents, "other" => $other);
	}
}
if (! function_exists('do_resource_filter')) {
	function do_resource_filter($resource = array())
	{

		$array = array();
		foreach ($resource as $value) {
			$arr['org_user_id'] = $value['org_user_id'];
			$arr['email'] = $value['email'];
			$arr['firstname'] = $value['firstname'];
			$arr['lastname'] = $value['lastname'];
			$arr['name'] = $value['name'];
			$arr['booking_url'] = $value['booking_url'];
			$arr['pageInfo'] = $value['pageInfo'];
			$arr['isSuperAdmin'] = $value['isSuperAdmin'];
			$arr['mobileNo'] = $value['mobileNo'];
			$arr['org_user_id'] = $value[''];
			$arr['org_user_id'] = $value[''];
			$arr['org_user_id'] = $value[''];
			$arr['org_user_id'] = $value[''];
			array_push($array, $arr);
		}
		return $array;
	}
}
if (! function_exists('loadEvents')) {
	function loadEvents($ev = array())
	{
		$events = array();
		foreach ($ev as $value) {
			$dbDate = $value->event_date;
			$value->event_date = millisec_to_date($dbDate);
			array_push($events, $value);
		}
		return $events;
	}
}
if (! function_exists('convert_to_user_date')) {
	function convert_to_user_date($date, $userTimeZone = "America/New_York", $format = 'd-m-Y', $serverTimeZone = 'UTC')
	{
		try {
			$dateTime = new DateTime($date, new DateTimeZone($serverTimeZone));
			$dateTime->setTimezone(new DateTimeZone($userTimeZone));
			return $dateTime->format($format);
		} catch (Exception $e) {
			return '';
		}
	}
}
if (! function_exists('convert_to_server_date')) {
	function convert_to_server_date($date, $userTimeZone = "America/New_York", $format = 'd-m-Y', $serverTimeZone = 'UTC')
	{
		try {
			$dateTime = new DateTime($date, new DateTimeZone($userTimeZone));
			$dateTime->setTimezone(new DateTimeZone($serverTimeZone));
			return $dateTime->format($format);
		} catch (Exception $e) {
			return '';
		}
	}
}
if (! function_exists('sendSMS')) {
	function sendSMS($userID, $userPWD, $recerverNO, $message)
	{
		if (strlen($message) > 140) // check for message length
		{
			echo "Error : Message length exceeds 140 characters";
			exit();
		}
		if (!function_exists('curl_init')) // check for curl library installation
		{
			echo "Error : Curl library not installed";
			exit();
		}

		$message_urlencode = rawurlencode($message);
		// message converted into URL encoded form
		$cookie_file_path = "/var/www/oose/cookie.txt";
		// Cookie file location in your machine with full read and write permission

		//START OF Code for getting sessionid
		$url = "http://site5.way2sms.com/content/index.html";
		$header_array[0] = "GET /content/index.html HTTP/1.1";
		$header_array[1] = "Host: site5.way2sms.com";
		$header_array[2] = "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.1) Gecko/20100101 Firefox/10.0.1";
		$header_array[3] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
		$header_array[4] = "Accept-Language: en-us,en;q=0.5";
		$header_array[5] = "Accept-Encoding: gzip,deflate";
		$header_array[6] = "DNT: 1";
		$header_array[7] = "Connection: keep-alive";
		$ch = curl_init();   //initialise the curl variable
		curl_setopt($ch, CURLOPT_URL, $url);
		//set curl URL for crawling
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
		//set the header for http request to URL 
		curl_setopt($ch, CURLOPT_REFERER, $reffer);
		//set reffer url means it shows from where the request is originated.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//it means after crawling data will return
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
		// store the return cookie data in cookie file 
		$result = curl_exec($ch); // Execute the curl function 
		curl_close($ch);
		//END OF Code for getting sessionid

		//START OF Code for automatic login and storing cookies
		$post_data = "username=" . $userID . "&password=" . $userPWD . "&button=Login";
		$url = "http://site5.way2sms.com/Login1.action";
		$header_array[0] = "POST /Login1.action HTTP/1.1";
		$header_array[1] = "Host: site5.way2sms.com";
		$header_array[2] = "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.1) Gecko/20100101 Firefox/10.0.1";
		$header_array[3] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
		$header_array[4] = "Accept-Language: en-us,en;q=0.5";
		$header_array[5] = "Accept-Encoding: gzip, deflate";
		$header_array[6] = "DNT: 1";
		$header_array[7] = "Connection: keep-alive";
		$header_array[8] = "Content-Type: application/x-www-form-urlencoded";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_REFERER, "http://site5.way2sms.com/content/index.html");
		$content = curl_exec($ch);
		$response = curl_getinfo($ch);
		curl_close($ch);
		//END OF Code for automatic login  and storing cookies

		// START OF Code is  getting way2sms unique user ID
		$url = "http://site5.way2sms.com/jsp/InstantSMS.jsp";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$content = curl_exec($ch);
		curl_close($ch);
		$regex = '/input type="hidden" name="Action" id="Action" value="(.*)"/';
		preg_match($regex, $content, $match);
		$userID = $match[1];
		// END OF Code for getting way2sms unique user ID

		// START OF Code for sending SMS to Recever
		$post_data = "HiddenAction=instantsms&catnamedis=Birthday&Action=" . $userID . "&chkall=on&MobNo=" . $recerverNO . "&textArea=" . $message_urlencode;
		$url = "http://site5.way2sms.com/quicksms.action";
		$header_array[0] = "POST /quicksms.action HTTP/1.1";
		$header_array[1] = "Host: site5.way2sms.com";
		$header_array[2] = "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.1) Gecko/20100101 Firefox/10.0.1";
		$header_array[3] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
		$header_array[4] = "Accept-Language: en-us,en;q=0.5";
		$header_array[5] = "Accept-Encoding: gzip, deflate";
		$header_array[6] = "DNT: 1";
		$header_array[7] = "Connection: keep-alive";
		$header_array[8] = "Content-Type: application/x-www-form-urlencoded";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_REFERER, "Referer: http://site5.way2sms.com/jsp/InstantSMS.jsp");
		$content = curl_exec($ch);
		$response = curl_getinfo($ch);
		curl_close($ch);
		// END OF Code for sending SMS to Recever

		//START OF Code for automatic logout
		$url = "http://site5.way2sms.com/jsp/logout.jsp";
		$header_array[0] = "GET /jsp/logout.jsp HTTP/1.1";
		$header_array[1] = "Host: site5.way2sms.com";
		$header_array[2] = "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.1) Gecko/20100101 Firefox/10.0.1";
		$header_array[3] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
		$header_array[4] = "Accept-Language: en-us,en;q=0.5";
		$header_array[5] = "Accept-Encoding: gzip, deflate";
		$header_array[6] = "DNT: 1";
		$header_array[7] = "Connection: keep-alive";
		$cookie_file_path = "/var/www/oose/cookie.txt";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_REFERER, "Referer: http://site5.way2sms.com/jsp/InstantSMS.jsp");
		$content = curl_exec($ch);
		$response = curl_getinfo($ch);
		curl_close($ch);
		//END OF Code for automatic logout

	} // end function send_sms
}
//example usage
/*$serverDate = $userDate = '2014-09-04 22:37:22';
echo convert_to_user_date($serverDate);
echo convert_to_server_date($userDate);*/