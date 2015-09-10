<?
//date d'hier
$datehier=date("d/m/Y",mktime(0,0,0,date("n"),date("j")-1,date("Y")));
//print $datehier; 
//require("rapport-kilometrique.php");

$sql="select * from ".__racinebd__."type_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_type[]=$tbl;
  $key_list_type[$tbl["type_compte_id"]]=$tbl["libelle"];
}

if($_POST["agence"]!=""){
  $where2=" and agence_compte_id=".$_POST["agence"];
}
$sql=getsqllistvehicule().$where2;
$link_km=query($sql);
while($tbl_km=fetch($link_km)){
  $sql="select * from ".__racinebd__."categorie_compte_device ccd
          inner join ".__racinebd__."categorie_compte cc on ccd.categorie_compte_id=cc.categorie_compte_id where device_id=".$tbl_km["phantom_device_id"];
  //print $sql;
  $link2=query($sql);
  $tbl_list_cat=array();
  while($tbl2=fetch($link2)){
    $tbl_list_cat[]=$tbl2["libelle"];
  }
  $tbl_km["listcat"]=implode(", ",$tbl_list_cat);
  $tbl_km["theorique"]=$tbl_km["kminit"]+$tbl_km["kmactuel"]+$tbl_km["correctifkm"];
  $tbl_list_vehicule[]=$tbl_km;  
}
$tbl_list_export=$tbl_list_vehicule;
?>