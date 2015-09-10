<?
/*
$requete_style = "select style from ".__racinebd__."etat order by etat_id ASC";
$link_style=query($requete_style);
while ($ligne_style=fetch($link_style)){
    $style++;
    $le_style[$style] = $ligne_style["style"];
}
*/


/************************************************************/
if($_GET["lang"]!=""){
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
<link href="<?=__reparbre__?>/src/skin-vista/ui.dynatree.css" rel="stylesheet" type="text/css">
<link href="<?=__reparbre__?>/src/skin-vista/jquery.tooltip.css" rel="stylesheet" type="text/css">
<link href="<?=__reparbre__?>/jq.context/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
<link href="<?=__racineadmin__?>/styles/phantom_v2/reset.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/text.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/buttons.css" type="text/css" media="screen" title="no title" />
<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/theme-default.css" type="text/css" media="screen" title="no title" /> 
<link rel="stylesheet" href="<?=__racineadmin__?>/styles/phantom_v2/all.css" type="text/css" media="screen" title="no title" />  
<script src="<?=__reparbre__?>/jquery/jquery.js" type="text/javascript"></script>
<script src="<?=__reparbre__?>/jquery/jquery-ui.custom.js" type="text/javascript"></script>
<script src="<?=__reparbre__?>/jquery/jquery.cookie.js" type="text/javascript"></script>
<script src="<?=__reparbre__?>/jquery/jquery.tooltip.js" type="text/javascript"></script>
<script src="<?=__reparbre__?>/jq.context/jquery.contextMenu.js" type="text/javascript"></script>
<script src="<?=__reparbre__?>/src/jquery.dynatree.jc.js" type="text/javascript"></script>
<script src="<?=__reparbre__?>/src/customtreefunction.php?langue_id=<?=$_POST["langue_id"]?>" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
      $( "#dialog-form" ).dialog({
            autoOpen: false,
            height: 140,
            width: 350,
            modal: true,
            buttons: {
                "<?=$trad["Renommer"]?>": function() { 
                    newval=$("#rennametxt").val();               
                    if ( newval!="" ) {
                        finishrename(newval,tmprenameid,tmprenametitle) 
                        $(this).dialog( "close" );
                    }
                },
                "<?=$trad["Fermer"]?>": function() {
                    $(this).dialog( "close" );
                }
            },
            close: function() {
                //allFields.val( "" ).removeClass( "ui-state-error" );
            },
            open: function() {
                //alert(tmprenametitle);
                $("#rennametxt").val(tmprenametitle);  
            }
        });
    d=new Date();
    //alert(d.getTime()+360*24*60*60*1000 )
		$("#arbre_new").dynatree( {
      //persist: true,
      cookie: {
        expires:d.getTime()+360*24*60*60*1000 // Days or Date; null: session cookie
      },
			title: "<?=__name__?>",
      imagePath:'<?=__reparbre__?>imgs/',
      defaultVerrouImg:'lock.gif',
			fx: { height: "toggle", duration: 200 },
			autoFocus: false,
			onActivate: function(node) {
        currentnode=node;
				$("#echoActive").text("" + node + " (" + node.getKeyPath()+ ")");
			},
      
      onKeydown: function(node, event) {
        // Eat keyboard events, when a menu is open
        if( $(".contextMenu:visible").length > 0 )
          return false;
        TouchKeyDown = (window.Event) ? event.which : event.keyDown;
        switch( TouchKeyDown ) {

        // Open context menu on [Space] key (simulate right click)
        case 32: // [Space]
          $(node.span).trigger("mousedown", {
            preventDefault: true,
            button: 2
            })
          .trigger("mouseup", {
            preventDefault: true,
            pageX: node.span.offsetLeft,
            pageY: node.span.offsetTop,
            button: 2
            });
          return false;

        // Handle Ctrl-C, -X and -V
        case 67:
          if( event.ctrlKey ) { // Ctrl-C
            copyPaste("copy", node);
            return false;
          }
          break;
        case 86:
          if( event.ctrlKey ) { // Ctrl-V
            copyPaste("paste", node);
            return false;
          }
          break;
        case 88:
          if( event.ctrlKey ) { // Ctrl-X
            copyPaste("cut", node);
            return false;
          }
          break;
        }
      },      
      //children:struct,
      initAjax: {url: "<?=__reparbre__?>/initarbre.php",data: {langue_id: <?=$_POST["langue_id"]?>}},
			onLazyRead: function(node){node.appendAjax({url: "<?=__reparbre__?>/sampleOpen1JC.php",dataType:"json",data: {key: node.data.key,langue_id: <?=$_POST["langue_id"]?>}});},
      onDblClick: function(node, event){rename(node)},
      //gestion du drag and drop
      dnd: {
            onDragStart: function(node) {
              //logMsg("tree.onDragStart(%o)", node);
              return true;
            },
            autoExpandMS: 500,
            preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
            onDragEnter: function(node, sourceNode) {
              //logMsg("tree.onDragEnter(%o, %o)", node, sourceNode);
              return true;
            },
            onDragOver: function(node, sourceNode, hitMode) {
              //logMsg("tree.onDragOver(%o, %o, %o)", node, sourceNode, hitMode);
              if(node.isDescendantOf(sourceNode)){
                return false;
              }
              if( !node.data.isFolder && hitMode === "over" ){
                return "after";
              }
            },
            onDrop: function(node, sourceNode, hitMode, ui, draggable) {
              //logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
              //alert(DTNodeStatus_Loading)
              //,hitMode:hitMode
              //alert(hitMode)
              //hitMode2=(hitMode=='over')?'over':'';
              //a gérer plus tard
              hitMode='over';
              node.setLazyNodeStatus(DTNodeStatus_Loading);
              $.ajax({
                url: '<?=__reparbre__?>/sampledrop.php',
                type: "POST",
                dataType: "json",
                data: {drop_id: node.data.key,drag_id: sourceNode.data.key,hitMode:hitMode},
                success: function(data) {
                  node.setLazyNodeStatus(DTNodeStatus_Ok);
                  if(data.ok){    
                    //alert(hitMode)    
                    sourceNode.move(node, hitMode);
                  }else{
                    alert(data.msg)
                  }
                }
              }).error(function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText+"erreur");
              node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
              );
            },
            onDragLeave: function(node, sourceNode) {
              //logMsg("tree.onDragLeave(%o, %o)", node, sourceNode);
            }
          }
		});    
    // jQuery contextMenu blocks mouse events, so we have to catch them in order to
