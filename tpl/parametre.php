<?
if($_SESSION["logfront"]!=1){
  header("Location: ".urlp(__defaultfather__));
  die;
}
$tbl_info=node();
if(verifdroitid($tbl_info["note1"])){
cache_require("menu2.php");
if($_GET["template"]=="default"||$_GET["template"]==""){
  cache_require("parametre.php");
}else{
  //print "parametre-".$_GET["template"].".php";
  cache_require("parametre-".$_GET["template"].".php");
}
}
?>