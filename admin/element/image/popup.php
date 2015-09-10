<?require("../../require/function.php")?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recadrage d'image</title>
<link rel="stylesheet" type="text/css" href="<?=__racineadmin__.__libext__?>/acidcrop/css/imgareaselect-default.css" /> 
<link rel="stylesheet" type="text/css" href="<?=__racineadmin__.__libext__?>/acidcrop/css/styles.css" /> 
<script>
top.currentelem="<?=$_GET["name"]?>";
top.myvalue="";
/*
myvalue='';
function closewindow(){
  //alert(myvalue)
  window.opener.document.form1.<?=$_GET["name"]?>.value=myvalue;
  //alert(window.opener.document.form1.<?=$_GET["name"]?>.value)
  self.close();
}*/
</script>
<style>
.btnform{border:none;width:171px;height:30px;background:url('../../images/new/fond_bouton.jpg') 0px 4px no-repeat;font-family:Arial;font-size:12px;color:black;font-weight:bold;text-transform:uppercase;margin-top:-4px}
</style>
<script type="text/javascript" src="<?=__racineadmin__.__libext__?>/acidcrop/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=__racineadmin__.__libext__?>/acidcrop/js/jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="custom.js"></script>
</head>
<?
$args=explode(",",$_GET["args"]);
$maxheight=0;
$maxwidth=0;
for($i=0;$i<count($args);$i++){
  $tab=explode("/",$args[$i]);
  $maxwidth=((int)$tab[1]>$maxwidth)?$tab[1]:$maxwidth;
  $maxheight=((int)$tab[2]>$maxheight)?$tab[2]:$maxheight;  
}
/*
$maxwidth=($maxwidth==0)?__widthmaximg__:$maxwidth;
$maxheight=($maxheight==0)?__heightmaximg__:$maxheight;
print $maxheight;
print $maxwidth;
*/
$maxwidth=($maxwidth==0)?"*":$maxwidth;
$maxheight=($maxheight==0)?"*":$maxheight;
if($_GET["myvalue"]==""){
  $filename=$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$_GET['table'].$_GET['id'].".jpg";
  @unlink($filename);
  $filename=$_SERVER["DOCUMENT_ROOT"].__uploaddir__."tbl_".$_GET['table'].$_GET['id'].".jpg";
  @unlink($filename);
  for($i=1;$i<count($args)+1;$i++){
    $filename=$_SERVER["DOCUMENT_ROOT"].__uploaddir__."tbl_".$i.$_GET['table'].$_GET['id'].".jpg";
    @unlink($filename);
  }
}
?>
<body>
<div id="wrap">
    
    <div id="uploader" style="overflow:hidden;">
    	
        <div id="big_uploader" style="margin-left:30px;">
            <!--<input type="button" name="close" value="fermer" onclick="closewindow()" />-->
            <h3>1.Télécharger une image (MAX 1.3 Mo): </h3>
            <form name="upload_big" id="upload_big"  method="post" enctype="multipart/form-data" action="upload.php?act=upload" target="upload_target" style="background:#dadbd5">
              <input name="photo" id="file" size="27" type="file" />
               <input type="hidden" name="height" value="<?=$maxheight?>" />
               <input type="hidden" name="width" value="<?=$maxwidth?>" />
               <input type="hidden" name="nb" value="<?=count($args)?>" />
               <input type="hidden" name="racine" value="<?=$_GET['table'].$_GET['id']?>" />      
              <?if($_GET["id"]==""){
              $filename=__uploaddir__."tbl_tmp_".$_GET['table'].$_SESSION['users_id'].".jpg";
              ?>
              <input type="hidden" name="newname" value="<?='tmp_'.$_GET['table'].$_SESSION['users_id']?>" />
              <?}else{
              $filename=__uploaddir__."tbl_".$_GET['table'].$_GET['id'].".jpg";
              ?>
              <input type="hidden" name="newname" value="<?=$_GET['table'].$_GET['id']?>" />
              <?}?>  
              <input type="submit" name="action" value="Charger" class="btnform"/>
            </form>
            <h3>2. Choisir une vignette à créer: </h3>
            Vignette : 
               <select name="vignette" id="thumbinfo" onchange="reinitval()">
               <?
               for($i=0;$i<count($args);$i++){
                $tab=explode("/",$args[$i]);
                if($tab[1]!="*"&&$tab[2]!="*"){
                  $libelle=$tab[0]." taille fixe (".$tab[1]."x".$tab[2].")";
                }else if($tab[1]!="*"&&$tab[2]=="*"){
                  $libelle=$tab[0]." largeur fixe (".$tab[1]."px)";
                }else if($tab[1]=="*"&&$tab[2]!="*"){
                  $libelle=$tab[0]." hauteur fixe (".$tab[2]."px)";
                }else{
                  $libelle=$tab[0]." libre choix";
                }
                print "<option value=\"".$tab[1]."/".$tab[2]."/".($i+1)."\">".$libelle."</option>";
               }
               ?>
               </select> 
    	</div><!-- big_uploader -->
      	<div style="height:20px">
          <div id="notice">Digesting..</div>
        </div>
        <div id="content">
        <img src="<?=__racineadmin__.__libext__?>/acidcrop/images/top.jpg" width="798" height="38" alt="_" />
			<div id="uploaded">
	   	      <h3>3. Image téléchargée, faites le recadrage</h3>
                	<div id="div_upload_big">
                	<?if(file_exists($_SERVER["DOCUMENT_ROOT"].$filename)){
                  $size=getimagesize($_SERVER["DOCUMENT_ROOT"].$filename);                  
                  ?>
                  <img id="big" src="<?=$filename?>?<?=mktime()?>" />
                  <script>
                  top.myvalue=<?=count($args)?>;
                  tabval[1]=<?=$size[0]?>;
                  tabval[2]=<?=$size[1]?>;
                  onload=reinitval;
                  </script>
                  <?}else{
                  $style="style=\"display:none\"";
                  }?>
                  </div>
                    <form name="upload_thumb" id="upload_thumb" method="post" action="upload.php?act=thumb" target="upload_target" <?=$style?>>

                        <input type="hidden" name="img_src" id="img_src" class="img_src" value="<?=$filename?>"/> 
                        <input type="hidden" name="height" value="0" id="height" class="height" />
                        <input type="hidden" name="width" value="0" id="width" class="width" />
                        <input type="hidden" id="indice" name="indice" />
                        <input type="hidden" id="y1" class="y1" name="y" />
                        <input type="hidden" id="x1" class="x1" name="x" />
                        <input type="hidden" id="y2" class="y2" name="y1" />
                        <input type="hidden" id="x2" class="x2" name="x1" />
                        <input type="hidden" id="uploaddir" name="uploaddir" value="<?=__uploaddir__?>" />
                        
                        <?if($_GET["id"]==""){?>
                        <input type="hidden" id="newname" name="newname" value="<?='tmp_'.$_GET['table'].$_SESSION['users_id']?>" />
                        <?}else{?>
                        <input type="hidden" id="newname" name="newname" value="<?=$_GET['table'].$_GET['id']?>" />
                        <?}?>                         
                        <input type="submit" value="Création de la vignette"  class="btnform"/>
                    </form>
                    
          </div><!-- uploaded-->
      <div style="clear:both"></div>
		  <div id="thumbnail" style="margin-left:20px">
                	<h3>4. Vignette</h3>
                    <div id="div_upload_thumb"></div>
                    
                    <div id="details" style="display:none">
                    	<table width="200">
                    	<tr>
                        	<td colspan="2">Image Source<br /><input type="text" name="img_src" class="img_src" size="35" /></td>
                      </tr>
                      <tr>
                        	<td>Height<br /><input type="text" name="height" class="height" size="5" /></td>
                          <td>Width<br /><input type="text" name="width" class="width" size="5"/></td>
                      </tr>
                      <tr>
                       		<td>Y1<br /><input type="text" class="y1"  size="5"/></td>
                          <td>X1<br /><input type="text" class="x1" size="5" /></td>
                      </tr>
                      <tr>
                       		<td>Y2<br /><input type="text" class="y2" size="5" /></td>
                          <td>X2<br /><input type="text" class="x2" size="5" /></td>
                      </tr>
                      </table>
                    </div>
          </div><!-- thumbnail -->
      		<img src="<?=__racineadmin__.__libext__?>/acidcrop/images/btm.jpg" width="798" height="19" alt="_" />
      </div><!-- content -->
        <iframe id="upload_target" name="upload_target" src="" style="width:100%;height:400px;border:1px solid #ccc;display:none"></iframe>
        <!-- this is the secret iframe :) -->
    </div><!-- uploader -->
</div><!-- wrap -->
</body>
</html>