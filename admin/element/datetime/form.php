<?php

if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
         	print value_print(affichedatetime($myvalue));
         }else{
         	$myvalue=($myvalue=="")?date("Y")."/".date("m")."/".date("d")." ".date("H").":".date("i"):$myvalue;
            $myvalue=($tabelem[2]!="yes"&&$_GET["mode"]=="ajout")?"":$myvalue;
            print '<input type="text" id="'.$tabelem[0].'" name="'.$tabelem[0].'" size="16" maxlength="16" value="'.affichedatetime($myvalue).'"><img src="../images/datepopup.gif" id="trigger'.$tabelem[0].'" style="cursor:pointer; cursor:hand;">';
            print '<script type="text/javascript">
              /*
              Calendar.setup(
                {
                  inputField  : "'.$tabelem[0].'",         // ID of the input field
                  ifFormat    : "%d/%m/%Y %H:%M",    // the date format
									showsTime      :    true,
                  timeFormat     :    "24",
                  button      : "trigger'.$tabelem[0].'"       // ID of the button
                }
              );*/
              top.calendar[top.calendar.length]={
                  inputField  : "'.$tabelem[0].'",         // ID of the input field
                  ifFormat    : "%d/%m/%Y %H:%M",    // the date format
                  showsTime      :    true,
                  timeFormat     :    "24",
                  button      : "trigger'.$tabelem[0].'"       // ID of the button
                };
            </script>';
         }

?>