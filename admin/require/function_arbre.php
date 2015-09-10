<?php
function listnoeud($pere,$langue_id=__defaultlangueid__){
  //$_POST["langue_id"]=1;            
  $pere=($pere=="_1")?"null":$pere;
  $requete_style = "select style from ".__racinebd__."etat order by etat_id ASC";
  $link_style=query($requete_style);
  while ($ligne_style=fetch($link_style)){
      $style++;
      $le_style[$style] = $ligne_style["style"];
  }
  $style = 0;
  $virgule = 0;
  $requete_child2 = "select a.*,g.libelle from ".__racinebd__."arbre a inner join ".__racinebd__."gabarit g on a.gabarit_id=g.gabarit_id where pere is null and a.supprimer = 0 order by ordre ASC";
  
  if($pere != "null" && $pere != "_2"){
      $_POST["langue_id"] = $_GET["la_langue"];
      $requete_child2 = "select a.*,g.libelle from ".__racinebd__."arbre a inner join ".__racinebd__."gabarit g on a.gabarit_id=g.gabarit_id where pere = ".$pere." and a.supprimer = 0 order by ordre ASC";
  }else if($pere == "_2"){
      $requete_child2 = "select a.*,g.libelle from ".__racinebd__."arbre a inner join ".__racinebd__."gabarit g on a.gabarit_id=g.gabarit_id where a.supprimer = 1 order by ordre ASC";
  }
  
  $link_child2=query($requete_child2);
  while ($ligne2=fetch($link_child2)){
    if($virgule > 0){
      echo ",";
    }
  
    $requete_name = "select nom from ".__racinebd__."contenu where arbre_id = '".$ligne2["arbre_id"]."' and langue_id = '".$langue_id."'";
    //$requete_name = "select nom from ".__racinebd__."contenu where arbre_id = '".$ligne2["arbre_id"]."' and langue_id = '1'";
    //print $requete_name;
    $link_name=query($requete_name);
    if(num_rows($link_name)==0){
      $requete_name = "select nom from ".__racinebd__."contenu where arbre_id = '".$ligne2["arbre_id"]."' and langue_id = '".__defaultlangueid__."'";
      $link_name=query($requete_name);
    }
    $ligne_name=fetch($link_name);
  //while ($ligne_name=fetch($link_name)){
      //echo "{id:'".$ligne2["arbre_id"]."', txt:'".$ligne_name["nom"]." ordre : ".$ligne2["ordre"]."'";
    echo "{id:'".$ligne2["arbre_id"]."', txt:'".$ligne_name["nom"]."'";
    
    //}
    //}
    $requete_souschild = "select arbre_id from ".__racinebd__."arbre A where A.pere = ".$ligne2["arbre_id"]." and A.supprimer = 0";
    $link_souschild=query($requete_souschild);
    $nombre_souschild = num_rows($link_souschild);
    
    if($nombre_souschild > 0){
        echo ",'canhavechildren' : true";
    }
    
    if($ligne2["users_id_verrou"]){
    
      $requete_verrou = "select login from ".__racinebd__."users where users_id = '".$ligne2["users_id_verrou"]."'";
      $link_verrou=query($requete_verrou);
      $ligne_verrou=fetch($link_verrou);
      echo ",'verrou':true";
      echo ",'tooltip' : 'id : ".$ligne2["arbre_id"]." (".str_replace("'","\'",$ligne2["libelle"]).")'";
      if(num_rows($link_verrou)>0){  
        echo ",'tooltipuser' : '".$ligne_verrou["login"]."'";
      }else{
        echo ",'tooltipuser' : 'Super Admin'";
      }
  
    }else{
        echo ",'tooltip' : 'id : ".$ligne2["arbre_id"]." (".str_replace("'","\'",$ligne2["libelle"]).")'";
    }
    echo ",'etat' : ".$ligne2["etat_id"];
    
    if($ligne2["gabarit_id"]){
        $requete_g = "select iconnormal from ".__racinebd__."gabarit where gabarit_id = '".$ligne2["gabarit_id"]."'";
        $link_g=query($requete_g);
      
        while ($ligne_g=fetch($link_g)){ 
    
        echo ",'img':'../../../upload/".__racinebd__."gabarit".$ligne2["gabarit_id"].".".$ligne_g["iconnormal"]."',
        'imgopen':'../../../upload/".__racinebd__."gabarit".$ligne2["gabarit_id"].".".$ligne_g["iconnormal"]."',
        'imgclose':'../../../upload/".__racinebd__."gabarit".$ligne2["gabarit_id"].".".$ligne_g["iconnormal"]."',
        'imgselected':'../../../upload/".__racinebd__."gabarit".$ligne2["gabarit_id"].".".$ligne_g["iconnormal"]."',
        'imgopenselected':'../../../upload/".__racinebd__."gabarit".$ligne2["gabarit_id"].".".$ligne_g["iconnormal"]."',
        'imgcloseselected':'../../../upload/".__racinebd__."gabarit".$ligne2["gabarit_id"].".".$ligne_g["iconnormal"]."'
        ";
        }
    }
    
    if($ligne2["secure"] == "1"){
        //echo "<script type='text/javascript'>alert('lapin')</script>";
        $requete_g = "select iconsecure from ".__racinebd__."gabarit where gabarit_id = '".$ligne2["gabarit_id"]."'";
        $link_g=query($requete_g);
      
        while ($ligne_g=fetch($link_g)){ 
    
        echo ",'img':'../../../upload/".__racinebd__."gabarit2_".$ligne2["gabarit_id"].".".$ligne_g["iconsecure"]."',
        'imgopen':'../../../upload/".__racinebd__."gabarit2_".$ligne2["gabarit_id"].".".$ligne_g["iconsecure"]."',
        'imgclose':'../../../upload/".__racinebd__."gabarit2_".$ligne2["gabarit_id"].".".$ligne_g["iconsecure"]."',
        'imgselected':'../../../upload/".__racinebd__."gabarit2_".$ligne2["gabarit_id"].".".$ligne_g["iconsecure"]."',
        'imgopenselected':'../../../upload/".__racinebd__."gabarit2_".$ligne2["gabarit_id"].".".$ligne_g["iconsecure"]."',
        'imgcloseselected':'../../../upload/".__racinebd__."gabarit2_".$ligne2["gabarit_id"].".".$ligne_g["iconsecure"]."'
        ";
        }
    }
    
    if($ligne2["arbre_id_alias"]){
    
        echo ",'alias' : 1";
        
        echo ",'img':'globe.gif',
        'imgopen':'globe.gif',
        'imgclose':'globe.gif',
        'imgselected':'globe.gif',
        'imgopenselected':'globe.gif',
        'imgcloseselected':'globe.gif'";
    } else {
        echo ",'alias' : 0";
    }
  
    /*if($ligne2["version_id"]){
        $version_id = $le_style[$ligne2["version_id"]];
    }*/
  
    if($ligne2["etat_id"]== "2"){
        $etat_id = $le_style[$ligne2["etat_id"]];
    }
  
    if(!$ligne2["arbre_id_alias"]){
      $requete_table = "select translate from ".__racinebd__."contenu where arbre_id = '".$ligne2["arbre_id"]."'";
      $link_table = query($requete_table);
      while ($ligne_table = fetch($link_table)){
          if($ligne_table["translate"] == "0"){
              $nottranslate = "nottranslate";
              break;
          }
      }
    }
    
    echo ",'style' : '".$etat_id." ".$nottranslate."'";
    $etat_id = "";
    $nottranslate = "";
    
    //cherche_enfant($ligne2["arbre_id"]);
  
    echo "}";
    $virgule++;
  }    
}
function getroot($arbre_id){
  if($arbre_id!=""){
  $sql="select pere,arbre_id from ".__racinebd__."arbre where arbre_id=".$arbre_id;
  $link=query($sql);
  $tbl_result=fetch($link);
  //print $tbl_result["pere"];
  
  while($tbl_result["pere"]!=""){
    $sql="select pere,arbre_id from ".__racinebd__."arbre where arbre_id=".$tbl_result["pere"];
    $link=query($sql);
    $tbl_result=fetch($link);
  }
  //print $tbl_result["pere"];
  return ($tbl_result["arbre_id"]=="")?"null":$tbl_result["arbre_id"];
  }else{
    return "null";
  }
}
function node($arbre_id=0,$etat_id=0,$version_id=0,$langue_id=0){
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  $arbre_id=($arbre_id===0)?$_GET["arbre"]:$arbre_id;
  $etat_id=($etat_id===0)?$_GET["etat_id"]:$etat_id;
  $version_id=($version_id===0)?$_GET["version_id"]:$version_id;
  
  $sql="select c1.*,c.nom,c.arbre_id,a.arbre_id as original,a.gabarit_id,a.pere,a.ordre,a2.secure from 
          ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id
          inner join ".__racinebd__."arbre a on ((c.arbre_id=a.arbre_id and a.arbre_id_alias is null) or (c.arbre_id=a.arbre_id_alias and a.arbre_id_alias is not null)) and c.langue_id=".$langue_id." 
          and a.etat_id in(".$etat_id.") and c1.version_id in(".$version_id.")
          and a.supprimer=0 and a.arbre_id=".$arbre_id." 
          inner join ".__racinebd__."arbre a2 on (a.arbre_id=a2.arbre_id and a.arbre_id_alias is null) or (a.arbre_id_alias=a2.arbre_id and a.arbre_id_alias is not null)";
          
  //print $sql;
  $link=query($sql);
  if(num_rows($link)==0&&$langue_id!=__defaultlangueid__)
    return node($arbre_id,$etat_id,$version_id,$langue_id=__defaultlangueid__);
  else
    return fetch($link);
}
function nodelistall($limit=0,$orderby="ordre",$gabarit_id=0,$where='',$etat_id=0,$version_id=0,$langue_id=0){
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  $limit=($limit==0)?"":"limit ".$limit;
  $orderby="order by ".$orderby;
  $etat_id=($etat_id==0)?$_GET["etat_id"]:$etat_id;
  $version_id=($version_id==0)?$_GET["version_id"]:$version_id;
  $gabarit_id=($gabarit_id==0)?"":"and a.gabarit_id in (".$gabarit_id.")";

  $sql="select a.arbre_id from 
          ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
          inner join ".__racinebd__."arbre a on ((c.arbre_id=a.arbre_id and a.arbre_id_alias is null) or (c.arbre_id=a.arbre_id_alias and a.arbre_id_alias is not null)) and c.langue_id=".__defaultlangueid__."
          inner join ".__racinebd__."gabarit g on g.gabarit_id=a.gabarit_id  
          and a.etat_id in(".$etat_id.") and c1.version_id in(".$version_id.")
          and a.supprimer=0 ".$gabarit_id." ".$where." ".$orderby." ".$limit;
  //print $sql;
  $link=query($sql);
  $tbl_result_final=array();
  while($tbl_result=fetch($link)){
    $tbl=node($tbl_result["arbre_id"],$etat_id,$version_id,$langue_id);
    if($tbl["arbre_id"]!=""){
      $tbl_result_final[]=$tbl;
    }
  }
  return ($limit=="limit 1")?$tbl_result_final[0]:$tbl_result_final;
}
function nodelist($pere=0,$limit=0,$orderby="ordre",$gabarit_id=0,$where='',$etat_id=0,$version_id=0,$langue_id=0){
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  $pere=($pere===0)?$_GET["arbre"]:$pere;
  $limit=($limit==0)?"":"limit ".$limit;
  $orderby="order by ".$orderby;
  $etat_id=($etat_id==0)?$_GET["etat_id"]:$etat_id;
  $version_id=($version_id==0)?$_GET["version_id"]:$version_id;
  $gabarit_id=($gabarit_id==0)?"":"and a.gabarit_id in (".$gabarit_id.")";

  $sql="select a.arbre_id from 
          ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
          inner join ".__racinebd__."arbre a on ((c.arbre_id=a.arbre_id and a.arbre_id_alias is null) or (c.arbre_id=a.arbre_id_alias and a.arbre_id_alias is not null)) and c.langue_id=".__defaultlangueid__."
          inner join ".__racinebd__."gabarit g on g.gabarit_id=a.gabarit_id  
          and a.etat_id in(".$etat_id.") and c1.version_id in(".$version_id.")
          and a.supprimer=0 and a.pere=".$pere." ".$gabarit_id." ".$where." ".$orderby." ".$limit;
  //print $sql."<br>";
  /*
  $sql="select a.arbre_id from ".__racinebd__."contenu c  
          inner join ".__racinebd__."arbre a on ((c.arbre_id=a.arbre_id and a.arbre_id_alias is null) or (c.arbre_id=a.arbre_id_alias and a.arbre_id_alias is not null)) and c.langue_id=".$langue_id."
          inner join ".__racinebd__."gabarit g on g.gabarit_id=a.gabarit_id  
          and a.etat_id in(".$etat_id.")
          and a.supprimer=0 and a.pere=".$pere." ".$gabarit_id." ".$where." ".$orderby." ".$limit;
  */
  
  /*
  $sql="select arbre_id from arbre a
          inner join gabarit g on a.gabarit_id=g.gabarit_id and a.supprimer=0 and a.pere=".$pere." ".$gabarit_id."  
          ".$where." ".$orderby." ".$limit;
  */
  //print $sql;
  $link=query($sql);
  $tbl_result_final=array();
  while($tbl_result=fetch($link)){
    $tbl=node($tbl_result["arbre_id"],$etat_id,$version_id,$langue_id);
    if($tbl["arbre_id"]!=""){
      $tbl_result_final[]=$tbl;
    }
  }
  return ($limit=="limit 1")?$tbl_result_final[0]:$tbl_result_final;
}
function nodelistgp($grandpere=0,$limit=0,$orderby="a.ordre",$gabarit_id=0,$where='',$etat_id=0,$version_id=0,$langue_id=0){
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  $grandpere=($grandpere===0)?$_GET["arbre"]:$grandpere;
  $limit=($limit==0)?"":"limit ".$limit;
  $orderby="order by ".$orderby;
  $etat_id=($etat_id==0)?$_GET["etat_id"]:$etat_id;
  $version_id=($version_id==0)?$_GET["version_id"]:$version_id;
  $gabarit_id=($gabarit_id==0)?"":"and a.gabarit_id in(".$gabarit_id.")";

  $sql="select a.arbre_id from 
          ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
          inner join ".__racinebd__."arbre a on ((c.arbre_id=a.arbre_id and a.arbre_id_alias is null) or (c.arbre_id=a.arbre_id_alias and a.arbre_id_alias is not null)) and c.langue_id=".__defaultlangueid__."
          inner join ".__racinebd__."gabarit g on g.gabarit_id=a.gabarit_id
          inner join ".__racinebd__."arbre a2 on a.pere=a2.arbre_id  
          and a.etat_id in(".$etat_id.") and c1.version_id in(".$version_id.")
          and a.supprimer=0 and a2.pere=".$grandpere." ".$gabarit_id." ".$where." ".$orderby." ".$limit; 
  /*
  $sql="select arbre_id from arbre a
          inner join gabarit g on a.gabarit_id=g.gabarit_id and a.supprimer=0 and a.pere=".$pere." ".$gabarit_id."  
          ".$where." ".$orderby." ".$limit;
  */
  //print $sql;
  $link=query($sql);
  $tbl_result_final=array();
  while($tbl_result=fetch($link)){
    $tbl=node($tbl_result["arbre_id"],$etat_id,$version_id,$langue_id);
    if($tbl["arbre_id"]!=""){
      $tbl_result_final[]=$tbl;
    }
  }
  return ($limit=="limit 1")?$tbl_result_final[0]:$tbl_result_final;
}
function search($query,$pere=0,$limit=0,$orderby="gabarit_id,pere",$where='',$etat_id=0,$version_id=0,$langue_id=0){
  return searchPhantom($query,'',false,$pere,$limit,$orderby,$where,$etat_id,$version_id,$langue_id);
  /*
  $langue_id=($langue_id==0&&$_GET["la_langue"]=="")?__defaultlangueid__:(($langue_id!="")?$langue_id:$_GET["la_langue"]);
  $pere=($pere===0)?"":"and a.pere in (".$pere.")";
  $limit=($limit==0)?"":"limit ".$limit;
  $orderby="order by ".$orderby;
  $etat_id=($etat_id==0)?$_GET["etat_id"]:$etat_id;
  $version_id=($version_id==0)?$_GET["version_id"]:$version_id;
  $from ="".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
          inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=".$langue_id." 
          and a.etat_id in(".$etat_id.") and c1.version_id in(".$version_id.")
          inner join ".__racinebd__."gabarit g on g.gabarit_id=a.gabarit_id and g.search=1 where 
          (MATCH(titre1,titre2,contenu,abstract) against('".addquote($query)."' IN BOOLEAN MODE)
          or c1.content_id in(select content_id from ".__racinebd__."tag_search ts inner join ".__racinebd__."tag_search_content tsc on ts.tag_search_id=tsc.tag_search_id where 
          MATCH(ts.libelle) against('".addquote($query)."' IN BOOLEAN MODE))
          or c1.content_id in(select content_id from ".__racinebd__."tag t inner join ".__racinebd__."tag_content tsc on t.tag_id=tsc.tag_id where 
          MATCH(t.libelle) against('".addquote($query)."' IN BOOLEAN MODE))
          ) and a.supprimer=0";
  $sql="select c1.*,c.arbre_id,a.pere,a.gabarit_id,g.libelle from ".$from." ".$pere." ".$where." ".$orderby." ".$limit;
  //print $sql;
  $link=query($sql);
  $tbl_result_final=array();
  while($tbl_result=fetch($link)){
    $tbl_result_final[]=$tbl_result;
  }
  return ($limit=="limit 1")?$tbl_result_final[0]:$tbl_result_final;
  */
}
function majrules($arbre_id,$child){
  $sql="delete from ".__racinebd__."groupe_arbre where arbre_id=".$arbre_id;
  query($sql);
  $sql="select * from ".__racinebd__."groupe order by libelle";
  $link_groupe=query($sql);
  $i=0;
  while($tbl_result_groupe=fetch($link_groupe)){
    for($j=0;$j<count($_POST["groupe_".$tbl_result_groupe["groupe_id"]."_droits_id"]);$j++){
      $sql="insert into ".__racinebd__."groupe_arbre (droits_id,groupe_id,arbre_id) values (".$_POST["groupe_".$tbl_result_groupe["groupe_id"]."_droits_id"][$j].",".$tbl_result_groupe["groupe_id"].",".$arbre_id.")";
      query($sql);
    }
  }
  if($child){
    $sql="select * from ".__racinebd__."arbre where pere=".$arbre_id." and supprimer=0";
    $link_child=query($sql);
    while($tbl_result_child=fetch($link_child)){
      majrules($tbl_result_child["arbre_id"],$child);
    }
  }
}
function getancestor($arbre_id=0,$tbl_ancestor=array()){
  $arbre_id=($arbre_id===0)?$_GET["arbre"]:$arbre_id;
  $sql="select pere from ".__racinebd__."arbre where arbre_id=".$arbre_id;
  $link=query($sql);
  $tbl_result=fetch($link);
  //print_r($tbl_ancestor);
  if($tbl_result["pere"]!=""){
    //print "ici";
    $tbl_ancestor[]=$tbl_result["pere"];
    return getancestor($tbl_result["pere"],$tbl_ancestor);
  }else{
    //print $tbl_ancestor;
    return array_reverse($tbl_ancestor);
    //return $tbl_ancestor;
  }
}
function cloud($site_id=__defaultfather__,$limit=10){
  //print $site_id;
  $sql="select count(t.tag_id)+ponderation as nb,t.libelle from ".__racinebd__."tag t inner join ".__racinebd__."tag_content tc on t.tag_id=tc.tag_id inner join
  ".__racinebd__."content c on c.content_id=tc.content_id inner join ".__racinebd__."contenu c1 on c.contenu_id=c1.contenu_id 
  and version_id=1 inner join ".__racinebd__."arbre a on a.root=".__defaultfather__." and a.arbre_id=c1.arbre_id and etat_id=1  group by t.tag_id order by count(t.tag_id)+ponderation desc limit ".$limit;
  $link=query($sql);
  $tbl_result_final=array();
  $i=1;
  while($tbl_result=fetch($link)){
    $tbl_result_final[]=array($i++,$tbl_result["libelle"]);
  }
  shuffle($tbl_result_final);
  return $tbl_result_final;
}
function tag($arbre_id=0){
  $arbre_id=($arbre_id===0)?$_GET["arbre"]:$arbre_id;
  $sql="select t.* from ".__racinebd__."tag t 
  inner join ".__racinebd__."tag_content tc 
  inner join ".__racinebd__."content c on c.content_id=tc.content_id
  inner join ".__racinebd__."contenu c1 on c1.contenu_id=c.contenu_id and c1.arbre_id=".$arbre_id."
  inner join ".__racinebd__."arbre a on a.arbre_id=c1.arbre_id and a.etat_id=1 and c1.langue_id=".__defaultlangueid__." 
  where t.tag_id=tc.tag_id and c.version_id=1 and t.supprimer=0 order by t.libelle";
  $link=query($sql);
  while($tbl_result=fetch($link)){
    $tbl_result_final[]=$tbl_result;
  }
  return $tbl_result_final;
}
function contextfile($arbre_id=0,$etat_id=0,$version_id=0){
  $arbre_id=($arbre_id===0)?$_GET["arbre"]:$arbre_id;
  $etat_id=($etat_id===0)?$_GET["etat_id"]:$etat_id;
  $version_id=($version_id===0)?$_GET["version_id"]:$version_id;
  $sql="select f.* from ".__racinebd__."fichiers f
  inner join ".__racinebd__."content c on c.content_id=f.content_id and c.version_id=1 
  inner join ".__racinebd__."contenu c1 on c1.contenu_id=c.contenu_id and c1.arbre_id=".$arbre_id." and c1.langue_id=".__defaultlangueid__." 
  inner join ".__racinebd__."arbre a on a.arbre_id=c1.arbre_id and a.etat_id=".$etat_id." and f.supprimer=0 order by f.titre";
  $link=query($sql);
  while($tbl_result=fetch($link)){
    $tbl_result["url"]=urlfile($tbl_result["fichiers_id"],$tbl_result["nom_fichier"]);
    $tbl_result_final[]=$tbl_result;
  }
  return $tbl_result_final;
}
function urlfile($id,$nom_fichier){
  return urlp(((int)__defaultfather__==0)?1:__defaultfather__)."/download/".$id."/".$nom_fichier;  
}
function urlimg($content_id,$indice,$nom_fichier,$ext,$indicevignette=0,$size=0,$table="content"){
  //return __defaultfather__;
  if($size==0){
  return urlp(((int)__defaultfather__==0)?1:__defaultfather__)."/image/".$content_id."/".$indice."/".$indicevignette."/".$table."/".makename($nom_fichier).".".$ext; 
  }else{
  return urlp(((int)__defaultfather__==0)?1:__defaultfather__)."/image/".$content_id."/".$indice."/".$indicevignette."/".$table."/".$size."/".makename($nom_fichier).".".$ext; 
  
  }
}
function linkarticle($arbre_id=0,$etat_id=0,$version_id=0,$limit=3,$onlysite=0){

  $arbre_id=($arbre_id===0)?$_GET["arbre"]:$arbre_id;
  $etat_id=($etat_id===0)?$_GET["etat_id"]:$etat_id;
  $version_id=($version_id===0)?$_GET["version_id"]:$version_id;
  $site=($onlysite==1)?"and a.root=".__defaultfather__:"and a.root!=".__defaultfather__;
  $tab=tag($arbre_id);
  for($i=0;$i<count($tab);$i++){
    $tab2[]=$tab[$i]["tag_id"];
  }
  if(count($tab)>0){
    $sql="select distinct c1.*,c.arbre_id from 
    ".__racinebd__."content c1 inner join ".__racinebd__."contenu c on c1.contenu_id=c.contenu_id  
    inner join ".__racinebd__."tag_content tc on c1.content_id=tc.content_id 
    inner join ".__racinebd__."arbre a on c.arbre_id=a.arbre_id and c.langue_id=".__defaultlangueid__." 
    and a.supprimer=0 and a.etat_id=".$_GET["etat_id"]." and c1.version_id=".$_GET["version_id"]." 
    and tc.tag_id in (".implode(",",$tab2).") 
    and c.arbre_id!=".$_GET["arbre"]." ".$site." order by c1.titre1 limit ".$limit;
    //print $sql;
    $link2=query($sql);
        
    while($tbl_result=fetch($link2)){
      $tbl_result_final[]=$tbl_result;
    }
    
  }
  return $tbl_result_final;
}
function deleteFinalNode($node_id){
  // Je supprime le noeud
  $requete_supp2 = "update ".__racinebd__."arbre set supprimer = 2 where supprimer = 1 and arbre_id = ".$node_id;
  $link_update2=query($requete_supp2);
  // Je liste les element ayant arbre_id_alias du noeud que l'on supprime
  $requete_select = "select * from ".__racinebd__."arbre where arbre_id_alias = ".$node_id." order by arbre_id ASC";
  $link_select=query($requete_select);
  while ($ligne_select=fetch($link_select)){
      // Je r +ƒ-¸cup +…-¡re l'arbre_id de l' +ƒ-¸l +ƒ-¸ment, son ordre et son p +…-¡re
      $mon_arbre_id_en_cours = $ligne_select['arbre_id'];
      $mon_ordre_en_cours = $ligne_select['ordre'];
      $mon_pere_en_cours = $ligne_select['pere'];
      $requete_supp3 = "update ".__racinebd__."arbre set supprimer = 2 where arbre_id = ".$mon_arbre_id_en_cours;
      $link_update3=query($requete_supp3);
      // Remise a niveau
      $sql="update ".__racinebd__."arbre set ordre=ordre-1 where pere ".(($mon_pere_en_cours=="")?"is null":"=".$mon_pere_en_cours)." and supprimer=0 and ordre>=".$mon_ordre_en_cours;
      query($sql);
  }
  $requete_supp4 = "update ".__racinebd__."log set supprimer = 1 where arbre_id = ".$node_id;
  $link_update4=query($requete_supp4);
}
function renameNode($node_id,$old_value,$new_value){
  if($new_value!=""){
    //on regarde si on est au premier niveau
    $sql="select * from ".__racinebd__."arbre where arbre_id=".$node_id;
    $link=query($sql);
    $tbl_result=fetch($link);
    $droit=true;
    if($tbl_result["pere"]==""){
      $droit=testGenRules("RULR");
    }
    $droit=$droit||testdroitarbre($node_id,"REN");
    if($droit){
      if (isset($node_id)) {
      	//echo stripslashes($_POST['new_value']);
        //makename($string);
        
        if($tbl_result["pere"]==""&&$tbl_result["gabarit_id"]==__gabidsite__){
          $newvalue=$new_value;  
        }else{
          $newvalue=makename($new_value);
        }
        $requete_update = "update ".__racinebd__."contenu set nom = '".$newvalue."' where arbre_id = ".$node_id." and langue_id = '".$_GET["la_langue"]."'";
        $link_update=query($requete_update);
        return $newvalue;
      }
    }else{
      return $old_value;
    }
  }else{
    return $old_value;
  }
}
function chgEtat($node_id){
  //on regarde si on est au premier niveau
  $sql="select * from ".__racinebd__."arbre where arbre_id=".$node_id;
  $link=query($sql);
  $tbl_result=fetch($link);
  $droit=true;
  if($tbl_result["pere"]==""){
    $droit=testGenRules("RULR");
  }
  $droit=$droit||testdroitarbre($node_id,"PUB");
  if($droit){
    $sql = "select etat_id from ".__racinebd__."arbre where arbre_id = ".$node_id;
    $link=query($sql);
    $tbl_result=fetch($link);
    $etat=($tbl_result["etat_id"]==1)?2:1;
    $sql = "update ".__racinebd__."arbre set etat_id=".$etat.",datepublication='0000-00-00 00:00:00',datedepublication='0000-00-00 00:00:00' where arbre_id = ".$node_id;
    query($sql);
    //publication depublication des alias
    $sql = "update ".__racinebd__."arbre set etat_id=".$etat.",datepublication='0000-00-00 00:00:00',datedepublication='0000-00-00 00:00:00' where supprimer=0 and arbre_id_alias = ".$node_id;
    query($sql);
  }
  return $droit;
}
function retoreNode($node_id){
    $requete_mouv = "select pere from ".__racinebd__."arbre where arbre_id = ".$node_id;
    $link_mouv=query($requete_mouv);
    while ($ligne_mouv=fetch($link_mouv)){
      $result_pere = $ligne_mouv["pere"];
    } 
    if($result_pere != ""){
        $requete_restaure = "select arbre_id from ".__racinebd__."arbre where pere = ".$result_pere." and supprimer = 0";
    } else {
        $requete_restaure = "select arbre_id from ".__racinebd__."arbre where pere is null and supprimer = 0";
    }
    $link_restaure=query($requete_restaure);
    $nombre_restaure = num_rows($link_restaure);
    
    $requete_update = "update ".__racinebd__."arbre set supprimer = 0 where arbre_id = ".$node_id;
    $link_update=query($requete_update);
    
    $requete_update = "update ".__racinebd__."arbre set ordre = ".($nombre_restaure + 1)." where arbre_id = ".$node_id;
    $link_update=query($requete_update);
    
    if($result_pere){
      return $result_pere;
    } else {
      return "_1";
    }
}
function lockNode($node_id){
  //on regarde si on est au premier niveau
  $sql="select * from ".__racinebd__."arbre where arbre_id=".$node_id;
  $link=query($sql);
  $tbl_result=fetch($link);
  $droit=true;
  if($tbl_result["pere"]==""){
    $droit=testGenRules("RULR");
  }
  $droit=$droit||testdroitarbre($node_id,"VER");
  if($droit){
    $requete_child2 = "select users_id_verrou from ".__racinebd__."arbre where arbre_id = ".$node_id;
    $link_child2=query($requete_child2);
    
    while ($ligne2=fetch($link_child2)){
      $result = $ligne2['users_id_verrou'];
    }
    
    if($result == 0){
        $requete_update = "update ".__racinebd__."arbre set users_id_verrou = ".$_SESSION["users_id"]." where arbre_id = ".$node_id;
    } else {
        $requete_update = "update ".__racinebd__."arbre set users_id_verrou = NULL where arbre_id = ".$node_id;
    }
    $link_update=query($requete_update);
  }
  return $droit;
}
function deleteNode($dragID){
    //suppression du fichier
    //on recherche le pere du noeud a supprimer et son ordre actuel
    $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dragID;
    $link=query($sql);
    $ligne=fetch($link);
    $pere=$ligne["pere"];
    $ordre=$ligne["ordre"];
    //on flag supprimer=1 pour lui mais pas pour son arborescence (pour le restaure au cas ou), on ne reinitialise pas l'ordre car la poubelle ne se range pas
    $sql="update ".__racinebd__."arbre set supprimer=1 where arbre_id=".$dragID;
    query($sql);
    
    //on modifie tous les ordres des freres ayant un ordre plus grand que le mien
    $sql="update ".__racinebd__."arbre set ordre=ordre-1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre>=".$ordre;
    query($sql);
    return true;
}
function createAlias($dragID,$dropID){
    if($dropID == "_1"){
        $requete_pere_alias = "select arbre_id from ".__racinebd__."arbre where pere is null and supprimer = 0";
        $link_pere_alias=query($requete_pere_alias);
        $nombre_pere_alias = num_rows($link_pere_alias);
        $mon_pere_dropID = "";
    } else {
        $requete_pere_alias = "select arbre_id from ".__racinebd__."arbre where pere = ".$dropID." and supprimer = 0";
        $link_pere_alias=query($requete_pere_alias);
        $nombre_pere_alias = num_rows($link_pere_alias);
        $mon_pere_dropID = $dropID;
    }

    $requete = "select * from ".__racinebd__."arbre where arbre_id = ".$dragID;
    $link=query($requete);
    $ligne=fetch($link);

    $requete_insert = "insert into ".__racinebd__."arbre (gabarit_id,pere,supprimer,users_id_crea,users_id_verrou,arbre_id_alias,secure,ordre,etat_id) values (
    ".(($ligne['gabarit_id']=="")?"null":$ligne['gabarit_id']).",
    ".(($mon_pere_dropID=="")?"null":$mon_pere_dropID).",
    ".(($ligne['supprimer']=="")?"null":$ligne['supprimer']).",
    ".$_SESSION["users_id"].",
    ".(($ligne['users_id_verrou']=="")?"null":$ligne['users_id_verrou']).",
    ".$dragID.",
    ".(($ligne['secure']=="")?"null":$ligne['secure']).",
    ".(($ligne['ordre']=="")?"null":($nombre_pere_alias + 1)).",
    ".(($ligne['etat_id']=="")?"null":$ligne['etat_id'])."
    
    )";
    $link_insert=query($requete_insert);

    //".(($ligne['langue_id']=="")?"null":$ligne['langue_id']).",
    //'".$ligne['nom']."',
    
    $dernier_ajout = insert_id();
    
    
    $requete_select = "select * from ".__racinebd__."contenu where arbre_id = ".$dragID;
    $link_select=query($requete_select);
    while($ligne_select=fetch($link_select)){
        $requete_insert = "insert into ".__racinebd__."contenu (arbre_id,langue_id,translate,nom) values (
        ".$dernier_ajout.",
        ".$ligne_select['langue_id'].",
        ".$ligne_select['translate'].",
        'alias__".$ligne_select['nom']."'
        )";
        $link_insert=query($requete_insert);
    }
    
    //affectation des droits identique a ceux du pere
		$sql="select * from ".__racinebd__."groupe_arbre where arbre_id='".(($mon_pere_dropID=="")?"null":$mon_pere_dropID)."'";
		$link=query($sql);
		if(num_rows($link)>0){
			while($tbl_result=fetch($link)){
        $sql="insert into ".__racinebd__."groupe_arbre (arbre_id,droits_id,groupe_id) values (".$dernier_ajout.",".$tbl_result["droits_id"].",".$tbl_result["groupe_id"].")";
        query($sql);
			}
		}
    
    return array(true,$dernier_ajout);
}
function moveBeforeNode($dragID,$dropID){
//deplacement du noeud en tant que frere
    //on recherche son ordre actuel
    $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dragID;
    $link=query($sql);
    $ligne=fetch($link);
    $ordre=$ligne["ordre"];
    $pere=$ligne["pere"];
    //on recherche l' ordre actuel de son frere
    $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dropID;
    $link=query($sql);
    $ligne=fetch($link);
    $newordre=$ligne["ordre"];
    $newpere=$ligne["pere"];   
    //on modifie tous les ordres des freres ayant un ordre plus petit que le mien et plus grand que mon frere
    //$sql="update arbre set ordre=ordre+1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre<".$ordre." and ordre >".(($newordre>$ordre)?"":"=").$newordre;
    if($newordre>$ordre){
      $sql="update ".__racinebd__."arbre set ordre=ordre-1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre<=".$newordre." and ordre >".$ordre;
    }else{
      $sql="update ".__racinebd__."arbre set ordre=ordre+1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre<".$ordre." and ordre >=".$newordre;
    }
    //print $sql."<br>";
    query($sql);
    //on modifie mon ordre
    $sql="update ".__racinebd__."arbre set ordre=".$newordre.",pere=".$newpere." where arbre_id=".$dragID;
    //print $sql."<br>";
    query($sql);
    return true;
}
function moveCrossNode($dragID,$dropID){
    //deplacement du noeud en tant que frere
    //on recherche son ordre actuel
    $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dragID;
    $link=query($sql);
    $ligne=fetch($link);
    $ordre=$ligne["ordre"];
    $pere=$ligne["pere"];
    //on recherche l' ordre actuel de son frere
    $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dropID;
    $link=query($sql);
    $ligne=fetch($link);
    $newordre=$ligne["ordre"];
    $newpere=$ligne["pere"];   
    //on modifie tous les ordres des freres ayant un ordre plus petit que le mien et plus grand que mon frere
    //$sql="update arbre set ordre=ordre+1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre<".$ordre." and ordre >".(($newordre>$ordre)?"":"=").$newordre;
    $sql="update ".__racinebd__."arbre set ordre=ordre-1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre>=".$ordre;
    query($sql);
    
    $sql="update ".__racinebd__."arbre set ordre=ordre+1 where supprimer=0 and pere".(($newpere=="")?" is null ":"=".$newpere)." and ordre<=".$newordre;
    //print $sql."<br>";
    query($sql);
    //on modifie mon ordre
    $sql="update ".__racinebd__."arbre set ordre=".$newordre.",pere=".$newpere." where arbre_id=".$dragID;
    //print $sql."<br>";
    query($sql);
    return true;
}
function moveFirstNode($dragID){
    //on recherche son ordre actuel
    $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dragID;
    $link=query($sql);
    $ligne=fetch($link);
    $ordre=$ligne["ordre"];
    $pere=$ligne["pere"];
    //remise a niveau des ordres
    $sql="update ".__racinebd__."arbre set ordre=ordre+1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre<=".$ordre;
    query($sql);
    //remise a niveau de l'ordre du noeud déplacer
    $sql="update ".__racinebd__."arbre set ordre=1 where arbre_id=".$dragID;
    query($sql);
    return true;
}
function moveLastNode($dragID){
    //on recherche son ordre actuel
    $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dragID;
    $link=query($sql);
    $ligne=fetch($link);
    $ordre=$ligne["ordre"];
    $pere=$ligne["pere"];
    //on recherche le max ordre actuel
    $sql="select max(ordre) as max from ".__racinebd__."arbre where pere=".$pere;
    $link=query($sql);
    $ligne=fetch($link);
    $max=$ligne["max"];
    //remise a niveau des ordres
    $sql="update ".__racinebd__."arbre set ordre=ordre-1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre>=".$ordre;
    //print $sql."<br>";
    query($sql);
    //remise a niveau de l'ordre du noeud déplacer
    $sql="update ".__racinebd__."arbre set ordre=".$max." where arbre_id=".$dragID;
    //print $sql."<br>";
    query($sql);
    return true;
}
function copyNode($dragID,$dropID,$chgname=true){
if($dropID == "_1"){
    $requete_pere_alias = "select arbre_id from ".__racinebd__."arbre where pere is null and supprimer = 0";
    $link_pere_alias=query($requete_pere_alias);
    $nombre_pere_alias = num_rows($link_pere_alias);
    $mon_pere_dropID = "";
} else {
    $requete_pere_alias = "select arbre_id from ".__racinebd__."arbre where pere = ".$dropID." and supprimer = 0";
    $link_pere_alias=query($requete_pere_alias);
    $nombre_pere_alias = num_rows($link_pere_alias);
    $mon_pere_dropID = $dropID;
}

//$requete = "select * from arbre where arbre_id = ".$dragID." and langue_id = '".$_GET["la_langue"]."'";
$requete = "select * from ".__racinebd__."arbre where arbre_id = ".$dragID;
$link=query($requete);
while ($ligne=fetch($link)){

    $requete_insert = "insert into ".__racinebd__."arbre (gabarit_id,pere,supprimer,users_id_crea,users_id_verrou,arbre_id_alias,secure,ordre,etat_id,root) values (
    ".(($ligne['gabarit_id']=="")?"null":$ligne['gabarit_id']).",
    ".(($mon_pere_dropID=="")?"null":$mon_pere_dropID).",
    ".(($ligne['supprimer']=="")?"null":$ligne['supprimer']).", 
    ".$_SESSION["users_id"].",
    ".(($ligne['users_id_verrou']=="")?"null":$ligne['users_id_verrou']).",
    ".(($ligne['arbre_id_alias']=="")?"null":$ligne['arbre_id_alias']).",
    ".(($ligne['secure']=="")?"null":$ligne['secure']).",
    ".(($ligne['ordre']=="")?"null":($nombre_pere_alias + 1)).",
    ".(($ligne['etat_id']=="")?"null":$ligne['etat_id']).",
    ".getroot($mon_pere_dropID)."
    )";
    $link_insert=query($requete_insert);
}

