<?
/*
 $sql="select * 
    from ".__racinebd__."device d
    inner join positions p on d.devices_id=p.device_id and d.device_id=".$_POST["vehicule"]."
    where valid=1 and latitude!=0 and longitude!=0 $where
    ORDER BY p.time ASC";
    */
 $sql="select * 
    from ".__racinebd__."device d
    inner join positions p on d.devices_id=p.device_id and d.device_id=".$_POST["vehicule"]."
    where latitude!=0 and longitude!=0 $where
    ORDER BY p.time ASC";  
    
  //print $sql."<br>";
  
  $linkconduite=query($sql);
  $totaldistance=0;
  $totalconduite=0;
  $totalarret=0;

  $semaine=array();
  $lastjour=0;
  while($tblconduite=fetch($linkconduite)){
    //recherche si le jour fait partie du mois
    $tabjour=explode(" ",$tblconduite["time"]);
    if($lastjour!=$tabjour[0]){
      $first=true;
      $lastspeed=0;
      $lastlat=0;
      $lastlon=0;
      $lastdistance=0;
      $semaine[$tabjour[0]]["debut"]=0;
      $lastjour=$tabjour[0];
      $i=0;
      $trajet=array();
      $debut=0;
      $fin=0;
      $semaine[$tabjour[0]]["date"]=affichedateiso($tabjour[0])." - ".jourfr(dayOfWeek(strtotime($tabjour[0]))-1);
    }  
    
    //$semaine[$tabjour[0]]["km"]+=(int)$tblconduite["distance_next"]/1000;
   $distance=0;
   if($lastlat!=$tblconduite["latitude"]&&$lastlon!=$tblconduite["longitude"]){
     if($lastlat!=0&&$lastlon!=0){
      //print "ici2";
      $distance= haversineGreatCircleDistance($lastlat, $lastlon, $tblconduite["latitude"], $tblconduite["longitude"])/1000;
      $semaine[$tabjour[0]]["km"]+=round($distance,2);
      $totaldistance+=$semaine[$tabjour[0]]["km"];
     }
    }  
            
    $semaine[$tabjour[0]]["vitessemax"]=($semaine[$tabjour[0]]["vitessemax"]>vitessekmh($tblconduite["speed"]))?$semaine[$tabjour[0]]["vitessemax"]:vitessekmh($tblconduite["speed"]);
    
   // if(($lastspeed!=$tblconduite["speed"]&&$lastspeed==0)||($lastdistance!=$distance&&$lastdistance==0)){
    
    if(((($lastspeed!=$tblconduite["speed"]&&$lastspeed==0)||($lastlat!=round($tblconduite["latitude"],4)&&$lastlon!=round($tblconduite["longitude"],4)&&!$first&&$tblconduite["speed"]!=0)))){
    
      $semaine[$tabjour[0]]["debut"]=($semaine[$tabjour[0]]["debut"]==0)?$tblconduite["time"]:$semaine[$tabjour[0]]["debut"];
      $semaine[$tabjour[0]]["fin"]=0;
      $debut=strtotime($tblconduite["time"]);
    }
    
    if(($lastspeed!=$tblconduite["speed"]&&$tblconduite["speed"]==0&&$lastspeed!=0)||($lastdistance!=$distance&&$distance==0&&$lastdistance!=0)){    
      $semaine[$tabjour[0]]["fin"]=$tblconduite["time"];
      $fin=strtotime($tblconduite["time"]);
      if($semaine[$tabjour[0]]["fin"]!=""&&$semaine[$tabjour[0]]["debut"]!=""){
        $semaine[$tabjour[0]]["datediff"]=dateDifference($semaine[$tabjour[0]]["fin"] , $semaine[$tabjour[0]]["debut"] , '%h H %i Min' );
        $semaine[$tabjour[0]]["conduite"]+=round(($fin-$debut)/60);
      }
      
      $semaine[$tabjour[0]]["arret"]=date('h\H i ',(strtotime($semaine[$tabjour[0]]["fin"])-strtotime($semaine[$tabjour[0]]["debut"])-3600-$semaine[$tabjour[0]]["conduite"]*60));    
      //$semaine[$tabjour[0]]["km"]=round($semaine[$tabjour[0]]["km"],2);
    }
            
    $lastspeed=$tblconduite["speed"];
    $lastlat=$tblconduite["latitude"];
    $lastlon=$tblconduite["longitude"];
    $lastdistance=$distance;
  }
//print_r($semaine);
?>