<?
require("situation.php");
$sql="select lc.*,tlc.libelle as lib from ".__racinebd__."lieu_compte lc inner join ".__racinebd__."type_lieu_compte tlc on lc.type_lieu_compte_id=tlc.type_lieu_compte_id where compte_id=".$_SESSION["compte_id"]." and lc.supprimer=0 and affichage=1 order by lc.libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $contenttab.="tab.push(new Array('".$tbl["icon"]."','".$tbl["latitude"]."','".$tbl["longitude"]."','".$tbl["rayon"]."'));";
}        
?>