$dernier_ajout = insert_id();
//for($j=1;$j<=2;$j++){

    //$requete_select = "select * from contenu where arbre_id = ".$dragID." and langue_id = ".$j;
    $requete_select = "select * from ".__racinebd__."contenu where arbre_id = ".$dragID;
    
    $link_select=query($requete_select);
    while ($ligne_select=fetch($link_select)){
        $name=($chgname)?makename("clone__".$ligne_select['nom']):$ligne_select['nom'];
        $requete_insert_contenu = "insert into ".__racinebd__."contenu (arbre_id,langue_id,translate,nom) values (
        ".$dernier_ajout.",
        ".$ligne_select['langue_id'].",
        ".$ligne_select['translate'].",
        '".$name."'
        )";
        $link_insert_contenu=query($requete_insert_contenu);

        $dernier_ajout_contenu = insert_id();    

        $requete_select_content = "select * from ".__racinebd__."content where contenu_id = ".$ligne_select['contenu_id'];
        $link_select_content=query($requete_select_content);

        //$result = mysql_query("select * from table"); 

        

        while ($ligne_select_content=fetch($link_select_content)){
            $requete="insert into ".__racinebd__."content ";
            
            $listchamps=array();
            $listvalue=array();
            $listext=array();
            $listchamps[]="contenu_id";
            $listvalue[]=$dernier_ajout_contenu;
            for ($i = 0; $i < mysql_num_fields($link_select_content); $i++) {
              if(mysql_field_name($link_select_content, $i)!="content_id"&&mysql_field_name($link_select_content, $i)!="contenu_id"){
              $listchamps[]=mysql_field_name($link_select_content, $i); 
              if(strpos(mysql_field_name($link_select_content, $i),"ext")===false){
              $listvalue[]="'".addslashes($ligne_select_content[mysql_field_name($link_select_content, $i)])."'";
              }else{
              $listvalue[]=($ligne_select_content[mysql_field_name($link_select_content, $i)]=="")?"null":"'".$ligne_select_content[mysql_field_name($link_select_content, $i)]."'";
              $listext[]= mysql_field_name($link_select_content, $i);
              }
              }
            } 

            $requete_insert_content= "insert into ".__racinebd__."content (".implode(",",$listchamps).") values(".implode(",",$listvalue).")";
            //print $requete_insert_content;
            //echo $requete_insert_content;
            $link_insert_content=query($requete_insert_content);
            $dernier_ajout_content = insert_id();
            
            for($listextindice=0;$listextindice<count($listext);$listextindice++){           
              $suffixe=($listextindice==0)?"":($listextindice+1)."_";
              //print $_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]]."<br>";
              @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              for($i=0;$i<5;$i++){
                @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$i.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$i.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              }  
            }          
            
            $requete_select_fichier = "select * from ".__racinebd__."fichiers where content_id = ".$ligne_select_content['content_id']." and supprimer=0";
            $link_select_fichier=query($requete_select_fichier);

            while ($ligne_select_fichier=fetch($link_select_fichier)){                        
                $requete_insert_fichier = "insert into ".__racinebd__."fichiers (content_id,titre,abstract,ext,nom_fichier,supprimer,contenu) values (
                ".$dernier_ajout_content.",
                '".addslashes($ligne_select_fichier['titre'])."',
                '".addslashes($ligne_select_fichier['abstract'])."',
                ".(($ligne_select_fichier['ext']=="")?"null":"'".$ligne_select_fichier['ext']."'").",
                '".addslashes($ligne_select_fichier['nom_fichier'])."',
                ".$ligne_select_fichier['supprimer'].",
                '".addslashes($ligne_select_fichier['contenu'])."'
                )";
                $link_insert_fichier=query($requete_insert_fichier);
                $dernier_ajout_fichier = insert_id();
                
                copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'fichiers'.$ligne_select_fichier['fichiers_id'].'.'.$ligne_select_fichier['ext'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'fichiers'.$dernier_ajout_fichier.'.'.$ligne_select_fichier['ext']);
            }
        }
    }   
		//affectation des droits identique a ceux du pere
		$sql="select * from ".__racinebd__."groupe_arbre where arbre_id='".(($mon_pere_dropID=="")?"null":$mon_pere_dropID)."'";
		$link=query($sql);
		if(num_rows($link)>0){
			while($tbl_result=fetch($link)){
        $sql="insert into ".__racinebd__."groupe_arbre (arbre_id,droits_id,groupe_id) values (".$dernier_ajout.",".$tbl_result["droits_id"].",".$tbl_result["groupe_id"].")";
        query($sql);
			}
		}
    
    return array(true,$dernier_ajout);
}
function moveNode($dragID,$dropID){
    //on recherche son ordre actuel
    $sql="select pere,ordre from ".__racinebd__."arbre where arbre_id=".$dragID;
    $link=query($sql);
    $ligne=fetch($link);
    $ordre=$ligne["ordre"];
    $pere=$ligne["pere"];
    //on recherche ne nombre de fils du nouveau pere
    $sql="select max(ordre)as maxordre from ".__racinebd__."arbre where supprimer=0 and pere".(($dropID=="_1")?" is null":"=".$dropID);
    $link=query($sql);
    $ligne=fetch($link);
    $newordre=$ligne["maxordre"];
    $newpere=($dropID=="_1")?"null":$dropID;
    $newordre=($pere==$newpere||$pere==""&&$newpere=="null")?$newordre-1:$newordre;
    //on modifie tous les ordres des freres ayant un ordre plus grand que le mien
    $sql="update ".__racinebd__."arbre set ordre=ordre-1 where supprimer=0 and pere".(($pere=="")?" is null ":"=".$pere)." and ordre>=".$ordre;
    query($sql);
    //print $sql."<br>";
    $sql="update ".__racinebd__."arbre set ordre=".($newordre+1).", pere = ".(($newpere=="")?"null":$newpere).",root=".getroot($newpere)." where arbre_id=".$dragID;
    //print $sql."<br>";
    query($sql);
    return true;
}
function recursiveCopy($dragID,$dropID){
  if($dragID!=$dropID){
    $result=copyNode($dragID,$dropID,false);
    $sql="select * from ".__racinebd__."arbre where supprimer=0 and pere=".$dragID." order by ordre";
    $link=query($sql);
    while($ligne=fetch($link)){
      recursiveCopy($ligne["arbre_id"],$result[1]);
    }
  }
}
function finaldelete($arbre_id){
  //recherche des fils
  $sql="select * from ".__racinebd__."arbre where pere=".$arbre_id;
  $link=query($sql);
  while($tbl_result=fetch($link)){
    finaldelete($tbl_result["arbre_id"]);
  }
  $sql="delete from ".__racinebd__."groupe_arbre where arbre_id=".$arbre_id;
  query($sql);
  $sql="delete from ".__racinebd__."log where arbre_id=".$arbre_id;
  query($sql);
  $sql="select * from ".__racinebd__."contenu c inner join ".__racinebd__."content c1 on c1.contenu_id=c.contenu_id where arbre_id=".$arbre_id;
  $link2=query($sql);
  while($tbl_result2=fetch($link2)){
    $sql="delete from ".__racinebd__."fichiers where content_id=".$tbl_result2["content_id"];
    query($sql);
    $sql="delete from ".__racinebd__."tag_content where content_id=".$tbl_result2["content_id"];
    query($sql);
    $sql="delete from ".__racinebd__."tag_search_content where content_id=".$tbl_result2["content_id"];
    query($sql);
    $sql="delete from ".__racinebd__."content where content_id=".$tbl_result2["content_id"];
    query($sql);
  }
  $sql="delete from ".__racinebd__."contenu where arbre_id=".$arbre_id;
  query($sql);
  $sql="delete from ".__racinebd__."arbre where arbre_id=".$arbre_id;
  query($sql);
  $sql="select max(arbre_id)as max from ".__racinebd__."arbre";
  $link=query($sql);
  $tbl_result=fetch($link);
  $sql="ALTER TABLE ".__racinebd__."arbre AUTO_INCREMENT = ".($tbl_result["max"]+1);
  query($sql);
  $sql="select max(log_id)as max from ".__racinebd__."log";
  $link=query($sql);
  $tbl_result=fetch($link);
  $sql="ALTER TABLE ".__racinebd__."log AUTO_INCREMENT = ".($tbl_result["max"]+1);
  query($sql);
  $sql="select max(contenu_id)as max from ".__racinebd__."contenu";
  $link=query($sql);
  $tbl_result=fetch($link);
  $sql="ALTER TABLE ".__racinebd__."contenu AUTO_INCREMENT = ".($tbl_result["max"]+1);
  query($sql);
  $sql="select max(content_id)as max from ".__racinebd__."content";
  $link=query($sql);
  $tbl_result=fetch($link);
  $sql="ALTER TABLE ".__racinebd__."content AUTO_INCREMENT = ".($tbl_result["max"]+1);
  query($sql);
  $sql="select max(fichiers_id)as max from ".__racinebd__."fichiers";
  $link=query($sql);
  $tbl_result=fetch($link);
  $sql="ALTER TABLE ".__racinebd__."fichiers AUTO_INCREMENT = ".($tbl_result["max"]+1);
  query($sql);
}

