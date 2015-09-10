<?
$indicedujour=dayOfWeek(mktime(0,0,0,date("n"),date("j"),date("Y")));
//typealarme_agence_id = 10 //alarme standard
$sql="select * from ".__racinebd__."alarme_compte where compte_id=".$_SESSION["compte_id"]." and typealarme_agence_id=10";
$link_alarme=query($sql);
if(num_rows($link_alarme)>0){
  $tbl_alarme_op=fetch($link_alarme);
  //verification si l'alerte est effective aujourd'hui
  $sql="select * from ".__racinebd__."alarme_compte_jour where alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"]." and jour_id=".$indicedujour;
  $link_alarme_jour=query($sql);
  if(num_rows($link_alarme_jour)>0){
    $sql="select * from ".__racinebd__."alarme_compte_device where alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
    $link_alarme_device=query($sql);
    while($tbl_alarme_devie=fetch($link_alarme_device)){
      //entrante
      if($tbl_alarme_op["valeur"]==1){
        $sql="select * from positions where device_id=".$tbl_alarme_devie["device_id"]." and time>='".$dernierdatedebut."' and time<='".$nouveldatedebut."'";
        $link_position=query($sql);
        $tbllistentrantelieu=array(); 
        $i=0; 
        while($tbl_position=fetch($link_position)){
          $sql="select lc.* from ".__racinebd__."alarme_compte_lieu acl
          inner join ".__racinebd__."lieu_compte lc on acl.lieu_compte_id=lc.lieu_compte_id
          where alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
          $link_alarme_lieu=query($sql);
          $tbllistentrantelieudeja=array();
          
          while($tbl_alarme_lieu=fetch($link_alarme_lieu)){
            // pour test
            //print $i."<br>";
            
            if(haversineGreatCircleDistance($tbl_position["latitude"], $tbl_position["longitude"], $tbl_alarme_lieu["latitude"],$tbl_alarme_lieu["longitude"])<=$tbl_alarme_lieu["rayon"]){
              //print "je suis ici";
              if($i==0){
                $tbllistentrantelieudeja[$tbl_alarme_lieu["lieu_compte_id"]]=true;
              }else if(!array_key_exists($tbl_alarme_lieu["lieu_compte_id"],$tbllistentrantelieu)){
                
                if($tbllistentrantelieudeja[$tbl_alarme_lieu["lieu_compte_id"]]!=true){
                  $tbllistentrantelieu[$tbl_alarme_lieu["lieu_compte_id"]]=$tbl_alarme_devie["device_id"];
                } 
              }
            }
            
          }
          $i++;
        }
        
        //envoi des mails
        $sql="select * from ".__racinebd__."alarme_compte_usergps acu
          inner join ".__racinebd__."usergps u on acu.usergps_id=u.usergps_id and alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
        $link_alarme_user=query($sql);
        while($tbl_alarme_user=fetch($link_alarme_user)){
          foreach ($tbllistentrantelieu as $key => $value){
            //recherche du descriptif du véhicule
            $sql="select * from ".__racinebd__."device where device_id=".$value;  
            $link_vehicule=query($sql);
            $tbl_vehicule=fetch($link_vehicule);
            $sql="select * from ".__racinebd__."lieu_compte where lieu_compte_id=".$key;  
            $link_lieu=query($sql);
            $tbl_lieu=fetch($link_lieu);
            $html="Bonjour,<br> le véhicule ".$tbl_vehicule["nomvehicule"]." (".$tbl_vehicule["immatriculation"].") vient d'arriver à ".$tbl_lieu["libelle"];        
            sendmailmister('','','Alarme standard',$html,$tbl_alarme_user["email"]);
          }
        }          
      }
      //sortante
      if($tbl_alarme_op["valeur"]==0){
        $sql="select * from positions where device_id=".$tbl_alarme_devie["device_id"]." and time>='".$dernierdatedebut."' and time<='".$nouveldatedebut."'";
        $link_position=query($sql);
        $tbllistentrantelieu=array();
        $tbllistentrantelieuid=array();
        while($tbl_position=fetch($link_position)){
          $sql="select lc.* from ".__racinebd__."alarme_compte_lieu acl
          inner join ".__racinebd__."lieu_compte lc on acl.lieu_compte_id=lc.lieu_compte_id
          where alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
          $link_alarme_lieu=query($sql); 
          while($tbl_alarme_lieu=fetch($link_alarme_lieu)){
            if(haversineGreatCircleDistance($tbl_position["latitude"], $tbl_position["longitude"], $tbl_alarme_lieu["latitude"],$tbl_alarme_lieu["longitude"])<=$tbl_alarme_lieu["rayon"]){
              if(!array_key_exists($tbl_alarme_lieu["lieu_compte_id"],$tbllistentrantelieu)){
                $tbllistentrantelieu[$tbl_alarme_lieu["lieu_compte_id"]]=$tbl_alarme_devie["device_id"]; 
                $tbllistentrantelieuid[]=$tbl_alarme_lieu["lieu_compte_id"];
              }
            }
            $lastpos=$tbl_position;
          }
        }
        
        if(count($tbllistentrantelieuid)>0){
          $sql="select * from ".__racinebd__."lieu_compte lc 
            inner join ".__racinebd__."type_lieu_compte tlc on lc.type_lieu_compte_id=tlc.type_lieu_compte_id 
            where lc.supprimer=0 and lieu_compte_id in(".implode(",",$tbllistentrantelieuid).")";
          $link_lieu=query($sql);
          while($tbl_lieu=fetch($link_lieu)){
            if(haversineGreatCircleDistance($lastpos["latitude"], $lastpos["longitude"], $tbl_lieu["latitude"],$tbl_lieu["longitude"])<=$tbl_lieu["rayon"]){
              $tbllistentrantelieu[$tbl_lieu["lieu_compte_id"]]=0; 
            } 
          }
          //envoi des mails
          $sql="select * from ".__racinebd__."alarme_compte_usergps acu
            inner join ".__racinebd__."usergps u on acu.usergps_id=u.usergps_id and alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
          $link_alarme_user=query($sql);
          while($tbl_alarme_user=fetch($link_alarme_user)){
            foreach ($tbllistentrantelieu as $key => $value){
              if($value!=0){
                //recherche du descriptif du véhicule
                $sql="select * from ".__racinebd__."device where device_id=".$value;  
                $link_vehicule=query($sql);
                $tbl_vehicule=fetch($link_vehicule);
                $sql="select * from ".__racinebd__."lieu_compte where lieu_compte_id=".$key;  
                $link_lieu=query($sql);
                $tbl_lieu=fetch($link_lieu);
                $html="Bonjour,<br> le véhicule ".$tbl_vehicule["nomvehicule"]." (".$tbl_vehicule["immatriculation"].") vient de partir de ".$tbl_lieu["libelle"];        
                //print $html;
                sendmailmister('','','Alarme standard',$html,$tbl_alarme_user["email"]);
              }
            }
          }
         }   
      }
    }
  }
}

