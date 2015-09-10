<?php
if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
  print '<textarea name="'.$tabelem[0].'" id="'.$tabelem[0].'" style="width400px;display:none" rows="24" cols="80">'.$myvalue.'</textarea>';
  print "<iframe src='../include/htmlview.php?css=".substr($searchstring[1],0,-1)."&elem=".$tabelem[0]."' frameborder='1' border='1' bordercolor='#000000' width='500' height='400'></iframe>";
}else{
  print '<textarea name="'.$tabelem[0].'" id="'.$tabelem[0].'" style="width:400px" rows="24" cols="80">'.htmlspecialchars($myvalue).'</textarea>';
  print '<script  type="text/javascript">
  indice=top.editor.length;
  top.editor[indice] = "'.$tabelem[0].'|'.substr($searchstring[1],0,-1).'|400|Default";
  </script>';
}
?>