function replaceNode($dragID,$dropID){
//ce que je copy $dragID
//Vers $dropID

     $requete_langue = "select * from ".__racinebd__."langue where active=1";
     $link_select_langue=query($requete_langue);
     while ($ligne_select_langue=fetch($link_select_langue)){


        //$requete_select = "select * from contenu where arbre_id = ".$dragID." and langue_id = ".$j;
        $requete_select = "select * from ".__racinebd__."contenu where arbre_id = ".$dropID." and langue_id=".$ligne_select_langue["langue_id"];    
        $link_select=query($requete_select);
        $ligne_select=fetch($link_select);
        $destination_ajout_contenu = $ligne_select["contenu_id"];  
        
        //suppression de l'ancien 
        $requete_delete = "delete from ".__racinebd__."content where contenu_id=".$destination_ajout_contenu;    
        $link_delete=query($requete_delete);
        
        //$requete_select = "select * from contenu where arbre_id = ".$dragID." and langue_id = ".$j;
        $requete_select = "select * from ".__racinebd__."contenu where arbre_id = ".$dragID." and langue_id=".$ligne_select_langue["langue_id"];    
        $link_select=query($requete_select);
        $ligne_select=fetch($link_select);
        $origine_ajout_contenu = $ligne_select["contenu_id"];    

        $requete_select_content = "select * from ".__racinebd__."content where contenu_id = ".$origine_ajout_contenu;
        $link_select_content=query($requete_select_content);
        //$result = mysql_query("select * from table"); 

        while ($ligne_select_content=fetch($link_select_content)){
            $requete="insert into ".__racinebd__."content ";
            
            $listchamps=array();
            $listvalue=array();
            $listext=array();
            $listchamps[]="contenu_id";
            $listvalue[]=$destination_ajout_contenu;
            for ($i = 0; $i < mysql_num_fields($link_select_content); $i++) {
              if(mysql_field_name($link_select_content, $i)!="content_id"&&mysql_field_name($link_select_content, $i)!="contenu_id"){
              $listchamps[]=mysql_field_name($link_select_content, $i); 
              if(strpos(mysql_field_name($link_select_content, $i),"ext")===false){
              $listvalue[]="'".addslashes($ligne_select_content[mysql_field_name($link_select_content, $i)])."'";
              }else{
              $listvalue[]=($ligne_select_content[mysql_field_name($link_select_content, $i)]=="")?"null":"'".$ligne_select_content[mysql_field_name($link_select_content, $i)]."'";
              $listext[]= mysql_field_name($link_select_content, $i);
              }
              }
            } 

            $requete_insert_content= "insert into ".__racinebd__."content (".implode(",",$listchamps).") values(".implode(",",$listvalue).")";
            //print $requete_insert_content;
            //echo $requete_insert_content;
            $link_insert_content=query($requete_insert_content);
            $dernier_ajout_content = insert_id();
            
            for($listextindice=0;$listextindice<count($listext);$listextindice++){           
              $suffixe=($listextindice==0)?"":($listextindice+1)."_";
              //print $_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]]."<br>";
              @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              for($i=0;$i<5;$i++){
                @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$i.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$i.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              }  
            }          
            
            $requete_select_fichier = "select * from ".__racinebd__."fichiers where content_id = ".$ligne_select_content['content_id']." and supprimer=0";
            $link_select_fichier=query($requete_select_fichier);

            while ($ligne_select_fichier=fetch($link_select_fichier)){                        
                $requete_insert_fichier = "insert into ".__racinebd__."fichiers (content_id,titre,abstract,ext,nom_fichier,supprimer,contenu) values (
                ".$dernier_ajout_content.",
                '".addslashes($ligne_select_fichier['titre'])."',
                '".addslashes($ligne_select_fichier['abstract'])."',
                ".(($ligne_select_fichier['ext']=="")?"null":"'".$ligne_select_fichier['ext']."'").",
                '".addslashes($ligne_select_fichier['nom_fichier'])."',
                ".$ligne_select_fichier['supprimer'].",
                '".addslashes($ligne_select_fichier['contenu'])."'
                )";
                $link_insert_fichier=query($requete_insert_fichier);
                $dernier_ajout_fichier = insert_id();
                
                copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'fichiers'.$ligne_select_fichier['fichiers_id'].'.'.$ligne_select_fichier['ext'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'fichiers'.$dernier_ajout_fichier.'.'.$ligne_select_fichier['ext']);
            }
        }
    }   
		
    return array(true,$dernier_ajout);
}


