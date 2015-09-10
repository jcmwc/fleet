<?php
require("../require/function.php");
require("../require/back_include.php");
testsession();

print renameNode($_POST['branch_id'],$_POST['old_value'],$_POST['new_value']);
if($newval!=$_POST['old_value']){
  log_phantom($_POST['branch_id'],"Modification d'etat du nom du noeud");
  genereFileReferencement();
}
?>