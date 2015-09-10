<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("TRAD");

$nbelemparpage=50;
$typeElem=$trad["Langue"];
$TxtTitre=$trad["Langue"];
$Ajouttxt=$trad["Ajouter une langue"];

$TxtSousTitreajout=$trad["Ajouter une langue"];
$TxtSousTitremodif=$trad["Modifier une langue"];
$TxtSousTitrevisu=$trad["Visualiser une langue"];
$TxtSousTitrelist=$trad["Liste des langues"];
$TxtSousTitresuppr=$trad["Supprimer une langue"];

//$TxtTitreDesc="Textes";
$table=__racinebd__."langue";
//$textehelp="<li>S&eacute;lectionnez \" Texte \" pour administrer les textes de chaque sc&egrave;ne.</li>";
$tablekey="langue_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			$szQuery = "select t.*,l.libelle as lib from $table t inner join ".__racinebd__."langue l on t.langue_id=l.langue_id";
			$ImgAjout=true;
			$tabcolonne=array("Langue"=> "libelle","Code"=> "shortlib");
			$update=true;
			$delete=false;
			//$media=true;
			$couleur="active";
			$search=false;
			$notview=true;
			//$previewlink="javascript:void(window.open('../../preview/banner.php?id={id}','banniere','height=160,width=160,status=no,toolbar=no,menubar=no,location=no'));";
			//$child=false;
			$valcouleur1=1;
			$txtcouleur = array("langue activée","langue déactivée");
			
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        /*
        case "suppr" :
          $txtmsg="La langue a &eacute;t&eacute; activée/déactivée";
          $szQuery="update $table set active=!active where ".$tablekey."='".$_GET["id"]."'";
        break;
        */
        case "ajout" :
          $txtmsg="La langue a &eacute;t&eacute; ajout&eacute;e";
          if($_FILES["ext"]["tmp_name"]!=""){
	          $myext="'".getext($_FILES["ext"]["name"])."'";
					}else{
						$myext="null";
					}
          $szQuery="insert into $table (libelle,shortlib,ext,active)
          values ('".addquote($_POST["libelle"])."','".addquote($_POST["shortlib"])."',$myext,'".addquote($_POST["active"])."')";
          $link=query($szQuery);
					$id=insert_id();
          if($_FILES["ext"]["tmp_name"]!=""){
	         	$myext=savefile("ext",$table,$id);
  					tbl_img($table,$id,getext($_FILES["ext"]["name"]),16,10);
					}
					//mise a niveau de la table contenu, pour les traduction des noeuds
					$sql="select * from ".__racinebd__."contenu where langue_id=".__defaultlangueid__;
					$link=query($sql);
					while($tbl_result=fetch($link)){
            $sql="insert into ".__racinebd__."contenu (arbre_id,langue_id,nom,translate) values (".$tbl_result["arbre_id"].",".$id.",'".$tbl_result["nom"]."',0)";
            query($sql);
          }
					$szQuery="";
        break;
      	case "modif" :
          if($_FILES["ext"]["tmp_name"]!=""&&$_POST["ext_chk"]!=1){
	          $myext=savefile("ext",$table);
						tbl_img($table,$_GET["id"],getext($_FILES["ext"]["name"]),16,10);
					}else{
           	if($_POST["ext_chk"]==1)
						  $myext=",ext=null ";
					}      	 
					$txtmsg="La langue a &eacute;t&eacute; modifi&eacute;e";
          $szQuery="update $table set 
					libelle='".addquote($_POST["libelle"])."',
					shortlib='".addquote($_POST["shortlib"])."',
					active='".addquote($_POST["active"])."'
					$myext
          where $tablekey=".$_GET["id"];
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
		"Langue"=>"libelle|txt(255)|yes",
		"Code"=>"shortlib|txt(255)|yes",
		"Icon"=>"ext|file(gif,jpg,png)|yes",
		"Active"=>"active|chk"
		);
	  require("../../include/template_detail.php");
  }
}
?>