function copyContent($content_id,$arbre_id,$langue_id,$onlylangue=0){
        
        //recherche du contenu_id        
        $requete_select_contenu = "select contenu_id,shortlib from ".__racinebd__."contenu c inner join ".__racinebd__."langue l on c.langue_id=l.langue_id where arbre_id = ".$arbre_id." and l.langue_id!=".$langue_id." ".(($onlylangue!=0)?"l.langue_id!=".$onlylangue:"");
        $link_select_contenu=query($requete_select_contenu);
        
        
        $requete_select_content = "select * from ".__racinebd__."content where content_id = ".$content_id;
        $link_select_content=query($requete_select_content);
        $ligne_select_content=fetch($link_select_content);
        
        //$result = mysql_query("select * from table");         

        while ($ligne_select_contenu=fetch($link_select_contenu)){
            $requete="insert into ".__racinebd__."content ";
            
            $listchamps=array();
            $listvalue=array();
            $listext=array();
            $listchamps[]="contenu_id";
            $listvalue[]=$ligne_select_contenu["contenu_id"];
            for ($i = 0; $i < mysql_num_fields($link_select_content); $i++) {
              if(mysql_field_name($link_select_content, $i)!="content_id"&&mysql_field_name($link_select_content, $i)!="contenu_id"){
                $listchamps[]=mysql_field_name($link_select_content, $i); 
                if(strpos(mysql_field_name($link_select_content, $i),"ext")===false){
                  if($_POST[mysql_field_name($link_select_content, $i)."___".$ligne_select_contenu["shortlib"]]!=""){
                    $listvalue[]="'".addslashes($_POST[mysql_field_name($link_select_content, $i)."___".$ligne_select_contenu["shortlib"]])."'";
                  }else{
                    $listvalue[]="'".addslashes($ligne_select_content[mysql_field_name($link_select_content, $i)])."'";  
                  }
                }else{
                  /*
                  $listvalue[]=($ligne_select_content[mysql_field_name($link_select_content, $i)]=="")?"null":"'".$ligne_select_content[mysql_field_name($link_select_content, $i)]."'";
                  $listext[]= mysql_field_name($link_select_content, $i);
                  */
                  //print "ici";
                  
                  $champs=mysql_field_name($link_select_content, $i);
                  if(isset ($_FILES[$champs."___".$ligne_select_contenu["shortlib"]])){
                    //print "ici";
                    /*
                    $numext=explode("___",$champs);
                    //sauvegarde du fichier
                    if(strlen($numext[0])>3){
                    */
                    if(strlen($champs)>3){
                      $numext=substr($champs,-1);
                      //$numext=substr($numext,3);
                      $listfile[]=array($champs."___".$ligne_select_contenu["shortlib"],__racinebd__."content".$numext."_");
                    }else{
                      $listfile[]=array($champs."___".$ligne_select_contenu["shortlib"],__racinebd__."content");
                    }
                    //$value=($_POST[$champs."___".$ligne_select_contenu["shortlib"]]=="")?"null":"'".$_POST[$champs."___".$ligne_select_contenu["shortlib"]]."'";
                    $listvalue[]=($_FILES[$champs."___".$ligne_select_contenu["shortlib"]]["name"]!="")?"'".getext($_FILES[$champs."___".$ligne_select_contenu["shortlib"]]["name"])."'":"null";
                  }else{
                    $listvalue[]=($ligne_select_content[$champs]=="")?"null":"'".$ligne_select_content[$champs]."'";
                    $listext[]= $champs;
                  }                 
                }
              }
            } 

            $requete_insert_content= "insert into ".__racinebd__."content (".implode(",",$listchamps).") values(".implode(",",$listvalue).")";
            //print $requete_insert_content;
            //echo $requete_insert_content;
            $link_insert_content=query($requete_insert_content);
            $dernier_ajout_content = insert_id();
            //print_r($listfile);
            for($j=0;$j<count($listfile);$j++){
              savefile($listfile[$j][0],$listfile[$j][1],$dernier_ajout_content);
            }
            
            for($listextindice=0;$listextindice<count($listext);$listextindice++){           
              //$suffixe=($listextindice==0)?"":($listextindice+1)."_";
              $suffixe=(strlen($listext[$listextindice])>3)?substr($listext[$listextindice],-1)."_":"";
              //print $_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]]."<br>";
              @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              for($i=0;$i<5;$i++){
                @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$i.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$i.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
              }  
            }          
            
            $requete_select_fichier = "select * from ".__racinebd__."fichiers where content_id = ".$ligne_select_content['content_id']." and supprimer=0";
            $link_select_fichier=query($requete_select_fichier);

            while ($ligne_select_fichier=fetch($link_select_fichier)){                        
                $requete_insert_fichier = "insert into ".__racinebd__."fichiers (content_id,titre,abstract,ext,nom_fichier,supprimer,contenu) values (
                ".$dernier_ajout_content.",
                '".addslashes($ligne_select_fichier['titre'])."',
                '".addslashes($ligne_select_fichier['abstract'])."',
                ".(($ligne_select_fichier['ext']=="")?"null":"'".$ligne_select_fichier['ext']."'").",
                '".addslashes($ligne_select_fichier['nom_fichier'])."',
                ".$ligne_select_fichier['supprimer'].",
                '".addslashes($ligne_select_fichier['contenu'])."'
                )";
                $link_insert_fichier=query($requete_insert_fichier);
                $dernier_ajout_fichier = insert_id();
                
                copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'fichiers'.$ligne_select_fichier['fichiers_id'].'.'.$ligne_select_fichier['ext'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'fichiers'.$dernier_ajout_fichier.'.'.$ligne_select_fichier['ext']);
            }
            $sql="update ".__racinebd__."contenu set translate=1 where contenu_id=".$ligne_select_contenu["contenu_id"];
            query($sql);
        }
        
}


