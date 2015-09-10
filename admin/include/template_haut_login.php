<?
require_once($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/require/back_include.php");
//$br = new Browser;
/************************************************************/
if ($_SESSION['islog']==""&&$notlogpage=="") {?>
	<script>window.location='<?=__racineadmin__?>/index.php'</script>
	<?
   die;
}

?>
<?require("allinclude2.php")?>
<script>
top.editor= new Array();
top.editorpdf= new Array();
top.editorhtml= new Array();
top.calendar= new Array();
</script>
<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/all.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/login.css" type="text/css" media="screen" title="no title" />
</HEAD>
<body>
