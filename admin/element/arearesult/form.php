<?php
//$tabinfo=split(",",substr($searchstring[1],0,-1));

if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
	print value_print($myvalue);
 }else{
	//print '<input type="text" name="'.$tabelem[0].'" size="60" maxlength="'.$tabinfo[1].'" value="'.$tabinfo[0].'" class="txt_champs">';
	print '<textarea name="'.$tabelem[0].'" class="txt_champs04">'.substr($searchstring[1],0,-1).'</textarea>';
 }

?>