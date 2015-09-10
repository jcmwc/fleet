<?php
include_once('smsMode_API.inc');
include_once('myDB_request.inc');

$myDAO = new DAO;
$numeros = $myDAO->get_numeros();

$api = new smsMode_api;

foreach ( $numeros as $num ){
    $response_string = $api->send_sms($num , 'Message de test' );
    sleep(0.2);
	//print $response_string."<br/>";
  print "Message envoyé<br/>";

}

?>