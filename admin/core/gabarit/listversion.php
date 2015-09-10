Choix de la version :
<select name="version_id" onchange="refreshpage('<?=$_SERVER["PHP_SELF"]?>?arbre_id=<?=$_GET["arbre_id"]?>&langue_id=<?=$_GET["langue_id"]?>&mode=list&version_id='+this.value)">
<?
$sql="select * from ".__racinebd__."version order by libelle";
$link=query($sql);
while($tbl_result=fetch($link)){?>
<option value="<?=$tbl_result["version_id"]?>" <?=($tbl_result["version_id"]==$_GET["version_id"])?"selected":""?>><?=$tbl_result["libelle"]?></option>
<?}
?>
</select>