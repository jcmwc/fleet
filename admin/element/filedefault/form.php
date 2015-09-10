<?php
$listext=split(",",substr($searchstring[1],0,-1));
$fichier=$listext[0];
if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){        	
  print affichemediaimg($fichier.".".$myvalue);
}else{
 	print '<input type="file" name="'.$tabelem[0].'"><input type="hidden" name="'.$tabelem[0].'_last" value="'.(($myvalue!='')?'1':'0').'"> '.value_print(($searchstring[1]!='')?'(jpg,png)':'').(($tabelem[2]!="yes"&&$_GET["mode"]!="ajout"&&$myvalue!='')?' supprimer <input type="checkbox" name="'.$tabelem[0].'_chk" value="1">':'').'<br>';
  print affichemediaimg($fichier.".".$myvalue);          
}
?>