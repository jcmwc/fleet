<?php

if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
	print value_print($myvalue);
}else{
	print '<textarea name="'.$tabelem[0].'" class="txt_champs04">'.$myvalue.'</textarea>';
}

?>