<?php
session_start();
include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include 'secret.php';
$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
$oauth_token = $_GET['oauth_token'];
if($oauth_token == '')
 {
 $url = $twitterObj->getAuthorizationUrl();
 echo "<div style='width:200px;margin-top:200px;margin-left:auto;margin-right:auto'>";
 echo "<a href='$url'>Sign In with Twitter</a>";
 echo "</div>";
 }
 else
 {
 $twitterObj->setToken($_GET['oauth_token']);
 $token = $twitterObj->getAccessToken();
 $twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
 $_SESSION['ot'] = $token->oauth_token;
 $_SESSION['ots'] = $token->oauth_token_secret;
 $twitterInfo= $twitterObj->get_accountVerify_credentials();
 $twitterInfo->response;
 $username = $twitterInfo->screen_name;
 $profilepic = $twitterInfo->profile_image_url;
 include 'update.php';
 }
if(isset($_POST['submit']))
 {
 $msg = $_REQUEST['tweet'];
 $twitterObj->setToken($_SESSION['ot'], $_SESSION['ots']);
 $update_status = $twitterObj->post_statusesUpdate(array('status' => $msg));
 $temp = $update_status->response;
 echo "<div align='center'>Updated your Timeline Successfully .</div>";
 }
?>