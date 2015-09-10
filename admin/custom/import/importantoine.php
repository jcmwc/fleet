<?
require("../../require/function.php");


//import des boitiers
$filename = "Import_boitier_antoine.csv";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$line=explode("\n",$contents);
for($i=1;$i<count($line);$i++){
  $tablelem=explode(";",$line[$i]);
  $sql="select * from ".__racinebd__."compte where codecreation ='".addslashes($tablelem[0])."' and supprimer=0";
  //print $sql;
  $link=query($sql);
  if(num_rows($link)>0){
    $tbl=fetch($link);
    
    //on verifie si la voiture existe
    $sql="select * from ".__racinebd__."device where supprimer=0 and unitid='".addquote($tablelem[4])."'";
    //print $sql;
    $link2=query($sql);
    //if(num_rows($link2)==0&&$tablelem[5]!=""){ 
    if(num_rows($link2)==0){    
      $compte_id=$tbl["compte_id"];
      
      $sql="select max(id) as maxid from devices";
      $link=query($sql);
      $tbl=fetch($link);
      
      $sql="insert into devices (name,uniqueId) 
      values('Device".($tbl["maxid"]+1)."','".addslashes($tablelem[4])."')";
      //print $sql."<br>";
      
      query($sql);
      $id=insert_id();
      
      $sql="INSERT INTO users_devices (users_id, devices_id) VALUES ('1', $id)";
      //query($sql);
      
      $szQuery="insert into ".__racinebd__."device (devices_id,type_device_id,IMEI,serialnumber,nomvehicule,telboitier,compte_id,date_creation,unitid,immatriculation) 
      values('".$id."',1,'".addslashes($tablelem[4])."','".addslashes($tablelem[4])."','".addslashes($tablelem[2])."','+".addslashes($tablelem[5])."','".$compte_id."',now(),'".addquote($tablelem[4])."','".addquote($tablelem[3])."')";
      //query($sql);
      //print $szQuery."<br>";
      query($szQuery);
      $device_id=insert_id();
      
      //device phantom_usergps_device
      $sql="select * from ".__racinebd__."usergps where compte_id=".$compte_id;
      $link_device=query($sql);
      while($tbl_device=fetch($link_device)){
        $sql="insert into ".__racinebd__."usergps_device (device_id,usergps_id) values('".$device_id."','".$tbl_device["usergps_id"]."')";
        //print $sql."<br>";
        query($sql);
      }
       
    }
    
  }else{
    print "erreur compte '".addslashes($tablelem[0])."' non trouvé<br>";
  }
 
}
?>