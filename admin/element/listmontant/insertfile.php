<?
require("../../require/function.php");
require("../../require/back_include.php");
set_time_limit(3600);
if($_POST["libelle"]!=""){
  $sql="select max(ordre) as maxordre from ".__racinebd__."devisline where supprimer=0 and devis_id=".$_GET["id"];
  $link=query($sql);
  $tbl=fetch($link);
  $sql="insert into ".__racinebd__."devisline (devis_id,libelle,montant,ordre) 
  value('".addquote($_GET["id"])."','".addquote($_POST["libelle"])."','".str_replace(",",".",addquote($_POST["montant"]))."','".($tbl["maxordre"]+1)."')";
  $link=query($sql); 
  $mmontant_id=insert_id();

  ?>
  <script>
  //rafraichissement de la liste
  //alert(top.listidmontantiframelist.location)
  if(top.listidmontantiframelist.contentWindow)
  top.listidmontantiframelist.contentWindow.location.reload(true);
  else
  top.listidmontantiframelist.location.reload(true);
  </script>
  <?
}
?>
<html>
<head>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
<script>
function validateForm(obj){
	if(obj.libelle.value==""){
		alert('Veuillez indiquer un libelle');
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

  <form method="post" action="insertfile.php?nomobj=<?=$_GET["nomobj"]?>&id=<?=$_GET["id"]?>" name="monform" style="margin:0;padding:0" onsubmit="return validateForm(this)">
  <table width="100%">
  <?
  $sql="select sum(montant) as total from ".__racinebd__."devisline where supprimer=0 and devis_id=".$_GET["id"];
  //print $sql;
  $link=query($sql);
  $tbl=fetch($link);
  ?>
  <tr>
    <td valign="top">Total :</td>
    <td colspan="2" style="font-size:20px"><?=$tbl["total"]?> €</td>
  </tr>
  <tr>
    <td valign="top">Libellé :</td>
    <td colspan="2"><textarea name="libelle" style="width:100%;height:55px"></textarea></td>
  </tr>
  <tr>
    <td vlign="top">Montant :</td>
    <td ><input type="text" name="montant" value="" style="width:100%;height:20px"/></td>
    <td align="right"><input type="submit" name="valider" value="<?=$trad["valider"]?>" /></td>
  </tr>
  </table>
  </form>

</body>
</html>