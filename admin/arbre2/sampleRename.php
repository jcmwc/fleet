<?php
require("../require/function.php");
require("../require/back_include.php");
testsession();
$_GET["la_langue"]=$_POST["langue_id"];
$newname= renameNode($_POST['branch_id'],$_POST['old_value'],$_POST["name"]);
if($newval!=$_POST['old_value']){
  log_phantom($_POST['branch_id'],"Modification d'etat du nom du noeud");
  genereFileReferencement();
}

echo '{';
echo '"ok" : true,';
echo '"msg" : "'.$newname.'"';
echo '}';
?>