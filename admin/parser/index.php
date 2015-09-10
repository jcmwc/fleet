<?php
require_once($_SERVER["DOCUMENT_ROOT"].__adminfolder__."/require/function.php");

if(__test__==true){
  require($_SERVER["DOCUMENT_ROOT"].__adminfolder__."/require/auth.php");
}

if($_GET["mode"]=="preview"){
  //on verifie si le noeud est validé
  ?>
  <script>window.location='<?=urlp($_GET["arbre_id"],$_GET["langue_id"])?>?version_id=<?=$_GET["version_id"]?>&etat_id=<?=$_GET["etat_id"]?>&mode=view'</script>
  <? 
  die;
}
//print $_SERVER["PATH_INFO"];
$_SERVER["PATH_INFO"]=($_SERVER["PATH_INFO"]==""&&$_SERVER["ORIG_PATH_INFO"]!="")?$_SERVER["ORIG_PATH_INFO"]:$_SERVER["PATH_INFO"];
$_SERVER["PATH_INFO"]=($_GET["pathinfo"]!="")?$_GET["pathinfo"]:$_SERVER["PATH_INFO"];

/*
print $_SERVER["PATH_INFO"];
die;
*/


$path=str_replace("/","",$_SERVER["PATH_INFO"]);


if($path=="deco"){
  $_SESSION = array();
  session_destroy();
  header('Location: '.urlp(__defaultfather__));
  die;
}
if($path=="sitemap.xml"||$path=="robots.txt"||(strpos($path,"fluxrss")===0&&strpos($path,".xml")>0)){
  $filename=$_SERVER["DOCUMENT_ROOT"].__racine__.__repflux__.$_SERVER["PATH_INFO"];
  $handle = fopen($filename,"r");
  $contents = fread($handle, filesize($filename));
  fclose($handle);
  print $contents;
  die;
}

