<?
require("../../require/function.php");

$table=__racinebd__."content";
$_SESSION["users_id"]=($_SESSION["users_id"]=="")?-1:$_SESSION["users_id"];

if($_FILES["Filedata"]["tmp_name"]!=""){
  $myext="'".getext($_FILES["Filedata"]["name"])."'";  
}else{
  if($_POST["Filedata"]!=""){
    $myext="'".$_POST["Filedata"]."'";
	}else{
    $myext="null";
  }
}

//recherche du nouvel ordre
$sql="select max(ordre) as maxordre from ".__racinebd__."arbre where supprimer=0 and pere ".(($_GET["pere"]==""||$_GET["pere"]=="0")?"is null":"=".$_GET["pere"]);
$link=query($sql);
$tbl_result=fetch($link);
$maxordre=$tbl_result["maxordre"]+1;
//enregistrement dans la table arbre
$sql="insert into ".__racinebd__."arbre (gabarit_id,pere,users_id_crea,ordre,secure,etat_id,root) values (".$_GET["gabarit_id"].",".(($_GET["pere"]==""||$_GET["pere"]=="0")?"null":$_GET["pere"]).",".$_SESSION["users_id"].",$maxordre,'".$_POST["secure"]."',1,".getroot($_GET["pere"]).")";
query($sql);
$arbre_id=insert_id();
//affectation des droits identique a ceux du pere
$sql="select * from ".__racinebd__."groupe_arbre where arbre_id='".$_GET["pere"]."'";
$link=query($sql);
if(num_rows($link)>0){
	while($tbl_result=fetch($link)){
    $sql="insert into ".__racinebd__."groupe_arbre (arbre_id,droits_id,groupe_id) values (".$arbre_id.",".$tbl_result["droits_id"].",".$tbl_result["groupe_id"].")";
    query($sql);
	}
}else{
  //si le pere ne possede aucun droit on lui met tout les droits
  /*
  $sql="select * from groupe";
  $link=query($sql);
  while($tbl_result=fetch($link)){
    $sql="select * from droits where droitarbre=1";
    $link_droits=query($sql);
    while($tbl_result_droits=fetch($link_droits)){
      $sql="insert into groupe_arbre (arbre_id,droits_id,groupe_id) values (".$arbre_id.",".$tbl_result_droits["droits_id"].",".$tbl_result["groupe_id"].")";
      query($sql);
    }
  } 
  */          
}

$sql="select * from ".__racinebd__."langue where active=1";
$link=query($sql);
while($tbl_result=fetch($link)){
 $name=($_GET["pere"]==""||$_GET["pere"]=="0")?$_POST["titre1"]:makename($_POST["titre1"]);
 if($tbl_result["langue_id"]==$_GET["langue_id"]){
    $sql="insert into ".__racinebd__."contenu (arbre_id,langue_id,nom,translate) values (".$arbre_id.",".$tbl_result["langue_id"].",'".$name."',1)";
    query($sql);
    $contenu_id=insert_id();
  }else{
    $sql="insert into ".__racinebd__."contenu (arbre_id,langue_id,nom,translate) values (".$arbre_id.",".$tbl_result["langue_id"].",'".$name."',0)";
    query($sql);
    
  }				  
}

$szQuery="insert into ".__racinebd__."content (titre1,ext,version_id,contenu_id)
values ('".addquote($_POST["titre1"])."',$myext,".$_POST["version_id"].",".$contenu_id.")";
$link=query($szQuery);
$id=insert_id();

//copy du master content dans les autres langues
copyContent($id,$arbre_id,$_GET["langue_id"]);
if($_FILES["Filedata"]["tmp_name"]!=""){
    savefile("Filedata",$table,$id);    
}
log_phantom($arbre_id,"Création du noeud");
log_phantom($arbre_id,"Modification du noeud (".$libversion.")");
//on deverouille
$sql="update ".__racinebd__."arbre set users_id_verrou=null,secure='".$_POST["secure"]."' where arbre_id=".$arbre_id;
query($sql);
$szQuery="";
?>