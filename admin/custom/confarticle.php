<?
  $sqllistval="select * from ".__racinebd__."list_val where supprimer=0 and content_id!=0 and content_id='".$_GET["content_id"]."'";
  $sqllistmodule="select module_id,libelle from ".__racinebd__."module order by libelle";

    switch($_GET["gabarit_id"]){
    	case 1 :
      //site 
    		$tabcolonne=array(
    		"version_id"=>"version_id|hidden",
    		"nom du site(RSS)"=>"titre1|txt(255)|yes",
    		"Email contact"=>"titre2|txt(255)|yes",
    		"Dossier"=>"abstract|txt(255)|yes"        
    		);
    		break;
      case 2 :
      //rubrique 
    		$tabcolonne=array(
    		"version_id"=>"version_id|hidden",
    		"Titre gauche"=>"titre1|txt(255)|yes|true",
        "Sous Titre gauche"=>"titre2|txt(255)|no|true",    
        "Contenu gauche"=>"abstract|html2(contenu.css)|no|true",
        "Titre droite"=>"titre3|txt(255)|no|true",
        "Sous Titre droite"=>"titre4|txt(255)|no|true",    
        "Contenu droite"=>"contenu|html2(contenu.css)|no|true",     
    		);
    		break;
        /*
      case 2 :
      //rubrique 
    		$tabcolonne=array(
    		"version_id"=>"version_id|hidden",
    		"Titre"=>"titre1|txt(72)|yes|true",
        "Sous Titre"=>"titre2|txt(255)|no|true",    
        "Abstract"=>"abstract|html(contenu.css)|no|true",
        "Intertitre"=>"titre3|txt(255)|no|true"     
    		);
    		break;
      case 3 :
      //article 
    		$tabcolonne=array(
    		"version_id"=>"version_id|hidden",
    		"Titre"=>"titre1|txt(72)|yes|true",
        "Visuel rubrique (300px*90px)"=>"ext|file|yes",
        "Sous Titre"=>"titre2|txt(255)|no|true",    
        "Abstract"=>"abstract|html(contenu.css)|no|true",
        "Intertitre"=>"titre3|txt(255)|no|true",
        "Contenu"=>"contenu|htmltemplate(contenu.css)|no|true"     
    		);
    		break;
        */
    	default :
    	//default
    		$tabcolonne=array(
    		"version_id"=>"version_id|hidden",
    		"Titre"=>"titre1|txt(255)|yes|true"
    		);
    		break;
		}
    $tabcolonne["Droit"]="note1|list(sqllistmodule)|no";	
    $tabcolonne["SEO"]="delim";
    $tabcolonne["Meta title"]="titleseo|txt(90)|no";
    $tabcolonne["Meta description"]="abstractseo|area|no";
    $tabcolonne["Meta robots"]="robotseo|radio3(index,follow;index,nofollow;noindex,nofollow)|no";
?>