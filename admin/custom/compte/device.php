<?
require("../../require/function.php");
require("../../require/back_include.php");
testGenRulesDie("USR");

$nbelemparpage=($_POST["nbelemparpage"]!="")?$_POST["nbelemparpage"]:(($_SESSION["nbelemparpage"]!="")?$_SESSION["nbelemparpage"]:50);
$_SESSION["nbelemparpage"]=$nbelemparpage;

$typeElem="Boitiers";
$TxtTitre="Boitiers";
$Ajouttxt="Ajouter un boitiers";

$TxtSousTitreajout="Ajouter un boitiers";
$TxtSousTitremodif="Modifier un boitiers";
$TxtSousTitrevisu="&Eacute;diter un boitiers";
$TxtSousTitrelist="Liste des boitiers";
$TxtSousTitresuppr="Supprimer un boitiers";

//$TxtTitreDesc="Textes";
$table=__racinebd__."device";
$tablekey="device_id";
//$txtretour=false;
if($_GET["mode"]!=""){
    if($_GET["mode"]=="list"){
      
			$szQuery = "select t.*,td.libelle from $table t 
                  inner join ".__racinebd__."compte c on c.compte_id=t.compte_id
                  inner join devices d on d.id=t.devices_id
                  inner join ".__racinebd__."type_device td on td.type_device_id=t.type_device_id
                  where t.supprimer=0 and c.compte_id=".$_GET["pere"];
			$ImgAjout=true;
			$tabcolonne=array("Nom"=> "nomvehicule","Serial"=>"serialnumber","IMEI"=>"IMEI","Date de création"=>"date_creation","Type"=>"libelle");
			$update=true;
			$delete=true;
			$notview=true;
			$retour=true;
      $libretour[]="Retour au compte";
      $lienretour[]=__racineadmin__."/custom/compte/index.php?mode=list";
      
			require("../../include/template_list.php");
    }else if($_POST["save"]=="yes"){
    	switch($_GET["mode"]){
        case "suppr" :
          $txtmsg="Le boitiers a &eacute;t&eacute; supprim&eacute;";
          //suppression de l'application sur gpsgate
          $sql="select * from $table where $tablekey=".$_GET["id"];
          $link=query($sql);
          $tbl=fetch($link);
          //archivage des anciennes données
          archivedevice($tbl["devices_id"]);
          $szQuery="update $table set supprimer=1 where $tablekey=".$_GET["id"];
        break;
        case "ajout" :
          $txtmsg="Le boitiers a &eacute;t&eacute; ajout&eacute;";
          //creation du device en base
          //on regarde le dernier id en base
          $sql="select max(id) as maxid from devices";
          $link=query($sql);
          $tbl=fetch($link);
          
          if($_POST["type_device_id"]==1){
            //orion on stock le serial
            $uniqueId=$_POST["unitid"];
          }else{
            $uniqueId=$_POST["IMEI"];
          }
          $sql="insert into devices (name,uniqueId) 
          values('Device".($tbl["maxid"]+1)."','".addquote($uniqueId)."')";
          query($sql);
          $id=insert_id();
          
          $sql="INSERT INTO users_devices (users_id, devices_id) VALUES ('1', $id)";
          query($sql);
          
          $szQuery="insert into ".__racinebd__."device (devices_id,type_device_id,IMEI,serialnumber,vieprivee,modepieton,nomvehicule,telboitier,compte_id,date_creation,unitid) 
          values('".$id."','".$_POST["type_device_id"]."','".addquote($_POST["IMEI"])."','".addquote($_POST["serialnumber"])."','".addquote($_POST["vieprivee"])."','".addquote($_POST["modepieton"])."','".addquote($_POST["nomvehicule"])."','".addquote($_POST["telboitier"])."','".$_GET["pere"]."',now(),'".addquote($_POST["unitid"])."')";
          //query($sql);
                    
          //$szQuery="";
        break;
      	case "modif" :
					$txtmsg="Le boitiers a &eacute;t&eacute; modifi&eacute;";
          //username='".addquote($_POST["username"])."',
          if($_POST["type_device_id"]==1){
            //orion on stock le serial
            $uniqueId=$_POST["unitid"];
          }else{
            $uniqueId=$_POST["IMEI"];
          }
          $sql="update devices set uniqueId='".addquote($uniqueId)."' where id=".$_POST["devices_id"];
          query($sql);
          
          $szQuery="update $table set 
					IMEI='".addquote($_POST["IMEI"])."',
					serialnumber='".addquote($_POST["serialnumber"])."',
          unitid='".addquote($_POST["unitid"])."',          
          vieprivee='".addquote($_POST["vieprivee"])."',
          modepieton='".addquote($_POST["modepieton"])."',
          nomvehicule='".addquote($_POST["nomvehicule"])."',
          telboitier='".addquote($_POST["telboitier"])."'                     
          where $tablekey=".$_GET["id"];
          //print $szQuery;
          //modification de la table device
          
          break;
      }
    	require("../../include/template_save.php");
    }else{
     //$szQuery = "SELECT * FROM $table where $tablekey=".$_GET["id"];
     /* 
     $szQuery = "select * from $table t 
                  inner join ".__racinebd__."compte c on c.application_id=t.original_application_id 
                  inner join device d on d.owner_id=t.user_id
                  inner join ".__racinebd__."device pd on pd.owner_id=t.user_id
                  inner join user_template ut on ut.user_template_id=t.user_template_id	 and ut.application_id=c.application_id and template_name='Device'
                  where active=1 and  $tablekey=".$_GET["id"];
      */                  
      $szQuery = "select * from $table t 
                  inner join ".__racinebd__."compte c on c.compte_id=t.compte_id
                  inner join ".__racinebd__."type_device td on td.type_device_id=t.type_device_id
                  inner join devices d on d.id=t.devices_id
                  where t.supprimer=0 and $tablekey=".$_GET["id"];
	   //libelle=>nom du champ|type|obligatoire|taille (facultatif)
      //les type sont les suivant
      // txt area html media date file email list(nom var requete) listmutiple(nom var requete)
    /*  
		$tabcolonne=array(
		"Nom"=>"username|txt(255)|yes",
		"IMEI"=>"name|txt(255)|yes",
    "Surname"=>"surname|txt(255)|yes",
    "Password"=>"password2|password|yes",
    "Email"=>"email|txt(255)|no"
		);
    */
    
    //group Administrators de l'application afin de pouvoir affiche la list msg_field_dict_id
    $querytypeboitier="SELECT type_device_id,libelle FROM ".__racinebd__."type_device order by libelle";
    
    //$querytypeboitier="select typeboitier_id,libelle from ".__racinebd__."typeboitier order by libelle";
    if($_GET["mode"]=="ajout"){
      $tabcolonne=array(
      "Type de boitier"=>"type_device_id|list(querytypeboitier)|yes",
      "IMEI"=>"IMEI|txt(255)|yes",
      "Numéro de serie"=>"serialnumber|txt(255)|yes",
  		"Nom"=>"nomvehicule|txt(255)|yes",
      "Téléphone (format international ex:+33600000000)"=>"telboitier|txt(255)|yes"
      /*,
      "Vie privée"=>"vieprivee|chk|no",
      "Mode pieton"=>"modepieton|chk|no"
      */
  		);
    }else{
  		$tabcolonne=array(      
      "type_device_id"=>"type_device_id|hidden|yes",
      "id"=>"devices_id|hidden|yes",
      "Type de boitier"=>"libelle|view",
      "IMEI"=>"IMEI|txt(255)|yes",
      "Numéro de serie"=>"serialnumber|txt(255)|yes",
      "Unit ID (obligatoire pour orion)"=>"unitid|txt(255)|yes",
  		"Nom"=>"nomvehicule|txt(255)|yes",
      "Téléphone (format international ex:+33600000000)"=>"telboitier|txt(255)|yes"
      /*,
      "Vie privée"=>"vieprivee|chk|no",
      "Mode pieton"=>"modepieton|chk|no"
      */
  		);
    }
	  require("../../include/template_detail.php");
  }
}
?>
