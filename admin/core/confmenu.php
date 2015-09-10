<?
if(testGenRules("USR")){
  $tabmenu2[]=array($trad["Utilisateur"],__racineadminmenucore__."/utilisateur/index.php");
  $tabmenu2[]=array($trad["Groupe"],__racineadminmenucore__."/utilisateur/groupe.php");
}
if(testGenRules("GAB")){
  $tabmenu2[]=array($trad["Gabarit"],__racineadminmenucore__."/gabarit/index.php");
}
if(testGenRules("TRAD")){
  $tabmenu2[]=array($trad["Traduction"],__racineadminmenucore__."/langue/index.php");
}
if(testGenRules("LAN")){
  $tabmenu2[]=array($trad["Langue"],__racineadminmenucore__."/langue/langue.php");
}
if(testGenRules("EMPT")){
  $tabmenu2[]=array($trad["Suppression des logs"],__racineadminmenucore__."/log/index.php");
}
?>