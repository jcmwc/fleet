<?
$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);
while($tbl=fetch($link)){
  $tbl_list_agence[]=$tbl;
}
//print_r($_POST);
if($_POST["id"]!=""&&$_POST["mode"]=="suppr"){
  $sql="update ".__racinebd__."alarme_entretien set supprimer=1 where alarme_entretien_id=".$_POST["id"];
  //print $sql;
  query($sql);
  $msgsave="Sauvegarde éffectuée";
}
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  /*
  $sql="update ".__racinebd__."device set kilometreentretien='".$_POST["kilometreentretien"]."',dateentretien='".datebdd($_POST["dateentretien"])."',nbheureentretien='".$_POST["nbheureentretien"]."' where owner_id=".$_POST["id"];
  //print $sql."<br>";
  query($sql);
  */
  $sql="update ".__racinebd__."alarme_entretien set km='".$_POST["km"]."',
        date='".datebdd($_POST["date"])."',entretien_compte_id='".$_POST["entretien_compte"]."' where alarme_entretien_id=".$_POST["id"];
  //print $sql;
  query($sql);
  $msgsave="Sauvegarde éffectuée";
}
if($_POST["agence"]!=""&&$_POST["mode"]=="ajout"){
  $sql="insert into ".__racinebd__."alarme_entretien (device_id,km,date,entretien_compte_id)
  values('".$_POST["vehicule"]."','".$_POST["km"]."','".datebdd($_POST["date"])."','".$_POST["entretien_compte"]."')";
  query($sql);  
  $msgsave="Sauvegarde éffectuée";
}

if($_POST["agence"]!=""){

  //listing des véhicules
  /*
  $sql = getsqllistvehicule()." and agence_compte_id=".$_POST["agence"];
  $link=query($sql);
  while($tbl=fetch($link)){
    //mettre a jour les km
    $sql="select * from ".__racinebd__."type_compte tc where type_compte_id=".$tbl["type_compte_id"];
    //print $sql;
    $link2=query($sql);
    $tbl_type=fetch($link2);
    $tbl["type"]=$tbl_type;
    
    //recherche catégorie
    $sql="select * from ".__racinebd__."categorie_compte_device ccd
          inner join ".__racinebd__."categorie_compte cc on ccd.categorie_compte_id=cc.categorie_compte_id where device_id=".$tbl["phantom_device_id"];
    //print $sql;
    $link2=query($sql);
    $tbl_list_cat=array();
    while($tbl2=fetch($link2)){
      $tbl_list_cat[]=$tbl2["libelle"];
    } 
    $tbl["listcat"]=implode(", ",$tbl_list_cat);
    $tbl_list_vehicule[]=$tbl;
  } */
  $sql = getsqllistvehicule()." and agence_compte_id=".$_POST["agence"];
  $link=query($sql);
  while($tbl=fetch($link)){
    $tbl_list_vehicule[]=$tbl;
  }
  
  $sql="select * from ".__racinebd__."alarme_entretien ae inner join ".__racinebd__."device d on ae.device_id=d.device_id and ae.supprimer=0 and agence_compte_id=".$_POST["agence"];
  //print $sql;
  $link=query($sql);
  while($tbl=fetch($link)){
    //mettre a jour les km
    $sql="select * from ".__racinebd__."type_compte tc where type_compte_id=".$tbl["type_compte_id"];
    //print $sql;
    $link2=query($sql);
    $tbl_type=fetch($link2);
    $tbl["type"]=$tbl_type;
    
    //recherche catégorie
    $sql="select * from ".__racinebd__."categorie_compte_device ccd
          inner join ".__racinebd__."categorie_compte cc on ccd.categorie_compte_id=cc.categorie_compte_id where device_id=".$tbl["device_id"];
    //print $sql;
    $link2=query($sql);
    $tbl_list_cat=array();
    while($tbl2=fetch($link2)){
      $tbl_list_cat[]=$tbl2["libelle"];
    } 
    $tbl["listcat"]=implode(", ",$tbl_list_cat);
    $tbl_list_alarme[]=$tbl;
  } 
  $sql="select * from ".__racinebd__."entretien_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
  $link=query($sql);
  
  while($tbl=fetch($link)){
    $tbl_list_type[]=$tbl;
  }
}
/*
if($_POST["agence"]!=""&&$_POST["id"]!=""&&$_POST["mode"]!="modif"){


  $sql="select * from ".__racinebd__."alarme_entretien ae where alarme_entretien_id=".$_GET["id"];
  $link=query($sql);
  $tbl_modif_vitesse=fetch($link);
}
*/

?>