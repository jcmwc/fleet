<?
require("../../require/function.php");
require("../../require/back_include.php");
set_time_limit(3600);
if($_FILES["ext"]["tmp_name"]!=""){
	//creation du repertoire tmp
  //@mkdir ($_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id'], 0775);
  //deplacement du fichier
	//move_uploaded_file($_FILES[ext]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$_FILES["ext"]["name"]);
  //$filename=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext"]["name"]);
  $filename=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext"]["name"]);
  $filename=makename($_FILES["ext"]["name"]);
  //if(move_uploaded_file($_FILES["ext"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$filename)===false){
  //sauvegarde en base
  $ext=getext($_FILES["ext"]["name"]);
  
  //$sql="insert into ".__racinebd__."fichiers (titre,abstract,ext,nom_fichier,contenu) value('".addquote($_POST["titre_fichier"])."','".addquote($_POST["description_fichier"])."','".$ext."','".$filename."','".$contenu."')";
  $sql="insert into ".__racinebd__."fichiers (titre,abstract,ext,nom_fichier) value('".addquote($_POST["titre_fichier"])."','".addquote($_POST["description_fichier"])."','".$ext."','".addquote($filename)."')";
  //print $sql;
  $link=query($sql); 
  $fichiers_id=insert_id();
  savefile("ext",__racinebd__."fichiers",$fichiers_id);
  //print $_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__."fichiers".$fichiers_id.".".$ext;  
  if(PHANTOM_FULLTEXT==true){
    $contenu=addslashes(extract2tmpfile($ext,$_SERVER["DOCUMENT_ROOT"].__uploaddir__.__racinebd__."fichiers".$fichiers_id.".".$ext));
  }
  if($contenu==''){
    $contenu=addquote($_POST["description_fichier"]);
  }
  
  $sql="update ".__racinebd__."fichiers set contenu='".$contenu."' where fichiers_id=".$fichiers_id;
  query($sql);
  ?>
  <script>
  content='<table width="100%" style="border-bottom:1px solid black" id="table_fichier_<?=$fichiers_id?>">';
  content+='<input type="hidden" name="listfichiers[]" value="<?=$fichiers_id?>"/>';
  content+='<input type="hidden" id="fichiers_<?=$fichiers_id?>" name="fichiers_<?=$fichiers_id?>" value="2" />';
  content+='<tr><td><?=$trad["Fichier"]?> :</td><td><a href="<?=__uploaddir__.__racinebd__?>fichiers<?=$fichiers_id?>.<?=$ext?>" target="_blank"><?=str_replace("'","\'",$filename)?></a></td></tr>';
  content+='<tr><td><?=$trad["Titre"]?> :</td><td><?=str_replace("'","\'",$_POST["titre_fichier"])?></td></tr>';
  content+='<tr><td><?=$trad["Description"]?> :</td><td><?=$_POST["description_fichier"]?></td></tr>';
  content+='<tr><td colspan="2" align="right"><input type="button" name="supprimer" value="<?=$trad["Supprimer"]?>" onclick="document.getElementById(\'table_fichier_<?=$fichiers_id?>\').style.display=\'none\';document.getElementById(\'fichiers_<?=$fichiers_id?>\').value=\'1\'"/></td></tr></table>';
  top.document.getElementById('listfile').innerHTML+=content;
  </script>
  <?
}
?>
<html>
<head>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">

<script>
function validateForm(obj){
	if(obj.ext.value==""){
		alert('<?=$trad["Veuillez choisir un fichier"]?>');
		obj.ext.focus();
		return false;
	}
	if(obj.titre_fichier.value==""){
		alert('<?=$trad["Veuillez indiquer un titre"]?>');
		obj.titre_fichier.focus();
		return false;
	}
	/*
	if(obj.description_fichier.value==""){
		alert('Veuillez indiquer une description');
		obj.description_fichier.focus();
		return false;
	}*/
	return true;
}
</script>
<style>
td{font-style:arial;font-size:12px;color:black;font-weight:bold}
</style>
</head>
<body style="margin:0;padding:0;background:#bebebd">

  <form enctype="multipart/form-data" method="post" action="insertfile.php?nomobj=<?=$_GET["nomobj"]?>" style="margin:0;padding:0" onsubmit="return validateForm(this)">
  <table width="100%">
  <tr>
    <td><?=$trad["Fichier"]?> :</td> 
    <td><input type="file" name="ext" /></td>
  </tr>
  <tr>
    <td><?=$trad["Titre"]?> :</td>
    <td><input type="text" name="titre_fichier" value="" /></td>
  </tr>
  <tr>
    <td>Description :</td>
    <td><textarea name="description_fichier" style="width:200px;height:80px"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><input type="submit" name="valider" value="<?=$trad["valider"]?>" /></td>
  </tr>
  </table>
  </form>

</body>
</html>