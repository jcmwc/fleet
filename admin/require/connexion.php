<?
/*
header ("Cache-Control: no-cache, must-revalidate");  
header ("Pragma: no-cache");                       
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
*/       
connect(__host__,__userbdd__,__passbdd__);
select_db(__bdd__);
query("SET NAMES 'utf8'");
?>