// activate the node on click
$(document).on('mousedown.contextMenu', function(e){
	var node = $.ui.dynatree.getNode(e.target);
	window.console && console.log("e: %o, node: %o", e, node);
	node && node.activate();
});
  $.contextMenu({
  	// bind menu to every dynatree node
  	selector: 'a.dynatree-title',
    events: {show: function(opt){ var node = $.ui.dynatree.getNode(this);updatemenu(node)}},
  	// called for every menu command
  	callback: function(cmd, options) {
      //alert('ici');
      //alert(cmd)
      action(cmd, options);
  	},
  	items: {
  		nouveau: {name: "<?=$trad["Nouveau"]?>", icon:"nouveau",items: {
      <?
      $myobj=&$_SESSION['obj_users_id'];
      if($myobj->user_id=="-1"){
        $requete = "select libelle,gabarit_id,iconnormal from ".__racinebd__."gabarit where supprimer=0 order by libelle";
      }else{
        $requete = "select libelle,g.gabarit_id,iconnormal from ".__racinebd__."gabarit g inner join ".__racinebd__."groupe_gabarit gg on g.gabarit_id=gg.gabarit_id and gg.groupe_id in(".$_SESSION['obj_users_id']->listgroupeid.") where supprimer=0 group by g.gabarit_id order by g.libelle";
      }
      $link=query($requete);
      $max=num_rows($link);
      $i=0; 
      $css="";   
      while ($ligne=fetch($link)){
          $css.=".context-menu-item.icon-gabarit".$ligne["gabarit_id"]."ico { background-image: url('".__uploaddir__.__racinebd__."gabarit".$ligne["gabarit_id"].".".$ligne["iconnormal"]."');}\n";
      ?>
        "gabarit<?=$ligne["gabarit_id"]?>": {name: "<?=str_replace("'","\'",$ligne["libelle"])?>",icon:"gabarit<?=$ligne["gabarit_id"]?>ico"}
        <?if($i++<$max-1){?>,<?}
        }?>  
      }},
      "sep1": "---------",
      "explorer": {name: "<?=$trad["Explorer"]?>", icon: "explore"},
      "informations": {name: "<?=$trad["Informations"]?>", icon: "informations"},
      "apercu": {name: "<?=$trad["Aperçu"]?>", icon: "apercu",items:{
        <?php
  			$requete_name = "select libelle,version_id from ".__racinebd__."version order by version_id";
        $link_name=query($requete_name);
        $max=num_rows($link_name);
        $i=0; 
        while ($ligne_name=fetch($link_name)){?>
            "apercu_version<?=$ligne_name["version_id"]?>": {name: "<?=$trad[$ligne_name["libelle"]]?>",icon:"version<?=$ligne_name["version_id"]?>ico"}
            <?if($i++<$max-1){?>,<?}
        }?>
      }},
      "verrouiller": {name: "<?=$trad["Verrouiller"]?>", icon: "verrouiller"},
      "deverrouiller": {name: "<?=$trad["Déverrouiller"]?>", icon: "deverrouiller"},
      "modifier": {name: "<?=$trad["Modifier"]?>", icon: "modifier",items:{
        <?php
  			$requete_name = "select libelle,version_id from ".__racinebd__."version order by version_id";
        $link_name=query($requete_name);
        $max=num_rows($link_name);
        $i=0; 
        while ($ligne_name=fetch($link_name)){?>
            "modifier_version<?=$ligne_name["version_id"]?>": {name: "<?=$trad[$ligne_name["libelle"]]?>",icon:"version<?=$ligne_name["version_id"]?>ico"}
            <?if($i++<$max-1){?>,<?}
        }?>
      }},
      "publier": {name: "<?=$trad["Publier"]?>", icon: "publier",items:{
        "pubinstant": {name: "<?=$trad["Instantanée"]?>", icon: "pubinstant"},
    		"pubcron": {name: "<?=$trad["Planifiée"]?>", icon: "pubcron"}      
      }},
      "depublier": {name: "<?=$trad["Dépublier"]?>", icon: "depublier",items:{
        "depubinstant": {name: "<?=$trad["Instantanée"]?>", icon: "depubinstant"},
    		"depubcron": {name: "<?=$trad["Planifiée"]?>", icon: "depubcron"}      
      }},
  		"supprimer": {name: "<?=$trad["Supprimer"]?>", icon: "supprimer"},
      "renommer": {name: "<?=$trad["Renommer"]?>", icon: "renommer"},
      "sep2": "---------",
      "couper": {name: "<?=$trad["Couper"]?>", icon: "couper"},
  		"copier": {name: "<?=$trad["Copier"]?>", icon: "copier"},
  		"coller": {name: "<?=$trad["Coller"]?>", icon: "coller"},
      "alias": {name: "<?=$trad["Créer un alias"]?>", icon: "alias"},
      "arbo": {name: "<?=$trad["Coller l\'arborescence"]?>", icon: "arbo"},
      "replace": {name: "<?=$trad["Remplacer"]?>", icon: "replace"},
  		"sep3": "---------",
      "ordre": {name: "<?=$trad["Ordre"]?>", icon: "ordre",items:{
        "premier": {name: "<?=$trad["En premier"]?>", icon: "premier"},
    		"haut": {name: "<?=$trad["Plus haut"]?>", icon: "haut"},
        "bas": {name: "<?=$trad["Plus bas"]?>", icon: "bas"},
        "dernier": {name: "<?=$trad["En dernier"]?>", icon: "dernier"}
      }},
      "sep4": "---------",
      "droits": {name: "<?=$trad["Droits"]?>", icon: "droits"},
      "export": {name: "<?=$trad["Export"]?>", icon: "export",items:{
        "xml": {name: "XML", icon: "xml"},
    		"pdf": {name: "PDF", icon: "pdf"}      
      }},
      "import": {name: "<?=$trad["Import"]?>", icon: "import"},
      "vider": {name: "<?=$trad["Vider la corbeille"]?>", icon: "vider"},
      "restaurer": {name: "<?=$trad["Restaurer"]?>", icon: "restaurer"},
      "suppression": {name: "<?=$trad["Suppression définitive"]?>", icon: "suppression"}
  	}
  }); // $.contextMenu()
  });
  </script>
<style>
  <?=$css?>
  .context-menu-item.icon-alias {background-image: url('<?=__reparbre__?>imgs/globe.gif');}
  div.nottranslate, .nottranslate a{border-bottom: 1px dashed red !important;}
  .brouillon,.brouillon a{text-decoration: line-through !important;}
  .img_pointer_arbre_on{background-image:url(<?=__reparbre__?>icones_arbre/fleche_on.png);}
  .img_pointer_arbre_off{background-image:url(<?=__reparbre__?>icones_arbre/fleche_off.png);}
</style>
