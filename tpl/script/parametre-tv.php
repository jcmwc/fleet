<?
if(!verifdroit("VEH")){
die;
}
$msgsave="";
if($_POST["mode"]=="delete"){
  //vérification des droit du compte
  $sql="update ".__racinebd__."type_compte set supprimer=1 where type_compte_id=".$_POST["id"]." and compte_id=".$_SESSION["compte_id"];
  query($sql);
  //print $sql."<br>";
  $msgsave="Suppression effectuée";  
}

if($_POST["mode"]=="ajout"){
  //vérification des droit du compte
  $sql="insert into ".__racinebd__."type_compte (libelle,consommation,vitesseattente,icon,compte_id) values('".addquote($_POST["libelle"])."','".addquote($_POST["consommation"])."','".addquote($_POST["vitesseattente"])."','".addquote($_POST["icon"])."',".$_SESSION["compte_id"].")";
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="Sauvegarde effectuée";  
}
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  //vérification des droit du compte
  $sql="update ".__racinebd__."type_compte set libelle ='".addquote($_POST["libelle"])."',consommation='".addquote($_POST["consommation"])."',vitesseattente='".addquote($_POST["vitesseattente"])."',icon='".addquote($_POST["icon"])."' where type_compte_id=".$_POST["id"]." and compte_id=".$_SESSION["compte_id"];
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="Sauvegarde effectuée";  
}
$sql="select * from ".__racinebd__."type_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_type[]=$tbl;
//  $key_list_agence[$tbl["type_compte_id"]]=$tbl["libelle"];
}

if($_POST["id"]!=""&&$_POST["mode"]==""){
  $sql="select * from ".__racinebd__."type_compte where compte_id=".$_SESSION["compte_id"]." and type_compte_id=".$_POST["id"]." order by libelle";
  $link=query($sql);  
  $tbl_modif_type=fetch($link);
}
?>