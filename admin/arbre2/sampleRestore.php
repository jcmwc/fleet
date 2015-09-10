<?php
require("../require/function.php");
require("../require/back_include.php");
testsession();
$node= retoreNode($_POST['branch_id']);

log_phantom($_POST['branch_id'],"Restauration du noeud");
genereFileReferencement();
echo '{';
echo '"ok" : true,';
echo '"msg" : "'.$node.'"';
echo '}';
?>

