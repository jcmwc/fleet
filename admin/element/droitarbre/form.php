<?php
$name= $tabelem[0];
if($_GET["mode"]!="ajout"){
  $sql="select * from ".__racinebd__."arbre_niveau_news where arbre_id=".$_GET["arbre_id"];
  //print $sql;
  $link=query($sql);
  $tbl_result_groupe=fetch($link);
  $idniveau_news=$tbl_result_groupe["idniveau_news"];
}
//print $idniveau_news;
$sql="select * from ref_niveau_news where idniveau_news>1 order by idniveau_news";
$link=query($sql);

while($tbl_result_groupe=fetch($link)){
  if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
    if($tbl_result["groupe_id"]==$groupe_id){
      print $tbl_result_groupe["nom_niveau_news"];
    }
  }else{
    print $tbl_result_groupe["nom_niveau_news"]."&nbsp;<input type=\"radio\" name=\"".$name."\" value=\"".$tbl_result_groupe["idniveau_news"]."\" ".(($idniveau_news==$tbl_result_groupe["idniveau_news"]||($groupe_id==""&&$tbl_result_groupe["idniveau_news"]==1))?"checked":"")." >&nbsp;";
  }    
}
?>