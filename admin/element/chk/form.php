<?php

if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
         	if((int)$myvalue==1){
            	print value_print("OUI");
            }else{
	            print value_print("NON");
            }
         }else{
         print "<input type=\"checkbox\" name=\"".$tabelem[0]."\" value=\"1\" ".(((int)$myvalue==1)?"checked":"").">";
         }
?>