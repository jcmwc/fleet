<?
if(!verifdroit("AGE")){
die;
}
$msgsave="";

if($_POST["mode"]=="ajout"){
  //vérification des droit du compte
  $sql="insert into ".__racinebd__."agence_compte (libelle,principal,compte_id) values('".addquote($_POST["libelle"])."','".$_POST["principal"]."',".$_SESSION["compte_id"].")";
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="ajout";  
}
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  //vérification des droit du compte
  $sql="update ".__racinebd__."agence_compte set libelle ='".addquote($_POST["libelle"])."' , principal='".$_POST["principal"]."' where agence_compte_id=".$_POST["id"]." and compte_id=".$_SESSION["compte_id"];
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="modif";  
}
$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_agence[]=$tbl;
//  $key_list_agence[$tbl["agence_compte_id"]]=$tbl["libelle"];
}

if($_POST["id"]!=""&&$_POST["mode"]==""){
  $sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and agence_compte_id=".$_POST["id"]." order by libelle";
  $link=query($sql);  
  $tbl_modif_agence=fetch($link);
}


?>