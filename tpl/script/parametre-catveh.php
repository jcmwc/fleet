<?
if(!verifdroit("VEH")){
die;
}
$msgsave="";


if($_POST["mode"]=="suppr"){
  //vérification des droit du compte
  $sql="update ".__racinebd__."categorie_compte set supprimer=1 where categorie_compte_id=".$_POST["id"]." and compte_id=".$_SESSION["compte_id"];
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="Suppression effectuée";  
}
if($_POST["mode"]=="ajout"){
  //vérification des droit du compte
  $sql="insert into ".__racinebd__."categorie_compte (libelle,compte_id) values('".addquote($_POST["libelle"])."',".$_SESSION["compte_id"].")";
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="ajout";  
}
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  //vérification des droit du compte
  $sql="update ".__racinebd__."categorie_compte set libelle ='".addquote($_POST["libelle"])."'  where categorie_compte_id=".$_POST["id"]." and compte_id=".$_SESSION["compte_id"];
  //print $sql."<br>";
  $link=query($sql);
  $msgsave="modif";  
}
$sql="select * from ".__racinebd__."categorie_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
//$sql="select tlc.*,count(lc.device_id) as nb from ".__racinebd__."categorie_compte tlc left join ".__racinebd__."device lc on tlc.categorie_compte_id=lc.categorie_id and lc.supprimer=0 where tlc.supprimer=0 and lc.compte_id=".$_SESSION["compte_id"]." group by tlc.categorie_compte_id order by libelle";

$link=query($sql);

while($tbl=fetch($link)){
  $sql="select * from ".__racinebd__."categorie_compte_device ccd inner join ".__racinebd__."device d on d.device_id=ccd.device_id and supprimer=0 and categorie_compte_id=".$tbl["categorie_compte_id"];
  $link2=query($sql);
  $tbl["nb"]=num_rows($link2);
  $tbl_list_categorie[]=$tbl;
//  $key_list_agence[$tbl["categorie_compte_id"]]=$tbl["libelle"];
}

if($_POST["id"]!=""&&$_POST["mode"]==""){
  $sql="select * from ".__racinebd__."categorie_compte where compte_id=".$_SESSION["compte_id"]." and categorie_compte_id=".$_POST["id"]." order by libelle";
  $link=query($sql);  
  $tbl_modif_categorie=fetch($link);
}


?>