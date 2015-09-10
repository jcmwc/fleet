<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=50;

$typeElem=$trad["Utilisateur"];
$TxtTitre=$trad["Utilisateur"];
$Ajouttxt=$trad["Ajouter un utilisateur"];

$TxtSousTitreajout=$trad["Ajouter un utilisateur"];
$TxtSousTitremodif=$trad["Modifier un utilisateur"];
$TxtSousTitrevisu=$trad["&Eacute;diter un utilisateur"];
$TxtSousTitrelist=$trad["Liste des utilisateurs"];
$TxtSousTitresuppr=$trad["Supprimer un utilisateur"];

//$TxtTitreDesc="Textes";
$table=__racinebd__."users";
$tablekey="users_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			$szQuery = "select * from $table where supprimer = 0";
			$ImgAjout=true;
			$tabcolonne=array($trad["Nom de l'utilisateur"]=> "login");
			$update=true;
			$delete=true;
			$search=false;
			$notview=true;
			
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg=$trad["L'utilisateur a &eacute;t&eacute; supprim&eacute;"];
          $szQuery="update $table set supprimer=1 where ".$tablekey."='".$_GET["id"]."'";
        break;
        case "ajout" :
          $txtmsg=$trad["L'utilisateur a &eacute;t&eacute; ajout&eacute;"];
          $szQuery="insert into $table (login,mdp,email)
          values ('".addquote($_POST["login"])."','".addquote($_POST["mdp"])."','".addquote($_POST["email"])."')";
          $link=query($szQuery);
          $id=insert_id();
          //sauvegarde des droits
          for($i=0;$i<count($_POST["groupe_id"]);$i++){
            $sql="insert into ".__racinebd__."groupe_users (groupe_id,users_id) values (".$_POST["groupe_id"][$i].",".$id.")";
            query($sql);
          }
          $szQuery="";
        break;
      	case "modif" :
					$txtmsg=$trad["L'utilisateur a &eacute;t&eacute; modifi&eacute;"];
          
          $szQuery="update $table set 
					login='".addquote($_POST["login"])."',
					mdp='".addquote($_POST["mdp"])."',
					email='".addquote($_POST["email"])."'
          where $tablekey=".$_GET["id"];
          //print $szQuery;
          $sql="delete from ".__racinebd__."groupe_users where users_id=".$_GET["id"];
          query($sql);
					//sauvegarde des droits
          for($i=0;$i<count($_POST["groupe_id"]);$i++){
            $sql="insert into ".__racinebd__."groupe_users (groupe_id,users_id) values (".$_POST["groupe_id"][$i].",".$_GET["id"].")";
            query($sql);
          }
          break;
      }
    	require("../../include/template_save.php");
    }else{
      $szQuery = "SELECT * FROM $table where $tablekey=".$_GET["id"];
	   //libelle=>nom du champ|type|obligatoire|taille (facultatif)
      //les type sont les suivant
      // txt area html media date file email list(nom var requete) listmutiple(nom var requete)
      $query1="select g.groupe_id,g.libelle from ".__racinebd__."groupe g left join ".__racinebd__."groupe_users gu on g.groupe_id=gu.groupe_id and  $tablekey='".$_GET["id"]."' where gu.groupe_id is null";
      //print $query1; 
      $query2="select g.groupe_id,g.libelle from ".__racinebd__."groupe g inner join ".__racinebd__."groupe_users gu on g.groupe_id=gu.groupe_id where $tablekey='".$_GET["id"]."'";
    
		$tabcolonne=array(
		$trad["Login"]=>"login|txt(255)|yes",
		$trad["Mot de passe"]=>"mdp|txt(255)|yes",
		$trad["Email"]=>"email|txt(255)|yes",
		$trad["Groupe(s)"]=>"groupe_id[]|listmultiple(query1,query2)"
		);
	  require("../../include/template_detail.php");
  }
}
?>
