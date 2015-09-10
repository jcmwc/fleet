Choix de l'etat :
<select name="etat_id" onchange="refreshpage('<?=$_SERVER["SCRIPT_NAME"]?>?arbre_id=<?=$_GET["arbre_id"]?>&langue_id=<?=$_GET["langue_id"]?>&mode=list&etat_id='+this.value)">
<?
$sql="select * from ".__racinebd__."etat order by etat_id";
$link=query($sql);
while($tbl_result=fetch($link)){?>
<option value="<?=$tbl_result["etat_id"]?>" <?=($tbl_result["etat_id"]==$_GET["etat_id"])?"selected":""?>><?=$tbl_result["libelle"]?></option>
<?}
?>
</select>