<?
//$_POST["date_jour"]=date("Y-m-d",time()-86400);
//$_POST["date_jour"]=date("d-m-Y",time()-86400);

$_POST["date_jour"]=date("d-m-Y",time()-86400);
//$_POST["date_jour"]="27-08-2014";

$tabresult=exportexcel("flotte",implodeargskey($_POST),array("Nom","Début","Fin","Ampl.","Conduite","Arrêt","Distance","Vit.max.","Conso."),array("nomvehicule","mintime","maxtime","amplitude","datediff","arret","km","vitesse","conso"));

$html="Ci joint le rapport de la flotte du ".$_POST["date_jour"];
sendmailmister('','','Rapport flotte journalier '.$_POST["date_jour"],$html,$_SESSION["email"],'',$tabresult);
//mise a jour de la date dans rapport
/*
$sql="update ".__racinebd__."rapport set date_envoi='".$_POST["date_jour"]."' where rapport_id=5";
query($sql);
*/
?>