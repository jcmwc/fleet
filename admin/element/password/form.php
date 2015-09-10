<?php

$maxlength=(count($tabelem)>3)?'maxlength="'.$tabelem[3].'"':'';
if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
	print value_print("******");
}else{
	print '<input type="password" name="'.$tabelem[0].'" size="60" '.$maxlength.' value="'.$myvalue.'" class="txt_champs">';
}

?>