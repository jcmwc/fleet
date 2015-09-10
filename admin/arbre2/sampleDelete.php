<?php
require("../require/function.php");
require("../require/back_include.php");
testsession();
deleteFinalNode($_POST['branch_id']);
//echo "<script type='text/javascript'>refreshA();</script>";
log_phantom($_POST['branch_id'],"Suppression définitive du noeud");
genereFileReferencement();
echo '{';
echo '"ok" : true,';
echo '"msg" : "'.$msg.'"';
echo '}';
?>