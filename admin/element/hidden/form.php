<?php

//$maxlength=(count($tabelem)>3)?'maxlength="'.$tabelem[3].'"':'';
$querystring= substr($searchstring[1],0,-1);
$myvalue=($querystring!="")?$querystring:$myvalue;
if($_GET["mode"]!="visu"&&$_GET["mode"]!="suppr"){
	print '<input type="hidden" name="'.$tabelem[0].'" value="'.$myvalue.'">';
}

?>