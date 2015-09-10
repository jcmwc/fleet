<?
$_POST["date_jour"]=date("d-m-Y",time()-86400);
//$_POST["date_jour"]="27-08-2014";
//on recherche la liste de véhicule auquel a droit l'utilisateur
$sql=getsqllistvehicule();
$link_list_vehicule=query($sql);
while($tbl_list_vehicule=fetch($link_list_vehicule)){
  $_POST["vehicule"]=$tbl_list_vehicule["phantom_device_id"];
  $tabresult=exportexcel("hebdo",implodeargskey($_POST),array("Date","Début","Fin","Ampl.","Conduite","Arrêt","Distance","Vit.max."),array("date","debut","fin","datediff","conduite","arret","km","vitessemax"));
  $html="Ci joint le rapport conducteur de la semaine ".date2week($_POST["date_jour"])." pour le véhicule ".$tbl_list_vehicule["nomvehicule"];
  sendmailmister('','','Rapport conducteur de la semaine '.date2week($_POST["date_jour"]),$html,$_SESSION["email"],'',$tabresult);
}

//mise a jour de la date dans rapport
/*
$sql="update ".__racinebd__."rapport set date_envoi='".$_POST["date_debut"]."' where rapport_id=9";
query($sql);
*/
?>
