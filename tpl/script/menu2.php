<?
if($_SESSION["logfront"]!=1){
  header("Location: ".urlp(__defaultfather__));
}
$tbl_list=nodelist(__compteid__);
if($_SESSION["newsdeja"]==""){
  $sql="select * from  ".__racinebd__."news where date_creation='".date("Y-m-d")."'";
  $link=query($sql);
  if(num_rows($link)>0){
    $tbl=fetch($link);
    $news='<div class="news">'.$tbl["texte"].'</div>';
  }
  $_SESSION["newsdeja"]=1;
}
?>