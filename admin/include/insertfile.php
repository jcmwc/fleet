<?
require("../require/function.php");
if($_FILES["ext"]["tmp_name"]!=""){
	//creation du repertoire tmp
  @mkdir ($_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id'], 0775);
  //deplacement du fichier
	//move_uploaded_file($_FILES[ext]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$_FILES["ext"]["name"]);
  $filename=preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["ext"]["name"]);
  //if(move_uploaded_file($_FILES["ext"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."u".$_SESSION['users_id']."/".$filename)===false){
  if(move_uploaded_file($_FILES["ext"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].__uploaddir__."tmp/".$filename)===false){
  ?>
  <script>
	alert('<?=$trad["Erreur de transfert de fichier"]?>')
  </script>
  <?}else{?>
  <script>
  top.document.getElementById('listfile').innerHTML+="Supprimer <input type=\"hidden\" name=\"list2<?=$_GET["nomobj"]?>\" value=\"<?=$filename?>\"><input type=\"checkbox\" name=\"<?=$_GET["nomobj"]?>\" value=\"<?=$filename?>\"><?=$filename?><br>";
  </script>
  <?}
}
?>
<html>
<head>
<script>
function validateForm(obj){
	if(obj.value!=""){
		obj.form.submit();
  	obj.disabled=true;
	}
}
</script>
</head>
<body style="margin:0;padding:0">
<form enctype="multipart/form-data" method="post" action="insertfile.php?nomobj=<?=$_GET["nomobj"]?>" style="margin:0;padding:0">
<input type="file" name="ext" onchange="validateForm(this)">
</form>
</body>
</html>