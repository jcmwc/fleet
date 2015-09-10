<?
require("../../require/function.php");
require("../../require/back_include.php");
set_time_limit(3600);
if($_POST["titre"]!=""){
  $sql="select max(ordre) as maxordre from ".__racinebd__."newsletterline where supprimer=0 and newsletter_id=".$_GET["id"];
  $link=query($sql);
  $tbl=fetch($link);
  
  if($_FILES["ext"]["tmp_name"]!=""){
    $myext="'".getext($_FILES["ext"]["name"])."'";  
  }else{
    if($_POST["ext"]!=""){
      $myext="'".$_POST["ext"]."'";
  	}else{
      $myext="null";
    }
  }
  $sql="insert into ".__racinebd__."newsletterline (newsletter_id,titre,contenu,ordre,ext,lien) 
  value('".addquote($_GET["id"])."','".addquote($_POST["titre"])."','".str_replace(",",".",addquote($_POST["contenu"]))."','".($tbl["maxordre"]+1)."',$myext,'".addquote($_POST["lien"])."')";
  $link=query($sql); 
  $mmontant_id=insert_id();
  
  if($_FILES["ext"]["tmp_name"]!=""){
      savefile("ext",__racinebd__."newsletterline",$mmontant_id);    
	}

  ?>
  <script>
  //rafraichissement de la liste
  //alert(top.listidmontantiframelist.location)
  if(top.listidmontantiframelist.contentWindow)
  top.listidmontantiframelist.contentWindow.location.href=top.listidmontantiframelist.contentWindow.location.href.replace('mode=','');
  else
    top.listidmontantiframelist.location.href=top.listidmontantiframelist.location.href.replace('mode=','');

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
  <form method="post" action="insertfile.php?nomobj=<?=$_GET["nomobj"]?>&id=<?=$_GET["id"]?>" name="monform" style="margin:0;padding:0" onsubmit="return validateForm(this)" enctype="multipart/form-data">
  <table width="100%">    
  <tr>
    <td valign="top">Titre :</td>
    <td colspan="2"><input type="text" name="titre" value="" style="width:100%;height:20px"/></td>
  </tr>
  <tr>
    <td vlign="top">Contenu :</td>
    <td colspan="2"><textarea name="contenu" style="width:100%;height:55px"></textarea></td>
  </tr>
  <tr>
    <td valign="top">Lien :</td>
    <td colspan="2"><input type="text" name="lien" value="" style="width:100%;height:20px"/></td>
  </tr>
  <tr>
    <td vlign="top">Image :</td>
    <td colspan="2"><input type="file" name="ext"></td>
    <td  align="right"><input type="submit" name="valider" value="<?=$trad["valider"]?>" /></td>
  </tr>
  </table>
  </form>
</body>
</html>