<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=($_POST["nbelemparpage"]!="")?$_POST["nbelemparpage"]:(($_SESSION["nbelemparpage"]!="")?$_SESSION["nbelemparpage"]:50);
$_SESSION["nbelemparpage"]=$nbelemparpage;

$typeElem="Nouveautés";
$TxtTitre="Nouveautés";
$Ajouttxt="Ajouter un nouveautés";

$TxtSousTitreajout="Ajouter une nouveautés";
$TxtSousTitremodif="Modifier une nouveautés";
$TxtSousTitrevisu="&Eacute;diter une nouveautés";
$TxtSousTitrelist="Liste des nouveautés";
$TxtSousTitresuppr="Supprimer une nouveautés";

//$TxtTitreDesc="Textes";
$table=__racinebd__."news";
$tablekey="news_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			//$szQuery = "select * from $table  where supprimer = 0";
      $szQuery = "select * from $table ";
			$ImgAjout=true;
			$tabcolonne=array("Texte"=> "texte","Date"=> "date_creation");
			$update=true;
			$delete=true;
			$search=false;
			$notview=true;
      
			
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg="La nouveauté a &eacute;t&eacute; supprim&eacute;";
          $szQuery="update $table set supprimer=1 where ".$tablekey."='".$_GET["id"]."'";
        break;
        case "ajout" :
          $txtmsg="La nouveauté a &eacute;t&eacute; ajout&eacute;";
          $szQuery="insert into $table (texte,date_creation)
          values ('".addquote($_POST["texte"])."','".datetimebdd($_POST["date_creation"])."')";
          
        break;
      	case "modif" :
					$txtmsg="La nouveauté a &eacute;t&eacute; modifi&eacute;";
          
          $szQuery="update $table set 
					texte='".addquote($_POST["texte"])."',
					date_creation='".datetimebdd($_POST["date_creation"])."'
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
		"Texte"=>"texte|area|yes",
		"Date"=>"date_creation|date2|yes"
		);
	  require("../../include/template_detail.php");
  }
}
?>
