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
</head>
<body>
<div id="global">
<div id="wrapper">
<div id="header">
		<h1><a href="<?=__racineadmin__?>/index.php"><?=__name__?></a><span><?if(__light__==true){?>Light<?}else{?>v <?=__version__?><?}?></span></h1>				
		<a href="javascript:;" id="reveal-nav">
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
			<span class="reveal-bar"></span>
		</a>
</div> <!-- #header -->	    	
	<div id="languages">
	</div> <!-- #languages -->    		    	
	 <div id="sidebar">						
	</div> <!-- #sidebar -->  	
    <div id="content">				
		<div id="contentHeader">
			<h1><?=(__light__)?$trad[__title__]." <sup>v".__version__."</sup>":$trad[__title__]?></h1>
		</div> <!-- #contentHeader -->			
<?//require("menu.php");?>