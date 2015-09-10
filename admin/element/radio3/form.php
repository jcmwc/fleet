<?php
$querystring= split(";",substr($searchstring[1],0,-1));
         if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
         	print $querystring[$myvalue];
         }else{
         for($I=0;$I<count($querystring);$I++)
	         //print $querystring[$I]."&nbsp;<input type=\"radio\" name=\"".$tabelem[0]."\" value=\"$I\" ".(((int)$myvalue==$I)?"checked":"")." ".disabledRadio($_GET["selection"],$I).">&nbsp;";
           print $querystring[$I]."&nbsp;<input type=\"radio\" name=\"".$tabelem[0]."\" value=\"".$querystring[$I]."\" ".(($myvalue==$querystring[$I]||($myvalue==""&&$I==0))?"checked":"")." >&nbsp;";
         }
?>