<?
ini_set("memory_limit","256M");
/*
Client ID: gme-rubycom
Crypto Key: WbVj8fjEqf34-ug0mkoBJIj8ZTM=
Client ID Type: Asset Tracking
SKU: GM1ASOTH12MOSTD
*/

define("__googlekey__","AIzaSyC4e8Gsf4BE6SVuZmt7PSdUGXnan-gBx4I");
define("__googleclient__","gme-rubycom");

/*
define("__googlekey__","WbVj8fjEqf34-ug0mkoBJIj8ZTM=");
*/
//pour l'affichage des etat moteur
define("__delaiattentemoteur__","180");
//pour la creation d'un nouveau trajet entre é enregistrement gps
define("__delaibetweengps__","360");
function etatvoiture($device_id){
print "<a href=\"".urlp(__cartoid__)."?id=".$device_id."\" class=\"etat_moteur\" style=\"background:".etatvoiturecouleur($device_id)[1]."\"></a>";
}
function etatvoituremini($valcolor,$device_id){
print "<a href=\"".urlp(__cartoid__)."?id=".$device_id."\" class=\"etat_moteur\" style=\"background:".$valcolor."\"></a>";
}
function etatvoiturecouleur($device_id){
  //recherche de l'etat
  /*
  $sql="select * from positions p
      inner join phantom_preference_compte pc on TIME_TO_SEC(TIMEDIFF(now(),p.time))<dureeminattente 
      inner join ".__racinebd__."device d on p.device_id=d.devices_id
      where valid=1 and speed>0 and d.device_id=".$device_id." order by p.time desc limit 1";
  */
  $sql="select * from positions p
      inner join ".__racinebd__."device d on p.device_id=d.devices_id
      where latitude!=0 and longitude!=0 and TIME_TO_SEC(TIMEDIFF(now(),p.time))<".__delaiattentemoteur__."  and speed>0 and d.device_id=".$device_id." order by p.time desc limit 1";
  $link=query($sql);                                              
  return array(num_rows($link),$_SESSION["etatcouleur"][num_rows($link)]);
}
function etatvoituretxt($device_id){
  //recherche de l'etat
  /*
  $sql="select * from positions p
        inner join ".__racinebd__."preference_compte pc on DATEDIFF(p.time,now)<dureeminattente 
       where device_id=".$device_id." and valid=1 and  speed>0 limit 1";  */
  
  /*$sql="select * from positions p
      inner join phantom_preference_compte pc on TIME_TO_SEC(TIMEDIFF(now(),p.time))<dureeminattente 
      inner join ".__racinebd__."device d on p.device_id=d.devices_id
      where valid=1 and speed>0 and d.device_id=".$device_id." order by p.time desc limit 1";
      */
  $sql="select * from positions p
      inner join ".__racinebd__."device d on p.device_id=d.devices_id
      where latitude!=0 and longitude!=0 and TIME_TO_SEC(TIMEDIFF(now(),p.time))<".__delaiattentemoteur__."  and speed>0 and d.device_id=".$device_id." order by p.time desc limit 1";
  
  $link=query($sql);
  return $_SESSION["etatlibelle"][num_rows($link)];
}

