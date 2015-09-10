<?
require("../../require/function.php");
testGenRulesDie("EMPT");
set_time_limit(3600);
$sql="delete from ".__racinebd__."log where DATEDIFF(now(),date_evt)> 360";
query($sql);

//suppression des vieux noeud
$sql="select * from ".__racinebd__."arbre where supprimer=2";
//$sql="select * from arbre where arbre_id>137";

$link=query($sql);
while($tbl_result=fetch($link)){
  finaldelete($tbl_result["arbre_id"]);
}

require("../../include/template_haut.php");?>
<center><?=$trad["Suppression définitive"]?> OK</center>
<?require("../../include/template_bas.php");?>