function updateContent($content_id,$arbre_id,$langue_id){
        
        //recherche du contenu_id        
        $requete_select_contenu = "select contenu_id,shortlib from ".__racinebd__."contenu c inner join ".__racinebd__."langue l on c.langue_id=l.langue_id where arbre_id = ".$arbre_id." and l.langue_id!=".$langue_id;
        $link_select_contenu=query($requete_select_contenu);
        
        
        $requete_select_content = "select * from ".__racinebd__."content where content_id = ".$content_id;
        $link_select_content=query($requete_select_content);
        $ligne_select_content=fetch($link_select_content);
        //print_r($_POST);
        //$result = mysql_query("select * from table");         
        $listfile=array();
        while ($ligne_select_contenu=fetch($link_select_contenu)){
            //$requete="insert into ".__racinebd__."content ";
            
            $listchamps=array();
            $listvalue=array();
            $listext=array();
            //$listchamps[]="contenu_id";
            //$listvalue[]=$ligne_select_contenu["contenu_id"];
            for ($i = 0; $i < mysql_num_fields($link_select_content); $i++) {
              if(mysql_field_name($link_select_content, $i)!="content_id"&&mysql_field_name($link_select_content, $i)!="contenu_id"){
                $champs=mysql_field_name($link_select_content, $i);                 
                if(strpos($champs,"ext")===false){
                  if($_POST[$champs."___".$ligne_select_contenu["shortlib"]]!=""){
                    $value="'".addslashes($_POST[$champs."___".$ligne_select_contenu["shortlib"]])."'";
                  }else{
                    $value="'".addslashes($ligne_select_content[$champs])."'";  
                  }
                  $listchamps[]=$champs."=".$value;
                }else{
                  //print $champs."___".$ligne_select_contenu["shortlib"]." : ".$_FILES[$champs."___".$ligne_select_contenu["shortlib"]];
                  //print_r($_FILES);
                  if(isset ($_FILES[$champs."___".$ligne_select_contenu["shortlib"]])){
                  
                    //$numext=explode("___",$champs);
                    //sauvegarde du fichier
                    /*
                    if(strlen($numext[0])>3){
                      $numext=substr($numext[0],-1);
                      */
                      //print "ici";
                    if(strlen($champs)>3){
                      $numext=substr($champs,-1);
                      //print $numext;
                      $listfile[]=array($champs."___".$ligne_select_contenu["shortlib"],__racinebd__."content".$numext."_");
                    }else{
                      $listfile[]=array($champs."___".$ligne_select_contenu["shortlib"],__racinebd__."content");
                    }
                    //$value=($_POST[$champs."___".$ligne_select_contenu["shortlib"]]=="")?"null":"'".$_POST[$champs."___".$ligne_select_contenu["shortlib"]]."'";
                    $value=($_FILES[$champs."___".$ligne_select_contenu["shortlib"]]["name"]!="")?"'".getext($_FILES[$champs."___".$ligne_select_contenu["shortlib"]]["name"])."'":"null";
                  }else{
                    $value=($ligne_select_content[$champs]=="")?"null":"'".$ligne_select_content[$champs]."'";
                    $listext[]= $champs;
                  }
                  if($_POST[$champs."___".$ligne_select_contenu["shortlib"]."_chk"]==1){
                    $listchamps[]=$champs."=null";
                  }else if($value!="null"){
                      $listchamps[]=$champs."=".$value;
                  }
                }
                
              }
            } 

            $requete_update_content= "update ".__racinebd__."content set ".implode(",",$listchamps)." where contenu_id=".$ligne_select_contenu["contenu_id"];
            //print $requete_insert_content;
            //echo $requete_insert_content;
            $link=query($requete_update_content);
            
            //verification que la mise ajour a été effectué sinon on crée un enregistrement
            $sql="select * from ".__racinebd__."content where contenu_id=".$ligne_select_contenu["contenu_id"];
            $link=query($sql);
            if(num_rows($link)==0){
              copyContent($content_id,$arbre_id,$langue_id,$ligne_select_contenu["langue_id"]);
            }else{
              $tbl=fetch($link);
              /*
              print_r($listfile);
              print_r($listext);
              */
              //sauvegarde des fichiers différents
              for($j=0;$j<count($listfile);$j++){
                savefile($listfile[$j][0],$listfile[$j][1],$tbl["content_id"]);
              }
            
              $dernier_ajout_content = $tbl["content_id"];
              
              //a faire pour l'update
              //print_r($listext);
              for($listextindice=0;$listextindice<count($listext);$listextindice++){
                $suffixe=(strlen($listext[$listextindice])>3)?substr($listext[$listextindice],-1)."_":"";           
                //$suffixe=($listextindice==0)?"":($listextindice+1)."_";
                //print $_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]]."<br>";
                @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
                @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
                for($i=0;$i<5;$i++){
                  @copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$i.__racinebd__.'content'.$suffixe.$ligne_select_content['content_id'].'.'.$ligne_select_content[$listext[$listextindice]],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$i.__racinebd__.'content'.$suffixe.$dernier_ajout_content.'.'.$ligne_select_content[$listext[$listextindice]]);
                }  
              }          
              
              $requete_select_fichier = "select * from ".__racinebd__."fichiers where content_id = ".$ligne_select_content['content_id']." and supprimer=0";
              $link_select_fichier=query($requete_select_fichier);
  
              while ($ligne_select_fichier=fetch($link_select_fichier)){                        
                  $requete_insert_fichier = "insert into ".__racinebd__."fichiers (content_id,titre,abstract,ext,nom_fichier,supprimer,contenu) values (
                  ".$dernier_ajout_content.",
                  '".addslashes($ligne_select_fichier['titre'])."',
                  '".addslashes($ligne_select_fichier['abstract'])."',
                  ".(($ligne_select_fichier['ext']=="")?"null":"'".$ligne_select_fichier['ext']."'").",
                  '".addslashes($ligne_select_fichier['nom_fichier'])."',
                  ".$ligne_select_fichier['supprimer'].",
                  '".addslashes($ligne_select_fichier['contenu'])."'
                  )";
                  $link_insert_fichier=query($requete_insert_fichier);
                  $dernier_ajout_fichier = insert_id();
                  
                  copy($_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'fichiers'.$ligne_select_fichier['fichiers_id'].'.'.$ligne_select_fichier['ext'],$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__.'fichiers'.$dernier_ajout_fichier.'.'.$ligne_select_fichier['ext']);
              }
            }
        }
}
?>