//typealarme_agence_id = 11 //Temps de présence dans un lieu anormal
$sql="select * from ".__racinebd__."alarme_compte where compte_id=".$_SESSION["compte_id"]." and typealarme_agence_id=11";
$link_alarme=query($sql);
if(num_rows($link_alarme)>0){
  $tbl_alarme_op=fetch($link_alarme);
  //verification si l'alerte est effective aujourd'hui
  $sql="select * from ".__racinebd__."alarme_compte_jour where alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"]." and jour_id=".$indicedujour;
  $link_alarme_jour=query($sql);
  if(num_rows($link_alarme_jour)>0){
    $sql="select * from ".__racinebd__."alarme_compte_device where alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
    $link_alarme_device=query($sql);
    while($tbl_alarme_devie=fetch($link_alarme_device)){
      //entrante

        $sql="select * from positions where device_id=".$tbl_alarme_devie["device_id"]." and time>='".$dernierdatedebut."' and time<='".$nouveldatedebut."'";
        $link_position=query($sql);
        $tbllistentrantelieu=array();
        $i=0;
        while($tbl_position=fetch($link_position)){
          $sql="select lc.* from ".__racinebd__."alarme_compte_lieu acl
          inner join ".__racinebd__."lieu_compte lc on acl.lieu_compte_id=lc.lieu_compte_id
          where alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
          $link_alarme_lieu=query($sql);
           
          while($tbl_alarme_lieu=fetch($link_alarme_lieu)){
            
            
            if(haversineGreatCircleDistance($tbl_position["latitude"], $tbl_position["longitude"], $tbl_alarme_lieu["latitude"],$tbl_alarme_lieu["longitude"])<=$tbl_alarme_lieu["rayon"]&&$i!=0){
              if($i==0){
                $tbllistentrantelieudeja[$tbl_alarme_lieu["lieu_compte_id"]]=true;
              }else if(!array_key_exists($tbl_alarme_lieu["lieu_compte_id"],$tbllistentrantelieu)){
                if($tbllistentrantelieudeja[$tbl_alarme_lieu["lieu_compte_id"]]!=true){
                  $tbllistentrantelieu[$tbl_alarme_lieu["lieu_compte_id"]]=array($tbl_position["time"],$tbl_alarme_devie["device_id"]);
                } 
              }
            }            
          }
          $i++;
        }
        foreach ($tbllistentrantelieu as $key => $value){
          
          $sql="insert into ".__racinebd__."alarme_compte_lieu_duree (alarme_compte_id,alarme_compte_lieu_id,date_entree,device_id)
            values ('".$tbl_alarme_op["alarme_compte_id"]."','".$key."','".$value[0]."','".$value[1]."')";
          query($sql);
        
        }
      //sortante
        $sql="select * from positions where device_id=".$tbl_alarme_devie["device_id"]." and time>='".$dernierdatedebut."' and time<='".$nouveldatedebut."'";
        $link_position=query($sql);
        $tbllistentrantelieu=array();
        $tbllistentrantelieuid=array();
        while($tbl_position=fetch($link_position)){
          $sql="select lc.* from ".__racinebd__."alarme_compte_lieu acl
          inner join ".__racinebd__."lieu_compte lc on acl.lieu_compte_id=lc.lieu_compte_id
          where alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
          $link_alarme_lieu=query($sql); 
          while($tbl_alarme_lieu=fetch($link_alarme_lieu)){
          
            
            if(haversineGreatCircleDistance($tbl_position["latitude"], $tbl_position["longitude"], $tbl_alarme_lieu["latitude"],$tbl_alarme_lieu["longitude"])<=$tbl_alarme_lieu["rayon"]){
              if(!array_key_exists($tbl_alarme_lieu["lieu_compte_id"],$tbllistentrantelieu)){
                $tbllistentrantelieu[$tbl_alarme_lieu["lieu_compte_id"]]=array($tbl_position["time"],$tbl_alarme_devie["device_id"]); 
                $tbllistentrantelieuid[]=$tbl_alarme_lieu["lieu_compte_id"];
              }
            }
            $lastpos=$tbl_position;
          }
        }
    
        if(count($tbllistentrantelieuid)>0){
          $sql="select * from ".__racinebd__."lieu_compte lc 
            inner join ".__racinebd__."type_lieu_compte tlc on lc.type_lieu_compte_id=tlc.type_lieu_compte_id 
            where lc.supprimer=0 and lieu_compte_id in(".implode(",",$tbllistentrantelieuid).")";
          $link_lieu=query($sql);
          while($tbl_lieu=fetch($link_lieu)){
            //print_r($lastpos);
            if(haversineGreatCircleDistance($lastpos["latitude"], $lastpos["longitude"], $tbl_lieu["latitude"],$tbl_lieu["longitude"])<=$tbl_lieu["rayon"]){
              $tbllistentrantelieu[$tbl_lieu["lieu_compte_id"]]=0; 
            } 
          }
          foreach ($tbllistentrantelieu as $key => $value){
            if($value!=0){
              $sql="select * from ".__racinebd__."alarme_compte_lieu_duree where 
              alarme_compte_id='".$tbl_alarme_op["alarme_compte_id"]."'
              and alarme_compte_lieu_id='".$key."'
              and device_id='".$value[1]."'";
              $link_date_entree=query($sql);
              $tbl_date_entree=fetch($link_date_entree);
              //vérification si le temps de presence est suppérieur a temps requis
              
              
              if(((strtotime($tbl_date_entree["date_entree"])- strtotime($value[0]))>$tbl_alarme_op["valeur"]*60)){
                //envoi des mails
                $sql="select * from ".__racinebd__."alarme_compte_usergps acu
                  inner join ".__racinebd__."usergps u on acu.usergps_id=u.usergps_id and alarme_compte_id=".$tbl_alarme_op["alarme_compte_id"];
                $link_alarme_user=query($sql);
                while($tbl_alarme_user=fetch($link_alarme_user)){
                  foreach ($tbllistentrantelieu as $key => $value){
                    if($value!=0){
                      //recherche du descriptif du véhicule
                      $sql="select * from ".__racinebd__."device where device_id=".$value[1];  
                      $link_vehicule=query($sql);
                      $tbl_vehicule=fetch($link_vehicule);
                      $sql="select * from ".__racinebd__."lieu_compte where lieu_compte_id=".$key;  
                      $link_lieu=query($sql);
                      $tbl_lieu=fetch($link_lieu);
                      $html="Bonjour,<br> le véhicule ".$tbl_vehicule["nomvehicule"]." (".$tbl_vehicule["immatriculation"].") a un temps de présence anormal à ".$tbl_lieu["libelle"];        
                      print $html;
                      sendmailmister('','','Alarme standard',$html,$tbl_alarme_user["email"]);
                    }
                  }
                }
              }
              //supression des enregistrement
              $sql="delete from ".__racinebd__."alarme_compte_lieu_duree where alarme_compte_id='".$tbl_alarme_op["alarme_compte_id"]."' and alarme_compte_lieu_id='".$key."' and device_id='".$value[1]."'";
              //query($sql);
            }
          }
         }   
    }
  }
}
?>