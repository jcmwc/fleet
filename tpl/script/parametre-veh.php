<?
if(!verifdroit("VEH")){
die;
}
if($_GET["mode"]=="delete"){
   $sql="update ".__racinebd__."device set supprimer=1 where device_id=".$_GET["id"];
   query($sql);
   $msgsave="Suppression effectuée";
}
//print_r($_POST);

//sauvegarde de modification
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  $sql="update ".__racinebd__."device set agence_compte_id='".$_POST["agence_compte_id"]."',
  type_compte_id='".$_POST["type_compte_id"]."',consommation='".addquote($_POST["consommation"])."',nomvehicule='".addquote($_POST["nomvehicule"])."'
  ,immatriculation='".addquote($_POST["immatriculation"])."',chassis='".addquote($_POST["chassis"])."',marque='".addquote($_POST["marque"])."'
  ,modele='".addquote($_POST["modele"])."',kminit='".addquote($_POST["kminit"])."',correctifkm='".addquote($_POST["correctifkm"])."'
  ,correctifh='".addquote($_POST["correctifh"])."',type_moteur_id='".$_POST["type_moteur_id"]."',consommationtype='".$_POST["consommationtype"]."',tel='".$_POST["tel"]."' where device_id=".$_POST["pdevice_id"];
  //print $sql."<br>";
  query($sql);
  //sauvegarde des categories
  $sql="delete from ".__racinebd__."categorie_compte_device where device_id=".$_POST["id"];
  query($sql);
  for($i=0;$i<count($_POST["categorie"]);$i++){
    $sql="insert into ".__racinebd__."categorie_compte_device (device_id,categorie_compte_id) values(".$_POST["id"].",".$_POST["categorie"][$i].")";
    query($sql);  
  }
  $msgsave="Sauvegarde effectuée";  
}


$sql="select * from ".__racinebd__."categorie_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_categorie[]=$tbl;
}

/*
//$sql="select * from ".__racinebd__."etat_moteur order by libelle";
$sql="select em.etat_moteur_id,em.libelle,emc.libelle as lib2 from ".__racinebd__."etat_moteur em left join
    ".__racinebd__."etat_moteur_compte emc on em.etat_moteur_id=emc.etat_moteur_id and compte_id=".$_SESSION["compte_id"]." order by libelle";
$link=query($sql);
while($tbl=fetch($link)){
  $tbl_list_etat[]=array($tbl["etat_moteur_id"],(($tbl["lib2"]=="")?$tbl["libelle"]:$tbl["lib2"]));
}
*/

$sql="select * from ".__racinebd__."type_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_type[]=$tbl;
  $key_list_type[$tbl["type_compte_id"]]=$tbl["libelle"];
}

$sql="select * from ".__racinebd__."type_moteur  order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_type_moteur[]=$tbl;
}

$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_agence[]=$tbl;
  $key_list_agence[$tbl["agence_compte_id"]]=$tbl["libelle"];
}

$sql=getsqllistboitier();
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_boitier[]=$tbl;
}

if($_POST["mode"]=="search"){
  //filtre
  $where="";
  if($_POST["type"]!=""){
    $where.=" and type_compte_id=".$_POST["type"];
  }
  if($_POST["agence"]!=""){
    $where.=" and agence_compte_id=".$_POST["agence"];
  }
  if($_POST["nom"]!=""){
    $where.=" and nomvehicule like '%".$_POST["nom"]."%'";
  }
  if($_POST["immatriculation"]!=""){
    $where.=" and immatriculation like '%".$_POST["immatriculation"]."%'";
  }
  if($_POST["phone_number"]!=""){
    $where.=" and phone_number like '%".$_POST["phone_number"]."%'";
  }
  if($_POST["IMEI"]!=""){
    $where.=" and pd.IMEI ='".$_POST["IMEI"]."'";
  }
  $sql=getsqllistboitier()." ".$where;
}else{
  $sql=getsqllistboitier();
}
$link=query($sql);

while($tbl=fetch($link)){
  $sql="select * from ".__racinebd__."categorie_compte_device ccd
        inner join ".__racinebd__."categorie_compte cc on ccd.categorie_compte_id=cc.categorie_compte_id where device_id=".$tbl["phantom_device_id"];
  //print $sql;
  $link2=query($sql);
  $tbl_list_cat=array();
  while($tbl2=fetch($link2)){
    $tbl_list_cat[]=$tbl2["libelle"];
    $tbl_list_cat_id[]=$tbl2["categorie_compte_id"];
  }
  $tbl["listcat"]=implode(", ",$tbl_list_cat);
  $tbl_list_vehicule[]=$tbl;  
}
//print_r($tbl_list_vehicule);

if($_GET["id"]!=""&&$_GET["mode"]=="modif"){
  $sql=getsqllistboitier()." and pd.device_id=".$_GET["id"];   
  //print $sql;
  $link=query($sql);
  $tbl_modif_veh=fetch($link);
}
?>