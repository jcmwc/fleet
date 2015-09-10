<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=($_POST["nbelemparpage"]!="")?$_POST["nbelemparpage"]:(($_SESSION["nbelemparpage"]!="")?$_SESSION["nbelemparpage"]:50);
$_SESSION["nbelemparpage"]=$nbelemparpage;

$typeElem="Type de Boitier";
$TxtTitre="Type de Boitier";
$Ajouttxt="Ajouter un type de boitier";

$TxtSousTitreajout="Ajouter un type de boitier";
$TxtSousTitremodif="Modifier un type de boitier";
$TxtSousTitrevisu="&Eacute;diter un type de boitier";
$TxtSousTitrelist="Liste des type de boitiers";
$TxtSousTitresuppr="Supprimer un type de boitier";

//$TxtTitreDesc="Textes";
$table=__racinebd__."typeboitier";
$tablekey="typeboitier_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			//$szQuery = "select * from $table  where supprimer = 0";
      $szQuery = "select * from $table ";
			$ImgAjout=true;
			$tabcolonne=array("Libelle"=> "libelle","Port"=> "port");
			$update=true;
			$delete=false;
			$search=false;
			$notview=true;

			
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg="Le type de boitier a &eacute;t&eacute; supprim&eacute;";
          $szQuery="update $table set supprimer=1 where ".$tablekey."='".$_GET["id"]."'";
        break;
        case "ajout" :
          $txtmsg="Le type de boitier a &eacute;t&eacute; ajout&eacute;";
          $szQuery="insert into $table (libelle,port)
          values ('".addquote($_POST["libelle"])."','".addquote($_POST["port"])."')";
          
        break;
      	case "modif" :
					$txtmsg="Le type de boitier a &eacute;t&eacute; modifi&eacute;";
          
          $szQuery="update $table set 
					libelle='".addquote($_POST["libelle"])."',
					port='".addquote($_POST["port"])."',
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
		"Libelle"=>"libelle|txt(255)|yes",
		"Port"=>"port|txt(255)|yes"
		);
	  require("../../include/template_detail.php");
  }
}
?>
