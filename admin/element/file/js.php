<?
//print "alert('".substr($searchstring[1],0,-1)."');";
$stringjs="";
if(trim(substr($searchstring[1],0,-1))!=""){
$listext=split(",",substr($searchstring[1],0,-1));
//print_r($listext);
for($i=0;$i<count($listext);$i++){
  $stringjs.="testext(obj.".$tabelem[0].".value,'".$listext[$i]."')||";
}
?>
//if(!(<?=substr($stringjs,0,-2)?>)&&obj.<?=$tabelem[0]?>_last.value==0){
//alert((!(<?=substr($stringjs,0,-2)?>)&&obj.<?=$tabelem[0]?>.value!=""&&obj.<?=$tabelem[0]?>_last.value==1))
//alert(<?=substr($stringjs,0,-2)?>)
if((!(<?=substr($stringjs,0,-2)?>)&&obj.<?=$tabelem[0]?>.value!=""&&obj.<?=$tabelem[0]?>_last.value==1)||(!(<?=substr($stringjs,0,-2)?>)&&obj.<?=$tabelem[0]?>_last.value==0)){
  alert("<?=$trad["Le"]?> <?=$key?> <?=$trad["n'est pas au bon format"]?> <?=($searchstring[1]!="")?"(".$searchstring[1]:""?>");
  obj.<?=$tabelem[0]?>.focus();
  return false;
}
<?}else{?>
if(obj.<?=$tabelem[0]?>.value==""&&obj.<?=$tabelem[0]?>_last.value==0){
  alert("<?=$trad["Le"]?> <?=$key?> <?=$trad["est obligatoire"]?>");
  obj.<?=$tabelem[0]?>.focus();
  return false;
}
<?}?>