<?
require("../admin/require/function.php");
set_time_limit(86400);


  
  if($_GET["typecron"]=="jour"){
    print "debut archive<br>";
    require("archive.php");
    print "fin archive<br>";
  }
  
  //recherche des différents comptes
  $sql="select c.* from ".__racinebd__."compte c 
        inner join ".__racinebd__."preference_compte pc on c.compte_id=pc.compte_id  where supprimer=0 and actif=1";

  $link_compte=query($sql);
  while($tbl_compte=fetch($link_compte)){
    //listing des utilisateurs du compte
    $sqllistuser = "select *,u.usergps_id from  ".__racinebd__."compte c 
        inner join ".__racinebd__."usergps u on u.compte_id=c.compte_id      
        where actif=1 and u.supprimer=0 and c.compte_id=".$tbl_compte["compte_id"];
    $_SESSION["compte_id"]=$tbl_compte["compte_id"];
    //maj des compteurs //verification 1 fois par jour  
    if($_GET["typecron"]=="jour"){
      require("majcompteur.php");
    }
    
    $link_user=query($sqllistuser);
    while($tbl_user=fetch($link_user)){

      //verificattion si la personne travaillait hier
      //$datehier=date("d/m/Y",mktime(0,0,0,date("n"),date("j")-1,date("Y")));
      $indicedujour=dayOfWeek(mktime(0,0,0,date("n"),date("j")-1,date("Y")));
      if($_GET["typecron"]=="jour"){
        $sql="select mc.* from ".__racinebd__."jour_usersgps mc
        inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and u.usergps_id=".$tbl_user["usergps_id"]." and jour_id=".$indicedujour;
      }else{
        $sql="select * from ".__racinebd__."usergps where usergps_id=".$tbl_user["usergps_id"];
      }
      $link_jour=query($sql);
      if(num_rows($link_jour)!=0){
        
        //creation des droits
        $_SESSION["logfront"]=1;        
        $_SESSION["email"]=$tbl_user["email"];
        $_SESSION["users_id"]=$tbl_user["usergps_id"];
        //recherche du compte affecté
        $_SESSION["compte_id"]=$tbl_user["compte_id"];
        $_SESSION["raisonsociale"]=$tbl_user["raisonsociale"];
        

        $sql="select * from ".__racinebd__."preference_compte where compte_id='".$_SESSION["compte_id"]."'";
        $link_preference=query($sql);
        $tbl_preference=fetch($link_preference);
        
        
        $sql="select m.* from ".__racinebd__."module m 
        inner join ".__racinebd__."module_usersgps mc on m.module_id=mc.module_id
        inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and mc.usergps_id=".$tbl_user["usergps_id"];
        $link2=query($sql);
        while($tbl2=fetch($link2)){
          $_SESSION["tabdroitmodule"][]=$tbl2;
        }
        
        $sql="select mc.* from ".__racinebd__."usergps_device mc
        inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and mc.usergps_id=".$tbl_user["usergps_id"];
        $_SESSION["filtrevehicule"]="";
        $link2=query($sql);
        $tabvehicule=array();
        while($tbl2=fetch($link2)){
          $tabvehicule[]= $tbl2["device_id"];
        }
        if(count($tabvehicule)){
          $_SESSION["filtrevehicule"]=" and pd.device_id in(".implode(",",$tabvehicule).")";
        }
        
        $sql="select mc.* from ".__racinebd__."agence_compte_usergps mc 
        inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and mc.usergps_id=".$tbl_user["usergps_id"];
        $_SESSION["filtreagence"]="";
        $link2=query($sql);
        $tabagence=array();
        while($tbl2=fetch($link2)){
          $tabagence[]= $tbl2["agence_compte_id"];
        }
        if(count($tabvehicule)){
          $_SESSION["filtreagence"]=" and agence_compte_id in(".implode(",",$tabagence).")";
        }
      
        //le rapport n'est envoyé q'une fois par jour pour les informations de la veille
        if($_GET["typecron"]=="jour"){
          //vérification si cet utilisateur à le droit sur ce rapport
          $sql="select * from ".__racinebd__."rapport_usersgps rug 
                inner join ".__racinebd__."rapport r on rug.rapport_id=r.rapport_id
                where usergps_id=".$_SESSION["users_id"]." and r.rapport_id=4";
          $link_droit=query($sql);

          if(num_rows($link_droit)>0){
            // Rapport kilométrique
            print "debut rapport kilometrique<br>";
            require("rapport-kilometrique.php");
            print "fin rapport kilometrique<br>";
          }
          $sql="select * from ".__racinebd__."rapport_usersgps rug 
                inner join ".__racinebd__."rapport r on rug.rapport_id=r.rapport_id 
                where usergps_id=".$_SESSION["users_id"]." and r.rapport_id=5";
          $link_droit=query($sql);
          if(num_rows($link_droit)>0){        
            // Rapport de flotte journalier
            print "debut rapport flottejour<br>";
            require("rapport-flottejour.php");
            print "fin rapport flottejour<br>";
          }
        }
        if($_GET["typecron"]=="semaine"){
          //on vérifie qu'il n'y a pas eut d'envoi cette semaine
          $sql="select * from ".__racinebd__."rapport_usersgps rug 
                inner join ".__racinebd__."rapport r on rug.rapport_id=r.rapport_id
                where usergps_id=".$_SESSION["users_id"]." and r.rapport_id=6";
          $link_droit=query($sql);
          if(num_rows($link_droit)>0){
            // Rapport de flotte hebdomadaire
            print "debut rapport flottehebdo<br>";
            require("rapport-flottehebdo.php");
            print "fin rapport flottehebdo<br>";
          }
        }
        if($_GET["typecron"]=="mois"){
          $sql="select * from ".__racinebd__."rapport_usersgps rug 
                inner join ".__racinebd__."rapport r on rug.rapport_id=r.rapport_id
                where usergps_id=".$_SESSION["users_id"]." and r.rapport_id=7";
          $link_droit=query($sql);
          if(num_rows($link_droit)>0){
            // Rapport de flotte mensuel
            print "debut rapport flottemensuel<br>";
            require("rapport-flottemensuel.php");
            print "fin rapport flottemensuel<br>";
          }
        }
        if($_GET["typecron"]=="jour"){
          $sql="select * from ".__racinebd__."rapport_usersgps rug 
                inner join ".__racinebd__."rapport r on rug.rapport_id=r.rapport_id 
                where usergps_id=".$_SESSION["users_id"]." and r.rapport_id=8";
          $link_droit=query($sql);
          if(num_rows($link_droit)>0){
            // Rapport conducteur journalier
            print "debut rapport vehicule jour<br>";
            require("rapport-vehicule-jour.php");
            print "fin rapport vehicule jour<br>";
          }
        }
        if($_GET["typecron"]=="semaine"){
          $sql="select * from ".__racinebd__."rapport_usersgps rug 
                inner join ".__racinebd__."rapport r on rug.rapport_id=r.rapport_id
                where usergps_id=".$_SESSION["users_id"]." and r.rapport_id=9";
          $link_droit=query($sql);
          if(num_rows($link_droit)>0){
            // Rapport conducteur hebdomadaire
            print "debut rapport vehicule semaine<br>";
            require("rapport-vehicule-hebdo.php");
            print "fin rapport vehicule semaine<br>";
          }
        }
        if($_GET["typecron"]=="mois"){
          $sql="select * from ".__racinebd__."rapport_usersgps rug 
                inner join ".__racinebd__."rapport r on rug.rapport_id=r.rapport_id
                where usergps_id=".$_SESSION["users_id"]." and r.rapport_id=10";
          $link_droit=query($sql);
          if(num_rows($link_droit)>0){
            // Rapport conducteur mensuel
            print "debut rapport vehicule mensuel<br>";
            require("rapport-vehicule-mensuel.php");
            print "fin rapport vehicule mensuel<br>";
          }
        }
      }
    }
  }

?>