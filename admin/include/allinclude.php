<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<HEAD>
<TITLE><?=__title__?></TITLE>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<script type="text/javascript" src="<?=__racineadmin__?>/js/formulaire.js"></script>	
<script type="text/javascript" src="<?=__racineadmin__?>/js/select.js"></script>
<script type="text/javascript" src="<?=__racineadminlib__?>/fckeditor/fckeditor.js"></script>
<script type="text/javascript" src="<?=__racineadminlib__?>/calendar/js/jscal2.js"></script> 
<script type="text/javascript" src="<?=__racineadminlib__?>/calendar/js/lang/<?=(($_SESSION["langue"]!="")?$_SESSION["langue"]:__langueadmin__)?>.js"></script>
<script type="text/javascript" src="<?=__racineadmin__?>/js/function.js"></script>
<?if(file_exists($_SERVER["DOCUMENT_ROOT"].__racineadmin__.__repcustom__."/function.js")){?>
<script type="text/javascript" src="<?=__racineadmin__.__repcustom__?>/function.js"></script>
	<?}?>
<script>
var GB_ROOT_DIR = "<?=__racineadminlib__?>/greybox/";
fckdir='<?=__fckdir__?>';
cssdir='<?=__cssdir__?>';
defaultlanguage    = '<?=(($_SESSION["langue"]!="")?$_SESSION["langue"]:__langueadmin__)?>' ;
</script>
<script type="text/javascript" src="<?=__racineadminlib__?>/greybox/AJS.js"></script>
<script type="text/javascript" src="<?=__racineadminlib__?>/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="<?=__racineadminlib__?>/greybox/gb_scripts.js"></script>
<script>
closetxt='FERMER';
</script>
<link href="<?=__racineadminlib__?>/greybox/gb_styles.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?=__racineadminlib__?>/fckeditor/_samples/sample.css" />
<link rel="stylesheet" type="text/css" href="<?=__racineadminlib__?>/calendar/css/jscal2.css" /> 
<link rel="stylesheet" type="text/css" href="<?=__racineadminlib__?>/calendar/css/border-radius.css" /> 
<link rel="stylesheet" type="text/css" href="<?=__racineadminlib__?>/calendar/css/steel/steel.css" /> 
<link rel="stylesheet" type="text/css" href="<?=__racineadmin__?>/styles/index_p01.css">


<!--[if IE 6]>
<style type="text/css">
#img_pointer_arbre{background:none;width:20px;height:65px;}
.img_pointer_arbre_on{filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=__reparbre__?>icones_arbre/fleche_on.png');}
.img_pointer_arbre_off{filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=__reparbre__?>icones_arbre/fleche_off.png');}
.menu li {overflow:hidden;}
a:hover.ss_menu_nouveau3 span {top:10px;left:-20px;}
</style>
<![endif]-->
<!--[if gte IE 7]>
<style type="text/css">
#resultat{width:auto;overflow:auto;overflow-x:hidden;}
a:hover.ss_menu_nouveau3 span {top:0px;}
</style>
<![endif]-->
<!--[if gte IE 8]>
<style type="text/css">
a:hover.ss_menu_nouveau3 span {top:-40px;}
</style>
<![endif]-->