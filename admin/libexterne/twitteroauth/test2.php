<?php
require_once 'twitteroauth/twitteroauth.php';
/* 
define("CONSUMER_KEY", "EIOzBHWYVvYTUTqao91FVw");
define("CONSUMER_SECRET", "daZsWNZE74r6s3KtNEcqfdCA0N9gpzFNrQUkljQU");
define("OAUTH_TOKEN", "59477179-h8N9iwCTReWVCdo1HZ3SXieovovVAXP6QOBhlsmH5");
define("OAUTH_SECRET", "KTLZAtT45CVPkuLYgbPCUwatXRMyFaYALuAtlZo4");
*/
define("CONSUMER_KEY", "DyOJwsu8c2j3Vz4FJDp0A");
define("CONSUMER_SECRET", "fKxcAZ9t2WgyQangWeIcVnhIJYl7APGB45FNtwJL5I");
define("OAUTH_TOKEN", "196088843-TrmnJpafitkpCUsd4aehulrcEa4tbljcmUwXFZCO");
define("OAUTH_SECRET", "ApWlVdTKLgVrOcu2bm4PZSa05PSQ9yKB6gEbCri8"); 

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
$content = $connection->get('account/verify_credentials');
 
$connection->post('statuses/update', array('status' => "essai jc"));