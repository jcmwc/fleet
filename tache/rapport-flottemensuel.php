<?
$_POST["date_jour"]=date("d-mY",time()-86400);
//$_POST["date_jour"]="27-08-2014";
$_POST["agence"]="";
$tabresult=exportexcel("flotte03",implodeargskey($_POST),array("Nom","Activité","Conduite","Arrêt","Distance","Vit.max.","Conso."),array("nomvehicule","amplitude","datediff","arret","km","vitesse","conso"));
$html="Ci joint le rapport de la flotte du mois ".date2month($_POST["date_jour"]);
sendmailmister('','','Rapport flotte mensuelle '.date2month($_POST["date_jour"]),$html,$_SESSION["email"],'',$tabresult);


//mise a jour de la date dans rapport
/*
$sql="update ".__racinebd__."rapport set date_envoi='".$_POST["date_jour"]."' where rapport_id=7";
query($sql);
*/
?>