<?
//$sql="select * from ".__racinebd__."etat_moteur order by libelle";
$sql="select em.etat,em.etat_moteur_id,em.libelle,emc.libelle as lib2 from ".__racinebd__."etat_moteur em left join
    ".__racinebd__."etat_moteur_compte emc on em.etat_moteur_id=emc.etat_moteur_id and compte_id=".$_SESSION["compte_id"]." order by libelle";
$link=query($sql);
while($tbl=fetch($link)){
  $tbl_list_etat[]=array("etat_moteur_id"=>$tbl["etat"],"libelle"=>(($tbl["lib2"]=="")?$tbl["libelle"]:$tbl["lib2"]));
}

$sql="select * from ".__racinebd__."type_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_type[]=$tbl;
  $key_list_type[$tbl["type_compte_id"]]=$tbl["libelle"];
}

$sql="select * from ".__racinebd__."categorie_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_categorie[]=$tbl;
  $key_list_categorie[$tbl["categorie_compte_id"]]=$tbl["libelle"];
}

$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_agence[]=$tbl;
  $key_list_agence[$tbl["agence_compte_id"]]=$tbl["libelle"];
}

//filtre
$where="";
if($_POST["type"]!=""){
  $where.=" and type_compte_id=".$_POST["type"];
}
if($_POST["agence"]!=""){
  $where.=" and agence_compte_id=".$_POST["agence"];
}
if($_POST["categorie"]!=""){
  $where.=" and categorie_compte_id=".$_POST["categorie"];
}
if($_POST["nom"]!=""){
  $where.=" and nomvehicule like '%".$_POST["nom"]."%'";
}
/*
if($_POST["etat"]!=""){
  $where.=" and gmr.data_bool=".$_POST["etat"];
}
*/

//listing des véhicules
$sql = getsqllistvehicule()." ".$where;
//print $sql."<br>";
$link=query($sql);
$nbgo=0;
$nbstay=0;
while($tbl=fetch($link)){

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
  $debut="";
  $tbl_info=adressegps($tbl["latitude"],$tbl["longitude"]);
  if(is_array($tbl_info)){
    $debut.="<img src=\"".__racineweb__."/tpl/img/lieux/".$tbl_info["icon"]."\"> <span>".$tbl_info["libelle"]."</span>";
  }else{
    $debut.=$tbl_info;
  }
  $tbl["adresse"]=$debut;
  $tbl["agence"]=$key_list_agence[$tbl["agence_compte_id"]];
  $tabval=etatvoiturecouleur($tbl["phantom_device_id"]);
  $tbl["couleur"]=$tabval[1];
  if($tabval[0]==1){
  $nbgo++;
  $tbl["moteur"]="Moteur Allumé";
  }else{
  $nbstay++;
  $tbl["moteur"]="Moteur Eteint";
  }
  $tbl["time"]=affichedatetime($tbl["time"]); 
  //gestion des entretiens
  $sql="select * from ".__racinebd__."alarme_entretien ae inner join ".__racinebd__."entretien_compte ec on ae.entretien_compte_id=ec.entretien_compte_id where device_id=".$tbl["phantom_device_id"]." and supprimer=0";
  $linkentretien=query($sql);
  $tbl["entretien"]="";
  while($tblentretien=fetch($linkentretien)){
    $tbl["entretien"].=$tblentretien["libelle"]." ".(($tblentretien["km"]==0)?affichedateiso($tblentretien["date"]):$tblentretien["km"]."km")."<br>";
  }                                   
  //$tbl
  
  if($_POST["etat"]!=""){
    if($_POST["etat"]==$tabval[0]){
      $tbl_list_vehicule[]=$tbl;
    }
  }else{
    $tbl_list_vehicule[]=$tbl;
  }
}
$tbl_list_export=$tbl_list_vehicule;
?>