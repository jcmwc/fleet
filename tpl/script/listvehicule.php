<?
require("../../admin/require/function.php");
require("../../conf_front.php");
//print_r($_GET);
/*
$sql = "select *,pd.device_id as phantom_device_id from users t 
                  inner join ".__racinebd__."compte c on c.application_id=t.original_application_id
                  inner join device d on d.owner_id=t.user_id
                  inner join ".__racinebd__."device pd on pd.owner_id=t.user_id
                  inner join user_template ut on ut.user_template_id=t.user_template_id	 and ut.application_id=c.application_id and template_name='Device'
                  left join ".__racinebd__."categorie_compte_device ccd on pd.device_id=ccd.device_id 
                  where t.active=1 and c.application_id=".$_SESSION["application_id"]." and t.user_id in('".((is_array($_GET["vehicule"]))?implode(",",$_GET["vehicule"]):"0")."')";
*/
$sql=getsqllistvehicule()." and pd.device_id in(".((is_array($_GET["vehicule"]))?implode(",",$_GET["vehicule"]):"0").")";
//print $sql;
$link=query($sql);
$content=array();
while($tbl=fetch($link)){
  //$content[]="{\"nomvehicule\": \"".$tbl["nomvehicule"]."\", \"date\": \"".$tbl["time_stamp"]."\",\"couleur\":\"".etatvoiturecouleur($tbl["user_id"])."\",\"bordure\":\"".etatvoiturecouleur($tbl["user_id"])."\",\"latitude\":".$tbl["latitude"].",\"longitude\":".$tbl["longitude"].",\"img\":\"".urliconvoiture($tbl["user_id"])."\"}";
  $tabcouleur=etatvoiturecouleur($tbl["phantom_device_id"]);
  $content[]="{\"nomvehicule\": \"".$tbl["nomvehicule"]."\", \"date\": \"".$tbl["time"]."\",\"couleur\":\"".$tabcouleur[1]."\",\"bordure\":\"".$tabcouleur[1]."\",\"latitude\":".$tbl["latitude"].",\"longitude\":".$tbl["longitude"].",\"img\":\"".urliconvoiture($tbl["phantom_device_id"])."\"}";
}
?>
{"listvehicule": [
    <?=implode(",",$content)?>
    ]
}