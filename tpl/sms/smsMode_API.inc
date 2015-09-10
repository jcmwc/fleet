<?

/************************************************************\
* php-smsMode version 1.0, modified 28-Aug-06
/************************************************************\
* This library is free software; you can redistribute it
* and/or modify it under the terms of the GNU Lesser General
* Public License as published by the Free Software
* Foundation; either version 2.1 of the  License, or (at your
* option) any later version.
/************************************************************\
* PLEASE CHANGE THE FOLLOWING BEFORE RUNNING THIS SCRIPT.
\************************************************************/

// smsMode account details
/*
define('SMS_MODE_PSEUDO', 'pseudo');
define('SMS_MODE_PASSWORD', 'password');
*/
define('SMS_MODE_PSEUDO', 'pseudo');
define('SMS_MODE_PASSWORD', 'password!');


define('SMS_MODE_HOST', 'www.smsMode.com');
define('SMS_MODE_PORT', '80');

class smsMode_api {

	/************************************************************\
	* SEND_SMS: Send a short text message via smsMode's api.
	\************************************************************/
	function send_sms($num, $texte) {

		$ch = curl_init();
		$url = 'https://'.SMS_MODE_HOST.'/fr/1.5/sendSMS.do';
		$url = $url . '?pseudo='.SMS_MODE_PSEUDO.'&pass='.SMS_MODE_PASSWORD.'&message='.$texte.'&numero='.$num.'&classe_msg=5';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response_string = curl_exec($ch);
		curl_close($ch);

		return $response_string;
	}

}
?>