function etatgps($device_id){
?>
<img src="<?=__racineweb__?>/tpl/img/rond_rouge.png">
<?
}  
function iconvoiture($device_id){
  if(urliconvoiture($device_id)!=false){?>
<img src="<?=urliconvoiture($device_id)?>">
<?}
}
function urliconvoiture($device_id){
//recherche de l'etat.
  /*
  $sql="select * from ".__racinebd__."etat_moteur em left join
  ".__racinebd__."etat_moteur_compte emc on em.etat_moteur_id=emc.etat_moteur_id and compte_id=".$_SESSION["compte_id"]." where
  em.etat_moteur_id =1";
  */
  
  $sql="select icon from ".__racinebd__."type_compte tc
      inner join ".__racinebd__."device d on tc.type_compte_id=d.type_compte_id
      and device_id=".$device_id;
  $link=query($sql);
  $tbl=fetch($link);
  if($tbl["icon"]==""){
  return __racineweb__."/tpl/img/vehicules/car_icon.png";
  }else{
  return __racineweb__."/tpl/img/vehicules/".$tbl["icon"];
  }
}
function adressegps($lat,$lon,$user_id=0){
  $returnval=findlieu($lat,$lon);
  if($returnval===false){
    return str_replace(", France","",getAddess($lat,$lon));
  }else{
    return $returnval;
  }
  //Avenue de l'Europe <br><span class="uppercase"> 78 590 noisy-le-roi</span>
}
function findlieu($lat,$lon){
  $sql="select lc.*,tlc.libelle as libcat from ".__racinebd__."lieu_compte lc inner join ".__racinebd__."type_lieu_compte tlc on lc.type_lieu_compte_id=tlc.type_lieu_compte_id where lc.supprimer=0 and compte_id=".$_SESSION["compte_id"];
  $link=query($sql);
  while($tbl=fetch($link)){
    if(haversineGreatCircleDistance($lat, $lon, $tbl["latitude"],$tbl["longitude"])<=$tbl["rayon"]){
      if($tbl["adresse"]==""){
        $tbl["adresse"]=getAddess($lat,$lon);
        $sql="update ".__racinebd__."lieu_compte set adresse='".$tbl["adresse"]."' where lieu_compte_id=".$tbl["lieu_compte_id"];
        query($sql);
      }
      $tbl["adresse"]=str_replace(", France","",$tbl["adresse"]);
      return $tbl;
      break;
    } 
  }
  return false;
}
function getAddess($lat,$long){
  //$url="http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lon."&sensor=false";
  //print "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false";
  $lat=round($lat,4);
  $long=round($long,4);
  //recherche dans a base de cache
  $sql="select * from ".__racinebd__."addresscache where latitude='".$lat."' and longitude='".$long."'";
  $link=query($sql);
  if(num_rows($link)==0){
    $data = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false"));
    //$data = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$long."&sensor=false&client=".__googlekey__));
    //print_r($data);
    if($data->status == "OK") {
      if(count($data->results)) {
          foreach($data->results as $result) {
              $address=$result->formatted_address;
              $sql="insert into ".__racinebd__."addresscache (latitude,longitude,address) values('".$lat."','".$long."','".addslashes($address)."')";
              query($sql);
              return $address;
          }
      }
    } else {
        // error
    }
  }else{
    $tbl=fetch($link);
    return $tbl["address"];
  }
}
 
function getsqllistvehicule(){
  $sql= "select *,pd.device_id as phantom_device_id,d.id as traccar_device_id from 
                  ".__racinebd__."compte c
                  inner join ".__racinebd__."device pd on pd.compte_id=c.compte_id
                  inner join devices d on pd.devices_id=d.id
                  inner join positions p on p.id=d.latestPosition_id
                  left join ".__racinebd__."categorie_compte_device ccd on pd.device_id=ccd.device_id 
                  where pd.supprimer=0 and c.compte_id=".$_SESSION["compte_id"]." ".$_SESSION["filtrevehicule"]." ".$_SESSION["filtreagence"];  
  return $sql;
}

function getsqllistvehiculerapport($where){
  return "select *,pd.device_id as phantom_device_id from 
                  ".__racinebd__."compte c
                  inner join ".__racinebd__."device pd on pd.compte_id=c.compte_id
                  inner join devices d on pd.devices_id=d.id
                  inner join positions p on p.device_id=d.id and p.valid=1
                  left join ".__racinebd__."categorie_compte_device ccd on pd.device_id=ccd.device_id 
                  where pd.supprimer=0 and c.compte_id=".$_SESSION["compte_id"]." ".$_SESSION["filtrevehicule"]." ".$_SESSION["filtreagence"]." ".$where."
                  order by pd.device_id,p.time ASC";
/*
  return "select *,pd.device_id as phantom_device_id,round(sum(ti.total_distance)/1000) as km,min(addtime(min_time_stamp,'".__decalageheure__.":0:0')) as mintime,max(addtime(max_time_stamp,'".__decalageheure__.":0:0')) as maxtime from users t                   
                  inner join ".__racinebd__."compte c on c.application_id=t.original_application_id
                  inner join device d on d.owner_id=t.user_id
                  inner join ".__racinebd__."device pd on pd.owner_id=t.user_id
                  inner join user_template ut on ut.user_template_id=t.user_template_id	 and ut.application_id=c.application_id and template_name='Device'
                  left join track_info_mod ti on ti.owner_id=t.user_id and total_distance is not null $where
                  where t.active=1 and c.application_id=".$_SESSION["application_id"]." ".$_SESSION["filtrevehicule"]." ".$_SESSION["filtreagence"];
*/
}

