<?
require("../../require/function.php");
require("../../require/back_include.php");
$_GET["nomobj"]="listval[]";
set_time_limit(3600);
if($_POST["save"]=="yes"){
	//creation du repertoire tmp
  //@mkdir ($_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id'], 0775);
  //deplacement du fichier
	//move_uploaded_file($_FILES[ext]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$_FILES["ext"]["name"]);
  
  //$filename2=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext2"]["name"]);
  
 
  
  //if(move_uploaded_file($_FILES["ext"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$filename)===false){
  //sauvegarde en base
  $sql="update ".__racinebd__."list_val 
  set titre='".addquote($_POST["titre"])."',
  val='".addquote($_POST["val"])."'
  where val_id=".$_POST["val_id"];
  /*
  ext1,nom_fichier1,titre2,ext2,nom_fichier2,lightbox,contenulightbox) 
  value(,'".$ext1."','".$filename1."','".addquote($_POST["titre_fichier2"])."','".$ext2."','".$filename2."','".$_POST["lightbox"]."','".$_POST["contenu"]."')";
  */
  $link=query($sql); 
  //$images_id=insert_id();
  $sql="select * from ".__racinebd__."list_val where val_id=".$_POST["val_id"];
  $link=query($sql);
  $tbl_info=fetch($link);
  ?>
  <script>
  //parent.
  content='<table width="100%" style="border-bottom:1px solid black" id="table_val_<?=$_POST["val_id"]?>">';
  content='<input type="hidden" name="listvals[]" value="<?=$tbl_info["val_id"]?>"/>';
  content+='<input type="hidden" name="listtitre[]" value="<?=$tbl_info["titre"]?>"/>';
  content+='<input type="hidden" name="listval[]" value="<?=$tbl_info["val"]?>"/>';
  content+='<input type="hidden" id="val_<?=$val_id?>" name="val_<?=$_POST["val_id"]?>" value="2" />';
  content+='<tr><td><?=$trad["Titre"]?> :</td><td><?=$tbl_info["titre"]?></td></tr>';
  content+='<tr><td>Valeur :</td><td><?=$tbl_info["val"]?></td></tr>';
  content+='<tr><td colspan="2" align="right"><input type="button" name="supprimer" value="<?=$trad["Supprimer"]?>" onclick="document.getElementById(\'table_val_<?=$_POST["val_id"]?>\').style.display=\'none\';document.getElementById(\'val_<?=$_POST["val_id"]?>\').value=\'1\'"/>';
  content+='<input type="button" name="modifier" value="modifier" onclick="modifelemlistval(<?=$val_id?>,this)"/></td></tr></table>';
  

  top.document.getElementById('table_val_<?=$_POST["val_id"]?>').innerHTML=content;
  /* */
  alert("Modifications prises en compte");
  window.location="insertfile.php?nomobj=listval[]";
  </script>
  <?
  die;
}
$sql="select * from ".__racinebd__."list_val where val_id=".$_GET["id"];
$link=query($sql);
$tbl_info=fetch($link);
?>
<html>
<head>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
<script>
function validateForm(obj){

	if(obj.titre.value==""){
		alert('Veuillez indiquer un titre');
		obj.titre.focus();
		return false;
	}
	
	return true;
}
</script>
<style>
td{font-style:arial;font-size:12px;color:black;font-weight:bold}
</style>
</head>
<body style="margin:0;padding:0;background:#bebebd">

  <form enctype="multipart/form-data" method="post" action="modiffile.php?nomobj=<?=$_GET["nomobj"]?>" name="monform" style="margin:0;padding:0" onsubmit="return validateForm(this)">
  <input type="hidden" name="save" value="yes" />
  <input type="hidden" name="val_id" value="<?=$_GET["id"]?>" />
  <table width="100%">
  
  <tr>
    <td><?=$trad["Titre"]?> :</td>
    <td><input type="text" name="titre" value="<?=$tbl_info["titre"]?>" /></td>
  </tr>
  
  <tr>
    <td>Val :</td>
    <td><input type="text" name="val" value="<?=$tbl_info["val"]?>" /></td>
  </tr>
  
  <tr>
    <td colspan="2" align="right"><input type="submit" name="modifier" value="Modifier" /><br>
    <a href="insertfile.php?nomobj=listval[]">Retour a l'ajout</a>
    </td>
  </tr>
  </table>
  </form>
</body>
</html>