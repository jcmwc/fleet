<?php
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
print "<select name=\"".$tabelem[0]."\" class=\"selectstyle\">";
}
for($i=1;$i<6;$i++){
  if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
    if($myvalue==$i){
      print value_print($myvalue);
    }
  }else{
    print "<option value=\"".$i."\" ".(($myvalue==$i)?"selected":"").">".$i."</option>";
  }
}
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
print "</select>";
}

?>