function getsqllistboitier(){
  $sql= "select *,pd.device_id as phantom_device_id from 
                  ".__racinebd__."compte c
                  inner join ".__racinebd__."device pd on pd.compte_id=c.compte_id
                  inner join devices d on pd.devices_id=d.id
                  where pd.supprimer=0 and c.compte_id=".$_SESSION["compte_id"]." ".$_SESSION["filtrevehicule"]." ".$_SESSION["filtreagence"];  
  return $sql;
  /*
  return "select * from users t 
                  inner join ".__racinebd__."compte c on c.application_id=t.original_application_id
                  inner join device d on d.owner_id=t.user_id
                  inner join user_template ut on ut.user_template_id=t.user_template_id	 and ut.application_id=c.application_id and template_name='Device' 
                  where t.active=1 and c.application_id=".$_SESSION["application_id"];
  */
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}
function vitessekmh($val){
  //return round($val*3.6,2);
  return round($val*1.852,2);
}
function inversevitessekmh($val){
  //return round($val*3.6,2);
  return round($val/1.852,2);
}
function vitessems($val){
  return $val/3.6;
}
function afficheheure($val){
  $tab=explode(" ",$val);
  return $tab[1];
}

function date2tab($madate){
  //return substr($madate,6,4)."-".substr($madate,3,2)."-".substr($madate,0,2);
  $today[mon]=substr($madate,3,2); 
	$today[mday]=substr($madate,0,2); 
	$today[year]=substr($madate,6,4);
  return $today;
}
function date2week($madate){
  //print mktime (0, 0, 0, substr($madate,3,2), substr($madate,0,2), substr($madate,6,4) );
  return date("W",mktime (0, 0, 0, substr($madate,3,2), substr($madate,0,2), substr($madate,6,4) ))." - ".substr($madate,6,4);
}
function date2month($madate){
  //print mktime (0, 0, 0, substr($madate,3,2), substr($madate,0,2), substr($madate,6,4) );
  return moisfr(substr($madate,3,2)*1)." - ".substr($madate,6,4);
}
function jourdebutmois($madate){
  //return date("Y-m-d H:i:s", mktime(0,0,0,substr($madate,3,2)-1,1,substr($madate,6,4)));
  return date("d-m-Y", mktime(0,0,0,substr($madate,3,2),1,substr($madate,6,4)));
}
function jourfinmois($madate){
  return date("d-m-Y", mktime(0,0,0,substr($madate,3,2)+1,0,substr($madate,6,4)));
}
function verifdroit($shortright){
  $myreturn=false;
  for($i=0;$i<count($_SESSION["tabdroitmodule"]);$i++){
    if($_SESSION["tabdroitmodule"][$i]["shortright"]==$shortright){
      $myreturn=true;
      break;
    }
  }
  return $myreturn;
}
function verifdroitid($id){
  $myreturn=false;
  for($i=0;$i<count($_SESSION["tabdroitmodule"]);$i++){
    if($_SESSION["tabdroitmodule"][$i]["module_id"]==$id){
      $myreturn=true;
      break;
    }
  }
  return $myreturn;
}

/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function haversineGreatCircleDistance(
  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $latDelta = $latTo - $latFrom;
  $lonDelta = $lonTo - $lonFrom;

  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
  return $angle * $earthRadius;
}

