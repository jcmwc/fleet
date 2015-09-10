<?php
$sql="select * from ".__racinebd__."users where users_id='".$myvalue."'";
$link=query($sql);
$tbl_result_user=fetch($link);
print $tbl_result_user["nom"]." ".$tbl_result_user["prenom"];

?>