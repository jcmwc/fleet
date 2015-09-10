<?
function searchPhantom($query,$without='',$pj=false,$pere=0,$limit=0,$orderby="gabarit_id,pere",$where='',$etat_id=0,$version_id=0,$langue_id=0){
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  $pere=($pere===0)?"":"and a.pere in (".$pere.")";
  $limit=($limit==0)?"":"limit ".$limit;
  $orderby="order by ".$orderby;
  $etat_id=($etat_id==0)?$_GET["etat_id"]:$etat_id;
  $version_id=($version_id==0)?$_GET["version_id"]:$version_id;
  $query=($without!='')?$query." -".$without:$query;
  $wherepj="";
  if($pj){
    $wherepj="or c1.content_id in(select content_id from ".__racinebd__."fichiers where 
    MATCH(titre,abstract,contenu) against('".addquote($query)."' IN BOOLEAN MODE) and supprimer=0)";
  }
  $from ="".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
          inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=".$langue_id." 
          and a.etat_id in(".$etat_id.") and c1.version_id in(".$version_id.")
          inner join ".__racinebd__."gabarit g on g.gabarit_id=a.gabarit_id and g.search=1 where 
          (MATCH(titre1,titre2,contenu,abstract) against('".addquote($query)."' IN BOOLEAN MODE)
          or c1.content_id in(select content_id from ".__racinebd__."tag_search ts inner join ".__racinebd__."tag_search_content tsc on ts.tag_search_id=tsc.tag_search_id where 
          MATCH(ts.libelle) against('".addquote($query)."' IN BOOLEAN MODE))
          or c1.content_id in(select content_id from ".__racinebd__."tag t inner join ".__racinebd__."tag_content tsc on t.tag_id=tsc.tag_id where 
          MATCH(t.libelle) against('".addquote($query)."' IN BOOLEAN MODE))
          $wherepj
          ) and a.supprimer=0";
  $sql="select c1.*,c.arbre_id,a.pere,a.gabarit_id,g.libelle from ".$from." ".$pere." ".$where." ".$orderby." ".$limit;
  //print $sql;
  $link=query($sql);
  $tbl_result_final=array();
  while($tbl_result=fetch($link)){
    $tbl_result_final[]=$tbl_result;
  }
  return ($limit=="limit 1")?$tbl_result_final[0]:$tbl_result_final;
}
function extract2tmpfile($ext,$filename){
	 switch (strtolower($ext)) {
         case 'doc':
         case 'docx':
         $command = PHANTOM_PARSE_MSWORD.' '.PHANTOM_OPTION_MSWORD.' '.$filename;
         break;

         case 'xls':
         case 'xlsx':
         $command = PHANTOM_PARSE_MSEXCEL.' '.PHANTOM_OPTION_MSEXCEL.' '.$filename;
         break;
         
         
         case 'pdf':
         $command = PHANTOM_PARSE_PDF.' '.PHANTOM_OPTION_PDF.' '.$filename;
         break;
         
         
         case 'ppt':
         case 'pptx':
         $command = PHANTOM_PARSE_PPT.' '.PHANTOM_OPTION_PPT.' '.$filename;
         break;
    }
    //print $command;
    if($command!=""){
    	exec($command,$result,$retval);
      if (!$retval) {
     	   // the replacement if ž is for unbreaking spaces
           // returned by catdoc parsing msword files
           // and '0xAD' "tiret quadratin" returned by pstotext
           // in iso-8859-1
           // Adjust with your encoding and/or your tools
           $tempfile=str_replace($filename,$ext,"txt");
           $f_handler = fopen($tempfile,'wb');
           if (is_array($result)) {
               $content.=str_replace('ž',' ',str_replace(chr(0xad),'-',implode(' ',$result)));
           }
           @unlink($tempfile);
      }
      if(strtolower($ext)=="pdf"){
           $tempfile=str_replace($ext,"txt",$filename);
           //print $tempfile; 
           $f_handler = fopen($tempfile,'r');
           $content=fread($f_handler, filesize($filename));         
           //@unlink($tempfile);
      }
    }  
    return $content;
}
?>