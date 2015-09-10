<?php

$querystring= substr($searchstring[1],0,-1);
$resultatselect=query($$querystring);
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
print "<select name=\"".$tabelem[0]."\" class=\"selectstyle\">";
print "<option value=\"null\"></option>";
}
while($tbl_resultselect = fetch($resultatselect)){
if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
if($myvalue==$tbl_resultselect[0]){
print value_print($tbl_resultselect[1]);
}
}else{
print "<option value=\"".$tbl_resultselect[0]."\" ".(($myvalue==$tbl_resultselect[0])?"selected":"").">".$tbl_resultselect[1]."</option>";
}
}
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
print "</select> <a href=\"#\" onclick=\"if(document.form1.".$tabelem[0].".selectedIndex!=0){window.open('".__racineadmin__."/element/listbymusic/popup.php?name='+document.form1.".$tabelem[0].".options[document.form1.".$tabelem[0].".selectedIndex].text)}\">Voir les chansons de cet artiste</a>";
}
?>
