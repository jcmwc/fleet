<?
$_POST["heure_debut"]=($_POST["heure_debut"]=="")?"00:00":$_POST["heure_debut"];
$_POST["heure_fin"]=($_POST["heure_fin"]=="")?"23:59":$_POST["heure_fin"];
if($_POST["date_debut"]!=""){
   $where.=" and p.time>='".datetimebdd($_POST["date_debut"]." ".$_POST["heure_debut"])."'";
}
if($_POST["date_fin"]!=""){
   $where.=" and p.time<='".datetimebdd($_POST["date_fin"]." ".$_POST["heure_fin"])."'";
}

if($_POST["date_debut"]!=""&&$_POST["date_fin"]!=""){ 
  require("rapport-gen2.php");
  $sql="select lc.*,tlc.libelle as lib from ".__racinebd__."lieu_compte lc inner join ".__racinebd__."type_lieu_compte tlc on lc.type_lieu_compte_id=tlc.type_lieu_compte_id where compte_id=".$_SESSION["compte_id"]." and lc.supprimer=0 and affichage=1  order by lc.libelle";
  $link=query($sql);
  
  while($tbl=fetch($link)){
    $contenttab.="tab.push(new Array('".$tbl["icon"]."','".$tbl["latitude"]."','".$tbl["longitude"]."','".$tbl["rayon"]."'));";
  } 
}
/*
if($_POST["date_debut"]!=""&&$_POST["date_fin"]!=""){  
  $sql="select *,addtime(td.time_stamp,'".__decalageheure__.":0:0') timestp from track_data td inner join track_info ti on ti.track_info_id=td.track_info_id and owner_id=".$_POST["vehicule"]." 
  where valid=1 and deleted=0 $where 
  ORDER BY `td`.`time_stamp`  ASC";
    
  //print $sql."<br>";
  
  $linkconduite=query($sql);
  $tbl["conduite"]=0;
  $lastspeed=0;
  $lastlat=0;
  $lastlon=0;
  $lastdistance=0;
  $totalconduite=0;
  $totalarret=0;
  $trajet=array();
  $i=0;
  $vitessemoy=array();
  $vitessemax=0;
  while($tblconduite=fetch($linkconduite)){
    $trajet[$i]["km"]+=(int)$tblconduite["distance_next"]/1000;
    $vitessemax=($vitessemax>$tblconduite["ground_speed"])?$vitessemax:$tblconduite["ground_speed"];
    $vitessemoy[]=$tblconduite["ground_speed"];
    //if($lastspeed!=$tblconduite["ground_speed"]&&$lastspeed==0){
    if(($lastspeed!=$tblconduite["ground_speed"]&&$lastspeed==0)||($lastdistance!=$tblconduite["distance_next"]&&$lastdistance==0)){
      $trajet[$i]["debut"]=$tblconduite["timestp"];
      $trajet[$i]["fin"]=0;
      $trajet[$i]["lat1"]=$tblconduite["latitude"];
      $trajet[$i]["lon1"]=$tblconduite["longitude"];
      
      $debut="<span>".affichedatetime($trajet[$i]["debut"])."</span><br>"; 
      $tbl_info=adressegps($trajet[$i]["lat1"],$trajet[$i]["lon1"]);
      if(is_array($tbl_info)){
        $debut.="<img src=\"".__racineweb__."/tpl/img/lieux/".$tbl_info["icon"]."\"> <span>".$tbl_info["libelle"]."</span>";
      }else{
        $debut.=$tbl_info;
      }
      $trajet[$i]["debuttxt"]=$debut;
    }
    //if($lastspeed!=$tblconduite["ground_speed"]&&$tblconduite["ground_speed"]==0&&$lastspeed!=0){
    if(($lastspeed!=$tblconduite["ground_speed"]&&$tblconduite["ground_speed"]==0&&$lastspeed!=0)||($lastdistance!=$tblconduite["distance_next"]&&$tblconduite["distance_next"]==0&&$lastdistance!=0)){
    if(array_key_exists("lat1",$trajet[$i])&&$trajet[$i]["lat1"]!=0){
      $trajet[$i]["fin"]=$tblconduite["timestp"];
      $trajet[$i]["lat2"]=$tblconduite["latitude"];
      $trajet[$i]["lon2"]=$tblconduite["longitude"];
      
      $fin="<span>".affichedatetime($trajet[$i]["fin"])."</span><br>"; 
      $tbl_info=adressegps($trajet[$i]["lat2"],$trajet[$i]["lon2"]);
      if(is_array($tbl_info)){
        $fin.="<img src=\"".__racineweb__."/tpl/img/lieux/".$tbl_info["icon"]."\"> <span>".$tbl_info["libelle"]."</span>";
      }else{
        $fin.=$tbl_info;
      }
      $trajet[$i]["fintxt"]=$fin;
       
      $summoy=0;
      for($j=0;$j<count($vitessemoy);$j++){
        $summoy+=$vitessemoy[$j];  
      }
      $trajet[$i]["moy"]=vitessekmh($summoy/count($vitessemoy)); 
      $trajet[$i]["max"]=vitessekmh($vitessemax);
      $trajet[$i]["datediff"]=dateDifference($trajet[$i]["fin"] , $trajet[$i]["debut"] , '%h H %i Min' );
      $debut=strtotime($trajet[$i]["debut"]);
      $fin=strtotime($trajet[$i]["fin"]);    
      //$tbl["conduite"]=round(($fin-$debut)/60);
      //print $tbl["conduite"];
      //$trajet[$i]["arret"]=date('h\H i ',(strtotime($trajet[$i]["fin"])-strtotime($trajet[$i]["debut"])-3600-$tbl["conduite"]*60));
      $i++;
      $trajet[$i]["km"]=0;
      $vitessemoy=array();
      $vitessemax=0;
    }
    }    
    $lastspeed=$tblconduite["ground_speed"];
    $lastdistance=$tblconduite["distance_next"];
    if($lastlat!=$tblconduite["latitude"]&&$lastlon!=$tblconduite["longitude"]&&$lastlon!=0&&$lastlat!=0&&$tblconduite["latitude"]!=0&&$tblconduite["longitude"]!=0){
      $contenttabcoordonnee.="tabcoordonnee.push(new google.maps.LatLng(".$tblconduite["latitude"].",".$tblconduite["longitude"]."));";
    }
    $lastlat=$tblconduite["latitude"];
    $lastlon=$tblconduite["longitude"];
    //$tbl_list_vehicule[]=$tblconduite;
  }
  $tbl_list_export=$trajet;
//print_r($trajet); 
*/

//}
?>