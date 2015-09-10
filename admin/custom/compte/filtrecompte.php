<?
$sql="select commercial_id,concat(nom,' ',prenom) as name from ".__racinebd__."commercial where actif=1 order by nom,prenom";
$link=query($sql);
?>
<form action="<?=$_SERVER["PHP_SELF"]?>" target="framecontent">
<table border="0" width="100%">
<tr>
  <td>Commercial</td>
  <td>
  <input type="hidden" name="mode" value="list" />
  <select name="pere" >
    <option value="">Tous</option>
    <?while($tbl_result=fetch($link)){?>
    <option value="<?=$tbl_result["commercial_id"]?>" <?=($_GET["pere"]==$tbl_result["commercial_id"])?"selected":""?>><?=$tbl_result["name"]?></option>
    <?}?>
  </select>
  </td>
</tr>
</table>
</form>