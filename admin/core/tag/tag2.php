<?
	
require("../../require/function.php");
testGenRulesDie("TAG");

$nbelemparpage=50;

$typeElem="Tag";
$TxtTitre="Tag";
$Ajouttxt="Ajouter d'un tag";
$Updatetxt="Text";

$TxtSousTitreajout="Ajouter un tag";
$TxtSousTitremodif="Modifier un tag";
$TxtSousTitrevisu="&Eacute;diter un tag";
$TxtSousTitrelist="Liste des tags secondaire";
$TxtSousTitresuppr="Supprimer un tag";


//$TxtTitreDesc="Textes";
$table=__racinebd__."tag_search";
//$textehelp="<li>S&eacute;lectionnez \" Texte \" pour administrer les textes de chaque sc&egrave;ne.</li>";
$tablekey="tag_search_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			//$szQuery = "select t.*,ne.libelle from $table t inner join newsletter_etat ne on t.newsletter_etat_id=ne.newsletter_etat_id where supprimer=0";
			$szQuery = "select * from $table where supprimer=0";
			$ImgAjout=true;
			$tabcolonne=array("Libelle"=> "libelle");
			$update=true;
			$delete=true;
			//$media=true;
			//$couleur="etat";
			$search=false;
			$notview=true;
			/*
			$couleur="envoye";
			$txtcouleur[1] = "Newsletter envoyé";
			$txtcouleur[0] = "Newsletter non envoyé";
			*/
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg="Le tag a &eacute;t&eacute; supprim&eacute;";
          $szQuery="update $table set supprimer=1 where ".$tablekey."='".$_GET["id"]."'";
        break;
        case "ajout" :
          $txtmsg="Le tag a &eacute;t&eacute; ajout&eacute;";
          
          $szQuery="insert into $table (libelle)
          values ('".addquote($_POST["libelle"])."')";
          
        break;
      	case "modif" :
					$txtmsg="Le tag a &eacute;t&eacute; modifi&eacute;";
					
          $szQuery="update $table set 
					libelle='".addquote($_POST["libelle"])."'
          where $tablekey=".$_GET["id"];
					
          //print $szQuery;
					break;
      }
      
    	require("../../include/template_save.php");
    }else{
      $szQuery = "SELECT * FROM $table where $tablekey=".$_GET["id"];
      //$query="select newsletter_etat_id,libelle from newsletter_etat order by libelle";
      //libelle=>nom du champ|type|obligatoire|taille (facultatif)
      //les type sont les suivant
      // txt area html media date file email list(nom var requete) listmutiple(nom var requete)
      
		$tabcolonne=array(
		"Libelle"=>"libelle|txt(255)|yes"
		);
		
		/*
		$tabcolonne=array(
		"Login"=>"login|txt(255)|yes",
		"Password"=>"mdp|txt(255)|yes",
		"Email"=>"email|html2(contenu.css)|yes",
		"Statut"=>"groupe_users_id|radio(Admin,Super Admin)|yes"
		
		);*/
    require("../../include/template_detail.php");
  }
}
?>
