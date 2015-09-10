<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=($_POST["nbelemparpage"]!="")?$_POST["nbelemparpage"]:(($_SESSION["nbelemparpage"]!="")?$_SESSION["nbelemparpage"]:50);
$_SESSION["nbelemparpage"]=$nbelemparpage;

$typeElem="Connexion";
$TxtTitre="Connexion";

$TxtSousTitrelist="Liste des statistique de connexion";


//$TxtTitreDesc="Textes";
$table=__racinebd__."compte_log";
$tablekey="compte_log_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			//$szQuery = "select * from $table  where supprimer = 0";
      $where="";
      if($_POST["compte_id"]!=""){
        $where.=" and c.compte_id=".$_POST["compte_id"];
      }
      if($_POST["date_debut"]!=""){
        $where.=" and t.date_connexion>='".datebdd($_POST["date_debut"])." 00:00:00'";
      }
      if($_POST["date_fin"]!=""){
        $where.=" and t.date_connexion<='".datebdd($_POST["date_fin"])." 23:59:59'";
      }
      $szQuery = "select * from $table t inner join ".__racinebd__."compte c on t.compte_id=c.compte_id where supprimer=0 and actif=1 $where";
      //print $szQuery;
			$ImgAjout=false;
			$tabcolonne=array("Compte"=> "nom","Date de connexion"=> "date_connexion");
      $filtre="filtrestat.php";
			$update=false;
			$delete=false;
			$search=false;
			$notview=true;
      $defaultcoltri="date_connexion";
      $defaultorder="desc";		
			require("../../include/template_list.php");
    }

  
}
?>
