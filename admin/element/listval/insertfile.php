<?
require("../../require/function.php");
require("../../require/back_include.php");
set_time_limit(3600);
if($_POST["titre"]!=""){

  $sql="insert into ".__racinebd__."list_val (titre,val) 
  value('".addquote($_POST["titre"])."','".addquote($_POST["val"])."')";
  $link=query($sql); 
  $val_id=insert_id();

  ?>
  <script>
  content='<table width="100%" style="border-bottom:1px solid black" id="table_val_<?=$val_id?>">';
  content+='<input type="hidden" name="listvals[]" value="<?=$val_id?>"/>';
  content+='<input type="hidden" name="listtitre[]" value="<?=$_POST["titre1"]?>"/>';
  content+='<input type="hidden" name="listval[]" value="<?=$_POST["val"]?>"/>';
  content+='<input type="hidden" id="val_<?=$val_id?>" name="val_<?=$val_id?>" value="2" />';
  content+='<tr><td><?=$trad["Titre"]?> :</td><td><?=$_POST["titre"]?></td></tr>';
  content+='<tr><td>Valeur :</td><td><?=$_POST["val"]?></td></tr>';
  content+='<tr><td colspan="2" align="right"><input type="button" name="supprimer" value="<?=$trad["Supprimer"]?>" onclick="document.getElementById(\'table_val_<?=$val_id?>\').style.display=\'none\';document.getElementById(\'val_<?=$val_id?>\').value=\'1\'"/>';
  content+='<input type="button" name="modifier" value="modifier" onclick="modifelemlistval(<?=$val_id?>,this)"/></td></tr></table>';
  //alert(content)
  top.document.getElementById('listvals').innerHTML+=content;
  </script>
  <?
}
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

  <form method="post" action="insertfile.php?nomobj=<?=$_GET["nomobj"]?>" name="monform" style="margin:0;padding:0" onsubmit="return validateForm(this)">
  <table width="100%">
  <tr>
    <td><?=$trad["Titre"]?> :</td>
    <td><input type="text" name="titre" value="" /></td>
  </tr>
  <tr>
    <td>Valeur :</td>
    <td><input type="text" name="val" value="" /></td>
  </tr>  
  <tr>
    <td colspan="2" align="right"><input type="submit" name="valider" value="<?=$trad["valider"]?>" /></td>
  </tr>
  </table>
  </form>

</body>
</html>