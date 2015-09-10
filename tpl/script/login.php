<?
require("../../admin/require/function.php");
require("../../conf_front.php");

if($_POST["mdp"]!=""&&$_POST["ident"]!=""){
  
  //$sql="select * from users where username='".addquote($_POST["ident"])."' and active=1 and user_template_id is null";
  /*
  $sql="select u.*,c.compte_id,c.raisonsociale from users u 
  inner join ".__racinebd__."compte c on u.original_application_id=c.application_id and  actif=1 and supprimer=0
  where username='".addquote($_POST["ident"])."' and active=1 and user_template_id is null";
  */
  $sql="select u.*,c.compte_id,c.raisonsociale from ".__racinebd__."usergps u
  inner join ".__racinebd__."compte c on c.compte_id=u.compte_id
  where c.supprimer=0 and u.supprimer=0
  and username='".addquote($_POST["ident"])."'";
  //print $sql;
  $link=query($sql);
  if(num_rows($link)>0){
    $tbl=fetch($link);
    if($tbl["password"]==md5($_POST["mdp"])){
      //verification si elle peut se connecter aujourd'hui
      $indicedujour=dayOfWeek(time());
      /*
      $sql="select mc.* from ".__racinebd__."jour_usersgps mc
      inner join ".__racinebd__."usergps u on u.usergps_id=mc.usergps_id and user_id=".$tbl["user_id"]." and jour_id=".$indicedujour;
      */
      $sql="select * from ".__racinebd__."jour_usersgps where usergps_id=".$tbl["usergps_id"]." and jour_id=".$indicedujour;
      //print $sql;
      $link2=query($sql);
      if(num_rows($link2)==0){
        print "nok2";
        die;
      }
      
      //creation des sessions
      $_SESSION["logfront"]=1;
      $_SESSION["users_id"]=$tbl["usergps_id"];
      //recherche du compte affecté
      $_SESSION["compte_id"]=$tbl["compte_id"];
      $_SESSION["raisonsociale"]=$tbl["raisonsociale"];
      $_SESSION["tabdroitoption"]=array();
      $sql="select m.* from ".__racinebd__."options m 
      inner join ".__racinebd__."compte_options mc on m.options_id=mc.options_id
      where compte_id=".$tbl["compte_id"];
      $link2=query($sql);
      while($tbl2=fetch($link2)){
        $_SESSION["tabdroitoption"][]=$tbl2["shortcut"];
      }
      $_SESSION["tabdroitmodule"]=array();
      $sql="select m.* from ".__racinebd__."module m 
      inner join ".__racinebd__."module_usersgps mc on m.module_id=mc.module_id
      where usergps_id=".$tbl["usergps_id"];
      $link2=query($sql);
      while($tbl2=fetch($link2)){
        $_SESSION["tabdroitmodule"][]=$tbl2;
      }
      
      //code couleur voiture
      $sql="select * from phantom_etat_moteur em  
            left join phantom_etat_moteur_compte emc on emc.etat_moteur_id=em.etat_moteur_id and compte_id=".$_SESSION["compte_id"];
      $link=query($sql);
      while($tbl2=fetch($link)){
        $_SESSION["etatlibelle"][$tbl2["etat"]]=$tbl2["libelle"];
        $_SESSION["etatcouleur"][$tbl2["etat"]]=(($tbl2["couleur"]=="")?$tbl2["defaultcouleur"]:$tbl2["couleur"]);
      }
      
      $sql="select * from ".__racinebd__."usergps_device where usergps_id=".$tbl["usergps_id"];
      $_SESSION["filtrevehicule"]="";
      $link2=query($sql);
      $tabvehicule=array();
      while($tbl2=fetch($link2)){
        $tabvehicule[]= $tbl2["device_id"];
      }
      if(count($tabvehicule)){
        $_SESSION["filtrevehicule"]=" and pd.device_id in(".implode(",",$tabvehicule).")";
      }
      
      $sql="select * from ".__racinebd__."agence_compte_usergps where usergps_id=".$tbl["usergps_id"];
      $_SESSION["filtreagence"]="";
      $link2=query($sql);
      $tabagence=array();
      while($tbl2=fetch($link2)){
        $tabagence[]= $tbl2["agence_compte_id"];
      }
      if(count($tabagence)){
        $_SESSION["filtreagence"]=" and agence_compte_id in(".implode(",",$tabagence).")";
      }
      $sql="insert into ".__racinebd__."compte_log (date_connexion,compte_id) values(now(),".$_SESSION["compte_id"].")";
      query($sql);

      print urlp(__situationid__);
      die;
    }
  }
}

?>
nok