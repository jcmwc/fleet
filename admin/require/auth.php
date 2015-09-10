<?php
function auth(){
	header('WWW-Authenticate: Basic realm="'.__title__.'"');
   header('HTTP/1.0 401 Unauthorized');
   echo 'Authentification failed';
   exit;
}
if (!isset($_SERVER['PHP_AUTH_USER'])) {
   auth();
} else {
  if($_SERVER['PHP_AUTH_USER']==__user__&&$_SERVER['PHP_AUTH_PW']==__pwd__){
   //ok
  }else{
   auth();
  }
}
?>