//on verifie si le fichier est déja en cache
$fileexist=cache_file_exist('',array($_GET,$_POST,$_SESSION),$_SERVER["PATH_INFO"]);
if($fileexist!==0&&$_GET["mode"]!="view"&&$_GET["pdf"]!=1&&$_GET["file"]==""){
  
  require($fileexist);
}else{
    if(!__showlang__){
      $sql="select shortlib from ".__racinebd__."langue where langue_id=".__defaultlangueid__;
      $link=query($sql);
      $tbl_result=fetch($link);
      $shortlib=$tbl_result["shortlib"];
    }
    
    $_GET["wheresecure"] = ($_SESSION["logfront"]!="")?"":"and secure=0";
    $_GET["wheresecure2"] = ($_SESSION["logfront"]!="")?"":"and a0.secure=0";
    //on regarde l'url actuel
    //on recherche la langue
    //$_GET["etat_id"]=($_GET["etat_id"]!=""&&$_SESSION["islog"])?$_GET["etat_id"]:1;
    $_GET["etat_id"]=($_GET["etat_id"]!="")?$_GET["etat_id"]:1;
    //$_GET["version_id"]=($_GET["version_id"]!=""&&$_SESSION["islog"])?$_GET["version_id"]:1;
    $_GET["version_id"]=($_GET["version_id"]!="")?$_GET["version_id"]:1;
    
    $tab_path_info=$_SERVER["PATH_INFO"];
    //print_r($tab_path_info);
    //die;
    //on verifie si le dernier caractére est / si oui on l'enleve
    $tab_path_info=(strrpos($tab_path_info,"/")+1==strlen($tab_path_info))?substr($tab_path_info,0,-1):$tab_path_info;
    
    $tab_path_info=split("/",$tab_path_info);
    $tmp_tab_path_info =array();    
    
    if(__showlang__){
      for($i=1;$i<count($tab_path_info);$i++){
        $tmp_tab_path_info[]=$tab_path_info[$i];
      }
    }else{
      $tmp_tab_path_info=$tab_path_info;
    }
    //$tmp_tab_path_info=$tab_path_info;
    
    
    
    $TAB_REQUEST_URI=split("/",str_replace(__racine__,'',$_SERVER["REQUEST_URI"]));
    if(trim($TAB_REQUEST_URI[1])=="userfiles"||trim($TAB_REQUEST_URI[1])=="upload"){    
    //if(trim($tab_path_info[1])=="userfiles"||trim($tab_path_info[1])=="upload"){  
      $tabrequest=explode("?",$_SERVER["REQUEST_URI"]);
      $size=getImageSize($_SERVER["DOCUMENT_ROOT"].$tabrequest[0]);
      
      $path_parts = pathinfo($_SERVER["DOCUMENT_ROOT"].$tabrequest[0]); 
      $ext = strtolower($path_parts["extension"]); 
      
      // Determine Content Type 
      switch ($ext) { 
        case "pdf": $ctype="application/pdf"; break; 
        case "exe": $ctype="application/octet-stream"; break; 
        case "zip": $ctype="application/zip"; break; 
        case "doc": $ctype="application/msword"; break; 
        case "xls": $ctype="application/vnd.ms-excel"; break; 
        case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
        case "gif": $ctype="image/gif"; break; 
        case "png": $ctype="image/png"; break; 
        case "jpeg": 
        case "jpg": $ctype="image/jpg"; break; 
        default: $ctype="application/force-download"; 
      } 
      header("Content-Type: $ctype");
      readfile($_SERVER["DOCUMENT_ROOT"].$tabrequest[0]);
      die;
    }
    
    //print_r($tmp_tab_path_info);
    //die;
    if(trim($tmp_tab_path_info[1])=="file"){
      $ctype="application/force-download"; 
      $ext=getext($tmp_tab_path_info[4]);
      header("Content-Type: $ctype");
        if($tmp_tab_path_info[3]==1){
          $url=__uploaddirfront__.__racinebd__."content".$tmp_tab_path_info[2].".".$ext;
        }else{
          $url=__uploaddirfront__.__racinebd__."content".$tmp_tab_path_info[3]."_".$tmp_tab_path_info[2].".".$ext;
        }

      readfile($_SERVER["DOCUMENT_ROOT"].$url);
      die;
    }
    if(trim($tmp_tab_path_info[1])=="image"){
      
      //vérification si il y a un resize a faire
      $resize=false;
      if(count($tmp_tab_path_info)>7){
        $ext=getext($tmp_tab_path_info[7]); 
        $resize=true;  
        
      }else{
        $ext=getext($tmp_tab_path_info[6]);
      }
      $table=$tmp_tab_path_info[5];
      // Determine Content Type 
      switch ($ext) { 
        case "gif": $ctype="image/gif"; break; 
        case "png": $ctype="image/png"; break; 
        case "jpeg": 
        case "jpg": $ctype="image/jpg"; break; 
        default: $ctype="application/force-download"; 
      } 
      header("Content-Type: $ctype");
      if($tmp_tab_path_info[4]==0){
        if($tmp_tab_path_info[3]==1){
          $url=__uploaddirfront__.__racinebd__.$table.$tmp_tab_path_info[2].".".$ext;
        }else{
          $url=__uploaddirfront__.__racinebd__.$table.$tmp_tab_path_info[3]."_".$tmp_tab_path_info[2].".".$ext;
        }
      }else{
        if($tmp_tab_path_info[3]==1){
          if($tmp_tab_path_info[4]==1){
            $url=__uploaddirfront__."tbl_".__racinebd__.$table.$tmp_tab_path_info[2].".".$ext;
          }else{
            $url=__uploaddirfront__."tbl_".$tmp_tab_path_info[4]."_".__racinebd__.$table.$tmp_tab_path_info[2].".".$ext;  
          }
        }else{
          if($tmp_tab_path_info[4]==1){
            $url=__uploaddirfront__."tbl_".__racinebd__.$table.$tmp_tab_path_info[3]."_".$tmp_tab_path_info[2].".".$ext;
          }else{
            $url=__uploaddirfront__."tbl_".$tmp_tab_path_info[4]."_".__racinebd__.$table.$tmp_tab_path_info[3]."_".$tmp_tab_path_info[2].".".$ext; 
          }
          
        }
      }
      if($resize){
        $size=explode("x",$tmp_tab_path_info[5]);
        $newurl=__cachefolderimg__."/".$tmp_tab_path_info[2]."/".implode("_",$tmp_tab_path_info).".".$ext;
        if(!file_exists($_SERVER["DOCUMENT_ROOT"].$newurl)){
          if(!is_dir($_SERVER["DOCUMENT_ROOT"].__cachefolderimg__."/".$tmp_tab_path_info[2])){
            mkdir($_SERVER["DOCUMENT_ROOT"].__cachefolderimg__."/".$tmp_tab_path_info[2]);
          }       
          smart_resize_image( $_SERVER["DOCUMENT_ROOT"].$url, $size[0], $size[1], true, $_SERVER["DOCUMENT_ROOT"].$newurl,false);
        }
        $url=$newurl;  
      }
      readfile($_SERVER["DOCUMENT_ROOT"].$url);
      die;
    }
    if(trim($tmp_tab_path_info[1])=="download"){
      if(trim($tmp_tab_path_info[2])=="all"){
        $tbl_info=node($tmp_tab_path_info[3]);
        $tbl_file=contextfile($tmp_tab_path_info[3]);
        //creation du répertoire
        //print $_SERVER["DOCUMENT_ROOT"].__uploaddirfront__."arbre".$tab_path_info[3];
        @mkdir ($_SERVER["DOCUMENT_ROOT"].__uploaddirfront__."arbre".$tmp_tab_path_info[3]);
        //copie des fichiers
        for($i=0;$i<count($tbl_file);$i++){
          copy($_SERVER["DOCUMENT_ROOT"].__uploaddirfront__.__racinebd__."fichiers".$tbl_file[$i]["fichiers_id"].".".$tbl_file[$i]["ext"],$_SERVER["DOCUMENT_ROOT"].__uploaddirfront__."arbre".$tmp_tab_path_info[3]."/".str_replace(".".$tbl_file[$i]["ext"],"",$tbl_file[$i]["nom_fichier"]).$tbl_file[$i]["fichiers_id"].".".$tbl_file[$i]["ext"]);
        }
        //die;
        $filename=$_SERVER["DOCUMENT_ROOT"].__uploaddirfront__.urlencode($tbl_info["titre1"]);
        //print "zip -r ".$filename." ".$_SERVER["DOCUMENT_ROOT"].__uploaddirfront__."arbre".$tab_path_info[3];
        //die;
        exec("zip -r ".$filename." ".$_SERVER["DOCUMENT_ROOT"].__uploaddirfront__."arbre".$tmp_tab_path_info[3]);
        header("Cache-control: private"); // fix for IE
        header("Content-Type: application/octet-stream"); 
        header("Content-type: application/zip");
        header("Content-Length: ".filesize($filename.".zip"));
        header("Content-Disposition: attachment; filename=".urlencode($tbl_info["titre1"].".zip"));
        readfile($filename.".zip");
        die;
      }else{
        $_GET["file"]=$tmp_tab_path_info[2];
      }
    }
    
    $sql="select c.nom from 
        ".__racinebd__."contenu c inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=".__defaultlangueid__." 
        and a.etat_id=1 and a.supprimer=0 and c.arbre_id=".__defaultfather__;
    $link=query($sql);
    $tbl_result=fetch($link);
    
    
    
    if($tbl_result["nom"]!=""){
      $tmptab=array();
      $tmptab[0]=$tbl_result["nom"];
    }
    if(!__showlang__){
      $start=0;
    }else{
      if($tab_path_info[0]==""){
        $start=2;
        $shortlib=$tab_path_info[1];
      }else{
        $start=1;
        $shortlib=$tab_path_info[0];
      }
      $_GET["shortlib"]=$shortlib;
    }
    //print_r($tab_path_info);
    for($i=$start;$i<count($tab_path_info);$i++){
      $tmptab[]=$tab_path_info[$i];
    }
    //print_r($tmptab);
    unset($tab_path_info);
    $tab_path_info=$tmptab;
    
    if($shortlib!=""){
      $sql="select langue_id from ".__racinebd__."langue where shortlib='".$shortlib."'";
      $link=query($sql);
      $tbl_result=fetch($link);
      $_GET["la_langue"]=$tbl_result["langue_id"];
    }else{
      $sql="select shortlib from ".__racinebd__."langue where langue_id=".__defaultlangueid__;
      $link=query($sql);
      $tbl_result=fetch($link);
      $_GET["shortlib"]=$tbl_result["shortlib"];
    }
    
    if($_GET["file"]!=""){
      //on verifie les droits sur le fichier
      $sql="select secure,nom_fichier,f.ext,titre from ".__racinebd__."arbre a inner join ".__racinebd__."contenu c on a.arbre_id=c.arbre_id and langue_id=".$_GET["la_langue"]." inner join ".__racinebd__."content c2 on c.contenu_id=c2.contenu_id and version_id=".$_GET["version_id"]." inner join ".__racinebd__."fichiers f on c2.content_id=f.content_id where fichiers_id=".$_GET["file"];
      $link=query($sql);
      $tbl_result=fetch($link);
      if(($tbl_result["secure"]==1&&$_SESSION["logfront"]!="")||$tbl_result["secure"]==0){
        $filename = urlencode($tbl_result["titre"].".".$tbl_result["ext"]);
        header("Cache-control: private"); // fix for IE
        header("Content-Type: application/octet-stream"); 
        header("Content-type: application/".$tbl_result["ext"]);
        header("Content-Length: ".filesize($_SERVER["DOCUMENT_ROOT"].__uploaddirfront__.__racinebd__."fichiers".$_GET["file"].".".$tbl_result["ext"]));
        header("Content-Disposition: attachment; filename=$filename");
        readfile($_SERVER["DOCUMENT_ROOT"].__uploaddirfront__.__racinebd__."fichiers".$_GET["file"].".".$tbl_result["ext"]);
      }
      exit;
    }
    
    //print_r($tab_path_info);
    //print_r($tab_path_info);
    if((count($tab_path_info)>2&&!__showlang__)||(count($tab_path_info)>=2&&__showlang__)){
      //print "ici6";
      //recherche de l'arbre_id
      /*
      for($i=3;$i<count($tab_path_info);$i++){
        $j=$i-2;
        $jointure.=" inner join ".__racinebd__."arbre a".$j." on a".$j.".arbre_id=a".($j-1).".pere inner join ".__racinebd__."contenu c".$j." on a".$j.".arbre_id=c".$j.".arbre_id and c".$j.".langue_id=".$_GET["la_langue"]." and c".$j.".nom='".$tab_path_info[count($tab_path_info)-($i-1)]."'";
      }*/
      for($i=2;$i<count($tab_path_info)-1;$i++){
        $j=$i-1;
        $jointure.=" inner join ".__racinebd__."arbre a".$j." on a".$j.".arbre_id=a".($j-1).".pere inner join ".__racinebd__."contenu c".$j." on a".$j.".arbre_id=c".$j.".arbre_id and c".$j.".langue_id=".$_GET["la_langue"]." and c".$j.".nom='".$tab_path_info[count($tab_path_info)-($i)]."'";
      }
      $sql="select a0.*,c.*,nom_fichier from 
      ".__racinebd__."arbre a0 
      $jointure inner join
      ".__racinebd__."contenu c on a0.arbre_id=c.arbre_id and c.langue_id=".$_GET["la_langue"]." inner join ".__racinebd__."gabarit g on g.gabarit_id=a0.gabarit_id 
      where c.nom ='".$tab_path_info[count($tab_path_info)-1]."' and a0.etat_id=".$_GET["etat_id"]." and a0.supprimer=0 and (a0.root=".__defaultfather__." or a0.root is null) ".$wheresecure2;
      $link=query($sql);
      //print $sql;
      if(num_rows($link)>0){
        $tbl_result=fetch($link);
        //print $tbl_result["root"];
         //print "ici";
        if(count($tab_path_info)>2){
          //recherche de l'arbre_id root
          $sql2="select a.arbre_id,a.pere from ".__racinebd__."contenu c inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id where nom = '".$tab_path_info[2]."' and pere is null and supprimer=0 and langue_id=".$_GET["la_langue"];
          $link2=query($sql2);
          $tbl_result2=fetch($link2);
          $_GET["root"]=$tbl_result2["arbre_id"];
          $_GET["ordre_root"]=$tbl_result2["ordre"];
          $_GET["arbre"]=$tbl_result["arbre_id"];
          $_GET["pere"]=$tbl_result["pere"];
          if(count($tab_path_info)>3&&$_GET["root"]!=""){
            $sql2="select a.arbre_id from ".__racinebd__."contenu c inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id where nom = '".$tab_path_info[3]."' and pere =".$_GET["root"]." and supprimer=0 and langue_id=".$_GET["la_langue"];
            $link2=query($sql2);
            $tbl_result2=fetch($link2);
            $_GET["root_n2"]=$tbl_result2["arbre_id"];
          }
        }else{
          $_GET["ordre_root"]="";
          $_GET["arbre"]=$tbl_result["arbre_id"];
          $_GET["root"]=$tbl_result["arbre_id"];
        }
        $_GET["translate"]=$tbl_result["translate"];
        $_GET["secure"]=$tbl_result["secure"];
        $_GET["gabarit_id"]=$tbl_result["gabarit_id"];
        $_GET["alias"]=$tbl_result["arbre_id_alias"];
        if($_GET["pdf"]==1){
          require($_SERVER["DOCUMENT_ROOT"].__racineweb__."/tpl/pdf.php");
          exit;
        }
        //print "tpl/".$tbl_result["nom_fichier"];
        if(($tbl_result["secure"]==1&&$_SESSION["logfront"]!=""&&rulesuserfront())||$tbl_result["secure"]==0){
          //print "icitpl/".$tbl_result["nom_fichier"];
          cache_file("tpl/".$tbl_result["nom_fichier"],array($_GET,$_POST,$_SESSION),$_SERVER["PATH_INFO"]);
          //require("tpl/".$tbl_result["nom_fichier"]);
        }else{
          cache_file("tpl/secure.php",array($_GET,$_POST,$_SESSION),$_SERVER["PATH_INFO"]);
        }
      }else{
        $_GET["la_langue"]=__defaultlangueid__;
        $_GET["arbre"]=0;
        header("Status : 404 Not Found");
        header("HTTP/1.0 404 Not Found");
        if(file_exists($_SERVER["DOCUMENT_ROOT"].__racine__."tpl/404.php")){
          cache_file("tpl/404.php",array($_GET,$_POST,$_SESSION),$_SERVER["PATH_INFO"]);
        }else{
          print "Pages non trouv&eacute;e"; 
          die;
        }
      }
    }else{
      
      $_GET["la_langue"]=($_GET["la_langue"]!="")?$_GET["la_langue"]:__defaultlangueid__;
      $_GET["arbre"]=0;
      //verification si le site est publié
      $sql="select etat_id from ".__racinebd__."arbre where arbre_id=".__defaultfather__;
      $link=query($sql);
      $tbl_etat=fetch($link);
      if($tbl_etat["etat_id"]==$_GET["etat_id"]){
        cache_file("tpl/index.php",array($_GET,$_POST,$_SESSION),$_SERVER["PATH_INFO"]);
      }else{
        if(file_exists($_SERVER["DOCUMENT_ROOT"].__racine__."tpl/maintenance.php")){       
          cache_file("tpl/maintenance.php",array($_GET,$_POST,$_SESSION),$_SERVER["PATH_INFO"]);
        }else{
          print "Site en maintenance";
          die;
        }
      }
    }
    if($_GET["mode"]=="view"){?>
    <div style="position:absolute;top:0px;left:0px;color:red;font-family:arial;font-size:12px;background:gray;font-weight:bold;padding:5px 5px 5px 5px">PREVIEW</div>
    <?
    }
    if(__showtime__){
      print "<br>".(round(microtime(true)-$starttime,2))." s<br>";
    }
}
?>