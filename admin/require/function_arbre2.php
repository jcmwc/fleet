<?php
function listnoeud2($pere,$langue_id=__defaultlangueid__){
  //$_POST["langue_id"]=1;            
  $pere=($pere=="root1")?"null":$pere;
  $requete_style = "select style from ".__racinebd__."etat order by etat_id ASC";
  $link_style=query($requete_style);
  while ($ligne_style=fetch($link_style)){
      $style++;
      $le_style[$style] = $ligne_style["style"];
  }
  $style = 0;
  $virgule = 0;
  $requete_child2 = "select a.*,g.libelle from ".__racinebd__."arbre a inner join ".__racinebd__."gabarit g on a.gabarit_id=g.gabarit_id where pere is null and a.supprimer = 0 order by ordre ASC";
  
  if($pere != "null" && $pere != "pb"){
      $_POST["langue_id"] = $_GET["la_langue"];
      $requete_child2 = "select a.*,g.libelle from ".__racinebd__."arbre a inner join ".__racinebd__."gabarit g on a.gabarit_id=g.gabarit_id where pere = ".$pere." and a.supprimer = 0 order by ordre ASC";
  }else if($pere == "pb"){
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
    echo '{"key":"'.$ligne2["arbre_id"].'", "title":"'.$ligne_name["nom"].'"';
    
    //}
    //}
    $requete_souschild = "select arbre_id from ".__racinebd__."arbre A where A.pere = ".$ligne2["arbre_id"]." and A.supprimer = 0";
    $link_souschild=query($requete_souschild);
    $nombre_souschild = num_rows($link_souschild);
    
    if($nombre_souschild > 0){
    
        echo ',"isLazy" : true';
    }
    // a voir pus tard
    
    if($ligne2["users_id_verrou"]){
    
      $requete_verrou = "select login from ".__racinebd__."users where users_id = '".$ligne2["users_id_verrou"]."'";
      $link_verrou=query($requete_verrou);
      $ligne_verrou=fetch($link_verrou);
      echo ',"verrou":true';
      echo ',"tooltip" : "id : '.$ligne2["arbre_id"].' ('.str_replace("'","\'",$ligne2["libelle"]).')"';
      if(num_rows($link_verrou)>0){  
        echo ',"tooltipuser" : "'.$ligne_verrou["login"].'"';
      }else{
        echo ',"tooltipuser" : "Super Admin"';
      }
  
    }else{
        echo ',"tooltip" : "id : '.$ligne2["arbre_id"].' ('.str_replace("'","\'",$ligne2["libelle"]).')"';
    } 
    echo ',"etat" : '.$ligne2["etat_id"];
    
    if($ligne2["arbre_id_alias"]){
        echo ',"alias" : 1';
        echo ',"icon":"globe.gif"';
    }else{
      if($ligne2["gabarit_id"]){
          $requete_g = "select iconnormal from ".__racinebd__."gabarit where gabarit_id = '".$ligne2["gabarit_id"]."'";
          $link_g=query($requete_g);
        
          while ($ligne_g=fetch($link_g)){ 
      
          echo ',"icon":"'.__uploaddir__.__racinebd__.'gabarit'.$ligne2["gabarit_id"].'.'.$ligne_g["iconnormal"].'"';
          }
      }
      
      if($ligne2["secure"] == "1"){
          //echo "<script type='text/javascript'>alert('lapin')</script>";
          $requete_g = "select iconsecure from ".__racinebd__."gabarit where gabarit_id = '".$ligne2["gabarit_id"]."'";
          $link_g=query($requete_g);
        
          while ($ligne_g=fetch($link_g)){ 
      
          echo ',"icon":"'.__uploaddir__.__racinebd__.'gabarit2_'.$ligne2["gabarit_id"].'.'.$ligne_g["iconsecure"].'"';
          }
      }
       echo ',"alias" : 0';
    }
    
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
    
    echo ',"addClass" : "'.$etat_id.' '.$nottranslate.'"';
    $etat_id = "";
    $nottranslate = "";
    echo "}";
    $virgule++;
  }    
}
?>