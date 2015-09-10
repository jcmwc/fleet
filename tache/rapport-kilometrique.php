<?
//$_POST["date_debut"]=date("Y-m-d",time()-86400);
$_POST["date_debut"]=date("d-m-Y",time()-86400);
$_POST["heure_debut"]="00:00:01";
$_POST["date_fin"]=$_POST["date_debut"];
$_POST["heure_fin"]="23:59:59";
$_POST["agence"]="";
//$tabresult=exportexcel("kilometrique",implodeargskey($_POST),array("Véhicule","Distance","Durée","Conso. Théorique","Conso. Carburant"),array("nomvehicule","km","datediff","consotheorique","conso"));
$tabresult=exportexcel("kilometrique",implodeargskey($_POST),array("Véhicule","Distance (km)","Durée (min)","Conso. Théorique (L/100km)","Conso. Carburant (L)"),array("nomvehicule","km","datediff","consotheorique","conso"));
$html="Ci joint le rapport kilométrique du ".$_POST["date_debut"];
//print_r($tabresult);
print "ici rapport kilometrique";
sendmailmister('','','Rapport kilométrique'.$_POST["date_debut"],$html,$_SESSION["email"],'',$tabresult);

//mise a jour de la date dans rapport
/*
$sql="update ".__racinebd__."rapport set date_envoi='".$_POST["date_debut"]."' where rapport_id=4";
query($sql);
*/
?>