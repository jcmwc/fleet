<?php
$maxlength=($searchstring[1]!="")?'maxlength="'.substr($searchstring[1],0,-1).'"':'';
if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
	print value_print($myvalue);
 }else{
	print '<input type="text" name="'.$tabelem[0].'" size="60" '.$maxlength.' value="'.$myvalue.'" class="txt_champs">';
 }

?>