<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=($_POST["nbelemparpage"]!="")?$_POST["nbelemparpage"]:(($_SESSION["nbelemparpage"]!="")?$_SESSION["nbelemparpage"]:50);
$_SESSION["nbelemparpage"]=$nbelemparpage;

$typeElem="Compte";
$TxtTitre="Compte";
$Ajouttxt="Ajouter un compte";

$TxtSousTitreajout="Ajouter un compte";
$TxtSousTitremodif="Modifier un compte";
$TxtSousTitrevisu="&Eacute;diter un compte";
$TxtSousTitrelist="Liste des comptes";
$TxtSousTitresuppr="Supprimer un compte";

//$TxtTitreDesc="Textes";
$table=__racinebd__."compte";
$tablekey="compte_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
      if($_GET["pere"]!=""){
        $where =" and t.commercial_id=".$_GET["pere"];
      }
       if($_POST["query"]!=""){
        $where .=" and (t.codecreation like '%".$_POST["query"]."%' or t.raisonsociale like '%".$_POST["query"]."%')";
      }
			$szQuery = "select *,concat(c.nom,' ',c.prenom) as commercial from $table t inner join ".__racinebd__."commercial c on t.commercial_id=c.commercial_id where supprimer = 0 $where";
			$ImgAjout=true;
			$tabcolonne=array("Code création"=> "codecreation","Raison sociale"=>"raisonsociale","Nom"=> "nom","Commercial"=> "commercial","Date de création"=>"date_creation");
			$update=true;
			$delete=true;
			$search=true;
			$notview=true;
      $filtre="filtrecompte.php";
      $valcouleur1=1;
      $couleur="actif";
			$txtcouleur = array("Compte actif","Compte non actif");
      $child=true;
			$childtxt[]="Boitiers";
      $urlchild[]=__racineadmin__."/custom/compte/device.php";
			$childtxt[]="Utilisateurs";
      $urlchild[]=__racineadmin__."/custom/compte/users.php";
      
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg="Le compte a &eacute;t&eacute; supprim&eacute;";

          archivecompte($_GET["id"]);
          $szQuery="update $table set supprimer=1 where ".$tablekey."='".$_GET["id"]."'";
        break;
        case "ajout" :
          $txtmsg="Le compte a &eacute;t&eacute; ajout&eacute;";

          $szQuery="insert into $table (commercial_id,nom,codecreation,raisonsociale,adresse,cp,ville,tel,email,actif,date_creation)
          values ('".addquote($_POST["commercial_id"])."','".addquote($_POST["nom"])."','".addquote($_POST["codecreation"])."','".addquote($_POST["raisonsociale"])."',
          '".addquote($_POST["adresse"])."','".addquote($_POST["cp"])."','".addquote($_POST["ville"])."','".addquote($_POST["tel"])."',
          '".addquote($_POST["email"])."','".addquote($_POST["actif"])."',now())";
          $link=query($szQuery);
          $id=insert_id();
          //sauvegarde des options
          for($i=0;$i<count($_POST["options_id"]);$i++){
            $sql="insert into ".__racinebd__."compte_options (compte_id,options_id) values (".$id.",".$_POST["options_id"][$i].")";
            query($sql);
          }
          
          //creation des préférence par defaut
          $sql="insert into ".__racinebd__."preference_compte (delaimail,dureemintraj,dureeminattente,compte_id) values(60,120,180,".$id.")";
          query($sql);
          
          //creation d'une agence par defaut
          $sql="insert into ".__racinebd__."agence_compte (libelle,principal,compte_id) values('Agence 1',1,".$id.")";
          query($sql);
          
          
          //creation de type de véhicule
          $sql="INSERT INTO `phantom_type_compte` (`libelle`, `compte_id`, `icon`) VALUES('Voiture', ".$id.", 'car_icon.png');";
          query($sql);
          $sql="INSERT INTO `phantom_type_compte` (`libelle`, `compte_id`, `icon`) VALUES('Camion', ".$id.", 'supercamion_icon.png');";
          query($sql);
          $sql="INSERT INTO `phantom_type_compte` (`libelle`, `compte_id`, `icon`) VALUES('Utilitaire', ".$id.", 'utilitaire-icon.png');";
          query($sql);
          
          $szQuery="";
        break;
      	case "modif" :
					$txtmsg="Le compte a &eacute;t&eacute; modifi&eacute;";
          
          $szQuery="update $table set 
					commercial_id='".addquote($_POST["commercial_id"])."',
					nom='".addquote($_POST["nom"])."',
					codecreation='".addquote($_POST["codecreation"])."',         
          adresse='".addquote($_POST["adresse"])."',
          raisonsociale='".addquote($_POST["raisonsociale"])."',
          cp='".addquote($_POST["cp"])."',
          ville='".addquote($_POST["ville"])."',
          tel='".addquote($_POST["tel"])."',
          email='".addquote($_POST["email"])."',
          actif='".addquote($_POST["actif"])."'
          where $tablekey=".$_GET["id"];
          //print $szQuery;
          $sql="delete from ".__racinebd__."compte_options where compte_id=".$_GET["id"];
          query($sql);
					//sauvegarde des options
          for($i=0;$i<count($_POST["options_id"]);$i++){
            $sql="insert into ".__racinebd__."compte_options (compte_id,options_id) values (".$_GET["id"].",".$_POST["options_id"][$i].")";
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
      $query1="select g.options_id,g.libelle from ".__racinebd__."options g left join ".__racinebd__."compte_options gu on g.options_id=gu.options_id and  $tablekey='".$_GET["id"]."' where gu.options_id is null order by libelle";
      //print $query1; 
      $query2="select g.options_id,g.libelle from ".__racinebd__."options g inner join ".__racinebd__."compte_options gu on g.options_id=gu.options_id where $tablekey='".$_GET["id"]."' order by libelle";
      
      $querycommercial="select commercial_id,concat(nom,' ',prenom) from ".__racinebd__."commercial where actif=1 order by nom,prenom";
		$tabcolonne=array(
		"Commercial"=>"commercial_id|list(querycommercial)|yes",
		"Nom"=>"nom|txt(255)|yes",
		"Code création"=>"codecreation|txt(255)|yes",
    "Raison sociale"=>"raisonsociale|txt(255)|yes",
    "Adresse"=>"adresse|txt(255)|yes",
    "Code postal"=>"cp|txt(255)|yes",
    "Ville"=>"ville|txt(255)|yes",
    "Téléphone"=>"tel|txt(255)|no",
    "Email"=>"email|txt(255)|no",
    "Option(s)"=>"options_id[]|listmultiple(query1,query2)",
    "Actif"=>"actif|chk|no"
		);
	  require("../../include/template_detail.php");
  }
}
?>
