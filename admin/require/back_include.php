<?
require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/trad/".(($_SESSION["langue"]!="")?$_SESSION["langue"]:__langueadmin__).".php");
require($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/confmenu.php");
require($_SERVER["DOCUMENT_ROOT"].__racineadminmenucore__."/confmenu.php");
require("browser.php");
?>