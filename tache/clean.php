<?
require("../admin/require/function.php");
set_time_limit(86400);
print date("Y-m-d H:i:s");  
$nomfichier=date("Y-m-d").".sql";
$fp = fopen($_SERVER["DOCUMENT_ROOT"].__racine__."/tache/clean/".$nomfichier, 'w');
$sql="select count(device_id) as nb,time,device_id from positions where speed=0 group by device_id,time";
$link=query($sql);
$nbdelete=0;
while($tbl=fetch($link)){
  if($tbl["nb"]>1){
    $sql="select * from positions where device_id='".$tbl["device_id"]."' and time='".$tbl["time"]."' order by dateserver asc";
    $link2=query($sql);
    $i=0;
    $max=num_rows($link2);
    while($tbl2=fetch($link2)){
      if($i++<$max-1){
        $sql="delete from positions where id='".$tbl2["id"]."'";
        //mysql($sql);  
        $nbdelete++;
        $content="insert into positions (id,address,altitude,course,latitude,longitude,other,power,speed,time,valid,device_id,dateserver,lastspeed)
          values('".$tbl2["id"]."','".$tbl2["address"]."','".$tbl2["altitude"]."','".$tbl2["course"]."','".$tbl2["latitude"]."','".$tbl2["longitude"]."',
          '".$tbl2["other"]."','".$tbl2["power"]."','".$tbl2["speed"]."','".$tbl2["time"]."','".$tbl2["valid"]."','".$tbl2["device_id"]."','".$tbl2["dateserver"]."','".$tbl2["lastspeed"]."');";
        fwrite($fp, $content."\n");
      }      
    }
  }
}
fclose($fp);
print "<br>".$nbdelete."<br>";
print date("Y-m-d H:i:s"); 
?>