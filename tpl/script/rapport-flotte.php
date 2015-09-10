<?
$_POST["date_jour"]=($_POST["date_jour"]=="")?date('d/m/Y'):$_POST["date_jour"];
$nottoday=(dateDifference(datebdd($_POST["date_jour"]),date('Y/m/d'),'%d')==0)?false:true;
$_POST["date_debut"]=$_POST["date_jour"]." 00:00:00";
$_POST["date_fin"]=$_POST["date_jour"]." 23:59:59";
require($_SERVER["DOCUMENT_ROOT"].__racine__."/tpl/script/rapport-kilometrique.php");
?>