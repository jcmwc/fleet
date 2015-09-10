<?
if($_SESSION["logfront"]!=1){
  header("Location: ".urlp(__defaultfather__));
  die;
}
$tbl_info=node();
if(verifdroitid($tbl_info["note1"])){
cache_require("menu2.php");


//cache_require("rapport-".$_GET["template"].".php");
if($_POST["template"]==""){
  cache_require("rapport.php");
}else{
  //print "rapport-".$_POST["template"].".php";
  cache_require("rapport-".$_POST["template"].".php");
}
}
?>