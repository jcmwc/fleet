<?
require("../admin/require/function.php");
//on recherche les enregistrement de plus de 90 jours
$date3mois=date("Y-n-j",mktime (0,0,0,date("n") ,date("j") -90, date("Y")) );
//print $date3mois;
$sql="select p.*,d.compte_id from positions p inner join
  ".__racinebd__."device d on d.devices_id=p.device_id 
  where time<'".$date3mois."' order by compte_id,p.device_id";

//die;
$lastdevice=0;
$content="";
$link_archive=query($sql);
$tabcontent=array();
//print num_rows($link_archive)."<br>";
while($tbl_archive=fetch($link_archive)){
  $tabcontent[$tbl_archive["compte_id"]][$tbl_archive["device_id"]].="insert into positions (address,altitude,course,latitude,longitude,other,power,speed,time,valid,device_id,dateserver) 
    values ('".$tbl_archive["address"]."','".$tbl_archive["altitude"]."','".$tbl_archive["course"]."','".$tbl_archive["latitude"]."','".$tbl_archive["longitude"]."',
    '".$tbl_archive["other"]."','".$tbl_archive["power"]."','".$tbl_archive["speed"]."','".$tbl_archive["time"]."','".$tbl_archive["valid"]."',
    '".$tbl_archive["device_id"]."','".$tbl_archive["time"]."','".$tbl_archive["dateserver"]."');\n";   
   //print $content;
}

//print_r($tabcontent);

foreach ($tabcontent as $key => $value){
  foreach ($value as $key2 => $value2){
    $dir= $_SERVER["DOCUMENT_ROOT"].__racine__."/archive/".$key."/".$key2;
    
    print $dir."<br>";
    
    if(!is_dir($dir)){
      mkdir ($dir,0777,true);  
    }
    if($value2!=""){
      $fp = fopen($dir."/".$date3mois.'.sql', 'w');
      fwrite($fp, $value2);
      fclose($fp); 
    }
  }
}

/*
$sql="delete from positions where time<'".$date3mois."'";
query($sql);
*/
?>