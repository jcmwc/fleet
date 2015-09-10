<?php
if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
  if((int)$tabelem[3]==1){
    print value_print("OUI");
  }else{
    print value_print("NON");
  }
}else{
  print "<input type=\"checkbox\" name=\"".$tabelem[0]."\" value=\"".$tabelem[2]."\" ".(((int)$tabelem[3]==1)?"checked":"").">";
}
?>