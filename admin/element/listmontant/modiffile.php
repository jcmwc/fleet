<?
require("../../require/function.php");
require("../../require/back_include.php");
$_GET["nomobj"]="listmontant[]";
set_time_limit(3600);
$sql="select * from ".__racinebd__."devisline where devisline_id=".(($_GET["id"]=="")?$_POST["devisline_id"]:$_GET["id"]);
$link=query($sql);
$tbl_info=fetch($link);
if($_POST["save"]=="yes"){
	 //sauvegarde en base
  $sql="update ".__racinebd__."devisline 
  set libelle='".addquote($_POST["libelle"])."',
  montant='".str_replace(",",".",addquote($_POST["montant"]))."'
  where devisline_id=".$_POST["devisline_id"];
  $link=query($sql); 
  
  ?>
  <script>
  alert("Modifications prises en compte");
  if(top.listidmontantiframelist.contentWindow)
  top.listidmontantiframelist.contentWindow.location.reload(true);
  else
  top.listidmontantiframelist.location.reload(true);
  
  window.location="insertfile.php?nomobj=listontant[]&id=<?=$tbl_info["devis_id"]?>";
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

	if(obj.libelle.value==""){
		alert('Veuillez indiquer un libelle');
		obj.libelle.focus();
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
  <input type="hidden" name="devisline_id" value="<?=$_GET["id"]?>" />
  <table width="100%">
  <tr>
    <td valign="top">Libellé :</td>
    <td colspan="2"><textarea name="libelle" style="width:100%;height:80px"><?=$tbl_info["libelle"]?></textarea></td>
  </tr>
  <tr>
    <td vlign="top">Montant :</td>
    <td ><input type="text" name="montant" value="<?=$tbl_info["montant"]?>" style="width:100%;height:20px"/></td>
    <td align="right"><input type="submit" name="modifier" value="Modifier" />&nbsp;
    <a href="insertfile.php?nomobj=listval[]&id=<?=$tbl_info["devis_id"]?>">Retour a l'ajout</a></td>
  </tr>
  </table>
  
  </form>
</body>
</html>