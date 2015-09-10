<?
//vérification des paramêtres du compte
  $sql="select * from ".__racinebd__."preference_compte where compte_id=".$_SESSION["compte_id"];
  $link=query($sql);
  $tbl_preference=fetch($link);
  $dureeminattente=$tbl_preference["dureeminattente"];

  if($where!=""){
    /*
    $sql="select * 
    from ".__racinebd__."device d
    inner join positions p on d.devices_id=p.device_id and d.device_id=".$_POST["vehicule"]."
    where valid=1 $where 
    ORDER BY p.time ASC";
    */
    $sql="select * 
    from ".__racinebd__."device d
    inner join positions p on d.devices_id=p.device_id and d.device_id=".$_POST["vehicule"]."
    where latitude!=0 and longitude!=0  $where 
    ORDER BY p.time ASC";
  }else{
    /*
    $sql="select * 
    from ".__racinebd__."device d
    inner join positions p on d.devices_id=p.device_id and d.device_id=".$_POST["vehicule"]."
    where p.time>='".datebdd($_POST["date_jour"])." 00:00:00' and p.time<='".datebdd($_POST["date_jour"])." 23:59:59' and valid=1 and latitude!=0 and longitude!=0
    ORDER BY p.time ASC";
    */
        $sql="select * 
    from ".__racinebd__."device d
    inner join positions p on d.devices_id=p.device_id and d.device_id=".$_POST["vehicule"]."
    where p.time>='".datebdd($_POST["date_jour"])." 00:00:00' and p.time<='".datebdd($_POST["date_jour"])." 23:59:59' and latitude!=0 and longitude!=0
    ORDER BY p.time ASC";
  } 
  //print $sql."<br>";
  $linkconduite=query($sql);
  $tbl["conduite"]=0;
  $lastspeed=0;
  $lastlat=0;
  $lastlon=0;
  $lastdistance=0;
  $totalconduite=0;
  $totaldistance=0;
  $totalarret=0;
  $trajet=array();             
  $i=0;
  $lastdate=0;
  $vitessemoy=array();
  $vitessemax=0;
  $vitessemaxvehicule=0;
  $fin=true; 
  $first=true;
  //$contenttabcoordonnee=""; 
  //print num_rows($linkconduite)."<br>";
  while($tblconduite=fetch($linkconduite)){   

    $vitessemax=($vitessemax>$tblconduite["speed"])?$vitessemax:$tblconduite["speed"];
    $vitessemaxvehicule=($vitessemaxvehicule>$tblconduite["speed"])?$vitessemaxvehicule:$tblconduite["speed"];
    $vitessemoy[]=$tblconduite["speed"];
    //if(((($lastspeed!=$tblconduite["speed"]&&$lastspeed==0)||($lastlat!=round($tblconduite["latitude"],4)&&$lastlon!=round($tblconduite["longitude"],4)&&!$first&&$tblconduite["speed"]==0))&&$fin==true)){
    //calcul du temps entre les 2 enregistrement gps
    //
    //print $tblconduite["time"]." / ".$lastdate." / ".__delaibetweengps__." / ".(strtotime($tblconduite["time"])- strtotime($lastdate))."<br>";
    $newtrajet=((strtotime($tblconduite["time"])- strtotime($lastdate))>__delaibetweengps__)?true:false;
    //$newtrajet=false;
    
    if($newtrajet){
      //print "OK ".$tblconduite["time"]." / ".$lastdate." / ".$trajet[$i]["fin"]." / ".__delaibetweengps__." / ".(strtotime($tblconduite["time"])- strtotime($lastdate))."<br>";
        if($trajet[$i]["lat1"]!=""){
          $fin=true;
          $trajet[$i]["fin"]=$lastinfo["time"];
          $trajet[$i]["lat2"]=$lastinfo["latitude"];
          $trajet[$i]["lon2"]=$lastinfo["longitude"];                     
          $trajet[$i]["max"]=$vitessemax;       
          $i++; 
          $vitessemoy=array();
          $vitessemax=0;
        }

      //$trajet[$i-1]["fin"]=$lastinfo["time"];
      /*
      $trajet[$i-1]["fin"]=$lastinfo["time"];
      $trajet[$i-1]["lat2"]=$lastinfo["latitude"];
      $trajet[$i-1]["lon2"]=$lastinfo["longitude"];
      */    
      /*
      if($trajet[$i-1]["fin"]==""){
        
      } */
    }  
    
    
    if(((($lastspeed!=$tblconduite["speed"]&&$lastspeed==0)||($lastlat!=round($tblconduite["latitude"],4)&&$lastlon!=round($tblconduite["longitude"],4)&&!$first&&$tblconduite["speed"]!=0))&&$fin==true)||($newtrajet&&$tblconduite["speed"]!=0)){
        $fin=false;
        $first=false;
        $trajet[$i]["km"]=0;
        $trajet[$i]["debut"]=$tblconduite["time"];
        $trajet[$i]["fin"]=0;
        $trajet[$i]["lat1"]=$tblconduite["latitude"];
        $trajet[$i]["lon1"]=$tblconduite["longitude"];
        $debut="<span>".affichedatetime($trajet[$i]["debut"])."</span><br>"; 
        
    }
    if($lastlat!=$tblconduite["latitude"]&&$lastlon!=$tblconduite["longitude"]){
       $trajet[$i]["coordonnees"].="tablist[].push(new google.maps.LatLng(".$tblconduite["latitude"].",".$tblconduite["longitude"]."));";
       $trajet[$i]["coordonnees2"].="tabcoordonnee.push(new google.maps.LatLng(".$tblconduite["latitude"].",".$tblconduite["longitude"]."));";
       if($lastlat!=0&&$lastlon!=0){
        $distance= haversineGreatCircleDistance($lastlat, $lastlon, $tblconduite["latitude"], $tblconduite["longitude"])/1000;
        $trajet[$i]["km"]+=round($distance,2);
        //print $trajet[$i]["km"]."<br>"; 
       }
    }   
    if((($lastspeed!=$tblconduite["speed"]&&$tblconduite["speed"]==0&&$lastspeed!=0))&&$fin==false){      
      
        if(array_key_exists("lat1",$trajet[$i])&&$trajet[$i]["lat1"]!=0){
          $fin=true;
          $trajet[$i]["fin"]=$tblconduite["time"];
          $trajet[$i]["lat2"]=$tblconduite["latitude"];
          $trajet[$i]["lon2"]=$tblconduite["longitude"];                     
          $trajet[$i]["max"]=$vitessemax;       
          $i++; 
          $vitessemoy=array();
          $vitessemax=0;               
        }      
    }    
    $lastspeed=$tblconduite["speed"];
    $lastlat=round($tblconduite["latitude"],4);
    $lastlon=round($tblconduite["longitude"],4);
    $lastdate=$tblconduite["time"];
    $lastinfo=$tblconduite;
    /*
    if(!$first&&$tblconduite["latitude"]==0&&$tblconduite["longitude"]==0){
        $first=true;
    } */
  }
  //print_r($trajet);
  $tmptrajet=array();
  $j=-1;

  //vérification si la dernière coordonnées à une fin
  
  if($trajet[$i]["fin"]==""&&$lastinfo["speed"]!=0){
    $trajet[$i]["fin"]=$lastinfo["time"];
    $trajet[$i]["lat2"]=$lastinfo["latitude"];
    $trajet[$i]["lon2"]=$lastinfo["longitude"];    
  }
  
  

  //print_r($trajet);
  for($i=0;$i<count($trajet);$i++){
    if($trajet[$i-1]["fin"]==""||((strtotime($trajet[$i]["debut"])- strtotime($trajet[$i-1]["fin"]))>$dureeminattente)){
        $j++;
        $tmptrajet[$j]=$trajet[$i];
    }else{
        //on verifie si on dejà un fusion en cour
        /*
        print "<br>".strtotime($tmptrajet[$j]["fin"])."<br>";   
        print strtotime($trajet[$i]["fin"])."<br>"; 
        print (strtotime($tmptrajet[$j]["fin"])-strtotime($trajet[$i]["fin"]))."<br>"; 
        */
        if($tmptrajet[$j]["fin"]==""||$trajet[$i]["fin"]!=""){
          //print $trajet[$i]["fin"];
          $tmptrajet[$j]["fin"]=$trajet[$i]["fin"];
        }
        //print $tmptrajet[$j]["fin"]."<br>"; 
        $tmptrajet[$j]["max"]=($trajet[$i]["max"]>$tmptrajet[$j]["max"])?$trajet[$i]["max"]:$tmptrajet[$j]["max"];
        $tmptrajet[$j]["km"]+=$trajet[$i]["km"];
        
        if($tmptrajet[$j]["lat2"]==""||$trajet[$i]["lat2"]!=""){
          $tmptrajet[$j]["lat2"]=$trajet[$i]["lat2"];
          $tmptrajet[$j]["lon2"]=$trajet[$i]["lon2"];
        }
        //$tmptrajet[$j]["fin"]=($tmptrajet[$j]["fin"]==0)?$tmptrajet[$j]["debut"]:$tmptrajet[$j]["fin"];
        //print $j." / ".$tmptrajet[$j]["fin"]."<br>";
        $tmptrajet[$j]["fin"]=($tmptrajet[$j]["fin"]==0)?$tmptrajet[$j]["debut"]:$tmptrajet[$j]["fin"];
        $tmptrajet[$j]["coordonnees"].=$trajet[$i]["coordonnees"];
        $tmptrajet[$j]["coordonnees2"].=$trajet[$i]["coordonnees2"];
        $tmptrajet[$j]["fusion"]++;
        
    }
  }
  //print_r($tmptrajet);
  //mise a jour des moyennnes, transformation des vitesses, maj des coordonnés
  for($j=0;$j<count($tmptrajet);$j++){
    if((strtotime($tmptrajet[$j]["fin"])-strtotime($tmptrajet[$j]["debut"]))!=0){
      $tmptrajet[$j]["moy"]=$tmptrajet[$j]["km"]/((strtotime($tmptrajet[$j]["fin"])-strtotime($tmptrajet[$j]["debut"]))/3600);
      
    }else{
      $tmptrajet[$j]["moy"]=0;
    }
    $tmptrajet[$j]["moy"]=($tmptrajet[$j]["moy"]>vitessekmh($tmptrajet[$j]["max"]))?vitessekmh($tmptrajet[$j]["max"]):$tmptrajet[$j]["moy"];
    $tmptrajet[$j]["moy"]=(int)$tmptrajet[$j]["moy"];  
    $tmptrajet[$j]["max"]=vitessekmh($tmptrajet[$j]["max"]);  
    $tmptrajet[$j]["coordonnees"]="tablist[".$j."]= new Array();".str_replace("tablist[]","tablist[".$j."]",$tmptrajet[$j]["coordonnees"]);
    $tmptrajet[$j]["coordonnees2"]= $tmptrajet[$j]["coordonnees2"];   
    $contenttabcoordonnee.=$tmptrajet[$j]["coordonnees"];
    $contenttabcoordonnee2.=$tmptrajet[$j]["coordonnees2"];
    if($tmptrajet[$j+1]["debut"]!=""){
      $tmptrajet[$j]["arret"]=secondsToTime2((int)((strtotime($tmptrajet[$j+1]["debut"])-strtotime($tmptrajet[$j]["fin"])))); 
      $tmptrajet[$j]["arretintime"]=(int)((strtotime($tmptrajet[$j+1]["debut"])-strtotime($tmptrajet[$j]["fin"]))); 
    }else{
      $tmptrajet[$j]["arret"]="";
    }
    //debuttxt
    //$tbl_info=adressegps($tmptrajet[$j]["lat1"],$tmptrajet[$j]["lon1"]);
    if($j==0){
      $tbl_info=adressegps($tmptrajet[$j]["lat1"],$tmptrajet[$j]["lon1"]);
    }else{
      $tbl_info=adressegps($tmptrajet[$j-1]["lat2"],$tmptrajet[$j-1]["lon2"]);
    }
    if(is_array($tbl_info)){
      $debut=$tbl_info["adresse"]."<br><img src=\"".__racineweb__."/tpl/img/lieux/".$tbl_info["icon"]."\"> <span>".$tbl_info["libelle"]."</span>";
    }else{
      $debut=$tbl_info;
    }
    $tmptrajet[$j]["debuttxt"]="<span>".affichedatetime($tmptrajet[$j]["debut"])."</span><br>".$debut;  
    //fintxt
    $tbl_info=adressegps($tmptrajet[$j]["lat2"],$tmptrajet[$j]["lon2"]);
    if(is_array($tbl_info)){
      $fin=$tbl_info["adresse"]."<br><img src=\"".__racineweb__."/tpl/img/lieux/".$tbl_info["icon"]."\"> <span>".$tbl_info["libelle"]."</span>";
    }else{
      $fin=$tbl_info;
    }
    //$tmptrajet[$j]["fintxt"]=$fin;
    $tmptrajet[$j]["fintxt"]="<span>".affichedatetime($tmptrajet[$j]["fin"])."</span><br>".$fin; 
    $tmptrajet[$j]["km"]=round($tmptrajet[$j]["km"],2);
    $totaldistance+=$tmptrajet[$j]["km"];
    if($tmptrajet[$j]["lat2"]==""&&$tmptrajet[$j]["lon2"]==""){
      $tmptrajet[$j]["lat2"]=$tmptrajet[$j]["lat1"];
      $tmptrajet[$j]["lon1"]=$tmptrajet[$j]["lon1"];
      $tmptrajet[$j]["fin"]="";
      $tmptrajet[$j]["fintxt"]=$tmptrajet[$j]["debuttxt"];
      $tmptrajet[$j]["datediff"]="-";
    }else{
      //datediff
      $tmptrajet[$j]["datediff"]=dateDifference($tmptrajet[$j]["fin"] , $tmptrajet[$j]["debut"] , '%h H %i Min' );
      $totalconduite+=(int)((strtotime($tmptrajet[$j]["fin"])-strtotime($tmptrajet[$j]["debut"]))/60);   
    }    
  }
  $trajet=$tmptrajet;

$sql="select lc.*,tlc.libelle as lib from ".__racinebd__."lieu_compte lc inner join ".__racinebd__."type_lieu_compte tlc on lc.type_lieu_compte_id=tlc.type_lieu_compte_id where compte_id=".$_SESSION["compte_id"]." and lc.supprimer=0 order by lc.libelle";
$link=query($sql);

while($tbl=fetch($link)){
  $contenttab.="tab.push(new Array('".$tbl["icon"]."','".$tbl["latitude"]."','".$tbl["longitude"]."','".$tbl["rayon"]."'));";
} 
$tbl_list_export=$trajet;
?>