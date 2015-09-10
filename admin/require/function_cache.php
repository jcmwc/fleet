<?php
function clear_cache(){
  $directory = $_SERVER["DOCUMENT_ROOT"].__cachefolder__;
  if( !$dirhandle = @opendir($directory) )
    return;
  while( false !== ($filename = readdir($dirhandle)) ) {
    if( $filename != "." && $filename != ".." ) {
      $filename = $directory. "/". $filename;
      @unlink($filename);
    }
  }
}
function cache_key($key=array()){
  $key_file="";
  if(is_array($key)){
    for($i=0;$i<count($key)-1;$i++){
      if(is_array($key[$i])){
        $key_file.=implode("",$key[$i]);
      }else{
        $key_file.=$key[$i];
      }
    }
  }else{
    $key_file=$key;
  }
  //print $key."/".$key_file."/icijckey<br>";
  return md5($key_file);
}
function cache_file_exist($template="",$key=array(),$racine=0){
  $key_file_md5=cache_key($key);
  //print "/".$key_file_md5."/"; 
  $racine=($racine===0)?$template:$racine;
  $retour=__cachefolder__.str_replace("/","_",$racine)."_".__defaultfather__."_".$key_file_md5.".html";
  if(!__debugmode__){
    return (file_exists($_SERVER["DOCUMENT_ROOT"].$retour))?$_SERVER["DOCUMENT_ROOT"].$retour:0;
  }else
    return 0;
}
function cache_file($template,$key=array(),$racine=0){
  //print $template;
  //print $racine;
  $key_file_md5=cache_key($key);
  ob_start();
  require($template);
  $content=replacelink(ob_get_contents());
  ob_end_clean();
  $racine=($racine===0)?$template:$racine;
  //sauvegarde du fichier
  $fp = @fopen($_SERVER["DOCUMENT_ROOT"].__cachefolder__.str_replace("/","_",$racine)."_".__defaultfather__."_".$key_file_md5.".html", "w");
  if($fp){
    fwrite($fp, $content);
    fclose($fp);
  }
  print $content;
}
function cache_file_script($template,$key=array(),$racine=0,$write=true){
  
  //print $racine;
  $key_file_md5=cache_key($key);
  ob_start();
  //print "tpl/script/".$template;
  if(file_exists($_SERVER["DOCUMENT_ROOT"].__racine__."/tpl/script/".$template))
    require($_SERVER["DOCUMENT_ROOT"].__racine__."/tpl/script/".$template);
  if(file_exists($_SERVER["DOCUMENT_ROOT"].__racine__."/tpl/layout/".$template))
    require($_SERVER["DOCUMENT_ROOT"].__racine__."/tpl/layout/".$template);
  $content=ob_get_contents();
  ob_end_clean();
  $racine=($racine===0)?$template:$racine;
  //sauvegarde du fichier
  if($write){
    $fp = fopen($_SERVER["DOCUMENT_ROOT"].__cachefolder__.str_replace("/","_",$racine)."_".__defaultfather__."_".$key_file_md5.".html", "w");
    fwrite($fp, $content);
    fclose($fp);
  }
  print $content;
}
function cache_require($template,$key=array()){
  //print $key."/icijc<br>";
  $fileexist=cache_file_exist($template,$key);
  //print $fileexist;
  if($fileexist!==0){
    require($fileexist);
  }else{
    cache_file_script($template,$key);
  }
}
?>