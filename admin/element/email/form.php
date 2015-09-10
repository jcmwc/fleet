<?php

if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
	print value_print($myvalue);
}else{
	print '<input type="text" name="'.$tabelem[0].'" size="60" maxlength="50" value="'.$myvalue.'" class="txt_champs">';
}

?>