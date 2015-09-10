<?
if(!verifdroit("LIEU")){
die;
}
$msgsave="";

if($_POST["mode"]=="suppr"){
  //vérification des droit du compte
  $sql="update ".__racinebd__."type_lieu_compte set supprimer=1 where type_lieu_compte_id=".$_POST["id"]." and compte_id=".$_SESSION["compte_id"];
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="Suppression effectuée";  
}
if($_POST["mode"]=="ajout"){
  //vérification des droit du compte
  $sql="insert into ".__racinebd__."type_lieu_compte (libelle,compte_id) values('".addquote($_POST["libelle"])."',".$_SESSION["compte_id"].")";
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="ajout effectué";  
}
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  //vérification des droit du compte
  $sql="update ".__racinebd__."type_lieu_compte set libelle ='".addquote($_POST["libelle"])."' where type_lieu_compte_id=".$_POST["id"]." and compte_id=".$_SESSION["compte_id"];
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="Modification effectuée";  
}
//$sql="select * from ".__racinebd__."type_lieu_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$sql="select tlc.*,count(lc.type_lieu_compte_id) as nb from ".__racinebd__."type_lieu_compte tlc left join ".__racinebd__."lieu_compte lc on tlc.type_lieu_compte_id=lc.type_lieu_compte_id and lc.supprimer=0 where tlc.supprimer=0 and compte_id=".$_SESSION["compte_id"]." group by tlc.type_lieu_compte_id order by libelle";
//print $sql;
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_typelieu[]=$tbl;
//  $key_list_agence[$tbl["type_lieu_compte_id"]]=$tbl["libelle"];
}

if($_POST["id"]!=""&&$_POST["mode"]==""){
  $sql="select * from ".__racinebd__."type_lieu_compte where compte_id=".$_SESSION["compte_id"]." and type_lieu_compte_id=".$_POST["id"]." order by libelle";
  $link=query($sql);  
  $tbl_modif_typelieu=fetch($link);
}
?>