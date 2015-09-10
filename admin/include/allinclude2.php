<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<TITLE><?=__title__?></TITLE>
<meta name="author" content="<?=__name__?>" />		
<meta name="viewport" content="width=device-width,initial-scale=1" />
<script type="text/javascript" src="<?=__racineadmin__?>/js/formulaire.js"></script>	
<script type="text/javascript" src="<?=__racineadmin__?>/js/select.js"></script>
<script type="text/javascript" src="<?=__racineadminlib__?>/fckeditor/fckeditor.js"></script>
<script type="text/javascript" src="<?=__racineadminlib__?>/calendar/js/jscal2.js"></script> 
<script type="text/javascript" src="<?=__racineadminlib__?>/calendar/js/lang/<?=(($_SESSION["langue"]!="")?$_SESSION["langue"]:__langueadmin__)?>.js"></script>
<script type="text/javascript" src="<?=__racineadmin__?>/js/function.js"></script>
<script src="<?=__reparbre__?>/jquery/jquery.js" type="text/javascript"></script>
<script src="<?=__reparbre__?>/jquery/jquery-ui.custom.js" type="text/javascript"></script>
<script src="<?=__racineadmin__?>/js/all.js" type="text/javascript"></script>
<?if(file_exists($_SERVER["DOCUMENT_ROOT"].__racineadmin__.__repcustom__."/function.js")){?>
<script type="text/javascript" src="<?=__racineadmin__.__repcustom__?>/function.js"></script>
	<?}?>
<script>
fckdir='<?=__fckdir__?>';
cssdir='<?=__cssdir__?>';
defaultlanguage    = '<?=(($_SESSION["langue"]!="")?$_SESSION["langue"]:__langueadmin__)?>' ;

closetxt='FERMER';
</script>
<?if(file_exists($_SERVER["DOCUMENT_ROOT"].__racineadmin__.__repcustom__."/style.css")){?>
<link rel="stylesheet" type="text/css" href="<?=__racineadmin__.__repcustom__?>/style.css" />
<?}?>
<link rel="stylesheet" type="text/css" href="<?=__racineadminlib__?>/fckeditor/_samples/sample.css" />
<link rel="stylesheet" type="text/css" href="<?=__racineadminlib__?>/calendar/css/jscal2.css" /> 
<link rel="stylesheet" type="text/css" href="<?=__racineadminlib__?>/calendar/css/border-radius.css" /> 
<link rel="stylesheet" type="text/css" href="<?=__racineadminlib__?>/calendar/css/steel/steel.css" /> 
<link rel="stylesheet" type="text/css" href="<?=__racineadmin__?>/styles/index_p01.css">
<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/all.css" type="text/css" />
	
<!--[if gte IE 9]>
	<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/ie9.css" type="text/css" />
	<![endif]-->
	
	<!--[if gte IE 8]>
	<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/ie8.css" type="text/css" />
	<![endif]-->
<!--[if IE 6]>
<style type="text/css">
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