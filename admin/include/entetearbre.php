<?
$requete_style = "select style from ".__racinebd__."etat order by etat_id ASC";
$link_style=query($requete_style);
while ($ligne_style=fetch($link_style)){
    $style++;
    $le_style[$style] = $ligne_style["style"];
}
/************************************************************/
if($_GET["lang"]){
  $requete_langue = "select langue_id from ".__racinebd__."langue where shortlib = '".$_GET["lang"]."'";
  $link_langue=query($requete_langue);
  $nombre_langue = num_rows($link_langue);
  if($nombre_langue > 0){
    while ($ligne_langue=fetch($link_langue)){
      $_POST["langue_id"] = $ligne_langue["langue_id"];
    }
  } else {
      $_POST["langue_id"] = 1;
  }
} else {
    $_POST["langue_id"] = 1;
}
/************************************************************/
?>
<!-- DEBUT ARBRE -->
<link rel="stylesheet" href="<?=__reparbre__?>css/tree.css" type="text/css" media="screen" />    
<link rel="stylesheet" href="<?=__reparbre__?>css/proto.menu.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=__reparbre__?>css/common.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=__reparbre__?>css/autocomplete.css" type="text/css" media="screen"  />
<link rel="stylesheet" href="<?=__reparbre__?>css/form.css" type="text/css" media="screen" />

<style>
.img_pointer_arbre_on{background-image:url(<?=__reparbre__?>icones_arbre/fleche_on.png);}
.img_pointer_arbre_off{background-image:url(<?=__reparbre__?>icones_arbre/fleche_off.png);}
</style>
<script type="text/javascript" src="<?=__reparbre__?>js/prototype.js"></script>
<script type="text/javascript" src="<?=__reparbre__?>js/scriptaculous.js"></script>
<script type="text/javascript" src="<?=__reparbre__?>js/Tree.js"></script>
<script type="text/javascript" src="<?=__reparbre__?>js/proto.menu.js"></script>
<script type="text/javascript" src="<?=__reparbre__?>js/treejc.php?la_langue=<?=$_POST["langue_id"]?>"></script>
<script type="text/javascript" src="<?=__reparbre__?>js/select.js"></script>
<script type="text/javascript">
var tree = null;
function TafelTreeInit () {
var struct = [
{

'id':'root1',
'txt':'<?=__name__?>',
'img':'base.gif',
'imgopen':'base.gif',
'imgclose':'base.gif',
'imgselected':'base.gif',
'imgopenselected':'base.gif',
'imgcloseselected':'base.gif',
'draggable':false,
'editable':false,
'items':[

<?php
listnoeud("null",$_POST["langue_id"]);
?>
]
},
{
'id':'pb',
'txt':'<?=$trad["Poubelle"]?>',
'img':'trash.gif',
'imgopen':'trashfull.gif',
'imgclose':'trashfull.gif',
'imgselected':'trash.gif',
'imgopenselected':'trashfull.gif',
'imgcloseselected':'trashfull.gif',
'draggable':false,
'editable':false,
'last': true,
'items':[
<?php
listnoeud('pb',$_POST["langue_id"]);
?>
]
}
];

tree = new TafelTree('arbre_new', struct, {
'generate' : true,
'imgBase' : '<?=__reparbre__?>imgs/',
'cookies':true,
'defaultImg' : 'page.gif',
'defaultImgSelected':'page.gif',
'defaultImgOpen':'page.gif',
'defaultImgClose':'page.gif',
'defaultImgCloseSelected':'page.gif',
'defaultImgOpenSelected':'page.gif',
'defaultAliasImg' : 'globe.gif',
'defaultVerrouImg' : 'lock.gif',
'onOpenPopulate' : [funcOpen, '<?=__reparbre__?>sampleOpen1JC.php?la_langue=<?=$_POST["langue_id"]?>'],		
'onClick' : testParent,
'dropALT' : true,
'dropSHIFT' : true,
'dropCTRL' : true,
'onDropAjax' : [funcDrop3, '<?=__reparbre__?>sampledrop.php?la_langue=<?=$_POST["langue_id"]?>'],
'onEditAjax' : [funcEdit, '<?=__reparbre__?>sampleEdit1.php?la_langue=<?=$_POST["langue_id"]?>'],
'onChgVerrou' : [funcVerrou,'<?=__reparbre__?>sampleVerrou.php?la_langue=<?=$_POST["langue_id"]?>'],
'onChgEtat' : [funcEtat,'<?=__reparbre__?>sampleEtat.php?la_langue=<?=$_POST["langue_id"]?>'],
'onFinishDelete' : [funcFinishDelete,'<?=__reparbre__?>sampleDelete.php?la_langue=<?=$_POST["langue_id"]?>'],
'onRestore' : [funcRestore,'<?=__reparbre__?>sampleRestore.php?la_langue=<?=$_POST["langue_id"]?>'],
'onMouseOver':function(branch){branch.addClass('mover');}, 
'onMouseOut':function(branch){branch.removeClass('mover');},
'onContextMenu':contextmenudiv,
'tooltipuser':'<?=$_SESSION["islog"]?>'
});
}
</script>
<!-- FIN ARBRE -->