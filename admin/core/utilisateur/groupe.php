<?	
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=50;

$typeElem=$trad["Groupe"];
$TxtTitre=$trad["Groupe"];
$Ajouttxt=$trad["Ajouter un groupe"];

$TxtSousTitreajout=$trad["Ajouter un groupe"];
$TxtSousTitremodif=$trad["Modifier un groupe"];
$TxtSousTitrevisu=$trad["&Eacute;diter un groupe"];
$TxtSousTitrelist=$trad["Liste des groupes"];
$TxtSousTitresuppr=$trad["Supprimer un groupe"];

$table=__racinebd__."groupe";
$tablekey="groupe_id";
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			$szQuery = "select * from $table";
			$ImgAjout=true;
			$tabcolonne=array($trad["Nom du groupe"]=> "libelle");
			$update=true;
			$delete=true;
			$search=false;
			$notview=true;			
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg=$trad["Le groupe a &eacute;t&eacute; supprim&eacute;"];
          $szQuery="delete from ".__racinebd__."groupe_droits where ".$tablekey."='".$_GET["id"]."'";
          query($szQuery);
          $szQuery="delete from ".__racinebd__."groupe_users where ".$tablekey."='".$_GET["id"]."'";
          query($szQuery);
          $szQuery="delete from ".__racinebd__."groupe_arbre where ".$tablekey."='".$_GET["id"]."'";
          query($szQuery);
          $szQuery="delete from ".__racinebd__."groupe_gabarit where ".$tablekey."='".$_GET["id"]."'";
          query($szQuery);
          $szQuery="delete from ".__racinebd__."groupe where ".$tablekey."='".$_GET["id"]."'";
          query($szQuery);
          $szQuery="";
        break;
        case "ajout" :
          $txtmsg=$trad["Le groupe a &eacute;t&eacute; ajout&eacute;"];
          $szQuery="insert into $table (libelle)
          values ('".addquote($_POST["libelle"])."')";
          $link=query($szQuery);
          $id=insert_id();
          //sauvegarde des droits
          for($i=0;$i<count($_POST["droits_id"]);$i++){
            $sql="insert into ".__racinebd__."groupe_droits (droits_id,groupe_id) values (".$_POST["droits_id"][$i].",".$id.")";
            query($sql);
          }
          for($i=0;$i<count($_POST["gabarit_id"]);$i++){
            $sql="insert into ".__racinebd__."groupe_gabarit (gabarit_id,groupe_id) values (".$_POST["gabarit_id"][$i].",".$id.")";
            query($sql);
          }
          $szQuery="";          
        break;
      	case "modif" :
					$txtmsg=$trad["Le groupe a &eacute;t&eacute; modifi&eacute;"];
          $sql="delete from ".__racinebd__."groupe_droits where groupe_id=".$_GET["id"];
          query($sql);
          //sauvegarde des droits
          for($i=0;$i<count($_POST["droits_id"]);$i++){
            $sql="insert into ".__racinebd__."groupe_droits (droits_id,groupe_id) values (".$_POST["droits_id"][$i].",".$_GET["id"].")";
            query($sql);
          }
          $sql="delete from ".__racinebd__."groupe_gabarit where groupe_id=".$_GET["id"];
          query($sql);
          //sauvegarde des droits
          for($i=0;$i<count($_POST["gabarit_id"]);$i++){
            $sql="insert into ".__racinebd__."groupe_gabarit (gabarit_id,groupe_id) values (".$_POST["gabarit_id"][$i].",".$_GET["id"].")";
            query($sql);
          }
          $szQuery="update $table set 
					libelle='".addquote($_POST["libelle"])."'
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
      $query1="select d.droits_id,d.libelle from ".__racinebd__."droits d left join ".__racinebd__."groupe_droits gd on d.droits_id=gd.droits_id and  $tablekey='".$_GET["id"]."' where gd.droits_id is null and droitarbre=0 order by d.libelle";
      //print $query1; 
      $query2="select d.droits_id,d.libelle from ".__racinebd__."droits d inner join ".__racinebd__."groupe_droits gd on d.droits_id=gd.droits_id where $tablekey='".$_GET["id"]."'  and droitarbre=0 order by d.libelle";
      $query3="select g.gabarit_id,g.libelle from ".__racinebd__."gabarit g left join ".__racinebd__."groupe_gabarit gg on g.gabarit_id=gg.gabarit_id and  $tablekey='".$_GET["id"]."' where gg.gabarit_id is null order by g.libelle";
      //print $query1; 
      $query4="select g.gabarit_id,g.libelle from ".__racinebd__."gabarit g inner join ".__racinebd__."groupe_gabarit gg on g.gabarit_id=gg.gabarit_id where $tablekey='".$_GET["id"]."' order by g.libelle";
    
		$tabcolonne=array(
		$trad["Libelle"]=>"libelle|txt(255)|yes",
		$trad["Droits"]=>"droits_id[]|listmultiple(query1,query2)",
		$trad["Gabarits"]=>"gabarit_id[]|listmultiple(query3,query4)"
		);		
    require("../../include/template_detail.php");
  }
}
?>
