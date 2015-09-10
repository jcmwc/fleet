<?
$msgsave="";
if($_POST["mode"]=="save"){
  $sql="update ".__racinebd__."preference_compte set delaimail='".$_POST["delaimail"]."',dureemintraj='".$_POST["dureemintraj"]."',dureeminattente='".$_POST["dureeminattente"]."' where compte_id='".$_SESSION["compte_id"]."'";
  query($sql);
  $msgsave="ok";
}
$sql="select * from ".__racinebd__."preference_compte where compte_id='".$_SESSION["compte_id"]."'";
$link=query($sql);
$tbl_preference=fetch($link);

?>