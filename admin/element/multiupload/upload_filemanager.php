<?php
/*
ce s cript est appelÚ par l'animation flash. Prenez note que si vous instanciez une session ici (session_start(); ) elle sera difÚrente de celle de la session instanciÚe par l'utilisateur affichant la page HTML contenant NAS Uploader. Vous ne pouvez donc pas accÚder Ó ses variables de session personnelles 
L'exmple Upload simple lancÚ via javascript  vous donne un moyen de contourner ce problÞme. Tout est expliquÚ.
*/
	//print_r($_FILES);
		//print_r($_GET);
		//echo 'var2='.$_GET['variable2'];  //cette variable est envoyÚe via javascript en argument de la fonction goUpload
		$_GET['dossierup']=str_replace("undefined","",$_GET['dossierup']);
	if (isset($_FILES["Filedata"])) {
	 if($_FILES["Filedata"]['error'] == 0){ 
	   	$tabfile = explode('.',  $_FILES['Filedata']['name']);
			$nomfile = $tabfile[0];
			$extfi = $tabfile[1];
			// si par exemple on a passÚ Ó l'url d'upload un paramÞtre en GET
			//$save_path = $_SERVER["DOCUMENT_ROOT"]."/echange/depot/".$_GET['dossierup'].'/';
			$save_path = $_SERVER["DOCUMENT_ROOT"].$_GET['dossierup'].'/';		
    	if (file_exists($save_path . $_FILES['Filedata']['name'])) {
         echo utf8_encode('Un fichier porte déjà ce nom dans ce dossier');
      } else {
        //creation du répertoire si non existant
        if (!is_dir($save_path)){
          mkdir($save_path, 0700);          
        }
    		if (move_uploaded_file($_FILES["Filedata"]["tmp_name"], $save_path.(($_FILES["Filedata"]["name"])))) {
             echo utf8_encode('1');
    			//on supprime le fichier uploadÚ
    	    //unlink ($save_path.(($_FILES["Filedata"]["name"])));
    	  } else {
    	     	 echo utf8_encode('Erreur d\'écriture');
    	  }
    	}
		} else {
		  switch ($_FILES["Filedata"]['error']) {
  		  case 1:
  		  echo 'Fichier trop volumineux';
  		  break;
  		  case 2:
  		  echo 'Fichier trop volumineux';
  		  break;
  		  case 3:
  		  echo 'Fichier incomplet';
  		  break;
  		  case 4:
  		  echo 'Pas de fichier';
  		  break;
  		  case 5:
  		  echo 'Erreur inconnue';
  		  break;
  		  case 6:
  		  echo 'Erreur serveur'; //pas de dossier tmp
  		  break;
  		  case 7:
  		  echo utf8_encode('Erreur d\'écriture');
  		  break;
  		  case 8:
  		  echo 'Extension incorrecte';
  		  break;
  		  default:
  		  echo 'Erreur inconnue';
  		  break;
		  }
		}
	} else {
	  echo utf8_encode("Pas de fichiers envoyés");
	}
	echo utf8_encode('.');
?>
