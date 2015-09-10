<?php
require("../require/function.php");
require("../require/back_include.php");
testsession();
$droit=chgEtat($_POST['branch_id']);
if($droit){
  $ok=true;
  genereFileReferencement();
  log_phantom($_POST['branch_id'],"Modification d'etat du noeud");
  $msg="";
}else{
  $ok=false;
  $msg=$trad["Vous n'avez pas les droits pour effectuer cette action"];
}
if ($ok) {
    echo '{';
    echo '"ok" : true,';
    echo '"msg" : "'.$msg.'"';
    echo '}';
  } else {
    echo '{';
    echo '"ok" : false,';
    echo '"msg" : "'.$msg.'"';
    echo '}';
  }
?>