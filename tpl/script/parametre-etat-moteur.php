<?
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
  //on verifie si il existe un enregistrement dans la table etat_moteur_compte
  $sql="select * from ".__racinebd__."etat_moteur_compte where etat_moteur_id=".$_POST["id"]." and compte_id=".$_SESSION["compte_id"];
  $link=query($sql);
  if(num_rows($link)==0){
    $sql="insert into ".__racinebd__."etat_moteur_compte(etat_moteur_id,libelle,couleur,compte_id) values(".$_POST["id"].",'".addquote($_POST["libelle"])."','".addquote($_POST["couleur"])."','".$_SESSION["compte_id"]."')";
  }else{
    $sql="update ".__racinebd__."etat_moteur_compte set libelle='".addquote($_POST["libelle"])."',couleur='".addquote($_POST["couleur"])."' where compte_id=".$_SESSION["compte_id"]." and etat_moteur_id=".$_POST["id"];    
  }
  query($sql);
  $msgsave="Sauvegarde effectuée";
}
$sql="select em.etat,em.etat_moteur_id,em.libelle,emc.libelle as lib2,couleur,defaultcouleur from ".__racinebd__."etat_moteur em left join
    ".__racinebd__."etat_moteur_compte emc on emc.etat_moteur_id=em.etat_moteur_id and compte_id=".$_SESSION["compte_id"]." order by libelle";
$link=query($sql);
while($tbl=fetch($link)){
  //$tbl_list_etat[]=array("etat_moteur_id"=>$tbl["etat"],"libelle"=>(($tbl["lib2"]=="")?$tbl["libelle"]:$tbl["lib2"]));
  $tbl_list_etat[]=$tbl;
}


if($_POST["id"]!=""){
  $sql="select em.etat,em.etat_moteur_id,em.libelle,emc.libelle as lib2,couleur,defaultcouleur 
      from ".__racinebd__."etat_moteur em left join
      ".__racinebd__."etat_moteur_compte emc on emc.etat_moteur_id=em.etat_moteur_id and compte_id=".$_SESSION["compte_id"]." where em.etat_moteur_id=".$_POST["id"]." order by libelle";
  //print $sql."<br>";
  $link=query($sql);
  $tbl_modif=fetch($link);
}
?>