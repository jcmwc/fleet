<?
require("../../require/function.php");
//lecture du fichier csv
$filename = "clients.csv";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$line=explode("\n",$contents);
for($i=1;$i<count($line);$i++){
  $tablelem=explode(";",$line[$i]);
  if($tablelem[1]!=""){
    //on verifie si le compte existe déjà
    $sql="select * from ".__racinebd__."compte where nom ='".addslashes($tablelem[1])."' and supprimer=0";
    $link=query($sql);
    if(num_rows($link)==0){
      if($tablelem[23]!=""){
        //verfification du commercial
        $sql="select * from ".__racinebd__."commercial where nom ='".addslashes($tablelem[23])."' and prenom='".addslashes($tablelem[24])."'";
        $link2=query($sql);
        if(num_rows($link2)==0){
          $sql="insert into ".__racinebd__."commercial (nom,prenom,actif) values('".addslashes($tablelem[23])."','".addslashes($tablelem[24])."',1)";
          query($sql);
          $commercial_id=insert_id(); 
        }else{
          $tbl2=fetch($link2);
          $commercial_id=$tbl2["commercial_id"];
        }    
      }
      $sql="insert into ".__racinebd__."compte (commercial_id,nom,codecreation,raisonsociale,adresse,cp,ville,tel,email,date_creation) 
        values ('".$commercial_id."','".addslashes($tablelem[1])."','".addslashes($tablelem[2])."','".addslashes($tablelem[1])."','".addslashes($tablelem[7])." ".addslashes($tablelem[8])."','".addslashes($tablelem[9])."','".addslashes($tablelem[10])."','".addslashes($tablelem[3])."','".addslashes($tablelem[6])."',now())";
      //print $sql."<br>";
      query($sql);
      $compte_id=insert_id();
      
      $sql="insert into ".__racinebd__."preference_compte (delaimail,dureemintraj,dureeminattente,compte_id) values(60,120,180,".$compte_id.")";
      query($sql);
      
      //creation d'une agence par defaut
      $sql="insert into ".__racinebd__."agence_compte (libelle,principal,compte_id) values('Agence 1',1,".$compte_id.")";
      query($sql);
       //creation de type de véhicule
      $sql="INSERT INTO `phantom_type_compte` (`libelle`, `compte_id`, `icon`) VALUES('Voiture', ".$compte_id.", 'car_icon.png');";
      query($sql);
      $sql="INSERT INTO `phantom_type_compte` (`libelle`, `compte_id`, `icon`) VALUES('Camion', ".$compte_id.", 'supercamion_icon.png');";
      query($sql);
      $sql="INSERT INTO `phantom_type_compte` (`libelle`, `compte_id`, `icon`) VALUES('Utilitaire', ".$compte_id.", 'utilitaire-icon.png');";
      query($sql);
      
      //creation d'un acces
      $sql="insert into ".__racinebd__."usergps (tel,compte_id,name,username,email,password,date_creation)
        values('".addslashes($tablelem[3])."','".$compte_id."','mister".$tablelem[2]."','mister".$tablelem[2]."','".addslashes($tablelem[6])."','d9e53a4cc04abc89b7f7c38300113bac',now())";
      query($sql);
      $usergpd_id=insert_id();
      
      //jours
      $sql="select * from ".__racinebd__."jour";
      $linkjour=query($sql);
      while($tbl_jour=fetch($linkjour)){
        $sql="insert into ".__racinebd__."jour_usersgps (jour_id,usergps_id) values('".$tbl_jour["jour_id"]."','".$usergpd_id."')";
        query($sql);
      }     
      
      //creation des droits par defaut
      //modules
      $sql="select * from ".__racinebd__."module";
      $linkmodule=query($sql);
      while($tbl_module=fetch($linkmodule)){
        $sql="insert into ".__racinebd__."module_usersgps (module_id,usergps_id) values('".$tbl_module["module_id"]."','".$usergpd_id."')";
        query($sql);
      }
    }
  }
}

//import des boitiers
$filename = "ExportMisterfleet-2014-09-22.csv";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$line=explode("\n",$contents);
for($i=1;$i<count($line);$i++){
  $tablelem=explode(";",$line[$i]);
  $sql="select * from ".__racinebd__."compte where nom ='".addslashes($tablelem[1])."' and supprimer=0";
  $link=query($sql);
  if(num_rows($link)>0){
    $tbl=fetch($link);
    
    //on verifie si la voiture existe
    $sql="select * from ".__racinebd__."device where lastid='".addquote($tablelem[2])."'";
    $link2=query($sql);
    if(num_rows($link2)==0&&$tablelem[5]!=""){    
      $compte_id=$tbl["compte_id"];
      
      $sql="select max(id) as maxid from devices";
      $link=query($sql);
      $tbl=fetch($link);
      
      $sql="insert into devices (name,uniqueId) 
      values('Device".($tbl["maxid"]+1)."','".addslashes($tablelem[5])."')";
      //print $sql;
      
      query($sql);
      $id=insert_id();
      
      $sql="INSERT INTO users_devices (users_id, devices_id) VALUES ('1', $id)";
      query($sql);
      
      $szQuery="insert into ".__racinebd__."device (devices_id,type_device_id,IMEI,serialnumber,nomvehicule,telboitier,compte_id,date_creation,unitid,immatriculation,lastid) 
      values('".$id."',1,'".addslashes($tablelem[5])."','".addslashes($tablelem[5])."','".addslashes($tablelem[3])."','+".addslashes($tablelem[6])."','".$compte_id."',now(),'".addquote($tablelem[5])."','".addquote($tablelem[4])."','".addquote($tablelem[2])."')";
      //query($sql);
      query($szQuery);
      $device_id=insert_id();
      
      //device phantom_usergps_device
      $sql="select * from ".__racinebd__."usergps where compte_id=".$compte_id;
      $link_device=query($sql);
      while($tbl_device=fetch($link_device)){
        $sql="insert into ".__racinebd__."usergps_device (device_id,usergps_id) values('".$device_id."','".$tbl_device["usergps_id"]."')";
        query($sql);
      }
      
    }
    
  }else{
    print "erreur compte '".addslashes($tablelem[1])."' non trouvé<br>";
  }
}
?>