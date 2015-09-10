<?
if($_POST["mode"]=="delete"){  
  $sql="update ".__racinebd__."alarme_compte set supprimer=1 where alarme_compte_id=".$_POST["id"];
  query($sql);
  $msgsave="Sµuppression effectuée";
}
//print_r($_POST);
if($_POST["mode"]=="ajout"){                                                                                                                           
  $sql="insert into ".__racinebd__."alarme_compte (typealarme_agence_id,agence_compte_id,compte_id,libelle,valeur) values('".$_POST["typealarme_agence_id"]."','".$_POST["agence"]."','".$_SESSION["compte_id"]."','".$_POST["name_descparam"]."','".$_POST["name_tpsarret"]."')";
  query($sql);
  $id=insert_id();
  //sauvegarde des horaires
  for($i=0;$i<count($_POST["jour"]);$i++){
    $sql="insert into ".__racinebd__."alarme_compte_jour (alarme_compte_id,jour_id) values(".$id.",".$_POST["jour"][$i].")";
    query($sql);  
  }
  //sauvegarde des vehicules
  for($i=0;$i<count($_POST["vehicule"]);$i++){
    $sql="insert into ".__racinebd__."alarme_compte_device (alarme_compte_id,device_id) values(".$id.",".$_POST["vehicule"][$i].")";
    query($sql);  
  }
  //sauvegarde des utilisateurs
  for($i=0;$i<count($_POST["user"]);$i++){
    $sql="insert into ".__racinebd__."alarme_compte_usergps  (alarme_compte_id,usergps_id) values(".$id.",".$_POST["user"][$i].")";
    query($sql);  
  }
  $msgsave="Sauvegarde effectuée";
}

if($_POST["id"]!=""&&$_POST["mode"]=="modif"){                                                                                                                         
  $sql="update ".__racinebd__."alarme_compte set typealarme_agence_id='".$_POST["typealarme_agence_id"]."',libelle='".$_POST["name_descparam"]."',valeur='".$_POST["name_tpsarret"]."' where alarme_compte_id=".$_POST["id"];
  query($sql);
  $id=insert_id();
  //sauvegarde des horaires
  $sql="delete from ".__racinebd__."alarme_compte_jour where alarme_compte_id=".$_POST["id"];
  query($sql);  
  for($i=0;$i<count($_POST["jour"]);$i++){
    $sql="insert into ".__racinebd__."alarme_compte_jour (alarme_compte_id,jour_id) values(".$_POST["id"].",".$_POST["jour"][$i].")";
    query($sql);  
  }
  //sauvegarde des vehicules
  $sql="delete from ".__racinebd__."alarme_compte_device where alarme_compte_id=".$_POST["id"];
  query($sql);  
  for($i=0;$i<count($_POST["vehicule"]);$i++){
    $sql="insert into ".__racinebd__."alarme_compte_device (alarme_compte_id,device_id) values(".$_POST["id"].",".$_POST["vehicule"][$i].")";
    query($sql);  
  }
  //sauvegarde des utilisateurs
  $sql="delete from ".__racinebd__."alarme_compte_usergps where alarme_compte_id=".$_POST["id"];
  query($sql);  
  for($i=0;$i<count($_POST["user"]);$i++){
    $sql="insert into ".__racinebd__."alarme_compte_usergps  (alarme_compte_id,usergps_id) values(".$_POST["id"].",".$_POST["user"][$i].")";
    query($sql);  
  }
  $msgsave="Sauvegarde effectuée";
}

$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_agence[]=$tbl;
}
if($_POST["agence"]!=""){
  $sql="select ac.* from ".__racinebd__."alarme_compte ac
  inner join ".__racinebd__."typealarme_agence taa on ac.typealarme_agence_id=taa.typealarme_agence_id and type=1
  where compte_id=".$_SESSION["compte_id"]." and agence_compte_id=".$_POST["agence"]." and supprimer=0 order by libelle";
  $link=query($sql);
  
  while($tbl=fetch($link)){
    $tbl_list_alarme[]=$tbl;
  }

  $sql="select * from ".__racinebd__."typealarme_agence where type=1 order by libelle";
  $link=query($sql);
  while($tbl=fetch($link)){
    $tbl_list_type_alarme_agence[]=$tbl;
  }
  $sql="select * from ".__racinebd__."jour order by jour_id";
  $link=query($sql);
  while($tbl=fetch($link)){
    $tbl_list_jour[]=$tbl;
  }
  
  $sql = getsqllistvehicule()." and agence_compte_id=".$_POST["agence"];
  $link=query($sql);
  while($tbl=fetch($link)){
    $tbl_list_vehicule[]=$tbl;
  }
  $sql = "select *,u.usergps_id from ".__racinebd__."compte c 
        inner join ".__racinebd__."usergps u on u.compte_id=c.compte_id 
        where c.supprimer=0 and u.supprimer=0 and c.compte_id=".$_SESSION["compte_id"];
  $link=query($sql);	
  while($tbl=fetch($link)){
    $tbl_list_user[]=$tbl;  
  }
}

if($_POST["agence"]!=""&&$_POST["id"]!=""){
  $sql="select * from ".__racinebd__."alarme_compte where alarme_compte_id=".$_POST["id"];
  $link=query($sql);
  $tbl_modif_alarme=fetch($link);
  //on recherche les jours
  $sql="select * from ".__racinebd__."alarme_compte_jour where alarme_compte_id=".$_POST["id"];
  $link=query($sql); 
  while($tbl=fetch($link)){
    $tbl_list_jour2[]=$tbl["jour_id"];
  }
  $tbl_modif_alarme["listjour"]=$tbl_list_jour2;
  
  //on recherche les vehicules
  $sql="select * from ".__racinebd__."alarme_compte_device where alarme_compte_id=".$_POST["id"];
  $link=query($sql); 
  while($tbl=fetch($link)){
    $tbl_list_vehicule2[]=$tbl["device_id"];
  }
  //on recherche les vehicules
  $sql="select * from ".__racinebd__."alarme_compte_usergps where alarme_compte_id=".$_POST["id"];
  $link=query($sql); 
  while($tbl=fetch($link)){
    $tbl_list_user2[]=$tbl["usergps_id"];
  }
  $tbl_modif_alarme["listjour"]=$tbl_list_jour2;
  $tbl_modif_alarme["listvehicule"]=$tbl_list_vehicule2;
  $tbl_modif_alarme["listusergps"]=$tbl_list_user2;
}
if(!is_array($tbl_modif_alarme["listjour"])){
$tbl_modif_alarme["listjour"]=array();
}
if(!is_array($tbl_modif_alarme["listvehicule"])){
$tbl_modif_alarme["listvehicule"]=array();
}
if(!is_array($tbl_modif_alarme["listusergps"])){
$tbl_modif_alarme["listusergps"]=array();
}

?>