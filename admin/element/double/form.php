<?php

$maxlength=(count($tabelem)>3)?'maxlength="'.$tabelem[3].'"':'';
	      	if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
            	$myvalue2=split(";",$myvalue);
   	      	print value_print($myvalue2[0])." ".value_print($myvalue2[1]);
      	   }else{
            	$myvalue2=split(";",$myvalue);
            	$tabelem2=split(";",$tabelem[0]);
         		print '<input type="text" name="'.$tabelem2[0].'" size="30" value="'.$myvalue2[0].'" class="txt_champs03"> <input type="text" name="'.$tabelem2[1].'" size="30" value="'.$myvalue2[1].'" class="txt_champs03">';
	         }

?>