<?
//require(dirname(__FILE__)."/../require/auth.php");

require("../require/function.php");
require("../require/back_include.php");
//print_r($_SESSION); 
testIpDie();
if ($_SESSION['islog']=="") {?>
	<script>window.location='../home/index.php'</script>
	<?
  die;
}
require("../include/allinclude.php");
if($_SESSION['islog']!=""&&__light__!=true){
  require("../include/entetearbre2.php");
}
?>
</HEAD>
<body>
<div id="global">Loading</div>
<iframe id="framecontent" name="framecontent" bgcolor="" marginheight="0" marginwidth="0" src="../home/index.php" height="0" width="0" style="border:none;" frameBorder="0" border="0" id="detailligne" name="detailligne" onload="aspirecontent()">
Your browser does not support iframes. 
</iframe>
<?
if($_SESSION['islog']!=""&&__light__!=true){
require("../include/template_ajout_arbre.php");
}
?>
<!--Fin tableau general-->
</BODY>
</HTML>
<?@bdd_close();?>