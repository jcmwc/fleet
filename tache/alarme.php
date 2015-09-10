<?
require("../admin/require/function.php");
set_time_limit(86400);

//vérification si la tache précédente est fini
$sql="select * from ".__racinebd__."alerte";
$link_alerte=query($sql);
$tbl_alerte=fetch($link_alerte);
//a commenter
//$tbl_alerte["date_fin"]="2014-09-08";

if($tbl_alerte["date_fin"]!=""){
  $dernierdatedebut=$tbl_alerte["date_debut"];
  //mise a jour de la date de début d'alerte
  $nouveldatedebut=date("Y-m-d H:i:s");
  $sql="update ".__racinebd__."alerte set date_debut='".$nouveldatedebut."', date_fin =null ";
  query($sql);
  
  //recherche des différents comptes
  $sql="select c.*,delaimail,TIME_TO_SEC(TIMEDIFF(now(), lastenvoi))/60 as diffenvoi from ".__racinebd__."compte c 
        inner join ".__racinebd__."preference_compte pc on c.compte_id=pc.compte_id  where supprimer=0 and actif=1";
  //print $sql."<br>";
  $link_compte=query($sql);
  while($tbl_compte=fetch($link_compte)){
    if($tbl_compte["diffenvoi"]>$tbl_compte["delaimail"]||$tbl_compte["diffenvoi"]==""){
      $_SESSION["compte_id"]=$tbl_compte["compte_id"];
      
      //alarme d'entretien
      $sql="select * from ".__racinebd__."alarme_entretien ae 
      inner join ".__racinebd__."device d on ae.device_id=d.device_id and ae.supprimer=0 and d.supprimer=0
      inner join ".__racinebd__."entretien_compte ec on ec.entretien_compte_id=ae.entretien_compte_id
      where date='".date('Y-m-d')."' or (km<kminit+kmactuel+correctifkm and km>0)";
      //print $sql;
      $link_entretien=query($sql);
      while($tbl_list_entretien=fetch($link_entretien)){
        //recherche des personnes a prévenir
        $sql="select u.* from ".__racinebd__."usergps_device mc
          inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and mc.device_id=".$tbl_list_entretien["device_id"]."
          inner join ".__racinebd__."rapport_usersgps ru on rapport_id=12 and ru.usergps_id=u.usergps_id
          and u.supprimer=0";
        $link_user_dest=query($sql);
        $html="Bonjour,<br> le véhicule ".$tbl_list_entretien["nomvehicule"]." (".$tbl_list_vehicule["immatriculation"].") à une alerte de type ".$tbl_list_entretien["libelle"];
        while($tbl_user_dest=fetch($link_user_dest)){
          //print $tbl_user_dest["email"]."<br>"; 
          sendmailmister('','','Alarme d\'entretien véhicule '.$tbl_list_entretien["nomvehicule"],$html,$tbl_user_dest["email"]);
        }
        //suppression de l'alarme
        $sql="update ".__racinebd__."alarme_entretien set supprimer=1 where alarme_entretien_id=".$tbl_list_entretien["alarme_entretien_id"];
        query($sql);
        //print $sql;
      }
      
      //alarme operationnelle
      require("alarme-operationelle.php");
      
      //listing des utilisateurs du compte qui travaille aujourd'hui
      $sql = "select *,u.usergps_id from  ".__racinebd__."compte c 
          inner join ".__racinebd__."usergps u on u.compte_id=c.compte_id      
          where actif=1 and u.supprimer=0 and c.compte_id=".$tbl_compte["compte_id"];
      
      
      $link_user=query($sql);
      while($tbl_user=fetch($link_user)){
      
        $indicedujour=dayOfWeek(mktime(0,0,0,date("n"),date("j"),date("Y")));
        $sql="select mc.* from ".__racinebd__."jour_usersgps mc
        inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and u.usergps_id=".$tbl_user["usergps_id"]." and jour_id=".$indicedujour;
        //print $sql."<br>";
        $link_jour=query($sql);
        if(num_rows($link_jour)!=0){
          //
          //creation des droits
          $_SESSION["logfront"]=1;        
          $_SESSION["email"]=$tbl_user["email"];
          $_SESSION["users_id"]=$tbl_user["usergps_id"];
          $_SESSION["usersgps_id"]=$tbl_user["usergps_id"];
          //recherche du compte affecté
          $_SESSION["compte_id"]=$tbl_user["compte_id"];
          $_SESSION["raisonsociale"]=$tbl_user["raisonsociale"];
          
          $sql="select * from ".__racinebd__."preference_compte where compte_id='".$_SESSION["compte_id"]."'";
          $link_preference=query($sql);
          $tbl_preference=fetch($link_preference);
          $_SESSION["delaimail"]=$tbl_preference["delaimail"];
          
          $sql="select m.* from ".__racinebd__."module m 
          inner join ".__racinebd__."module_usersgps mc on m.module_id=mc.module_id
          inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and mc.usergps_id=".$tbl_user["usergps_id"];
          $link2=query($sql);
          while($tbl2=fetch($link2)){
            $_SESSION["tabdroitmodule"][]=$tbl2;
          }
          
          $sql="select mc.* from ".__racinebd__."usergps_device mc
          inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and mc.usergps_id=".$tbl_user["usergps_id"];
          $_SESSION["filtrevehicule"]="";
          $link2=query($sql);
          $tabvehicule=array();
          while($tbl2=fetch($link2)){
            $tabvehicule[]= $tbl2["device_id"];
          }
          if(count($tabvehicule)){
            $_SESSION["filtrevehicule"]=" and pd.device_id in(".implode(",",$tabvehicule).")";
          }
          
          $sql="select mc.* from ".__racinebd__."agence_compte_usergps mc 
          inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and mc.usergps_id=".$tbl_user["usergps_id"];
          $_SESSION["filtreagence"]="";
          $link2=query($sql);
          $tabagence=array();
          while($tbl2=fetch($link2)){
            $tabagence[]= $tbl2["agence_compte_id"];
          }
          if(count($tabvehicule)){
            $_SESSION["filtreagence"]=" and agence_compte_id in(".implode(",",$tabagence).")";
          }
        
          //alarme de vitesse
          
          //on regarde si la personne doit recevoir ces alertes
          $sql="select * from ".__racinebd__."rapport_usersgps where rapport_id=11 and usergps_id=".$tbl_user["usergps_id"];
          //print $sql;
          $linkalerte=query($sql);
          if($linkalerte){
            //recherche des vehicules du compte géré par cet utilisateur qui ont des alarmes de vitesse
            $sql=getsqllistvehicule()." and vitessemax!='0.00'";
            //print $sql."<br>";
            $link_vehicule=query($sql);
            while($tbl_list_vehicule=fetch($link_vehicule)){
              //on liste des enregistrement de la table position pendant l'interval d'alerte
              $sql="select * from positions where device_id=".$tbl_list_vehicule["traccar_device_id"]." and time>='".$dernierdatedebut."' and time<'".$nouveldatedebut."' and speed>'".inversevitessekmh($tbl_list_vehicule["vitessemax"])."'";
              //print $sql."<br>";
              $linkvitesse=query($sql);
              if(num_rows($linkvitesse)>0){
                $html="Bonjour,<br> le véhicule ".$tbl_list_vehicule["nomvehicule"]." 
                  (".$tbl_list_vehicule["immatriculation"].") à été controlé à une vitesse de :"; 
                while($tbl_vitesse=fetch($linkvitesse)){
                  $adresse = str_replace(", France","",getAddess($tbl_vitesse["latitude"],$tbl_vitesse["longitude"]));
                  $datelieu = "<br>".affichedatetime($tbl_vitesse["time"])."<br>".$adresse;                
                  $html.="<br>".vitessekmh($tbl_vitesse["speed"])." km/h à ".$datelieu."<br>";                               
                }
                $html.="Sa vitesse maximale autorisée est de ".$tbl_list_vehicule["vitessemax"]." km/h";
                //print $html;
                sendmailmister('','','Alarme vitesse véhicule '.$tbl_list_vehicule["nomvehicule"],$html,$_SESSION["email"]);
              }
            }
          }
          //a decommenter
          $sql="update ".__racinebd__."preference_compte set lastenvoi=now() where compte_id=".$_SESSION["compte_id"];
          query($sql);
        }
      }
    }
  } 
  $sql="update ".__racinebd__."alerte set date_fin=now()";
  query($sql);
}
?>