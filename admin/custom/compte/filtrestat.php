<form action="<?=$_SERVER["PHP_SELF"]?>?mode=list" target="framecontent" method="post">
<?
$sql="select * from ".__racinebd__."compte where actif=1 and supprimer=0";
$link=query($sql);
?>
<select name="compte_id">
  <option value="0">Tous</option>
  <?while($tbl=fetch($link)){?>
  <option value="<?=$tbl["compte_id"]?>" <?=($_POST["compte_id"]==$tbl["compte_id"])?"selected":""?>><?=$tbl["nom"]?></option>
  <?}?>
</select><br>
<table border="0" width="100%">
<tr>
  <td>
  Date de début (dd-jj-yyyy) : <input type="text" name="date_debut" value="<?=$_POST["date_debut"]?>" />
  </td>
  <td>
  Date de fin (dd-jj-yyyy) : <input type="text" name="date_fin" value="<?=$_POST["date_fin"]?>" />
  </td>
  <td valign="bottom"><br><input type="submit" name="Filtrer" value="Filter" /></td>
</tr> 
</table>
</form>