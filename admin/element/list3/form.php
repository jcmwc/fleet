<?php

$querystring= substr($searchstring[1],0,-1);
$tabelemchild=split(",",$querystring);
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
print "<select name=\"".$tabelem[0]."\" class=\"selectstyle\">";
print "<option value=\"null\"></option>";
}
for($i=0;$i<count($tabelemchild);$i++){
  if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
    if($myvalue==$tabelemchild[$i]){
      print value_print($tabelemchild[$i]);
    }
  }else{
    print "<option value=\"".$tabelemchild[$i]."\" ".(($myvalue==$tabelemchild[$i])?"selected":"").">".$tabelemchild[$i]."</option>";
  }
}
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
print "</select>";
}

?>