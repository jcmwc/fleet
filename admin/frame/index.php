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
require("../include/allinclude2.php");
if($_SESSION['islog']!=""&&__light__!=true){
  require("../include/entetearbre2.php");
}
?>
</head>
<body style="margin:0px; padding:0px;">
<div id="global">Loading</div>
<iframe id="framecontent" name="framecontent" bgcolor="" marginheight="0" marginwidth="0" src="../home/index.php" height="0" width="0" style="border:none;" frameBorder="0" border="0" onload="aspirecontent()"> 
</iframe>
<?
if($_SESSION['islog']!=""&&__light__!=true){
require("../include/template_ajout_arbre2.php");
}
if(__light__==true){?>
<!--Fin tableau general-->
<style>
  #contenaire_arbre{left:-320px}
  #content{margin-left:20px}
  #quickNav{left:40px}
  #img_pointer_arbre{left:325px}  
</style>
<?}?>
</BODY>
</HTML>
<?@bdd_close();?>