<?php
require("../require/function.php");
require("../require/back_include.php");
testsession();
$okDrop = false;
$msg = 'Erreur dans POST';
// On vérifie qu'il y a bien quelque chose qui vient
// de la page en POST
// Les variables disponibles sont :
// - drag = JSON de la branche qui a bougé
// - drop = JSON de la branche sur laquelle on a déposé le drag
// - drag_id = id de la branche qui a bougé
// - drop_id = id de la branche sur laquelle on a déposé le drag_id
// - treedrag_id = id de l'arbre d'où est tiré la branche qui a bougé
// - treedrop_id = id de l'arbre qui accueille la branche qui a bougé 
// - sibling = 0 si on le drop comme fils, 1 s'il est comme frère  exite plus
// - copydrag = 1 si copy
// - alias = 1 si alias
// - hitMode pour savoir s on déplace avant ou apres
/*
$_POST['drag_id']="63";
$_POST['drop_id']="1081";
$_POST['hitMode']="first";
*/
$dragID = $_POST['drag_id'];
$dropID = $_POST['drop_id'];
$copydrag = $_POST['copydrag'];
$alias = $_POST['alias'];
$recursive = $_POST['recursive'];
$hitMode = $_POST['hitMode'];
$replace = $_POST['replace'];

/*
$dragID = $_GET['drag_id'];
$dropID = $_GET['drop_id'];
$sibling = $_GET['sibling'];
$copydrag = $_GET['copydrag'];
$alias = $_GET['alias'];
*/
//print $dropID;
//test des droits
$droit=true;
if($dropID=="_2"){
  //si c'est une suppression
  $droit=testdroitarbre($dragID,"DEL");
}else{
  //on verifie si on a le droit d'utiliser le contenu de départ
  $droitdepart=testdroitarbre($dragID,"ADD")||testdroitarbre($dragID,"UPD");
  if($hitMode=="after"||$hitMode=="before"){
      $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dragID;
      $link=query($sql);
      $ligne=fetch($link);
      $pere=$ligne["pere"];
      $droitarrive=testdroitarbre($pere,"ADD")||testdroitarbre($pere,"UPD");
  }else {
    if($dropID=="root1"){
      $droitarrive=testGenRules("RULR");
    }else{
      $droitarrive=testdroitarbre($dropID,"ADD");
    }
  }
  $droit=$droit&&($droitdepart&&$droitarrive);
}
//print $droit;
//die;
if(!$droit){
  echo '{';
  echo '"ok" : false,';
  echo '"msg" : "'.$trad["Vous n\'avez pas les droits pour effectuer cette action"].'"';
  echo '}';
  die;
}

//on verifie que l'objet en cour de déplacement n'est pas supprimer
$sql="select supprimer from ".__racinebd__."arbre where arbre_id=".$dragID;
$link=query($sql);
$ligne=fetch($link);

if(isset($dropID)&&$ligne["supprimer"]==0){
  if($dropID == "_2"){
    $okDrop=deleteNode($dragID);
    $msg = 'Tout est ok';
    log_phantom($dragID,"Suppression du noeud");
  }else if ($alias == 1){
    $result=createAlias($dragID,$dropID);
    $okDrop=$result[0];
    $msg = $result[1];
    log_phantom($dragID,"Création d'un alias");
  } else if($hitMode=="before") {
    //print "ici jc";                          
    $okDrop=moveBeforeNode($dragID,$dropID);
    $msg = 'Tout est ok';
    log_phantom($dragID,"Déplacement du noeud");
  } else if($hitMode=="first") {
    //print "ici jc";                          
    $okDrop=moveFirstNode($dragID);
    $msg = 'Tout est ok';
    log_phantom($dragID,"Déplacement du noeud");
  } else if($hitMode=="last") {
    //print "ici jc";                          
    $okDrop=moveLastNode($dragID);
    $msg = 'Tout est ok';
    log_phantom($dragID,"Déplacement du noeud");
  }else if($hitMode=="after") {
    $okDrop=moveBeforeNode($dropID,$dragID);
    $msg = 'Tout est ok';
    log_phantom($dragID,"Déplacement du noeud");
  }else if($copydrag == 1) {
    if($recursive==1){
      recursiveCopy($dragID,$dropID);
      $okDrop=true;
      $msg = 'Tout est ok';
    }else {
      //copy du noeud
      $result = copyNode($dragID,$dropID);
      $okDrop=$result[0];
      $msg = $result[1];
      log_phantom($result[1],"Copie du noeud".$dragID);
    }
  }else if($replace == 1) {  
      replaceNode($dropID,$dragID);
      $okDrop=true;
      $msg = 'Tout est ok'; 
  }else{
    //déplacement standard
    if($hitMode=="over"){
      $okDrop = moveNode($dragID,$dropID);
    }else{
      $okDrop = moveCrossNode($dragID,$dropID);
    }
    $msg = 'Tout est ok';
    log_phantom($dragID,"Déplacement du noeud");
  }
}else{
  $okDrop = false;
  $msg = $trad["Vous devez restaurer le noeud afin de la déplacer"];
}

// Ici, on renvoie un objet JSON (carrément!). Il faut
// savoir que la réponse peut être absolument n'importe
// quoi. Il faut juste la traiter comme il faut en
// Javascript après...
if($includefunc==''){
  if ($okDrop) {
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
  genereFileReferencement();
}
?>