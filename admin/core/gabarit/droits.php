<?
require("../../require/function.php");
require("../../require/back_include.php");
$_GET["id"]=$_GET["arbre_id"];
testdroitarbredie($_GET["id"],"RUL");
$detailsave="no";
$nbelemparpage=50;
$typeElem=$trad["Groupe"];
$TxtTitre=$trad["Groupe"];
$Ajouttxt=$trad["Ajouter un groupe"];

$TxtSousTitreajout=$trad["Ajouter un groupe"];
$TxtSousTitremodif=$trad["Modifier les droits"];
$TxtSousTitrevisu=$trad["&Eacute;diter un groupe"];
$TxtSousTitrelist=$trad["Liste des groupes"];
$TxtSousTitresuppr=$trad["Supprimer un groupe"];

$_GET["mode"]="modif";

$table=__racinebd__."arbre";
$tablekey="arbre_id";
if($_GET["mode"]!=""){
    if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
      	case "modif" :
					$txtmsg="Les droits ont &eacute;t&eacute; modifi&eacute;s";
          //sauvegarde des droits
          majrules($_GET["id"],$_POST["child"]);
					break;
      }
    	require("../../include/template_save.php");
    }else{
      $szQuery = "SELECT * FROM $table where $tablekey=".$_GET["id"];
      //libelle=>nom du champ|type|obligatoire|taille (facultatif)
      //les type sont les suivant
      // txt area html media date file email list(nom var requete) listmutiple(nom var requete)
    	$sql="select * from ".__racinebd__."groupe order by libelle";
  		$link_groupe=query($sql);
  		$i=0;
  		while($tbl_result_groupe=fetch($link_groupe)){
  		  $queryname="query".$i;
    		$$queryname="select d.droits_id,d.libelle from ".__racinebd__."droits d left join ".__racinebd__."groupe_arbre gd on d.droits_id=gd.droits_id and groupe_id='".$tbl_result_groupe["groupe_id"]."' and arbre_id=".$_GET["id"]." where gd.droits_id is null and droitarbre=1";
    		$queryname="query".($i+1);
        $$queryname="select d.droits_id,d.libelle from ".__racinebd__."droits d inner join ".__racinebd__."groupe_arbre gd on d.droits_id=gd.droits_id where groupe_id='".$tbl_result_groupe["groupe_id"]."' and droitarbre=1 and arbre_id=".$_GET["id"];
  		  $tabcolonne[$trad["Droits pour le groupe"]." \"".$tbl_result_groupe["libelle"]."\""]="groupe_".$tbl_result_groupe["groupe_id"]."_droits_id[]|listmultiple(query".$i.",query".($i+1).")";
  		  $i=$i+2;
  		}
  		$tabcolonne[$trad["Affecter aux enfants"]]="child|chk";
      require("../../include/template_detail.php");
  }
}
?>
