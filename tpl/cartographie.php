<?
if($_SESSION["logfront"]!=1){
  header("Location: ".urlp(__defaultfather__));
  die;
}
$tbl_info=node();
if(verifdroitid($tbl_info["note1"])){
cache_require("menu2.php");
cache_require("cartographie.php");
}
?>