<?php
$tabval=split(',',substr($searchstring[1],0,-1));
//print value_print($myvalue);
$total=0;
for($i=0;$i<count($tabval);$i++){
  $total+=$tbl_result[$tabval[$i]];
}
for($i=0;$i<count($tabval);$i++){
  if($total!=0)
    print "(".$tbl_result[$tabval[$i]].") ".(round($tbl_result[$tabval[$i]]*100/$total))."%<br>";
}
?>