<?php

$originalkey=$key;
$key=($tablekey2=="")?$_GET["id"]:$tbl_result[$tablekey2];
$key=($key=="")?$tbl_result[$tablekey]:$key;
	      if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
        	if($indice>1){
         	print affichemedia($key,$myvalue,$table.$indice."_");
          }else{
          print affichemedia($key,$myvalue,$table);
          }
					//print "".$key.",".$myvalue.",".$table.$indice."";
        }else{
         	print '<input type="file" name="'.$tabelem[0].'"><input type="hidden" name="'.$tabelem[0].'_last" value="'.(($myvalue!='')?'1':'0').'"> '.value_print(($searchstring[1]!='')?'('.$searchstring[1]:'').(($tabelem[2]!="yes"&&$_GET["mode"]!="ajout"&&$myvalue!='')?' supprimer <input type="checkbox" name="'.$tabelem[0].'_chk" value="1">':'').'<br>';
          if($indice>1){
         	print affichemedia($key,$myvalue,$table.$indice."_");
          }else{
          print affichemedia($key,$myvalue,$table);
          }
        }
        $indice++;
$key=$originalkey;
?>