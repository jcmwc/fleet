<?
require("../../require/function.php");
require("../../require/back_include.php");
set_time_limit(3600);
if($_FILES["ext1"]["tmp_name"]!=""){
	//creation du repertoire tmp
  //@mkdir ($_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id'], 0775);
  //deplacement du fichier
	//move_uploaded_file($_FILES[ext]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$_FILES["ext"]["name"]);
  $filename1=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext1"]["name"]);
  $filename2=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext2"]["name"]);
  //if(move_uploaded_file($_FILES["ext"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$filename)===false){
  //sauvegarde en base
  $ext1=getext($_FILES["ext1"]["name"]);
  $ext2=getext($_FILES["ext2"]["name"]);
  /*if(PHANTOM_FULLTEXT==true){
    $contenu1=addslashes(extract2tmpfile($ext1,$_FILES["ext1"]["tmp_name"]));
    $contenu2=addslashes(extract2tmpfile($ext2,$_FILES["ext2"]["tmp_name"]));
  }else{
    $contenu1=addquote($_POST["description_fichier1"]);
    $contenu2=addquote($_POST["description_fichier2"]);
  }*/
  $sql="insert into ".__racinebd__."list_images (titre1,ext1,nom_fichier1,titre2,ext2,nom_fichier2,lightbox,contenulightbox) 
  value('".addquote($_POST["titre_fichier1"])."','".$ext1."','".$filename1."','".addquote($_POST["titre_fichier2"])."','".$ext2."','".$filename2."','".$_POST["lightbox"]."','".$_POST["contenu"]."')";
  $link=query($sql); 
  $images_id=insert_id();
  savefile("ext1",__racinebd__."list_images",$images_id);
  savefile("ext2",__racinebd__."list_images2_",$images_id);
  ?>
  <script>
  content='<table width="100%" style="border-bottom:1px solid black" id="table_images_<?=$images_id?>">';
  content+='<input type="hidden" name="listimages[]" value="<?=$images_id?>"/>';
  content+='<textarea name="listimagescontenu[]" style="display:none"><?=str_replace(array("\r\n", "\n", "\r"),"",str_replace("'","\'",$_POST["contenu"]))?></textarea>';
  content+='<input type="hidden" name="listimageschk[]" value="<?=$_POST["lightbox"]?>"/>';
  content+='<input type="hidden" name="listimagestitre1[]" value="<?=$_POST["titre_fichier1"]?>"/>';
  content+='<input type="hidden" name="listimagestitre2[]" value="<?=$_POST["titre_fichier2"]?>"/>';
  content+='<input type="hidden" id="images_<?=$images_id?>" name="images_<?=$images_id?>" value="2" />';
  content+='<tr><td><?=$trad["Fichier"]?>1 :</td><td><a href="<?=__uploaddir__.__racinebd__?>list_images<?=$images_id?>.<?=$ext1?>" target="_blank"><?=$filename1?></a></td></tr>';
  content+='<tr><td><?=$trad["Titre"]?>1 :</td><td><?=$_POST["titre_fichier1"]?></td></tr>';
  content+='<!-- <tr><td><?=$trad["Fichier"]?>2 :</td><td><a href="<?=__uploaddir__.__racinebd__?>list_images2_<?=$images_id?>.<?=$ext2?>" target="_blank"><?=$filename2?></a></td></tr> -->';
  content+='<tr><td>Lien (id si interne) :</td><td><?=$_POST["titre_fichier2"]?></td></tr>';
  content+='<tr><td colspan="2" align="right"><input type="button" name="supprimer" value="<?=$trad["Supprimer"]?>" onclick="document.getElementById(\'table_images_<?=$images_id?>\').style.display=\'none\';document.getElementById(\'images_<?=$images_id?>\').value=\'1\'"/>';
  content+='<input type="button" name="modifier" value="modifier" onclick="modifelemlistimage(<?=$images_id?>,this)"/></td></tr></table>';
  top.document.getElementById('listimages').innerHTML+=content;
  </script>
  <?
}
?>
<html>
<head>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
<script type="text/javascript" src="../../libexterne/fckeditor/fckeditor.js"></script>
<script>
function validateForm(obj){
	if(obj.ext1.value==""){
		alert('Veuillez choisir une image');
		obj.ext1.focus();
		return false;
	}
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

  <form enctype="multipart/form-data" method="post" action="insertfile.php?nomobj=<?=$_GET["nomobj"]?>" name="monform" style="margin:0;padding:0" onsubmit="return validateForm(this)">
  <table width="100%">
  <tr>
    <td>Image (largeur 199px) :</td> 
    <td><input type="file" name="ext1" /></td>
  </tr>
  <tr>
    <td><?=$trad["Titre"]?> :</td>
    <td><input type="text" name="titre_fichier1" value="" /></td>
  </tr>
  <!-- <tr>
    <td><?=$trad["Fichier"]?>2 :</td> 
    <td><input type="file" name="ext2" /></td>
  </tr> -->
  <tr>
    <td>Lien (id si interne) :</td>
    <td><input type="text" name="titre_fichier2" value="" /></td>
  </tr>
  <!-- <tr>
    <td>Lightbox :</td>
    <td><input type="checkbox" name="lightbox" value="1" /></td>
  </tr>  -->
  <tr>
    <td colspan="2">Contenu</td>
  </tr>
  <tr>
    <td colspan="2">
    <textarea name="contenu" id="contenu" style="width:450px" rows="24" cols="80"></textarea>
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
    <td colspan="2" align="right"><input type="submit" name="valider" value="<?=$trad["valider"]?>" /></td>
  </tr>
  </table>
  </form>

</body>
</html>