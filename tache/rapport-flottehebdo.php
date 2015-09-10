<?
//$_POST["date_jour"]=date("Y-m-d",time()-86400);
$_POST["date_jour"]=date("d-m-Y",time()-86400);
//$_POST["date_jour"]="27-08-2014";
$_POST["agence"]="";
$tabresult=exportexcel("flotte02",implodeargskey($_POST),array("Nom","Activité","Conduite","Arrêt","Distance","Vit.max.","Conso."),array("nomvehicule","amplitude","datediff","arret","km","vitesse","conso"));

$html="Ci joint le rapport de la flotte de la semaine ".date2week($_POST["date_jour"]);
sendmailmister('','','Rapport flotte hebdomadaire '.date2week($_POST["date_jour"]),$html,$_SESSION["email"],'',$tabresult);

//mise a jour de la date dans rapport
/*
$sql="update ".__racinebd__."rapport set date_envoi='".$_POST["date_jour"]."' where rapport_id=6";
query($sql);
*/
?>