function showexport($template,$menu,$champs){
  if(testoption("ECSV")){
  if(verifdroit("EXP")){?>
    <a href="<?=__racineweb__?>/tpl/script/export.php?template=<?=$template?>&args=<?=implodeargskey($_POST)?>&menu=<?=implodeargs($menu)?>&champs=<?=implodeargs($champs)?>"><img src="<?=__racineweb__?>/tpl/img/telecharger_ico.png"></a>
  <?}
  }
}
function implodeargskey($myarray){
  $returnval= array();
  foreach ($myarray as $key => $value){
    $returnval[]=$key."|".$value;
  }
  if(count($returnval)>0){
    return urlencode(implode(",",$returnval));
  }else{
    return "";
  }
}
function implodeargs($myarray){ 
  if(count($myarray)>0){
    return urlencode(implode(",",$myarray));
  }else{
    return "";
  }
}
function exportexcel($template,$args,$menu,$champs){

  require_once($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/phpexcel/Classes/PHPExcel.php");
  require_once($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/phpexcel/Classes/PHPExcel/Writer/Excel2007.php");
  $debutligne=5;
  $objPHPExcel = new PHPExcel();

  $styleArrayTitre = array(
  	'font' => array(
  		'bold' => true,
      'name' => 'Arial',
      'size' => '12',
  	),
  	'alignment' => array(
  		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  	),
  	'borders' => array(
  		'outline' => array(
  			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
        'color' => array(
          'argb' => '00000000'      
  		  ),    
      ),
      'inside' => array(
  			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
        'color' => array(
          'argb' => '00000000'      
  		  ),
      ),
  	),
  	'fill' => array(
  		'type' => PHPExcel_Style_Fill::FILL_SOLID,
  		'startcolor' => array(
  			'argb' => 'FFA0A0A0',
  		),
  	),
  );
  $styleArray = array(
  	'font' => array(
  		'bold' => false,
      'name' => 'Arial',
      'size' => '12',
  	),
  	'alignment' => array(
  		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  	),
  	'borders' => array(
  		'outline' => array(
  			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
        'color' => array(
          'argb' => '00000000'      
  		  ),    
      ),
      'inside' => array(
  			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
        'color' => array(
          'argb' => '00000000'      
  		  ),
      ),
  	),
  );
  //– Quelques propriétées
  $objPHPExcel->getProperties()->setCreator("MisterFleet");
  $objPHPExcel->getProperties()->setLastModifiedBy("MisterFleet");
  $objPHPExcel->getProperties()->setTitle("MisterFleet - Export");
  $objPHPExcel->getProperties()->setSubject("MisterFleet - Export");
  $objPHPExcel->getProperties()->setDescription("MisterFleet - Export (".$template.")- ".date("Y-m-d H:i:s"));
  //– Les Données
  $objPHPExcel->setActiveSheetIndex(0);
  
  args2post($args);
  $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Rapport : ');
  $objPHPExcel->getActiveSheet()->SetCellValue('C1', $template." ".date("Y-m-d H:i:s"));
  
  if(array_key_exists("agence",$_POST)||$_POST["vehicule"]==""){
    $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Agence : ');
    if($_POST["agence"]==""){
    $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Toutes');  
    }else{
    //recherche de l'agence en cour
    $sql="select * from ".__racinebd__."agence_compte where agence_compte_id=".$_POST["agence"];
    $link_agence=query($sql);
    $tbl_agence=fetch($link_agence);
    $objPHPExcel->getActiveSheet()->SetCellValue('C2',$tbl_agence["libelle"]);
    }  
  }else{
    $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Véhicule : ');
    //recherche de l'agence en cour
    $sql="select * from ".__racinebd__."device where device_id=".$_POST["vehicule"];
    $link_vehicule=query($sql);
    $tbl_vehicule=fetch($link_vehicule);
    $objPHPExcel->getActiveSheet()->SetCellValue('C2',$tbl_vehicule["nomvehicule"]);  
  }
  if($_POST["date_jour"]!=""){
    $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Date : ');
    $objPHPExcel->getActiveSheet()->SetCellValue('C3', $_POST["date_jour"]);  
  }
  if($_POST["date_debut"]!=""){
    $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Date début : ');
    if(strlen($_POST["date_debut"]." ".$_POST["heure_debut"])>20){
    $objPHPExcel->getActiveSheet()->SetCellValue('C3', substr($_POST["date_debut"]." ".$_POST["heure_debut"],0,20)); 
    }else{
    $objPHPExcel->getActiveSheet()->SetCellValue('C3', $_POST["date_debut"]." ".$_POST["heure_debut"]); 
    } 
  }
  if($_POST["date_fin"]!=""){
    $objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Date fin : ');
    if(strlen($_POST["date_fin"]." ".$_POST["heure_fin"])>20){
    $objPHPExcel->getActiveSheet()->SetCellValue('C4', substr($_POST["date_fin"]." ".$_POST["heure_fin"],0,20)); 
    }else{
    $objPHPExcel->getActiveSheet()->SetCellValue('C4', $_POST["date_fin"]." ".$_POST["heure_fin"]);
    } 
  }
  /*
  $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Rapport : ');
  $objPHPExcel->getActiveSheet()->SetCellValue('C1', $template." ".date("Y-m-d H:i:s"));
  */
  
  //creation du menu
  if(is_array($menu)){
    $tabmenu=$menu;
  }else{
    $tabmenu=explode(",",$menu);
  }
  for($i=0;$i<count($tabmenu);$i++){
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i+1,$debutligne, $tabmenu[$i]);
  }
  //affectation du style
  $objPHPExcel->getActiveSheet()->getStyle("B".$debutligne.":".getNameFromNumber($i).$debutligne)->applyFromArray($styleArrayTitre);
  

  if($template=="situation"){
    require($_SERVER["DOCUMENT_ROOT"].__racine__."/tpl/script/situation.php");
  }else{
    //print $_SERVER["DOCUMENT_ROOT"].__racine__."/tpl/script/rapport-".$template.".php<br>";
    require($_SERVER["DOCUMENT_ROOT"].__racine__."/tpl/script/rapport-".$template.".php");
  }
  if(is_array($champs)){
    $tabchamps=$champs;
  }else{
    $tabchamps=explode(",",$champs);
  }   
  //print_r($tbl_list_export);
  if(is_array($semaine)){
    $i=0;
    foreach ($semaine as $key => $val){
      for($j=0;$j<count($tabchamps);$j++){
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j+1,$i+$debutligne+1, strip_tags(br2nl($val[$tabchamps[$j]])));
      }
      $i++;
    }
  }else{
    for($i=0;$i<count($tbl_list_export);$i++){
      for($j=0;$j<count($tabchamps);$j++){
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j+1,$i+$debutligne+1, strip_tags(br2nl($tbl_list_export[$i][$tabchamps[$j]])));
      }
    }  
  }
  foreach(range('B',getNameFromNumber(count($tabmenu))) as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
  }

  
  for($k=$debutligne+1;$k<$i+$debutligne+1;$k++) {      
    $objPHPExcel->getActiveSheet()->getRowDimension($k)->setRowHeight(30);  
  } 
  //affectation du style
  $objPHPExcel->getActiveSheet()->getStyle("B".($debutligne+1).":".getNameFromNumber($j).($i+$debutligne))->applyFromArray($styleArray);
  //– On sauvegarde notre fichier (Format Excel 2007)
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  //on verifie si le compte possède déjà un répertoire
  if($_SESSION["compte_id"]!=""){
    $dir=$_SERVER["DOCUMENT_ROOT"].__uploaddir__."compte".$_SESSION["compte_id"];
  }else{
    $dir=$_SERVER["DOCUMENT_ROOT"].__uploaddir__."compte".$_POST["compte_id"];
  }
  if (!file_exists($dir) && !is_dir($dir)) {
    mkdir($dir);         
  } 
  $filename="Export-".str_replace(" ","-",$template)."-".date("Y-m-d_H-i-s").".xlsx";
  $file=$dir.$filename;
  $objWriter->save($file);
  return array($file,$filename);
  
}
function args2post($args){
  $tabargs=explode(",",$args);
  for($i=0;$i<count($tabargs);$i++){
    $tab=explode("|",$tabargs[$i]);
    $_POST[$tab[0]]=$tab[1];  
  }
}
function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}
function br2nl($foo) {
  return preg_replace("/\<br\s*\/?\>/i", "\n", $foo);
}
function sendmailmister($exp='',$expname='',$subject='',$html='',$dest='',$rep='',$tblfile=array()){
  if(count($tblfile)>0){
    sendmail($exp,$expname,$subject,$html,$dest,$rep,array($tblfile));
  }else{
    sendmail($exp,$expname,$subject,$html,$dest);
  }
}
function secondsToTime($seconds) {
    $dtF = new DateTime("@0");
    $dtT = new DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a jours, %h H, %i Min');
}
function secondsToTime2($seconds) {
    $dtF = new DateTime("@0");
    $dtT = new DateTime("@$seconds");
    return str_replace("0 jours, ","",$dtF->diff($dtT)->format('%a jours, %h H, %i Min'));
}
/*
function deleteCompteDevice($id){
  $sql="select * from ".__racinebd__."device where compte_id=".$id;
  $link=query($sql);
  while($tbl=fetch($link)){
    deleteDevice($tbl["device_id"]);
  }
}
function deleteDevice($id){
  $sql="update ".__racinebd__."device set supprimer=1 where device_id='".$_GET["id"]."'";
  query($sql);
  $sql="select devices_id from ".__racinebd__."device where device_id='".$_GET["id"]."'";
  $link=query($sql);
  $tbl=fetch($link);
  $sql="delete from devices where id='".$tbl["devices_id"]."'";
  query($sql);
  $sql="delete from positions where device_id='".$tbl["devices_id"]."'";
  query($sql);
  //prevoir un archivage des datas
}  */
/*
function get_distance_m($lat1, $lng1, $lat2, $lng2) {
  $earth_radius = 6378137;   // Terre = sphère de 6378km de rayon
  $rlo1 = deg2rad($lng1);
  $rla1 = deg2rad($lat1);
  $rlo2 = deg2rad($lng2);
  $rla2 = deg2rad($lat2);
  $dlo = ($rlo2 - $rlo1) / 2;
  $dla = ($rla2 - $rla1) / 2;
  $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo
));
  $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
  return ($earth_radius * $d);
} */
function getCoordonnees($adresse){
    $timestamp=time();
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($adresse)."&sensor=true&".$timestamp;
    //print $url."<br>";
    $json = file_get_contents($url);
    $donnees = json_decode($json);
    //print $url."<br>";

   
 try{
      if ($donnees -> status != "OK") {
        //die;
        return array("0","0",$donnees);
      }else {
          return array($donnees -> results[0] ->geometry -> location ->lat,$donnees -> results[0] ->geometry -> location ->lng,$donnees);
      }
    }catch(Exception $e){
    }

}

