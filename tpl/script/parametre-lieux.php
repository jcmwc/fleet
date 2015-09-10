<?
if(!verifdroit("LIEU")){
die;
}
$msgsave="";
if($_POST["mode"]=="delete"){
  //vérification des droit du compte
  $sql="update ".__racinebd__."lieu_compte set supprimer=1 where lieu_compte_id=".$_POST["id"];
  query($sql);
  //print $sql."<br>";
  $msgsave="Suppression effectuée";  
}

if($_POST["mode"]=="ajout"){
  
  if($_POST["latitude"]==0&&$_POST["longitude"]==0&&$_POST["adresse"]!=""){
    $tabcoordnate=getCoordonnees($_POST["adresse"]);
    $_POST["latitude"]=$tabcoordnate[0];
    $_POST["longitude"]=$tabcoordnate[1];
    if($_POST["latitude"]==0&&$_POST["latitude"]==0){
      $msgsave="Les coordonnées GPS non pas été trouvés<br>";
    }
  }
  //getCoordonnees
  //vérification des droit du compte
  $sql="insert into ".__racinebd__."lieu_compte (libelle,type_lieu_compte_id,agence_compte_id,latitude,longitude,icon,rayon,affichage,alarme,adresse) 
  values('".addquote($_POST["libelle"])."','".addquote($_POST["type_lieu_compte_id"])."','".addquote($_POST["agence_compte_id"])."','".addquote($_POST["latitude"])."','".addquote($_POST["longitude"])."'
  ,'".addquote($_POST["icon"])."','".addquote($_POST["rayon"])."','".addquote($_POST["affichage"])."','".addquote($_POST["alarme"])."','".addquote($_POST["adresse"])."')";
  //print $sql."<br>";
  $link=query($sql);
  $msgsave.="Sauvegarde effectuée";  
}
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  if($_POST["latitude"]==0&&$_POST["longitude"]==0&&$_POST["adresse"]!=""){
    $tabcoordnate=getCoordonnees($_POST["adresse"]);
    $_POST["latitude"]=$tabcoordnate[0];
    $_POST["longitude"]=$tabcoordnate[1];
    if($_POST["latitude"]==0&&$_POST["latitude"]==0){
      $msgsave="Les coordonnées GPS non pas été trouvés<br>";
    }
  }
  
  //vérification des droit du compte
  $sql="update ".__racinebd__."lieu_compte set libelle ='".addquote($_POST["libelle"])."',type_lieu_compte_id='".addquote($_POST["type_lieu_compte_id"])."'
  ,agence_compte_id='".addquote($_POST["agence_compte_id"])."',latitude='".addquote($_POST["latitude"])."',longitude='".addquote($_POST["longitude"])."'
  ,icon='".addquote($_POST["icon"])."',rayon='".addquote($_POST["rayon"])."',affichage='".addquote($_POST["affichage"])."',alarme='".addquote($_POST["alarme"])."',adresse='".addquote($_POST["adresse"])."'
   where lieu_compte_id=".$_POST["id"];
  //print $sql."<br>";
  $link=query($sql);
  $msgsave.="Sauvegarde effectuée";  
}
if($_POST["type_lieu_compte"]!=""){
  $where=" and lc.type_lieu_compte_id=".$_POST["type_lieu_compte"];
}

$sql="select lc.*,tlc.libelle as lib from ".__racinebd__."lieu_compte lc inner join ".__racinebd__."type_lieu_compte tlc on lc.type_lieu_compte_id=tlc.type_lieu_compte_id where compte_id=".$_SESSION["compte_id"]." and lc.supprimer=0 ".$where." order by lc.libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_type[]=$tbl;
//  $key_list_agence[$tbl["type_lieu_id"]]=$tbl["libelle"];
}

if($_POST["id"]!=""&&$_POST["mode"]==""){
  $sql="select * from ".__racinebd__."lieu_compte where lieu_compte_id=".$_POST["id"]." order by libelle";
  $link=query($sql);  
  $tbl_modif_type=fetch($link);
}

$sql="select * from ".__racinebd__."type_lieu_compte where compte_id=".$_SESSION["compte_id"]." order by libelle";
//print $sql;
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_typelieu[]=$tbl;
//  $key_list_agence[$tbl["type_lieu_compte_id"]]=$tbl["libelle"];
}


$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_agence[]=$tbl;
}
?>