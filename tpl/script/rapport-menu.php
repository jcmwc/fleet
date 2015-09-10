<?
$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_agence[]=$tbl;
}

//listing des véhicules
$sql = getsqllistvehicule();
$link=query($sql);
while($tbl=fetch($link)){
  $tbl_list_vehicule[]=$tbl;
}
?>