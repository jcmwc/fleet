<?
//require("../admin/require/function.php");
//mettre a jour les km
$datehier=date("d/m/Y",mktime(0,0,0,date("n"),date("j")-1,date("Y")));
  $where="";
  $_POST["date_debut"]=$datehier." 00:00:00";
  $_POST["date_fin"]=$datehier." 23:59:59";
  if($_POST["date_debut"]!=""){
     //$where.=" and addtime(min_time_stamp,'".__decalageheure__.":0:0')>='".datetimebdd($_POST["date_debut"]." ".$_POST["heure_debut"])."'";
     $where.=" and p.time>='".datetimebdd($_POST["date_debut"]." ".$_POST["heure_debut"])."'";
  }
  if($_POST["date_fin"]!=""){
     $where.=" and p.time<='".datetimebdd($_POST["date_fin"]." ".$_POST["heure_fin"])."'";
  }
  $sql="select * from ".__racinebd__."device where supprimer=0 and compte_id=".$_SESSION["compte_id"];    
  $link_list_vehicule=query($sql);
  //$_GET["rapport"]=1;
  while($tbl_list_vehicule=fetch($link_list_vehicule)){
    $_POST["vehicule"]=$tbl_list_vehicule["device_id"];
    require("../tpl/script/rapport-gen2.php");
    //$tbl_km["km"]=round($totaldistance,2);
    //mise a jour des km du jour
    $sql="update ".__racinebd__."device set kmactuel=kmactuel+".round($totaldistance,2)." where device_id=".$_POST["vehicule"];
    //print $sql."<br>";
    query($sql);
    require("alarme-sociale.php");
  }
  
?>