function archivecompte($compte_id){
  $sql="select * from ".__racinebd__."device where compte_id=".$compte_id;
  $link=query($sql);
  while($tbl=fetch($link)){
    $sql="update ".__racinebd__."device set supprimer=1 where device_id='".$_GET["id"]."'";
    query($sql);
    archivedevice($tbl["devices_id"]);
  }
} 


function archivedevice($device_id){
  $sql="select p.*,d.compte_id from positions p inner join
    ".__racinebd__."device d on d.device_id=p.device_id 
    where d.device_id='".$device_id."' order by compte_id,p.device_id";
  //print $sql;
  $lastdevice=0;
  $content="";
  $link_archive=query($sql);
  $tabcontent=array();
  while($tbl_archive=fetch($link_archive)){
    $tabcontent[$tbl_archive["compte_id"]][$tbl_archive["device_id"]].="insert into positions (address,altitude,course,latitude,longitude,other,power,speed,time,valid,device_id) 
      values ('".$tbl_archive["address"]."','".$tbl_archive["altitude"]."','".$tbl_archive["course"]."','".$tbl_archive["latitude"]."','".$tbl_archive["longitude"]."',
      '".$tbl_archive["other"]."','".$tbl_archive["power"]."','".$tbl_archive["speed"]."','".$tbl_archive["time"]."','".$tbl_archive["valid"]."',
      '".$tbl_archive["device_id"]."');\n";   
     //print $content;
  }
  
  foreach ($tabcontent as $key => $value){
    foreach ($value as $key2 => $value2){
      $dir= $_SERVER["DOCUMENT_ROOT"].__racine__."/archive/".$key."/".$key2;
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
  
  $sql="delete from positions where device_id='".$device_id."'";
  query($sql);
  
  $sql="delete from users_devices where devices_id='".$device_id."'";
  query($sql);
  
  $sql="delete from devices where id='".$device_id."'";
  query($sql);
  
}
function testoption($shortcut){
  if(is_array($_SESSION["tabdroitoption"])){
    return in_array($shortcut,$_SESSION["tabdroitoption"]);
  }else{
    return false;
  }
}
?>
      