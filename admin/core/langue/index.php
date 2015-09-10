<?	
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("TRAD");

$nbelemparpage=50;

$typeElem=$trad["Traduction"];
$TxtTitre=$trad["Traduction"];
$Ajouttxt=$trad["Ajouter une traduction"];

$TxtSousTitreajout=$trad["Ajouter une traduction"];
$TxtSousTitremodif=$trad["Modifier une traduction"];
$TxtSousTitrevisu=$trad["Visualiser une traduction"];
$TxtSousTitrelist=$trad["Liste des traductions"];
$TxtSousTitresuppr=$trad["Supprimer une traduction"];

//$TxtTitreDesc="Textes";
$table=__racinebd__."traduction";
//$textehelp="<li>S&eacute;lectionnez \" Texte \" pour administrer les textes de chaque sc&egrave;ne.</li>";
$tablekey="traduction_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
      if($_POST["query"]!=""){
        $where=" and (t.libelle like '%".$_POST["query"]."%'  or t.libelle_trad like '%".$_POST["query"]."%')";
      }
			$szQuery = "select t.*,l.libelle as lib from $table t inner join ".__racinebd__."langue l on t.langue_id=l.langue_id where supprimer = 0".$where;
			$ImgAjout=true;
			$tabcolonne=array($trad["Libelle defaut"]=> "libelle",$trad["Libelle traduit"]=> "libelle_trad",$trad["Langue"]=> "lib");
			$update=true;
			$delete=true;
			$search=true;
			$notview=true;
			
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg=$trad["La traduction a &eacute;t&eacute; supprim&eacute;"];
          $szQuery="update $table set supprimer=1 where ".$tablekey."='".$_GET["id"]."'";
        break;
        case "ajout" :
          $txtmsg=$trad["La traduction a &eacute;t&eacute; ajout&eacute;"];
          $szQuery="insert into $table (libelle,libelle_trad,langue_id)
          values ('".addquote($_POST["libelle"])."','".addquote($_POST["libelle_trad"])."','".addquote($_POST["langue_id"])."')";
        break;
      	case "modif" :
					$txtmsg=$trad["La traduction a &eacute;t&eacute; modifi&eacute;"];
          $szQuery="update $table set 
					libelle='".addquote($_POST["libelle"])."',
					libelle_trad='".addquote($_POST["libelle_trad"])."',
					langue_id='".addquote($_POST["langue_id"])."'
          where $tablekey=".$_GET["id"];
          //print $szQuery;
					//print "<script>alert(\"".$szQuery."\")</script>>";
          break;
      }
    	require("../../include/template_save.php");
    }else{
      $szQuery = "SELECT * FROM $table where $tablekey=".$_GET["id"];
	   //libelle=>nom du champ|type|obligatoire|taille (facultatif)
      //les type sont les suivant
      // txt area html media date file email list(nom var requete) listmutiple(nom var requete)
    $querylist="select langue_id,libelle from ".__racinebd__."langue";
		$tabcolonne=array(
		$trad["Libelle par defaut"]=>"libelle|area|yes",
		$trad["Libelle traduit"]=>"libelle_trad|area|yes",
		$trad["Langue"]=>"langue_id|list(querylist)|yes"
		);
	  require("../../include/template_detail.php");
  }
}
?>
