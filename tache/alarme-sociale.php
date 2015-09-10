<?
//on regarde si aujourd'hui on gére des alarme
$indicedujour=dayOfWeek(time());
$sql="select acj.* from ".__racinebd__."alarme_compte_jour acj 
      inner join ".__racinebd__."alarme_compte ac on ac.alarme_compte_id=acj.alarme_compte_id
      inner join ".__racinebd__."alarme_compte_device acd on acd.alarme_compte_id=ac.alarme_compte_id
      where jour_id=".$indicedujour." and compte_id=".$_SESSION["compte_id"]." and acd.device_id=".$_POST["vehicule"];
$link_alarme_sociale=query($sql);
if(num_rows($link_alarme_sociale)>0){
while($tbl_alarme_sociale=fetch($link_alarme_sociale)){
  $valeur=$tbl_alarme_sociale["valeur"];
  //on vérifie le type
  switch ($tbl_alarme_sociale["typealarme_agence"]) {
    //Temps d'arrêt insuffisant
    case 1:        
        for($i=0;$i<count($trajet);$i++){
          if($trajet[$i]["arretintime"]<$valeur*60){
            $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut un temps d'arrêt insuffisant";        
            //recherche des destinataire
            $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                  inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                  where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
            $link_user_alarme=query($sql);
            while($tbl_alarme_user=fetch($link_user_alarme)){
              sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
            }
          }
        }
        break;
    //Durée de conduite anormale
    case 2:        
        if($totalconduite>$valeur*60){
          $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut un temps de conduite anormale";        
          //recherche des destinataire
          $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
          $link_user_alarme=query($sql);
          while($tbl_alarme_user=fetch($link_user_alarme)){
            sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
          }
        }
        break;
    //embauche tardive
    case 3:
        //Heure (HH:MM) :
        $jourtab=explode(" ",$trajet[0]["debut"]);
        if(strtotime($trajet[0]["debut"])>strtotime($jourtab[0]." ".$valeur)){
          $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut une embauche tardive";        
          //recherche des destinataire
          $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
          $link_user_alarme=query($sql);
          while($tbl_alarme_user=fetch($link_user_alarme)){
            sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
          }
        }
        break;
    //distance quotidienne excessive
    case 4:
        if($totaldistance>$valeur*60){
          $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut une distance quotidienne excessive";        
          //recherche des destinataire
          $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
          $link_user_alarme=query($sql);
          while($tbl_alarme_user=fetch($link_user_alarme)){
            sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
          }
        }
        break;
    //distance quotidienne insuffisante
    case 5:
        if($totaldistance<$valeur*60){
          $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut une distance quotidienne insuffisante";        
          //recherche des destinataire
          $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
          $link_user_alarme=query($sql);
          while($tbl_alarme_user=fetch($link_user_alarme)){
            sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
          }
        }
        break;
    //Vitesse moyenne insuffisante
    case 6:
        for($i=0;$i<count($trajet);$i++){
          if($trajet[$i]["moy"]<valeur*60){
            $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut une vitesse moyenne insuffisante";        
            //recherche des destinataire
            $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                  inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                  where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
            $link_user_alarme=query($sql);
            while($tbl_alarme_user=fetch($link_user_alarme)){
              sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
            }
          }
        }
        break;
    //Vitesse moyenne excessive
    case 7:
        for($i=0;$i<count($trajet);$i++){
          if($trajet[$i]["moy"]>valeur*60){
            $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut une vitesse moyenne excessive";        
            //recherche des destinataire
            $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                  inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                  where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
            $link_user_alarme=query($sql);
            while($tbl_alarme_user=fetch($link_user_alarme)){
              sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
            }
          }
        }
        break;
    //Temps d'arret journalier excessif
    case 8:
        for($i=0;$i<count($trajet);$i++){
          if($trajet[$i]["arretintime"]>$valeur*60){
            $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut un temps d'arrêt insuffisant";        
            //recherche des destinataire
            $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                  inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                  where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
            $link_user_alarme=query($sql);
            while($tbl_alarme_user=fetch($link_user_alarme)){
              sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
            }
          }
        }
        break;
    //Temps de conduite journalier insuffisant
    case 9:
        if($totalconduite<$valeur*60){
          $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à eut un temps de conduite insuffisant";        
          //recherche des destinataire
          $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                inner join ".__racinebd__."usergps u.usergps_id=acu.usergps_id
                where alarme_compte_id=".$tbl_alarme_sociale["alarme_compte_id"];
          $link_user_alarme=query($sql);
          while($tbl_alarme_user=fetch($link_user_alarme)){
            sendmailmister('','','Alarme sociale',$html,$tbl_alarme_user["email"]);
          }
        }
        break;
  }  
}
}
?>
