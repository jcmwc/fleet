<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("GAB");

$nbelemparpage=50;

$typeElem=$trad["Gabarit"];
$TxtTitre=$trad["Gabarit"];
$Ajouttxt=$trad["Ajouter un gabarit"];

$TxtSousTitreajout=$trad["Ajouter un gabarit"];
$TxtSousTitremodif=$trad["Modifier un gabarit"];
$TxtSousTitrevisu=$trad["&Eacute;diter un gabarit"];
$TxtSousTitrelist=$trad["Liste des gabarits"];
$TxtSousTitresuppr=$trad["Supprimer un gabarit"];

$table=__racinebd__."gabarit";
$tablekey="gabarit_id";
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
			$szQuery = "select * from $table where supprimer = 0";
			$ImgAjout=true;
			$tabcolonne=array($trad["Nom du gabarit"]=> "libelle");
			$update=true;
			$delete=false;
			$search=false;
			$notview=true;
			$txtcouleur[0] = $trad["Gabarit valid&eacute;"];
			$txtcouleur[1] = $trad["Gabarit non valid&eacute;"];
			$child=false;
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg=$trad["Le gabarit a &eacute;t&eacute; supprim&eacute;"];
          $szQuery="update $table set supprimer=1 where gabarit_id='".$_GET["id"]."'";
        break;
        case "ajout" :
          if($_FILES["iconnormal"]["tmp_name"]!=""){
	            		$myext="'".getext($_FILES["iconnormal"]["name"])."'";
					}else{
						$myext="null";
					}
					if($_FILES["iconsecure"]["tmp_name"]!=""){
	            		$myext2="'".getext($_FILES["iconsecure"]["name"])."'";
					}else{
						$myext2="null";
					}
          $txtmsg=$trad["Le gabarit a &eacute;t&eacute; ajout&eacute;"];
          $szQuery="insert into $table (iconnormal,iconsecure,libelle,table_nom,nom_fichier,sitemap,rss,search)
          values ($myext,$myext2,'".addquote($_POST["libelle"])."','".addquote($_POST["table_nom"])."','".addquote($_POST["nom_fichier"])."','".addquote($_POST["sitemap"])."','".addquote($_POST["rss"])."','".addquote($_POST["search"])."')";
          
          $link=query($szQuery);
					$id=insert_id();
					if($_FILES["iconnormal"]["tmp_name"]!=""){
            $myext=savefile("iconnormal",$table,$id);
            tbl_img($table,$id,getext($_FILES["iconnormal"]["name"]),18,18);
					}
					if($_FILES["iconsecure"]["tmp_name"]!=""){
            $myext2=savefile("iconsecure",$table."2_",$id);
            tbl_img($table."2_",$id,getext($_FILES["iconsecure"]["name"]),18,18);
					}
					$szQuery="";
        break;
      	case "modif" :
          if($_FILES["iconnormal"]["tmp_name"]!=""&&$_POST["iconnormal_chk"]!=1){
            $myext=savefile("iconnormal",$table);
            tbl_img($table,$_GET["id"],getext($_FILES["iconnormal"]["name"]),18,18);
					}else{
           	if($_POST["iconnormal_chk"]==1)
						  $myext=",iconnormal=null ";
					}
					if($_FILES["iconsecure"]["tmp_name"]!=""&&$_POST["iconsecure_chk"]!=1){
	          $myext2=savefile("iconsecure",$table."2_");    		
            tbl_img($table."2_",$_GET["id"],getext($_FILES["iconsecure"]["name"]),18,18);
					}else{
            if($_POST["iconsecure_chk"]==1)
              $myext2=",iconsecure=null ";
					}
					$txtmsg=$trad["Le gabarit a &eacute;t&eacute; modifi&eacute;"];
          $szQuery="update $table set 
					libelle='".addquote($_POST["libelle"])."',
					table_nom='".addquote($_POST["table_nom"])."',
					nom_fichier='".addquote($_POST["nom_fichier"])."',
					sitemap='".addquote($_POST["sitemap"])."',
					search='".addquote($_POST["search"])."',
					rss='".addquote($_POST["rss"])."'
					$myext
					$myext2 
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
		$trad["Image normale"]=>"iconnormal|file(jpg,jpeg,gif,png)|no",
    $trad["Image secure"]=>"iconsecure|file(jpg,jpeg,gif,png)|no",
		$trad["Libelle gabarit"]=>"libelle|txt(255)|yes",
		$trad["Table"]=>"table_nom|txt(255)|yes",
		$trad["Nom du fichier .php"]=>"nom_fichier|txt(255)|no",
    $trad["Plan du site"]=>"sitemap|radio2(non,oui)|yes",
		$trad["Flux Rss"]=>"rss|radio2(non,oui)|yes",
		$trad["Recherche"]=>"search|radio2(non,oui)|yes"
		);
	  require("../../include/template_detail.php");
  }
}
?>
