<?
$_POST["date_jour"]=($_POST["date_jour"]=="")?date('d/m/Y'):$_POST["date_jour"];

require("rapport-gen2.php");
?>