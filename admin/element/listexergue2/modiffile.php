<?
require("../../require/function.php");
require("../../require/back_include.php");
$_GET["nomobj"]="listimages[]";
set_time_limit(3600);
if($_POST["save"]=="yes"){
	//creation du repertoire tmp
  //@mkdir ($_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id'], 0775);
  //deplacement du fichier
	//move_uploaded_file($_FILES[ext]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$_FILES["ext"]["name"]);
  
  //$filename2=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext2"]["name"]);
  
  if($_FILES["ext1"]["tmp_name"]!=""&&$_POST["ext1_chk"]!=1){
    $myext1=savefile("ext1",__racinebd__."list_images");
	}else{
		if($_POST["ext1"]!=""&&$_POST["ext1_chk"]!=1){
		  $filename1=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext1"]["name"]);
      $myext1=",ext1='".getext($_FILES["ext1"]["name"])."',nom_fichier1='".$filename1."'";
		}else if($_POST["ext1_chk"]==1){
      $myext1=",ext1=null";
    }
  }
  if($_FILES["ext2"]["tmp_name"]!=""&&$_POST["ext2_chk"]!=1){
    $myext2=savefile("ext2",__racinebd__."list_images2_");
	}else{
		if($_POST["ext2"]!=""&&$_POST["ext2_chk"]!=1){
		  $filename2=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext2"]["name"]);
      $myext2=",ext2='".getext($_FILES["ext2"]["name"])."',nom_fichier2='".$filename2."'";
		}else if($_POST["ext2_chk"]==1){
      $myext2=",ext1=null";
    }
  }
  
  //if(move_uploaded_file($_FILES["ext"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$filename)===false){
  //sauvegarde en base
  $ext1=getext($_FILES["ext1"]["name"]);
  $ext2=getext($_FILES["ext2"]["name"]);
  $sql="update ".__racinebd__."list_images 
  set titre1='".addquote($_POST["titre_fichier1"])."',
  titre2='".addquote($_POST["titre_fichier2"])."',
  lightbox='".addquote($_POST["lightbox"])."',
  contenulightbox='".addquote($_POST["contenu"])."'
  $myext1
  $myext2
  where images_id=".$_POST["images_id"];
  /*
  ext1,nom_fichier1,titre2,ext2,nom_fichier2,lightbox,contenulightbox) 
  value(,'".$ext1."','".$filename1."','".addquote($_POST["titre_fichier2"])."','".$ext2."','".$filename2."','".$_POST["lightbox"]."','".$_POST["contenu"]."')";
  */
  $link=query($sql); 
  //$images_id=insert_id();
  $sql="select * from ".__racinebd__."list_images where images_id=".$_POST["images_id"];
  $link=query($sql);
  $tbl_info=fetch($link);
  ?>
  <script>
  //parent.
  
  //content='<table width="100%" style="border-bottom:1px solid black" id="table_image_<?=$images_id?>">';
  content='<input type="hidden" name="listimages[]" value="<?=$_POST["images_id"]?>" />';
  content+='<textarea name="listimagescontenu[]" style="display:none"><?=str_replace(array("\r\n", "\n", "\r"),"",str_replace("'","\'",$tbl_info["contenulightbox"]))?></textarea>';
  content+='<input type="hidden" name="listimageschk[]" value="<?=$tbl_info["lightbox"]?>"/>';
  content+='<input type="hidden" name="listimagestitre1[]" value="<?=$tbl_info["titre1"]?>"/>';
  content+='<input type="hidden" name="listimagestitre2[]" value="<?=$tbl_info["titre2"]?>"/>';
  content+='<input type="hidden" id="images_<?=$_POST["images_id"]?>" name="images_<?=$_POST["images_id"]?>" value="0" />';
  content+='<tr><td><?=$trad["Fichier"]?> :</td><td><a href="<?=__uploaddir__.__racinebd__?>list_images<?=$_POST["images_id"]?>.<?=$tbl_info["ext1"]?>" target="_blank"><?=$tbl_info["nom_fichier1"]?></a></td></tr>';
  content+='<tr><td><?=$trad["Titre"]?> :</td><td><?=$tbl_info["titre1"]?></td></tr>';
  content+='<!--<tr><td><?=$trad["Fichier"]?>2 :</td><td><a href="<?=__uploaddir__.__racinebd__?>list_images2_<?=$_POST["images_id"]?>.<?=$tbl_info["ext2"]?>" target="_blank"><?=$tbl_info["nom_fichier2"]?></a></td></tr>-->';
  //content+='<tr><td>Lien (id si interne) :</td><td><?=$tbl_info["titre2"]?></td></tr>';
  content+='<tr><td colspan="2" align="right"><input type="button" name="supprimer" value="<?=$trad["Supprimer"]?>" onclick="document.getElementById(\'table_images_<?=$_POST["images_id"]?>\').style.display=\'none\';document.getElementById(\'images_<?=$_POST["images_id"]?>\').value=\'1\'"/>';
  content+='<input type="button" name="modifier" value="modifier" onclick="modifelemlistimage(<?=$_POST["images_id"]?>,this)"/></td></tr>';
  top.document.getElementById('table_images_<?=$_POST["images_id"]?>').innerHTML=content;
  /* */
  alert("Modifications prises en compte");
  window.location="insertfile.php?nomobj=listimages[]";
  </script>
  <?
  die;
}
$sql="select * from ".__racinebd__."list_images where images_id=".$_GET["id"];
$link=query($sql);
$tbl_info=fetch($link);
?>
<html>
<head>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
<script type="text/javascript" src="../../libexterne/fckeditor/fckeditor.js"></script>
<script>
function validateForm(obj){

	if(obj.titre_fichier1.value==""){
		alert('Veuillez indiquer un titre');
		obj.titre_fichier1.focus();
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

  <form enctype="multipart/form-data" method="post" action="modiffile.php?nomobj=<?=$_GET["nomobj"]?>" name="monform" style="margin:0;padding:0" onsubmit="return validateForm(this)">
  <input type="hidden" name="save" value="yes" />
  <input type="hidden" name="images_id" value="<?=$_GET["id"]?>" />
  <table width="100%">
  <tr>
    <td>Image  (largeur 148px) :</td> 
    <td><input type="file" name="ext1" />(a remplir pour modifier)</td>
  </tr>
  <tr>
    <td><?=$trad["Titre"]?> :</td>
    <td><input type="text" name="titre_fichier1" value="<?=$tbl_info["titre1"]?>" /></td>
  </tr>
  <!--
  <tr>
    <td><?=$trad["Fichier"]?>2 :</td> 
    <td><input type="file" name="ext2" />(a remplir pour modifier)</td>
  </tr>  -->
  <tr>
    <td>Lien (id si interne) :</td>
    <td><input type="text" name="titre_fichier2" value="<?=$tbl_info["titre2"]?>" /></td>
  </tr>
  <!-- <tr>
    <td>Lightbox :</td>
    <td><input type="checkbox" name="lightbox" value="1" <?=($tbl_info["lightbox"])?"checked":""?>/></td>
  </tr>  -->
  <tr>
    <td colspan="2">Contenu</td>
  </tr>
  <tr>
    <td colspan="2">
    <textarea name="contenu" id="contenu" style="width:450px" rows="24" cols="80"><?=$tbl_info["contenulightbox"]?></textarea>
    <script  type="text/javascript">
    var myeditor = new FCKeditor("contenu") ;
    myeditor.Config["ProcessHTMLEntities"]    = false;
    myeditor.Config["playerUrl"]    = '/userfiles/mediaplayer.swf';
    myeditor.BasePath	= top.fckdir;
    //editor[i].Height = height;
    myeditor.Height = 300;
    myeditor.ToolbarSet="Default";
      //editor[i].Config.StylesXmlPath = chemin+"xmlstyle.php?"+cssdir+cssstring;
      //alert(editor[i].Config.StylesXmlPath)
      //editor[i].Config.EditorAreaCSS = cssdir+cssstring;
			//editor[i].Config.StylesXmlPath =	cssdir+cssstring+'.xml';
  		//editor[i].Config.StylesXmlPath =	'../fckstyles.xml';
	   //editor[i].Config.EditorAreaCSS=chemin + 'css/fck_editorarea.css';
    myeditor.ReplaceTextarea() ;
    </script>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="right"><input type="submit" name="modifier" value="Modifier" /><br>
    <a href="insertfile.php?nomobj=listimages[]">Retour a l'ajout</a>
    </td>
  </tr>
  </table>
  </form>
</body>
</html>