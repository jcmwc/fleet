<?
$TxtSousTitre="TxtSousTitre".$_GET["mode"];
$TxtSousTitre=$$TxtSousTitre;
$resultat= query($szQuery);
//require("../include/template_haut".$_GET["template"].".php");
require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_haut.php");
?>

<style type="text/css">
#formdiv a{font-family :arial;}
#formdiv a:link{color : #BBBBBB; text-decoration : none;}
#formdiv a:active{color : #add01e; text-decoration : none;}  
#formdiv a:visited{color : #BBBBBB; text-decoration : none;}
#formdiv a:hover{color : #add01e; text-decoration : none;}
</style>
<div id="formdiv" style="margin:0 auto;position:relative;  text-align : center; font-size : 14px; line-height : 17px; font-family : arial; padding-top : 40px; padding-bottom : 50px;">
			<strong><?=$errorString?> <?=$txtmsg?></strong><br/><br/>
			<?if ($detailsave!="no") {
        if ($_GET["mode"]!="send") {
			   if($_GET["template"]=="_popup"){?>
	        <A HREF="javascript:self.close()" ><?=$trad["Fermer"]?></A><br />
         <?}else{
          if($notliste!=true){?>
					<A HREF="<?=$_SERVER["PHP_SELF"]?>?mode=list&pere=<?=$_GET["pere"]?>" target="framecontent"><?=$trad["Cliquez ici pour retourner dans"]?> <?=$TxtSousTitrelist?>.</A><br />
   	     <?}
				if($_GET["mode"]!="suppr"&&$_GET["mode"]!="ajout"&&$notviewsstitre!=true&&$_POST["save"]=="yes"){?>
	        <A HREF="<?=$_SERVER["PHP_SELF"]?>?mode=visu&pere=<?=$_GET["pere"]?>&id=<?=$_GET["id"]?>" target="framecontent"><?=$trad["Cliquez ici pour voir la modification"]?>.</A><br />
   	      <?}}}}?>
<div class="clear"></div>
</div>
<div class="clear"></div>

<?require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_bas.php");?>
