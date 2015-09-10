<?
require("class_rules.php");
require("config.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

require(dirname(__FILE__)."/../custom/config.php");
require(__bddtype__.".php");
require("connexion.php");
if(file_exists($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/function.php")){
  require($_SERVER["DOCUMENT_ROOT"].__racineadminmenu__."/function.php");
}
require("function_arbre.php");
require("function_arbre2.php");
require("function_cache.php");
require("function_image.php");
require("function_captcha.php");
require("function_xml.php");
require("function_search.php");
require("mp3file.php");
require($_SERVER["DOCUMENT_ROOT"].__racineadminlib__."/html2pdf/html2pdf.class.php");
require($_SERVER["DOCUMENT_ROOT"].__racineadminlib__."/PHPMailer/class.phpmailer.php");
require($_SERVER["DOCUMENT_ROOT"].__racineadminlib__.'/acidcrop/asido/class.asido.php');

session_start();

if(!__light__){
  //vérification des publications/dépublication
  //publication
  $sql="select * from ".__racinebd__."arbre where datepublication<now() and datepublication!='0000-00-00 00:00:00'";
  $link=query($sql);
  while($tbl=fetch($link)){
    $sql="update ".__racinebd__."arbre set datepublication='0000-00-00 00:00:00', etat_id=1 where arbre_id=".$tbl["arbre_id"];
    query($sql);
  }
  //depublication
  $sql="select * from ".__racinebd__."arbre where datedepublication<now() and datedepublication!='0000-00-00 00:00:00'";
  $link=query($sql);
  while($tbl=fetch($link)){
    $sql="update ".__racinebd__."arbre set datedepublication='0000-00-00 00:00:00', etat_id=2 where arbre_id=".$tbl["arbre_id"];
    query($sql);
  }
}

define("LATIN1_UC_CHARS", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ");
define("LATIN1_LC_CHARS", "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý");
function identification($login_user,$mdp_user,$langue){
  if($login_user!=""&&$mdp_user!=""){
    if($login_user==__user__ && $mdp_user==__pwd__){
  		$_SESSION['users_id']=-1;
  		$_SESSION['obj_users_id']=new class_rules(-1);
  		$_SESSION['islog']=1;
  		$_SESSION['langue']=$langue;
      return true;
  	}else{
    	$requete = "SELECT users_id,login,mdp FROM ".__racinebd__."users WHERE login = '$login_user' and supprimer=0";
    	$result = query($requete);
    	$nombre = num_rows($result);
    
    	if($result > 0){
    		$ligne=fetch($result);
    		$users_id = $ligne["users_id"];
    		$login = $ligne["login"];
    		$mdp = $ligne["mdp"];    		
    		if($mdp == $mdp_user){
    			session_start();
    			$_SESSION["users_id"] = $users_id;
    			$_SESSION["obj_users_id"] = new class_rules($users_id,$ligne);
    			$_SESSION['islog']=1;
          $_SESSION['langue']=$langue;
    			return true;
    		} else {
    			return "Non";
    		}
    	} else {
    		return 'Non';
    	}
    }
	} else {
  		return 'Non';
  }
}
function convertWordChar($montexte){
   	return str_replace("\n","",str_replace("’","'",str_replace("…","...",$montexte)));
}
function cutWord($texte,$maxsizecarac=__maxsizecarac__)
{
	if((strlen($texte)>$maxsizecarac))
	{
	 		$texte = strip_tags($texte,'<strong>');
	 		//print "/.".$texte."./";
			$tab = split(" ",$texte);
			$tmptexte = "";
			
			for($i=0;$i<count($tab);$i++){
				if((strlen($tmptexte.$tab[$i])>$maxsizecarac)){
					break;
				}
				$tmptexte .= $tab[$i]." ";
			}
			return $tmptexte."...";
	} else {
			return strip_tags($texte);
	}
}
function dayOfWeek($timestamp) { 
	$maval=intval(strftime("%w",$timestamp));
if($maval==0) 
 	return 7;
else
 	return $maval;
}
function raccourcirChaine($chaine, $tailleMax)
{
$positionDernierEspace = 0;
if( strlen($chaine) >= $tailleMax )
{
$chaine = substr($chaine,0,$tailleMax);
$positionDernierEspace = strrpos($chaine,' ');
$chaine = substr($chaine,0,$positionDernierEspace).'...';
}
return $chaine;
}
function jourdebutsemaine($today)
{
	$month = $today[mon]; 
	$mday = $today[mday]; 
	$year = $today[year];
	$tsp=mktime (0,0,0,$month, $mday-dayOfWeek(mktime (0,0,0,$month,$mday,$year))+1, $year); 
	return $lbonnedate = strftime ("%d-%m-%Y",$tsp); 
} 
function jourfinsemaine($today)
{
	$month = $today[mon]; 
	$mday = $today[mday]; 
	$year = $today[year];
	$tsp=mktime (0,0,0,$month, $mday-dayOfWeek(mktime (0,0,0,$month,$mday,$year))+7, $year); 
	return $lbonnedate = strftime ("%d-%m-%Y",$tsp); 
}
function datebdd($madate)
{
	/*$tsp=mktime (0,0,0,substr($madate,4,5),substr($madate,0,2),substr($madate,7,10)); 
	return $lbonnedate = strftime ("%Y-%m-%d",$tsp); */
	return substr($madate,6,4)."-".substr($madate,3,2)."-".substr($madate,0,2);
}
function datetimebdd($madate)
{
	/*$tsp=mktime (0,0,0,substr($madate,4,5),substr($madate,0,2),substr($madate,7,10)); 
	return $lbonnedate = strftime ("%Y-%m-%d",$tsp); */
	return substr($madate,6,4)."-".substr($madate,3,2)."-".substr($madate,0,2)." ".substr($madate,11,5).":00";
}
function affichedateiso($madate)
{
  if($madate!=""){
	//$tsp=$tsp=mktime (0,0,0,substr($madate,5,2),substr($madate,8,2),substr($madate,0,4)); 
	//return $lbonnedate = strftime ("%d/%m/%Y",$tsp);
	return substr($madate,8,2)."/".substr($madate,5,2)."/".substr($madate,0,4);
	}else{
	return "";
	}
}
function affichedatetime($madate)
{
  if($madate!=""){
	return substr($madate,8,2)."/".substr($madate,5,2)."/".substr($madate,0,4)." ".substr($madate,11,5);
	}else{
	return "";
	}
}
function moisfr($indice,$langue=__defaultlangueid__){
 
  $tabmois[1]=trad("janvier",$langue);
  $tabmois[2]=trad("février",$langue);
  $tabmois[3]=trad("mars",$langue);
  $tabmois[4]=trad("avril",$langue);
  $tabmois[5]=trad("mai",$langue);
  $tabmois[6]=trad("juin",$langue);
  $tabmois[7]=trad("juillet",$langue);
  $tabmois[8]=trad("août",$langue);
  $tabmois[9]=trad("septembre",$langue);
  $tabmois[10]=trad("octobre",$langue);
  $tabmois[11]=trad("novembre",$langue);
  $tabmois[12]=trad("décembre",$langue);

  return $tabmois[$indice];
}
function jourfr($indice,$langue=__defaultlangueid__){
  $tabjourfr_2[0]=trad("Lundi",$langue);
  $tabjourfr_2[1]=trad("Mardi",$langue);
  $tabjourfr_2[2]=trad("Mercredi",$langue);
  $tabjourfr_2[3]=trad("Jeudi",$langue);
  $tabjourfr_2[4]=trad("Vendredi",$langue);
  $tabjourfr_2[5]=trad("Samedi",$langue);
  $tabjourfr_2[6]=trad("Dimanche",$langue);
  return $tabjourfr_2[$indice];
}
function affichedateshort($madate,$langue=__defaultlangueid__)
{
  //print $madate;
  if($madate!=""){
	$m=substr($madate,5,2);
	$j=substr($madate,8,2);
	$a=substr($madate,0,4);
	$h=substr($madate,11,5);
	//return  $j." ".moisfr((int)$m,$langue)." ".$a; 
	return  $j."&nbsp;".moisfr((int)$m,$langue)."&nbsp;".$a;
	}else{
	return "";
	}
}
function affichedate($madate,$langue=__defaultlangueid__)
{
  if($madate!=""){
	$m=substr($madate,5,2);
	$j=substr($madate,8,2);
	$a=substr($madate,0,4);
	$h=substr($madate,11,5);
	return  $j." ".moisfr((int)$m,$langue)." ".$a.(($h!="")?" ".$h:""); 
	}else{
	return "";
	}
}
function affichedateFin($madate,$duree) {
	if($madate!=""){
	//$tsp=$tsp=mktime (0,0,0,substr($madate,5,2),substr($madate,8,2),substr($madate,0,4)); 
	//return $lbonnedate = strftime ("%d/%m/%Y",$tsp);
	$mois = substr($madate,5,2);
	$jour =(substr($madate,8,2))+($duree-1);
	$annee =  substr($madate,0,4);
	return $lbonnedate = date("d/m/Y", mktime(0, 0, 0, $mois, $jour,$annee));
	}else{
	return "";
	}
}
function affichedateheure($madate)
{
	@setlocale("LC_TIME","fr_FR"); 
	$tsp=$tsp=mktime (substr($madate,11,2),substr($madate,14,2),0,substr($madate,5,2),substr($madate,8,2),substr($madate,0,4)); 
	return $lbonnedate = strftime ("%d-%B-%Y %H:%M",$tsp); 
	//return substr($madate,8,2)."-".substr($madate,5,2)."-".substr($madate,0,4);
}
function requetesql2($default)
{
global $coltri;
if($coltri=="")
{
	$coltri=$default;
}
return " order by $coltri";
}

function metzero($val){
	return ($val<10)?"0".$val:$val;
}

function orderby2($nomcol,$libelle)
{
$coltri=$_GET["coltri"];
$order=$_GET["order"];
$url=str_replace("coltri=$coltri","",$_SERVER["QUERY_STRING"]);
$url=str_replace("&order=$order&","",$url);
$monorder="desc";
	if($coltri==$nomcol)
	{
		if($order=="desc")
		{
			$monorder="asc";
			$order2="ui-icon-triangle-1-n";
		}
		else
		{
			$order2="ui-icon-triangle-1-s";
			$monorder="desc";
		}
	}
	print "<div class=\"DataTables_sort_wrapper\"><a href='".$_SERVER["PHP_SELF"]."?coltri=$nomcol&order=$monorder&$url' target='framecontent'>$libelle</a>";
	if($coltri==$nomcol)
		//print "&nbsp&nbsp&nbsp<img src=\"".__racineadmin__."/images/new/fleche_".$order.".jpg\">";
		print "<span class=\"DataTables_sort_icon css_right ui-icon ".$order2."\" style=\"display: inline-block;margin-left: 1em;position: relative;top: 4px;\"></span></div>";
}

function requetesql($default,$defaulttri)
{
$coltri=$_GET["coltri"];
$order=$_GET["order"];
if($coltri=="")
{
	$coltri=$default;
	$order=$defaulttri;
	$_GET["coltri"]=$coltri;
	$_GET["order"]=$order;
}
return " order by $coltri $order";
}
function formatdecimal($val){
				 return nombrestyle($val,'liennoirbis');
}
function commapoint($montant){
				 return str_replace(",",".",$montant);
}
function uppertags($html){
  return stripslashes(preg_replace("/(<\/?)(\w+)([^>]*>)/e", "'\\1'.strtoupper('\\2\\3')", $html));
}		
function pourcentage($nb,$total){
	if($total!=0) 
	return round($nb*100/$total,2);
	else 
	return 0;
}
function pagination($numrows)
{
	$QUERY_STRING= $_SERVER["QUERY_STRING"];
	$PHP_SELF= $_SERVER["PHP_SELF"];
	global $nbelemparpage,$front;
	$debut= (int)$_GET["debut"];
	$url=str_replace("debut=".$debut."&","",$QUERY_STRING);
	$url=str_replace("debut=$debut","",$url);
	//print $numrows;
	if ($nbelemparpage==0) {
	$nb=0;
	}
	if ($nbelemparpage!=0) {
  	$nb =ceil($numrows/$nbelemparpage);
	}
   if($debut!=0){
			 print " <A HREF='".$PHP_SELF."?debut=".($debut-$nbelemparpage)."&$url' target='framecontent' class=\"prev\">&lt;</A>";
   }
   if(__maxelempagin__<$nb){
	   $start=(($debut/$nbelemparpage)<round(__maxelempagin__/2))?1:round($debut/$nbelemparpage)-1;
      $stop=($start+__maxelempagin__>$nb)?$nb+1:$start+__maxelempagin__;
      $start=($stop==$nb+1)?$nb-__maxelempagin__+1:$start;
   }else{
   	$start=1;
      $stop=$nb;
   }
  	for($i=$start;$i<=$stop;$i++)
  	{
    	if(($i-1)*$nbelemparpage==$debut){
  	  			print "<a href=\"javascript:;\" class=\"selected\">".$i."</a>";
    	}else{
    			$val=($i-1)*$nbelemparpage;
      		print " <A HREF='".$PHP_SELF."?debut=".$val."&$url' target='framecontent'>".$i."</A>";
      }
    	if($i!=$stop)
    		print "";
	}
   if($debut!=($nb-1)*$nbelemparpage&&$nb!=0){
			 print " <A HREF='".$PHP_SELF."?debut=".($debut+$nbelemparpage)."&$url' target='framecontent' class=\"next\">&gt;</A>";
   }
}
function value_print($myvalue){
	return $myvalue;
}
function addquote($mystring){
    if (!get_magic_quotes_gpc()) {
       return addslashes($mystring);
    } else {
       return $mystring;
    }
}
function affichemedia($id,$ext,$table,$mini=0){
  
  //$timestamp="?".mktime();
  $timestamp="?".time();
	 if ($table=="animated_banner") {
	 		print "<img src=\"".__uploaddir__.$table.$id.".gif\">";
	 } else  if($ext!=""&&$_GET["mode"]!="list"){
	       
        $size=getimagesize ($_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.'.'.$ext);
        $mysize=($mini==1)?"width=50 height=50":$size[3];
        //print $size[2];
        if($ext=="mp3"){
          ?>
          <object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="200" height="24">
        		<param name="movie" value="<?=__racine__?>/tpl/images/player-viral.swf" />
        		<param name="allowfullscreen" value="true" />
        		<param name="allowscriptaccess" value="always" />
        		<param name="flashvars" value="file=<?=__uploaddir__.$table.$id.".".$ext.$timestamp?>" />
        		<embed
        			type="application/x-shockwave-flash"
        			id="player2"
        			name="player2"
        			src="<?=__racine__?>/tpl/images/player-viral.swf" 
        			width="200" 
        			height="24"
        			allowscriptaccess="always" 
        			allowfullscreen="true"
        			flashvars="file=<?=__uploaddir__.$table.$id.".".$ext.$timestamp?>" 
        		/>
        	</object>
          <?
        }else{
        //print $size[2];
        switch($size[2]){
        case 4 :
        //flash
        				print '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,30,0" '.$mysize.'>
                    		<param name=movie value="'.__uploaddir__.$table.$id.".".$ext.$timestamp.'">
                    		<param name=quality value=high>
                    		<param name="BGCOLOR" value="#EEEEEE">
                    		<param name="salign" value="tl">
                    		<param name="menu" value="0">
                    		<embed src="'.__uploaddir__.$table.$id.".".$ext.$timestamp.'" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" '.$mysize.' bgcolor="#EEEEEE" salign="tl" menu="0"></embed>
                    		</object>';
        break;
        case 1 :
        case 2 :
        case 3 :
        //image
        	//print "<img src=\"".__uploaddir__."tbl".$table.$id.".".$ext."\">";
  	      $size=getimagesize ($_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.'.'.$ext);
	       	$mysize=($size[0]>470)?"width=460":"";
	       	
         print "<img src=\"".__uploaddir__.$table.$id.".".$ext.$timestamp."\" $mysize>";
         /*
         if($mini)
         print "<img src=\"".__racine__."/thumbGen.php?media_id=$id&type=1\" $mysize />";
         else
         print "<img src=\"".__racine__."/thumbGen.php?media_id=$id&type=2\" />";
         */
        break;
        default :
        print "<a href=\"".__uploaddir__.$table.$id.".".$ext."\" target=\"_blank\"><img src=\"../images/new/document.gif\" width=\"39\" width=\"48\" border=\"0\"></a>";
     	}
     	}
   }else if($_GET["mode"]=="list"){
					$tbl_result=$GLOBALS["tbl_result"];
					//print_r($tbl_result);
					$imgprin=$GLOBALS["imgprin"];
					$ext=$tbl_result[$imgprin];
					//print $ext;
					if($ext==""){
					print "<a href=\"".__uploaddir__.$table.$id.".jpg\"><img src=\"".__uploaddir__.$table.$id.".jpg.".$timestamp."\" width=\"40\" border=\"0\"></a>";
					}else{
					print "<a href=\"".__uploaddir__.$table.$id.".".$ext."\"><img src=\"".__uploaddir__.$table.$id.".".$ext.$timestamp."\" width=\"40\" border=\"0\"></a>";
					}   	
   }
}
function affichemedia2($fichier){
  	if($fichier!="")
   print "<a href=\"".__uploaddir__.$fichier."\"><img src=\"../images/new/document.gif\" width=\"39\" width=\"48\" border=\"0\"></a>";
}
function affichemediaimg($fichier){
    if($fichier!=""){
      
      if(file_exists($_SERVER["DOCUMENT_ROOT"].__uploaddir__.$fichier))
        print "<a href=\"".__uploaddir__.$fichier."\" target=\"_blank\"><img src=\"".__uploaddir__.$fichier."?".time()."\" width=\"40\" border=\"0\"></a>";
    }
}
function getext($myfile) {
	$myext = strtolower(substr($myfile, strrpos($myfile,".")+ 1));
   return $myext; 
}
function embed_images($body)
{
    // get all img tags
    preg_match_all('/<img.*?>/', $body, $matches);
    if (!isset($matches[0])) return;
    $i = 1;
    foreach ($matches[0] as $img)
    {
        $id = 'img'.($i++);
        // replace image web path with local path
        preg_match('/src="(.*?)"/', $img, $m);
        if (!isset($m[1])) continue;
        $arr = parse_url($m[1]);
        if (!isset($arr['host']) || !isset($arr['path']))continue;
        // add
        $this->AddEmbeddedImage('images'.$arr['path'], $id, 'attachment', 'base64', 'image/'.getext($arr['path']));
        $body = str_replace($img, '<img alt="" src="cid:'.$id.'" style="border: none;" />', $body); 
    }
    return $body;
} 
function tbl_img($table,$id,$ext,$width,$height,$vignette=false,$indice=''){
  $newname=($vignette==true)?$_SERVER["DOCUMENT_ROOT"].__uploaddir__."tbl_".$indice.$table.$id.".".$ext:$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.".".$ext;
	//resizeImg($_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.".".$ext,$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.".".$ext,$width,$height);
	//smart_resize_image( $_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.".".$ext, $width, $height, true, $newname,!$vignette);
	//print "<script>alert('".$table."ici')";
	$return=smart_resize_image( $_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.".".$ext, $width, $height, false, $newname,!$vignette);
	//print "<script>alert('".$return."fin')";
}
function smart_resize_image( $file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false )
{
//print "<script>alert('".$file."')</script>";
  //print "ici";
 
    if ( $height <= 0 && $width <= 0 ) {
      return false;
    }
    if($height != "18" && $width != "18"){
            //print "<script>alert('dedant')<script>";
            $info = getimagesize($file);
            $image = '';
         
            $final_width = 0;
            $final_height = 0;
            list($width_old, $height_old) = $info;
         
            //if ($proportional) {
              if ($width == 0) $factor = $height/$height_old;
              elseif ($height == 0) $factor = $width/$width_old;
              //else $factor = min ( $width / $width_old, $height / $height_old);   
              elseif($proportional) $factor = min ( $width / $width_old, $height / $height_old);
              else  $factor = max ( $width / $width_old, $height / $height_old);
         
              $final_width = round ($width_old * $factor);
              $final_height = round ($height_old * $factor);
         
            //}
            /*
            else {
              //imagecopyresized($cropimg, $origimg, 0, 0, $cropStartX, $cropStartY, $width, $height, $width, $height);
              $final_width = ( $width <= 0 ) ? $width_old : $width;
              $final_height = ( $height <= 0 ) ? $height_old : $height;
            }*/
         
            switch ( $info[2] ) {
              case IMAGETYPE_GIF:
                $image = imagecreatefromgif($file);
              break;
              case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($file);
              break;
              case IMAGETYPE_PNG:
                $image = imagecreatefrompng($file);
              break;
              default:
                return false;
            }
            
            $image_resized = imagecreatetruecolor( $final_width, $final_height );
         
            if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
              //print "transparent";
              $trnprt_indx = imagecolortransparent($image);
              
              // If we have a specific transparent color
              if ($trnprt_indx >= 0) {
         
                // Get the original image's transparent color's RGB values
                $trnprt_color    = imagecolorsforindex($image, $trnprt_indx);
                //print_r($trnprt_color);
                // Allocate the same color in the new image resource
                $trnprt_indx    = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
         
                // Completely fill the background of the new image with allocated color.
                imagefill($image_resized, 0, 0, $trnprt_indx);
         
                // Set the background color for new image to transparent
                imagecolortransparent($image_resized, $trnprt_indx);
         
         
              } 
              // Always make a transparent background color for PNGs that don't have one allocated already
              elseif ($info[2] == IMAGETYPE_PNG) {
         
                // Turn off transparency blending (temporarily)
                imagealphablending($image_resized, false);
         
                // Create a new transparent color for image
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
         
                // Completely fill the background of the new image with allocated color.
                imagefill($image_resized, 0, 0, $color);
         
                // Restore transparency blending
                imagesavealpha($image_resized, true);
              }
            }
          
            imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
                    
            if (!$proportional) {
              $image_resized2 = imagecreatetruecolor($width, $height);
              imagecopy($image_resized2, $image_resized, 0, 0, ($final_width-$width)/2, ($final_height-$height)/2, $final_width, $final_height);
              $image_resized=$image_resized2;
            }     
            
            //imagecopyresized($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
            
            if ( $delete_original ) {
              if ( $use_linux_commands )
                exec('rm '.$file);
              else
                @unlink($file);
            }         
            switch ( strtolower($output) ) {
              case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
              break;
              case 'file':
                $output = $file;
              break;
              case 'return':
                return $image_resized;
              break;
              default:
              break;
            }
         
            switch ( $info[2] ) {
              case IMAGETYPE_GIF:
                imagegif($image_resized, $output);
              break;
              case IMAGETYPE_JPEG:
                imagejpeg($image_resized, $output);
              break;
              case IMAGETYPE_PNG:
                imagepng($image_resized, $output);
              break;
              default:
                return false;
            }
            return true;
    }
}
function savefile($name,$table,$id=0){
//print "ici";
	if($id==0){
     if($_FILES[$name]["tmp_name"]!=""&&$_POST[$name."_chk"]!=1){
        $myext=getext($_FILES[$name]["name"]);
        move_uploaded_file($_FILES[$name]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$_GET["id"].'.'.$myext);
        chmod($_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$_GET["id"].'.'.$myext, 0775);
        return ",$name='$myext' ";
     }else{
  	   return ",$name=null ";
      }
      //suppression du cache 
      if($table==__racinebd__."content"){
        rmdir($_SERVER["DOCUMENT_ROOT"].__cachefolderimg__."/".$_GET["id"]);
      }
   }else{
     if($_FILES[$name]["tmp_name"]!=""&&$_POST[$name."_chk"]!=1){
        $myext=getext($_FILES[$name]["name"]);
        move_uploaded_file($_FILES[$name]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.'.'.$myext);
				//chmod($_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.'.'.$myext, 0775); 
     }
   }
}
function savefilenotext($name,$table,$id=0){
	if($id==0){
     if($_FILES[$name]["tmp_name"]!=""&&$_POST[$name."_chk"]!=1){
        $myext=getext($_FILES[$name]["name"]);
        move_uploaded_file($_FILES[$name]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$_GET["id"]);
        return ",$name='$myext' ";
     }else
  	   return ",$name=null ";
   }else{
     if($_FILES[$name]["tmp_name"]!=""&&$_POST[$name."_chk"]!=1){
        $myext=getext($_FILES[$name]["name"]);
        move_uploaded_file($_FILES[$name]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id);
		  chmod($_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id, 0755); 
     }
   }
}
function savefile2($name){
	move_uploaded_file($_FILES[$name]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$_FILES[$name]["name"]);
	return "'".$_FILES[$name]["name"]."'";
}
function testext($name,$listext){
	return (array_search(getext($_FILES[$name]["name"]),$listext)===false)?false:true;
}
function makeBool($val){
	return ($val=='1')?true:false;
}
function uc_latin1 ($str) {
    $str = strtoupper(strtr($str, LATIN1_LC_CHARS, LATIN1_UC_CHARS));
    return strtr($str, array("ß" => "SS"));
}
function chemin($arbre_id=0,$langue_id=0){
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  //print $arbre_id."/".$langue_id."<br>";
  //print "ici";
  $arbre_id=($arbre_id===0)?$_GET["arbre"]:$arbre_id;
  if($arbre_id!=""&&$arbre_id!="0"){
  $sql="select pere,nom,contenu_id,a.arbre_id,etat_id,translate,arbre_id_alias,root,nom_fichier 
  from ".__racinebd__."arbre a inner join ".__racinebd__."gabarit g on a.gabarit_id=g.gabarit_id 
  inner join ".__racinebd__."contenu c on (a.arbre_id=c.arbre_id or a.arbre_id_alias=c.arbre_id) and langue_id=".$langue_id." where c.arbre_id=".$arbre_id;
  $link=query($sql);
  $tbl_result=fetch($link);
  if($tbl_result["translate"]=="1"){
    $sql="select * from ".__racinebd__."content where contenu_id=".$tbl_result["contenu_id"]." and version_id=1";
  }else{
    $sql="select * from ".__racinebd__."contenu c1 inner join ".__racinebd__."content c2 on c1.contenu_id=c2.contenu_id where c1.langue_id=".__defaultlangueid__." and arbre_id=".(($tbl_result["arbre_id_alias"]!="")?$tbl_result["arbre_id_alias"]:$tbl_result["arbre_id"])." and version_id=1";
  }
  $link_txt=query($sql);
  $tbl_result_txt=fetch($link_txt);
  if($tbl_result["pere"]==$tbl_result["root"]){
    $sql="select shortlib from ".__racinebd__."langue where langue_id=".$langue_id;
    $link_langue=query($sql);
    $tbl_result_langue=fetch($link_langue);
    //if($langue_id==1)
      if(__showlang__){
        if($tbl_result["nom_fichier"]==""||$tbl_result["etat_id"]!=1){
          //return "<a href=\"".urlp($tbl_result["root"]).$tbl_result_langue["shortlib"]."\">".trad("Accueil",$langue_id)."</a>";
          //return "<a href=\"".urlp($tbl_result["root"])."\">".trad("Accueil",$langue_id)."</a>";
        }else{
          //return "<a href=\"".urlp($tbl_result["root"]).$tbl_result_langue["shortlib"]."\">".trad("Accueil",$langue_id)."</a> > <a href=\"".(($tbl_result["nom_fichier"]=="")?"#":(($tbl_result["etat_id"]==1)?urlp($arbre_id,$langue_id):"#"))."\">".strip_tags($tbl_result_txt["titre1"])."</a>";
          return "<a href=\"".urlp($tbl_result["root"])."\">".trad("Accueil",$langue_id)."</a> > <a href=\"".(($tbl_result["nom_fichier"]=="")?"#":(($tbl_result["etat_id"]==1)?urlp($arbre_id,$langue_id):"#"))."\">".strip_tags($tbl_result_txt["titre1"])."</a>";
        }
      }else{
       if($tbl_result["nom_fichier"]==""||$tbl_result["etat_id"]!=1){
          return "<a href=\"".urlp($tbl_result["root"])."\">".trad("Accueil",$langue_id)."</a>";
        }else{
          return "<a href=\"".urlp($tbl_result["root"])."\">".trad("Accueil",$langue_id)."</a> > <a href=\"".(($tbl_result["nom_fichier"]=="")?"#":(($tbl_result["etat_id"]==1)?urlp($arbre_id,$langue_id):"#"))."\">".strip_tags($tbl_result_txt["titre1"])."</a>";
        }
      }
  }else{
      if($tbl_result["nom_fichier"]==""||$tbl_result["etat_id"]!=1){
        return chemin($tbl_result["pere"],$langue_id)." > ";
      }else{
        return chemin($tbl_result["pere"],$langue_id)." > <a href=\"".(($tbl_result["nom_fichier"]=="")?"#":(($tbl_result["etat_id"]==1)?urlp($arbre_id,$langue_id):"#"))."\">".strip_tags($tbl_result_txt["titre1"])."</a>";
      }
    //return chemin($tbl_result["pere"],$langue_id)." > <a href=\"#\">".strip_tags($tbl_result_txt["titre1"])."</a>";
  }
  }
}
function makename($string){
$avec_accent=array(
    "á","Á","ã","Ã",
    "â","Â","à","À",
    "é","É","ê","Ê",
    "í","Í","ó","Ó",
    "õ","Õ","ô","Ô",
    "ú","Ú","ü","Ü",
    "ç","Ç"," ","\"","'");
$sans_accent=array(
    "a","A","a","A",
    "a","A","a","A",
    "e","E","e","E",
    "i","I","o","O",
    "o","O","o","O",
    "u","U","u","U",
    "c","C","_","","");
  //$que = array( 'á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ',' ' );
  //$por = array( 'a','e','i','o','u','A','E','I','O','U','n','n','_' );
    $name=preg_replace('/[^a-z0-9_\-\.]/i','_', str_replace( $avec_accent,$sans_accent,$string ));
    return strtolower( $name ); 
}
function log_phantom($arbre_id,$libelle){
  $sql="insert into ".__racinebd__."log (arbre_id,users_id,libelle,date_evt) values (".$arbre_id.",".$_SESSION["users_id"].",'".addslashes($libelle)."',now())";
  query($sql);
}
function url_phantom($arbre_id,$langue_id=__defaultlangueid_){
  //return __urlsite__.urlp($arbre_id,$langue_id);
  return urlp($arbre_id,$langue_id);
}
function urlpf($arbre_id){
  $sql="select root from ".__racinebd__."arbre where arbre_id=".$arbre_id;
  $link=query($sql);
  $tbl=fetch($link);
  //return urlp($tbl["root"]);
  return __racine__.str_replace(urlp($tbl["root"])."/","",urlp($arbre_id));
  //return print_r($tbl_info);
}
function urlp($arbre_id,$langue_id=0,$first=true){
  //print __html__;
  if(function_exists(urlpcustom)&&__html__===true){
    return urlpcustom($arbre_id,$langue_id=0,$first=true);
  }else{
    if(defined("__racineurl__")){
       $racineurl=__racineurl__;   
    }else{
       $racineurl="";
    }
  
    $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
    $sql="select shortlib from ".__racinebd__."langue where langue_id=".$langue_id;
    $link=query($sql);
    $tbl_result=fetch($link);
    $shortlib=$tbl_result["shortlib"];
    $sql="select a.supprimer,nom,pere,etat_id from ".__racinebd__."arbre a inner join ".__racinebd__."contenu c on a.arbre_id=c.arbre_id and langue_id=".$langue_id." where c.arbre_id='".$arbre_id."'";
    $link=query($sql);
    $tbl_result=fetch($link);
  
    if(($tbl_result["etat_id"]==1 && $tbl_result["supprimer"] == 0)||!$first||$_GET["mode"]=="preview"){
      if($tbl_result["pere"]=="")
        if(__showlang__){
          return $tbl_result["nom"].__parser__.$shortlib;
        }else{
          return $tbl_result["nom"].__parser__;
        }
      else
        return urlp($tbl_result["pere"],$langue_id,false)."/".makename($tbl_result["nom"]);
    }else{
      if($arbre_id!=0){
        return "#";
      }else{
        if(__showlang__){
          return $tbl_result["nom"]."/".__parser__.$shortlib;
        }else{
          return $tbl_result["nom"]."/".__parser__;
        }
      }
    }
  }
}
function genereFileReferencement(){
  genRobot();
  genSitemap();
  genRss();
  clear_cache();
}
function genRobot(){
  //generation d'un fichier par site
  $sql="select c1.*,c.arbre_id from ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
        inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=".__defaultlangueid__." and a.etat_id=1 
         and c1.version_id=1 where pere is null and gabarit_id=".__gabidsite__." and a.supprimer=0";
  //print $sql;
  $link=query($sql);
  while($tbl_result=fetch($link)){
    //print dirname($_SERVER['PHP_SELF']);
    $sitemap = @fopen($tbl_result["abstract"].__repflux__."/robots.txt","w");
    //print $tbl_result["abstract"]."/robots.txtici<br>";
    $content="";
    $content.="User-agent:*\n";
    $requete = "SELECT c.nom,a.arbre_id,c.langue_id
    FROM ".__racinebd__."arbre a
    INNER JOIN ".__racinebd__."contenu c ON a.arbre_id = c.arbre_id
    INNER JOIN ".__racinebd__."content c1 ON c.contenu_id = c1.contenu_id
    WHERE a.supprimer = 0
    AND (a.secure = 1 or c1.robotseo='noindex,nofollow')
    AND a.etat_id = 1
    AND a.arbre_id_alias IS NULL AND a.root=".$tbl_result["arbre_id"];
    $link2=query($requete);
    while ($ligne=fetch($link2)){
      $content.= "Disallow: ".urlpf($ligne['arbre_id'],$ligne['langue_id'])."\n";  
    }
    @fwrite($sitemap,$content);
    @fclose($sitemap);
  }
}
function genSitemap(){
//generation d'un fichier par site
  //$sql="select * from arbre  where pere is null and gabarit_id=".__gabidsite__;
  $sql="select c1.*,c.arbre_id from ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
        inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=".__defaultlangueid__." and a.etat_id=1 
        and c1.version_id=1 where pere is null and gabarit_id=".__gabidsite__." and a.supprimer=0";
  $link=query($sql);
  while($tbl_result=fetch($link)){
  //$sitemap = fopen($_SERVER["DOCUMENT_ROOT"].__racine__."/sitemap.xml","w");
    $sitemap = @fopen($tbl_result["abstract"].__repflux__."/sitemap.xml","w");
    $content="";
    $content.= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $content.="<urlset
          xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
          xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
          xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
                http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
    
    $requete = "SELECT c.nom,a.arbre_id,c.langue_id
    FROM ".__racinebd__."arbre a
    INNER JOIN ".__racinebd__."contenu c ON a.arbre_id = c.arbre_id
    INNER JOIN ".__racinebd__."gabarit G ON a.gabarit_id = G.gabarit_id
    INNER JOIN ".__racinebd__."langue l ON l.langue_id = c.langue_id and l.active=1
    WHERE a.supprimer = 0
    AND a.secure = 0
    AND a.etat_id = 1
    And G.sitemap = 1
    AND a.arbre_id_alias IS NULL AND a.root=".$tbl_result["arbre_id"];
    $link2=query($requete);
    while ($ligne=fetch($link2)){
      $content.="\t<url>\n";
      $content.= "\t\t<loc>\n\t\t\t".url_phantom($ligne['arbre_id'],$ligne['langue_id'])."\n\t\t</loc>\n";  
      
      //$content.="\t\t<priority>1.00</priority>\n";
      //$content.="\t\t<changefreq>daily</changefreq>\n";
      $content.="\t</url>\n";
      
    }
    $content.="</urlset>";
    @fwrite($sitemap,$content);
    @fclose($sitemap);
  }
}
function genRss(){
  //generation d'un fichier par site
  //$sql="select * from arbre where pere is null and gabarit_id=".__gabidsite__;
  $sql="select c1.*,c.arbre_id,c.nom from ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
        inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=".__defaultlangueid__." and a.etat_id=1 
         and c1.version_id=1 where pere is null and gabarit_id=".__gabidsite__." and a.supprimer=0";
  $link=query($sql);
  while($tbl_result=fetch($link)){
    $sql="select * from ".__racinebd__."langue where active=1";
    $link_langue=query($sql);
    while ($ligne_langue=fetch($link_langue)){
    	//$fluxrss = @fopen($_SERVER["DOCUMENT_ROOT"].__racine__."/fluxrss_".strtolower($ligne_langue["shortlib"]).".xml","w");
    	if(__showlang__)
    	 $fluxrss = @fopen($tbl_result["abstract"].__repflux__."/fluxrss_".strtolower($ligne_langue["shortlib"]).".xml","w");
    	else
    	 $fluxrss = @fopen($tbl_result["abstract"].__repflux__."/fluxrss.xml","w");
    	//print $_SERVER["DOCUMENT_ROOT"].__racine__."/fluxrss_".strtolower($ligne_langue["shortlib"]).".xml";
    	$content="";
    	$content.= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    	$content.="<rss version=\"2.0\">";
    	$content.="
    	\t<channel>
    	\t\t<title>".$tbl_result["titre1"]."</title>
    	\t\t<link>".$tbl_result["nom"]."</link>
    	\t\t<description></description>
    	\t\t<language>".strtolower($ligne_langue["shortlib"])."</language> 
    	";
    	$requete = "SELECT c.nom,a.arbre_id,c.langue_id,co.titre1,co.abstract,co.date_actu
    	FROM ".__racinebd__."arbre a
    	INNER JOIN ".__racinebd__."contenu c ON a.arbre_id = c.arbre_id
    	INNER JOIN ".__racinebd__."content co ON c.contenu_id = co.contenu_id
    	INNER JOIN ".__racinebd__."gabarit G ON a.gabarit_id = G.gabarit_id
    	WHERE a.supprimer =0
    	AND a.secure = 0
    	AND a.etat_id = 1
    	AND co.version_id=1
    	And G.rss = 1
    	AND c.langue_id =".$ligne_langue["langue_id"]."  AND a.root=".$tbl_result["arbre_id"]." 
    	AND a.arbre_id_alias IS NULL order by date_actu desc limit 10";
    	$link2=query($requete);
    
    	while ($ligne=fetch($link2)){
    	  $content.="\t\t<item>\n";
    	  $content.="\t\t\t<title><![CDATA[".strip_tags($ligne['titre1'])."]]></title>\n";
    	  $content.= "\t\t\t<link>".url_phantom($ligne['arbre_id'],$ligne['langue_id'])."</link>\n";  
    	  //echo $ligne['nom']." ".$i."<br/>";
    	  $content.="\t\t\t<description><![CDATA[".$ligne['abstract']."]]></description>\n";
    	  if($ligne['date_actu']!="0000-00-00 00:00:00"){
    			  
    		$content.="\t\t\t<pubDate>".date("D, d M Y H:i:s", strtotime($ligne['date_actu']))." GMT</pubDate>\n";
    	  }
    	  $content.="\t\t</item>\n";
    
    	}
    	$content.="</channel>\n
    	</rss>";
    	@fwrite($fluxrss,$content);
    	@fclose($fluxrss);
    }
  }
}
function trad($key,$langue_id=0){
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  $sql="select libelle_trad from ".__racinebd__."traduction where langue_id=".$langue_id." and libelle = '".addslashes($key)."' and supprimer=0";
  $link=query($sql,true);
  if($link==false){
    return $key;
  }else{
    $ligne=fetch($link);
    if(__insertlangue__){
      $sql="select libelle_trad from ".__racinebd__."traduction where libelle = '".addslashes($key)."' and supprimer=0";
      $link2=query($sql);
      if(num_rows($link2)==0){
        $sql="insert into ".__racinebd__."traduction (langue_id,libelle,libelle_trad) values(".__defaultlangueid__.",'".addslashes($key)."','".addslashes($key)."')";
        query($sql);
      }
    }
    return (num_rows($link)>0)?$ligne["libelle_trad"]:$key;
  }
}
function replacelink($mastring,$langue_id=0){
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  //print "replacelink";
  //fonction qui restructure les liens
  $tbl_result=array();
  //$text = explode('</a>', $mastring);
  $text = explode('href=', $mastring);
  //print count($text)."icijc";
  for($i=0;$i<count($text);$i++){
    $mytab=array();
    ereg("\"noeud:(.*)\"", $text[$i],$mytab);
    //ereg("<a(.*)href=\"noeud:(.*)\">", $text[$i],&$mytab);
    //print_r($mytab);
    //print count($mytab)."ici";
    if(count($mytab)>1){
      //print $mytab[0];
      $submytab=split("\"",$mytab[0]);
      //print_r($submytab);
      $val=substr($submytab[1],8);
      //print "/".$val."/";
      $tabval=split("/",$val);
      //print $tabval[0]."ici<br>";
      $tmpval="";
      if(count($tabval)==1){
        $subtabval=split("#",$tabval[0]);
        //print_r($subtabval);
        $ancre=(count($subtabval)==2)?"#".$subtabval[1]:"";  
        //$tbl_result[]=str_replace($submytab[0], "href=\"".urlp($subtabval[0],$langue_id).$ancre."\"", $text[$i]);
        $tmpval=str_replace("noeud://".$submytab[0], urlp($subtabval[0],$langue_id).$ancre."\"", $text[$i]);
      }else{
        $subtabval=split("#",$tabval[0]);
        $ancre=(count($subtabval)==2)?"#".$subtabval[1]:"";
        //$tbl_result[]=str_replace($submytab[0], "href=\"".urlp($subtabval[0],$langue_id)."?debut=".($tabval[1]-1).$ancre."\"", $text[$i]);
       $tmpval=str_replace("noeud://".$submytab[0], urlp($subtabval[0],$langue_id)."?debut=".($tabval[1]-1).$ancre."\"", $text[$i]);
      }
      $tmpval=str_replace($val."\"","", $tmpval);
      $tbl_result[]=$tmpval;
      //print "noeud://".$submytab[0];
      //print $val;
      //$val=substr($mytab[2],2,(strpos($mytab[2],'"')==0)?strlen($mytab[2]):strpos($mytab[2],'"')-2);
    //  $tbl_result[]=ereg_replace("href=\"noeud:(.*)\"", "href=\"".urlp($mytab[1],$langue_id)."\"", $text[$i]);
      //$tbl_result[]=$text[$i];
    }else{
      $tbl_result[]=$text[$i];
    }
    unset($mytab);
      
  }
  //return implode('</a>',$tbl_result);
  return implode('href=',$tbl_result);
  //return $mastring;
}
function fsize($file){
       $size=0;
       $range = Array (' B', ' Ko', ' Mo', ' Go');
       if(is_dir($file))
               if ($dh = opendir($file)){
                       while (($filecnt = readdir($dh)) !== false) {
                               if($filecnt == "." || $filecnt == "..")continue;
                               if(is_dir($file."/".$filecnt))
                                       $size += fsize($file."/".$filecnt);
                               else
                                       $size += filesize($file."/".$filecnt);
                               echo "\n$file/$filecnt";
                       }
                       closedir($dh);
               }else
                       return false;
       else
               $size = filesize($file);

       for ($i = 0; $size >= 1024 && $i < count($range); $i++)
               $size /= 1024;
       return round($size,2).$range[$i];
}

function sendmail($exp='',$expname='',$subject='',$html='',$dest='',$rep='',$tblfile=array()){
    $mail             = new PHPMailer();
    if(__smtpmailer__){
      $mail->IsSMTP();
      $mail->Host       = __smtphost__;      // sets GMAIL as the SMTP server
      if(__smtpauth__){
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        if(__smtpsecure__=="ssl"){
          $mail->SMTPSecure = __smtpsecure__;                 // sets the prefix to the servier
          $mail->Port       = __smtpport__;                   // set the SMTP port for the GMAIL server
        }
        $mail->Username   = __smtpusername__;  // GMAIL username
        $mail->Password   = __smtppassword__; 
      }
    }    
	
  if($exp==''){
    $nodeid=(defined("__defaultfather__"))?__defaultfather__:1;
  	$sql="select titre2 from 
          ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
          inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=1 
          and a.etat_id=1 and c1.version_id=1
          and a.supprimer=0 and c.arbre_id=".$nodeid;
    $link=query($sql);
    $tbl_result=fetch($link);
    $tabexp=split(",",$tbl_result["titre2"]);
    $exp=$tabexp[0];
  }
  //$tblfile[0] //url
  //$tblfile[1] //name
  //$tblfile[2] //ext
  //print_r($tblfile);
  for($i=0;$i<count($tblfile);$i++){
    //print $tblfile[$i][0]."<br>";
    $mail->AddAttachment($tblfile[$i][0], $tblfile[$i][1]);
  }
  
  $mail->SetFrom($exp, $expname);
  //$mail->From = $exp;
  
  $mail->AddReplyTo($exp, $expname);
	
  $mail->Subject =$subject;
  
  $html=is_utf8($html)?$html:utf8_encode($html);
  if($rep!=''){
    $mail->MsgHTML(embed_images($html));
  }else{
    $mail->MsgHTML($html);
	}
  
	if($dest==''){
    $nodeid=(defined("__defaultfather__"))?__defaultfather__:1;
  	$sql="select titre2 from 
          ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
          inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=1 
          and a.etat_id=1 and c1.version_id=1
          and a.supprimer=0 and c.arbre_id=".$nodeid;
    $link=query($sql);
    $tbl_result=fetch($link);
    //$result = $mail->send(split(",",$tbl_result['titre2']), 'mail');
    $listemail=split(",",$tbl_result['titre2']);
	}else{
    $listemail=split(",",$dest);
  }
  for($i=0;$i<count($listemail);$i++){
      $mail->AddAddress($listemail[$i]); 
  }
  
  $result=$mail->Send();
	unset($mail);
	return $result;
}
function Genere_Password($size=6){
  // Initialisation des caractères utilisables
  $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
  for($i=0;$i<$size;$i++)
  {
    $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
  }
  
  return $password;
}
function downloadfile($filename,$ext,$table,$id=''){
    $fileurl=$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.".".$ext;
  	header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // required for certain browsers 
    header("Content-Type: application/force-download");
    // change, added quotes to allow spaces in filenames, by Rajkumar Singh
    header("Content-Disposition: attachment; filename=\"".$filename."\";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($fileurl));
    readfile($fileurl);
    
    /*
    header("Cache-control: private"); // fix for IE
  	header("Content-Type: application/octet-stream"); 
  	header("Content-type: application/".$ext);
  	header("Content-Length: ".filesize($_SERVER["DOCUMENT_ROOT"].__uploaddirfront__.$table.$id.".".$ext));
  	header("Content-Disposition: attachment; filename=$filename");
  	$fp = fopen($_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.".".$ext, 'r');
  	
    fpassthru($fp); // ** CORRECT **
  	@fclose($fp);
  	exit;
  	*/
}
function dumpmeta($link,$tbl_result,$name=''){
  $i=0;
  while ($i < mysql_num_fields($link)) {
    $meta=mysql_fetch_field($link, $i++);
    if(!$meta->primary_key&&$meta->name!="pere"&&$meta->name!="root"&&$meta->name!=$name){
      if($tbl_result[$meta->name]!=""){?>
      <<?=$meta->name?>><![CDATA[<?=$tbl_result[$meta->name]?>]]></<?=$meta->name?>>
      <?}else if($meta->not_null){?>
      <<?=$meta->name?>></<?=$meta->name?>>
      <?}
    }
  }
}
function dumpxml($arbre_id){
  print "<arbre>";
  $sql="select * from ".__racinebd__."arbre where arbre_id=".$arbre_id;
  $link=query($sql);
  $tbl_result=fetch($link);
  dumpmeta($link,$tbl_result);
  $sql="select * from ".__racinebd__."contenu where arbre_id=".$arbre_id;
  $link=query($sql);
  while($tbl_result=fetch($link)){?>
    <contenu><?dumpmeta($link,$tbl_result,"arbre_id");
    $sql="select * from ".__racinebd__."content where contenu_id=".$tbl_result["contenu_id"];
    $link2=query($sql);
    while($tbl_result2=fetch($link2)){?>
    <content><?dumpmeta($link2,$tbl_result2,"contenu_id");?></content>
    <?}?>
    </contenu>
  <?}
  $sql="select * from ".__racinebd__."arbre where pere=".$arbre_id;
  $link=query($sql);
  while($tbl_result=fetch($link)){?>
    <childs><?=dumpxml($tbl_result["arbre_id"])?></childs>
  <?}
  print "</arbre>";
}
function readdump($sFilename){
  $rHandle = fopen($sFilename, 'r');
  $sData .= fread($rHandle, filesize($sFilename));
  fclose($rHandle);
  return xml2array($sData);
}
function rulesuserfront(){
  /*
  print function_exists(rulesuserfrontcustom());
  die;*/
  if(!function_exists(rulesuserfrontcustom)){
  //print "icijc";
    if($_GET["arbre"]!=""){
      $tbl_info=node();
      $sql="select content_id from ".__racinebd__."groupefront_user gfu inner join ".__racinebd__."groupefront_content gfc on gfu.groupefront_id=gfc.groupefront_id and content_id='".$tbl_info["content_id"]."' and userfront_id=".$_SESSION["userfront_id"];
      //print $sql;
      $link=query($sql);
      if(num_rows($link)==0){
        return false;
      }else{
        return true;
      }
    }
  }else{
    return rulesuserfrontcustom();
  }
}
function majfichier($content_id){
  //print "<script>alert('majfichier')</script>";
  for($i=0;$i<count($_POST["listfichiers"]);$i++){
    //print "<script>alert('ici jc')</script>";
    //on regarde si le fichier doit être supprimer ou pas
    if($_POST["fichiers_".$_POST["listfichiers"][$i]]==1){
      $sql="update ".__racinebd__."fichiers set supprimer=1 where fichiers_id=".$_POST["listfichiers"][$i];
      query($sql);
    }
    if($_POST["fichiers_".$_POST["listfichiers"][$i]]==2){
      $sql="update ".__racinebd__."fichiers set content_id=".$content_id." where fichiers_id=".$_POST["listfichiers"][$i];
      query($sql);
    }
  }
}

function majprix($content_id){
  //print "<script>alert('majfichier')</script>";
  for($i=0;$i<count($_POST["listprix"]);$i++){
    //print "<script>alert('ici jc')</script>";
    //on regarde si le fichier doit être supprimer ou pas
    if($_POST["prix_".$_POST["listprix"][$i]]==1){
      /*
      $sql="delete from ".__racinebd__."valeur_prix where prix_id=".$_POST["listprix"][$i];
      query($sql);
      $sql="delete from ".__racinebd__."prix where prix_id=".$_POST["listprix"][$i];
      query($sql);
      */
      $sql="update ".__racinebd__."prix set supprimer=1 where prix_id=".$_POST["listprix"][$i];
      query($sql);
      /*
      $sql="update ".__racinebd__."fichiers set supprimer=1 where fichiers_id=".$_POST["listfichiers"][$i];
      query($sql);*/
    }
    if($_POST["prix_".$_POST["listprix"][$i]]==2){
      $sql="update ".__racinebd__."prix set content_id=".$content_id." where prix_id=".$_POST["listprix"][$i];
      query($sql);
    }
  }
}
/*
function tweet($username,$password,$message,$url){  
  // Définir le message à tweeter  
  //$message = "Test pour un projet PHP";
  $message =  urlencode(stripslashes(urldecode($message)))." ".get_tiny_url($url);
  print $message."<br>";
  print $username."<br>";
  print $password."<br>";   
  // Accéder à l'API de Twitter  
  $url = "http://twitter.com/statuses/update.xml";  
  // Sinon utiliser JSON  
  // $url = ‘http://twitter.com/statuses/update.json’;  
  // Initialiser  
  $curl_handle = curl_init();  
  curl_setopt($curl_handle, CURLOPT_URL, "$url");  
  curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);  
  curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);  
  curl_setopt($curl_handle, CURLOPT_POST, 1);  
  curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message");  
  curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");  
  // Envoyer le tweet  
  $buffer = curl_exec($curl_handle);  
  curl_close($curl_handle);  
  // Vérifier que tout est OK  
  if ($resultArray['http_code'] == 200) 
  echo 'Tweet Posted';
  else
  echo 'Could not post Tweet to Twitter right now. Try again later.'.$resultArray['http_code'];
   
}*/
function tweet($consumerKey,$consumerSecret,$accesstoken,$accesstokensecret,$message,$url){
  $message =  stripslashes(urldecode($message))." ".get_tiny_url($url);
  //$consumerKey    = '<insert your consumer key';
  //$consumerSecret = '<insert your consumer secret>';
  //$oAuthToken     = '<insert your access token>';
  //$oAuthSecret    = '<insert your token secret>';
  require_once($_SERVER["DOCUMENT_ROOT"].__racineadminlib__.'/twitteroauth/twitteroauth/twitteroauth.php');
  
  // twitteroauth.php points to OAuth.php
  // all files are in the same dir
  // create a new instance
  $tweet = new TwitterOAuth($consumerKey,$consumerSecret,$accesstoken,$accesstokensecret);
  
   // post to twitter
  //include 'tweet.php';  // the file where the tweet instance is created
  //$statusMessage = 'Movie added: '.$title. ' -> ' . $message;
  //print $message."<br>";
  
  $content = $tweet->get('account/verify_credentials');
  //print "icijc";
  //$tweet->post('statuses/update', array('status' => $message));
  $tweet->post('statuses/update', array('status' => $message));
}
//gets the data from a URL   
function get_tiny_url($url)  {  
  $ch = curl_init();  
  $timeout = 5;  
  curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
  $data = curl_exec($ch);  
  curl_close($ch);  
  return $data;  
}
function is_utf8($str) { 
    $c=0; $b=0; 
    $bits=0; 
    $len=strlen($str); 
    for($i=0; $i<$len; $i++){ 
        $c=ord($str[$i]); 
        if ($c >= 128) { 
            if(($c >= 254)) return false; 
            elseif($c >= 252) $bits=6; 
            elseif($c >= 248) $bits=5; 
            elseif($c >= 240) $bits=4; 
            elseif($c >= 224) $bits=3; 
            elseif($c >= 192) $bits=2; 
            else return false; 
            if(($i+$bits) > $len) return false; 
            while($bits > 1){ 
                $i++; 
                $b=ord($str[$i]); 
                if($b < 128 || $b > 191) return false; 
                $bits--; 
            } 
        } 
    } 
    return true; 
} 
function majval($content_id){
  //print "<script>alert('majfichier')</script>";
  for($i=0;$i<count($_POST["listvals"]);$i++){
    //print "<script>alert('ici jc')</script>";
    //on regarde si le fichier doit être supprimer ou pas
    if($_POST["val_".$_POST["listvals"][$i]]==1){
      $sql="update ".__racinebd__."list_val set supprimer=1 where val_id=".$_POST["listvals"][$i];
      query($sql);
    }
    if($_POST["val_".$_POST["listvals"][$i]]==2){
      $sql="update ".__racinebd__."list_val set content_id=".$content_id." where val_id=".$_POST["listvals"][$i];
      query($sql);
    }
  }
}
function listval($content_id){
  $sql="select * from ".__racinebd__."list_val where content_id=".$content_id." order by titre";
  $link=query($sql);
  while($tbl=fetch($link)){
    $tab[]=$tbl;
  }
  return $tab;
}
function videchamps($string){
  $val=trim(html_entity_decode(strip_tags(str_replace("&#160;","",$string))));   
  if($val==""){
    return "";
  }else{
    return $string;
  }
}

?>