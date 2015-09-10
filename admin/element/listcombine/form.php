<?php
$querystring= split(",",substr($searchstring[1],0,-1));
$subtabelem= split(",",$tabelem[0]);

$resultatselect=query($$querystring[0]);
$myvalue=$tbl_result[$subtabelem[0]];
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
  print "<select name=\"".$subtabelem[0]."\" class=\"selectstyle\" onchange=\"majelemcombine('".$subtabelem[0]."','".$subtabelem[1]."',this)\">";
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
  print "</select>";
}
print "<br>";
$resultatselect=query($$querystring[1]);
$myvalue=$tbl_result[$subtabelem[1]];
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
  print "<script>";
  print "top.tab".$subtabelem[0]."_".$subtabelem[1]."= new Array();";
  $lastmainid=0;
  $tabelem=array();
  while($tbl_resultselect = fetch($resultatselect)){
    if($myvalue==$tbl_resultselect[0]){
      $currrentval= value_print($tbl_resultselect[1]);
    }
    if($lastmainid!=$tbl_resultselect[2]){
      print "top.tab".$subtabelem[0]."_".$subtabelem[1]."[".$tbl_resultselect[2]."]=new Array();";
      $lastmainid=$tbl_resultselect[2];
    }
    print "top.tab".$subtabelem[0]."_".$subtabelem[1]."[".$tbl_resultselect[2]."][top.tab".$subtabelem[0]."_".$subtabelem[1]."[".$tbl_resultselect[2]."].length]= new Array('".addslashes($tbl_resultselect[1])."','".addslashes($tbl_resultselect[0])."');";
    $tabelem[]=$tbl_resultselect;
  }
  print "</script>";
  print "<select name=\"".$subtabelem[1]."\" class=\"selectstyle\">";
  print "<option value=\"null\"></option>";
  if($_GET["mode"]=="modif"){
  for($i=0;$i<count($tabelem);$i++){
    print "<option value=\"".$tabelem[$i][0]."\" ".(($myvalue==$tabelem[$i][0])?"selected":"").">".$tabelem[$i][1]."</option>";
  }
  }
}
if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
  value_print($currrentval);
}
if(!($_GET["mode"]=="visu"||$_GET["mode"]=="suppr")){
  print "</select>";
}
?>