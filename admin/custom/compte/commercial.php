<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=($_POST["nbelemparpage"]!="")?$_POST["nbelemparpage"]:(($_SESSION["nbelemparpage"]!="")?$_SESSION["nbelemparpage"]:50);
$_SESSION["nbelemparpage"]=$nbelemparpage;

$typeElem="Commercial";
$TxtTitre="Commercial";
$Ajouttxt="Ajouter un commercial";

$TxtSousTitreajout="Ajouter un commercial";
$TxtSousTitremodif="Modifier un commercial";
$TxtSousTitrevisu="&Eacute;diter un commercial";
$TxtSousTitrelist="Liste des commercials";
$TxtSousTitresuppr="Supprimer un commercial";

//$TxtTitreDesc="Textes";
$table=__racinebd__."commercial";
$tablekey="commercial_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			//$szQuery = "select * from $table  where supprimer = 0";
      $szQuery = "select * from $table ";
			$ImgAjout=true;
			$tabcolonne=array("Nom"=> "nom","Prénom"=> "prenom");
			$update=true;
			$delete=false;
			$search=false;
			$notview=true;
      $valcouleur1=1;
      $couleur="actif";
			$txtcouleur = array("Commercial actif","Commercial non actif");
      $child=true;
			$childtxt[]="Compte";
      $urlchild[]=__racineadmin__."/custom/compte/index.php";
			
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg="Le commercial a &eacute;t&eacute; supprim&eacute;";
          $szQuery="update $table set supprimer=1 where ".$tablekey."='".$_GET["id"]."'";
        break;
        case "ajout" :
          $txtmsg="Le commercial a &eacute;t&eacute; ajout&eacute;";
          $szQuery="insert into $table (prenom,nom,actif)
          values ('".addquote($_POST["prenom"])."','".addquote($_POST["nom"])."','".addquote($_POST["actif"])."')";
          
        break;
      	case "modif" :
					$txtmsg="Le commercial a &eacute;t&eacute; modifi&eacute;";
          
          $szQuery="update $table set 
					prenom='".addquote($_POST["prenom"])."',
					nom='".addquote($_POST["nom"])."',
					actif='".addquote($_POST["actif"])."'
          where $tablekey=".$_GET["id"];
        
          break;
      }
    	require("../../include/template_save.php");
    }else{
      $szQuery = "SELECT * FROM $table where $tablekey=".$_GET["id"];
	   //libelle=>nom du champ|type|obligatoire|taille (facultatif)
      //les type sont les suivant
      // txt area html media date file email list(nom var requete) listmutiple(nom var requete)
      
		$tabcolonne=array(
		"Nom"=>"nom|txt(255)|yes",
		"Prénom"=>"prenom|txt(255)|yes",
    "Actif"=>"actif|chk|no"
		);
	  require("../../include/template_detail.php");
  }
}
?>
