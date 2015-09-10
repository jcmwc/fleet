<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=($_POST["nbelemparpage"]!="")?$_POST["nbelemparpage"]:(($_SESSION["nbelemparpage"]!="")?$_SESSION["nbelemparpage"]:50);
$_SESSION["nbelemparpage"]=$nbelemparpage;

$typeElem="Utilisateurs";
$TxtTitre="Utilisateurs";
$Ajouttxt="Ajouter un Utilisateurs";

$TxtSousTitreajout="Ajouter un Utilisateurs";
$TxtSousTitremodif="Modifier un Utilisateurs";
$TxtSousTitrevisu="&Eacute;diter un Utilisateurs";
$TxtSousTitrelist="Liste des Utilisateurss";
$TxtSousTitresuppr="Supprimer un Utilisateurs";

//$TxtTitreDesc="Textes";
$table=__racinebd__."usergps";
$tablekey="usergps_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
      
			$szQuery = "select t.* from $table t 
      inner join ".__racinebd__."compte c on c.compte_id=t.compte_id where t.supprimer=0 and c.compte_id=".$_GET["pere"];
			$ImgAjout=true;
			$tabcolonne=array("Username"=> "username","Email"=>"email","Date de création"=>"date_creation");
			$update=true;
			$delete=false;
			$notview=true;
      $retour=true;
      $libretour[]="Retour au compte";
      $lienretour[]=__racineadmin__."/custom/compte/index.php?mode=list";
			
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg="L'utilisateurs a &eacute;t&eacute; supprim&eacute;";
          //suppression de l'application sur gpsgate
          
          $szQuery="update $table set supprimer=1 where ".$tablekey."='".$_GET["id"]."'";
        break;
        case "ajout" :
          $txtmsg="L'utilisateurs a &eacute;t&eacute; ajout&eacute;";
          //verification si le username est déjà utilisé
          //$sql="select * from $table where ".$tablekey."='".$_GET["id"]."'";
  
  
          //creation d'une liaison phantom_usergps
          $sql="insert into ".__racinebd__."usergps (tel,name,email,password,username,date_creation,compte_id) values('".addquote($_POST["tel"])."','".addquote($_POST["name"])."','".addquote($_POST["email"])."','".md5($_POST["password"])."','".addquote($_POST["username"])."',now(),'".$_GET["pere"]."')";
          query($sql);
          $usergpd_id=insert_id();
          
          //creation des droits par defaut
          //modules
          $sql="select * from ".__racinebd__."module";
          $link=query($sql);
          while($tbl=fetch($link)){
            $sql="insert into ".__racinebd__."module_usersgps (module_id,usergps_id) values('".$tbl["module_id"]."','".$usergpd_id."')";
            query($sql);
          }

          //jours
          $sql="select * from ".__racinebd__."jour";
          $link=query($sql);
          while($tbl=fetch($link)){
            $sql="insert into ".__racinebd__."jour_usersgps (jour_id,usergps_id) values('".$tbl["jour_id"]."','".$usergpd_id."')";
            query($sql);
          }
          
          //rapport
          $sql="select * from ".__racinebd__."rapport";
          $link=query($sql);
          while($tbl=fetch($link)){
            $sql="insert into ".__racinebd__."rapport_usersgps (rapport_id,usergps_id) values('".$tbl["rapport_id"]."','".$usergpd_id."')";
            query($sql);
          }
          
          //device phantom_usergps_device
          $sql="select * from ".__racinebd__."device where compte_id=".$_GET["pere"];
          $link=query($sql);
          while($tbl=fetch($link)){
            $sql="insert into ".__racinebd__."usergps_device (device_id,usergps_id) values('".$tbl["device_id"]."','".$usergpd_id."')";
            query($sql);
          }

          $szQuery="";
        break;
      	case "modif" :
					$txtmsg="L'utilisateurs a &eacute;t&eacute; modifi&eacute;";
          if($_POST["password2"]!=""){
            $pwd=",password='".md5($_POST["password2"])."'";
          }
          
          $szQuery="update $table set 
					username='".addquote($_POST["username"])."',
					name='".addquote($_POST["name"])."',
          email='".addquote($_POST["email"])."',
          tel='".addquote($_POST["tel"])."'
          $pwd
          where $tablekey=".$_GET["id"];
          //print $szQuery;
          
          break;
      }
    	require("../../include/template_save.php");
    }else{
      $szQuery = "SELECT * FROM $table where $tablekey=".$_GET["id"];
	   //libelle=>nom du champ|type|obligatoire|taille (facultatif)
      //les type sont les suivant
      // txt area html media date file email list(nom var requete) listmutiple(nom var requete)
    if($_GET["mode"]=="ajout"){  
		$tabcolonne=array(
		"Username"=>"username|txt(255)|yes",
		"Name"=>"name|txt(255)|yes",
    "Password"=>"password|password|yes",
    "Email"=>"email|txt(255)|no",
    "Téléphone"=>"tel|txt(255)|no"
		);
    }else{
    $tabcolonne=array(
		"Username"=>"username|txt(255)|yes",
		"Name"=>"name|txt(255)|yes",
    "Password (for change)"=>"password2|password|no",
    "Email"=>"email|txt(255)|no",
    "Téléphone"=>"tel|txt(255)|no"
		);
    }
	  require("../../include/template_detail.php");
  }
}
?>
