<?
$_POST["heure_debut"]=($_POST["heure_debut"]=="")?"00:00":$_POST["heure_debut"];
$_POST["heure_fin"]=($_POST["heure_fin"]=="")?"23:59":$_POST["heure_fin"];
$_POST["date_debut"]=($_POST["date_debut"]=="")?date("d/m/Y",mktime(0,0,0,date("n"),date("j")-1,date("Y"))):$_POST["date_debut"];
$_POST["date_fin"]=($_POST["date_fin"]=="")?date("d/m/Y"):$_POST["date_fin"];
$where="";                                                            
if($_POST["date_debut"]!=""){
   //$where.=" and addtime(min_time_stamp,'".__decalageheure__.":0:0')>='".datetimebdd($_POST["date_debut"]." ".$_POST["heure_debut"])."'";
   $where.=" and p.time>='".datetimebdd($_POST["date_debut"]." ".$_POST["heure_debut"])."'";
}
if($_POST["date_fin"]!=""){
   $where.=" and p.time<='".datetimebdd($_POST["date_fin"]." ".$_POST["heure_fin"])."'";
}
$sql="select * from ".__racinebd__."type_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $tbl_list_type[]=$tbl;
  $key_list_type[$tbl["type_compte_id"]]=$tbl["libelle"];
}

if($_POST["agence"]!=""){
  $where2=" and agence_compte_id=".$_POST["agence"];
}
if($_POST["date_debut"]!=""||$_POST["date_fin"]!=""){
  $totalalldistance=0;
  $totalallconso=0;
  $totalallarret=0;
  $totalallconduite=0;
  $sql=getsqllistvehicule().$where2;
  //$sql=getsqllistvehiculerapport($where).$where2;
  //print $sql; 
  $link_km=query($sql);
  while($tbl_km=fetch($link_km)){
    if($tbl_km["phantom_device_id"]!=""){
    //print_r($tbl);
    $sql="select * from ".__racinebd__."categorie_compte_device ccd
          inner join ".__racinebd__."categorie_compte cc on ccd.categorie_compte_id=cc.categorie_compte_id where device_id=".$tbl_km["phantom_device_id"];
    //print $sql;
    $link2=query($sql);
    $tbl_list_cat=array();
    while($tbl2=fetch($link2)){
      $tbl_list_cat[]=$tbl2["libelle"];
    }
    $tbl_km["listcat"]=implode(", ",$tbl_list_cat);
    //calcul du temps
    
    //consotheorique
    if($tbl_km["consommationtype"]==1){
      $sql="select * from ".__racinebd__."type_compte where compte_id=".$_SESSION["compte_id"]." and type_compte_id=".$tbl_km["type_compte_id"];
      $link2=query($sql);
      $tbl2=fetch($link2);
      $tbl_km["consotheorique"]=$tbl2["consommation"];
    }else{
      $tbl_km["consotheorique"]=$tbl_km["consommation"];
    }
    /*
    print $tbl["mintime"]."<br>";
    print $tbl["maxtime"];
    */
    //recherche du km
    $_POST["vehicule"]=$tbl_km["phantom_device_id"];
    require("rapport-gen2.php");
    $tbl_km["datediff"]=secondsToTime2($totalconduite*60);
    //$tbl_km["datediff"]=$totalconduite;
    $tbl_km["km"]=round($totaldistance,2);
    $totalalldistance+=$totaldistance;
    $tbl_km["conso"]=$tbl_km["consotheorique"]*((int)$tbl_km["km"])/100;
    $totalallconso+=$tbl_km["conso"];
    $tbl_km["vitesse"]=vitessekmh($vitessemaxvehicule);
    $tbl_km["mintime"]=$trajet[0]["debut"];
    //print $trajet[0]["debut"];
    $tbl_km["maxtime"]=$trajet[count($trajet)-1]["fin"];
    $tbl_km["amplitude"]=dateDifference($tbl_km["mintime"] , $tbl_km["maxtime"] , '%d Jours %h H %i Min' );
    /*
    print strtotime($tbl_km["maxtime"])."<br>";
    print strtotime($tbl_km["mintime"])."<br>";
    */
    $tbl_km["maxtime"]=($tbl_km["maxtime"]=="")?$tbl_km["mintime"]:$tbl_km["maxtime"];
    $totalallarret+=strtotime($tbl_km["maxtime"])-strtotime($tbl_km["mintime"])-($totalconduite*60);
    //print $totalarret."<br>";
    $tbl_km["arret"]=secondsToTime(strtotime($tbl_km["maxtime"])-strtotime($tbl_km["mintime"])-($totalconduite*60));
    $totalallconduite+=$totalconduite*60;
    //$totalarret+=(strtotime($tbl_km["maxtime"])-($totalconduite*60))-strtotime($tbl_km["mintime"]);
    //print (strtotime($tbl_km["maxtime"])-($totalconduite*60))-strtotime($tbl_km["mintime"])."<br>";
    //$tbl_km["arret"]=dateDifference($tbl_km["mintime"] , date("Y-m-j h:i:s",strtotime($tbl_km["maxtime"])-$totalconduite*60) , '%d Jours %h H %i Min' );
    //$totalkm+=($tbl["kminit"]+$totaldistance+$tbl["correctifkm"]);
    /*
    $tbl["datediff"]=dateDifference($tbl["mintime"] , $tbl["maxtime"] , '%y Année %m Mois %d Jours %h H %i Min' );
    $totalkm+=($tbl["kminit"]+$tbl["km"]+$tbl["correctifkm"]);
    $totaldistance+=($tbl["km"]);
    $totalconso+=$tbl["consotheorique"]*((int)$tbl["km"])/100;
    
    $tbl["conso"]=$tbl["consotheorique"]*((int)$tbl["km"])/100;
    $tbl["theorique"]=$tbl["kminit"]+$tbl["km"]+$tbl["correctifkm"];
    */
    $tbl_list_vehicule[]=$tbl_km;  
    }
  }
  //print_r($tbl_list_vehicule);
  $tbl_list_export=$tbl_list_vehicule;
}
?>