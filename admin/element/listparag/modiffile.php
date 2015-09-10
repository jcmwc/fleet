<?
require("../../require/function.php");
require("../../require/back_include.php");
$_GET["nomobj"]="listmontant[]";
set_time_limit(3600);
$sql="select * from ".__racinebd__."newsletterline where newsletterline_id=".(($_GET["id"]=="")?$_POST["newsletterline_id"]:$_GET["id"]);
$link=query($sql);
$tbl_info=fetch($link);
if($_POST["save"]=="yes"){

  if($_FILES["ext"]["tmp_name"]!=""){
    $myext=savefile("ext",__racinebd__."newsletterline",$_POST["newsletterline_id"]);
    $myext=",ext='".getext($_FILES["ext"]["name"])."'";  
	}
	 //sauvegarde en base   
  $sql="update ".__racinebd__."newsletterline 
  set titre='".addquote($_POST["titre"])."',
  contenu='".str_replace(",",".",addquote($_POST["contenu"]))."',
  lien='".str_replace(",",".",addquote($_POST["lien"]))."'
  $myext
  where newsletterline_id=".$_POST["newsletterline_id"];
  $link=query($sql); 
  
  ?>
  <script>
  alert("Modifications prises en compte");
  if(top.listidmontantiframelist.contentWindow)
  top.listidmontantiframelist.contentWindow.location.href=top.listidmontantiframelist.contentWindow.location.href.replace('mode=','');
  else
  top.listidmontantiframelist.location.href=top.listidmontantiframelist.location.href.replace('mode=','');

  
  window.location="insertfile.php?nomobj=listontant[]&id=<?=$tbl_info["newsletter_id"]?>";
  </script>
  <?
  die;
}

?>
<html>
<head>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
<script>
function validateForm(obj){

	if(obj.titre.value==""){
		alert('Veuillez indiquer un titre');
		obj.titre.focus();
		return false;
	}
	
	return true;
}
</script>
<style>
td{font-style:arial;font-size:12px;color:black;font-weight:bold}
</style>
</head>
<body style="margin:0;padding:0;background:#bebebd">

  <form enctype="multipart/form-data" method="post" action="modiffile.php" name="monform" style="margin:0;padding:0" onsubmit="return validateForm(this)">
  <input type="hidden" name="save" value="yes" />
  <input type="hidden" name="newsletterline_id" value="<?=$_GET["id"]?>" />
  <table width="100%">
  <tr>
    <td valign="top">Titre :</td>
    <td ><input type="text" name="titre" value="<?=$tbl_info["titre"]?>" style="width:100%;height:20px"/></td>
  </tr>
  <tr>
    <td vlign="top">Contenu :</td>    
    <td><textarea name="contenu" style="width:100%;height:55px"><?=$tbl_info["contenu"]?></textarea></td>
  </tr>
  <tr>
    <td valign="top">Lien (id si interne):</td>
    <td ><input type="text" name="lien" value="<?=$tbl_info["lien"]?>" style="width:100%;height:20px"/></td>
  </tr>
  <tr>
    <td vlign="top">Image :</td>
    <td colspan="2"><input type="file" name="ext"></td>
    <td  align="right"><input type="submit" name="modifier" value="Modifier" />&nbsp;
    <a href="insertfile.php?nomobj=listval[]&id=<?=$tbl_info["devis_id"]?>">Retour a l'ajout</a></td>
  </tr>
 
  </table>
  
  </form>
</body>
</html>