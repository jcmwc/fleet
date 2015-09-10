<?
/*
if(testGenRules("TAG")){
  $tabmenu[]=array("Tags",array("Primaire"=>__racineadminmenu__."/tag/tag1.php","Secondaire"=>__racineadminmenu__."/tag/tag2.php"));
}
*/
if(testGenRules("USR")){
  //$tabmenu[]=array("Configuration",array("Commerciaux"=>__racineadminmenu__."/compte/commercial.php","Type de boitier"=>__racineadminmenu__."/compte/boitier.php"));
  $tabmenu[]=array("Configuration",array("Commerciaux"=>__racineadminmenu__."/compte/commercial.php"));
  $tabmenu[]=array("Compte",__racineadminmenu__."/compte/index.php");
  //$tabmenu[]=array("Boitiers",__racineadminmenu__."/compte/device.php");
  //Voir plus tard
  $tabmenu[]=array("Nouveautés",__racineadminmenu__."/compte/news.php");
  $tabmenu[]=array("Stats",__racineadminmenu__."/compte/stat.php");
  /*
  $tabmenu[]=array("Stats",__racineadminmenu__."/compte/stats.php");
  $tabmenu[]=array("Imports",array("Véhicules"=>__racineadminmenu__."/compte/importvehicule.php","Dallas"=>__racineadminmenu__."/compte/importdallas.php"));
  */
}
?>