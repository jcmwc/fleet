<?
$sql="select compte_id,nom from ".__racinebd__."compte where actif=1 order by nom";
$link=query($sql);
?>
<form action="<?=$_SERVER["PHP_SELF"]?>" target="framecontent">
<table border="0" width="100%">
<tr>
  <td>Compte</td>
  <td colspan="2">
  <input type="hidden" name="mode" value="list" />
  <select name="pere">
    <option value="">Tous</option>
    <?while($tbl_result=fetch($link)){?>
    <option value="<?=$tbl_result["compte_id"]?>" <?=($_GET["pere"]==$tbl_result["compte_id"])?"selected":""?>><?=$tbl_result["nom"]?></option>
    <?}?>
  </select>
  </td>
  <td>Type de boitier</td>
  <td  colspan="2">
  <?
  $sql="select typeboitier_id,libelle from ".__racinebd__."typeboitier  order by libelle";
  $link=query($sql);
  ?>

  <select name="typeboitier_id">
    <option value="">Tous</option>
    <?while($tbl_result=fetch($link)){?>
    <option value="<?=$tbl_result["typeboitier_id"]?>" <?=($_GET["typeboitier_id"]==$tbl_result["typeboitier_id"])?"selected":""?>><?=$tbl_result["libelle"]?></option>
    <?}?>
  </select>
  </td>
</tr>
  <td>Identifiant</td>
  <td><input type="text" name="uniqueId" value="<?=$_GET["uniqueId"]?>"></td>  
  <td>Numéro d'appel</td>
  <td><input type="text" name="tel" value="<?=$_GET["tel"]?>"></td>  
  <td  colspan="2"><input type="submit" name="Rafraichir" value="Rafraichir"></td>
</tr>
</table>
</form>