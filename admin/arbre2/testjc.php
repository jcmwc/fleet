<?
require("../require/function.php");
require("../require/back_include.php");


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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title><?=__name__?></title>
	<link href="src/skin-vista/ui.dynatree.css" rel="stylesheet" type="text/css">
  <link href="src/skin-vista/jquery.tooltip.css" rel="stylesheet" type="text/css">
  <link href="jq.context/jquery.contextMenu.css" rel="stylesheet" type="text/css" />  
  <script src="jquery/jquery.js" type="text/javascript"></script>
  <script src="jquery/jquery-ui.custom.js" type="text/javascript"></script>
  <script src="jquery/jquery.cookie.js" type="text/javascript"></script>
  <script src="jquery/jquery.tooltip.js" type="text/javascript"></script>
  <script src="jq.context/jquery.contextMenu.js" type="text/javascript"></script>
  <script src="src/jquery.dynatree.jc.js" type="text/javascript"></script>

  <script type="text/javascript">
  function getIframe(){
    if(document.all){
      moniframe=eval("framecontent");
    }else{
      moniframe=document.getElementById('framecontent').contentWindow
    }
    return moniframe;
  }
  function rename(node){
    if(node.getLevel()>1){
      content="<input type=\"text\" name=\"name_"+node.data.key+"\" id=\"name_"+node.data.key+"\" value=\""+node.data.title+"\" onKeyPress=\"if (((window.Event) ? event.which : event.keyDown) == 13) finishrename(this,"+node.data.key+",'"+node.data.title+"')\" onBlur=\"finishrename(this,"+node.data.key+",'"+node.data.title+"')\">"
      $(node.li).find("a:eq(0)").html(content)
      $("#name_"+node.data.key).focus();
    }
  }
  
  function finishrename(obj,key,oldvalue){
      node=$("#arbre_new").dynatree("getTree").getNodeByKey(key)
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      $.ajax({
        url: '/bailleul/dev2/admin/arbre2/sampleRename.php',
        type: "POST",
        dataType: "json",
        data: {branch_id: key,name:obj.value,langue_id:<?=$_POST["langue_id"]?>,old_value:oldvalue},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
             $(node.li).find("a:eq(0)").html(data.msg)
          }else{
            alert(data.msg)
          }
        }
      }).error(function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText+"erreur");
        node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
      ); 
  }
  function action(cmd, options){
    if(currentnode==null){
      alert('<?=$trad["Veuillez sélectionner un élément"]?>');  
      return;
    }
    //var node = $.ui.dynatree.getNode(this);
    var node=currentnode;
		window.console && console.log(cmd + " - " + node);
		node.activate();
    switch( cmd ) {
      case "renommer":
        rename(currentnode);
      break;
  	  case "explorer":
        moniframe=getIframe();
        moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?&arbre_id='+node.data.key+'&langue_id=<?=$_POST["langue_id"]?>&mode=list';
      break;
      case "informations":
        moniframe=getIframe();
        moniframe.location='<?=__racineadminmenucore__?>/gabarit/log.php?arbre_id='+node.data.key;
      break;
      case "deverrouiller":
      case "verrouiller":
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampleVerrou.php',
          type: "POST",
          dataType: "json",
          data: {branch_id: node.data.key},
          success: function(data) {
            node.setLazyNodeStatus(DTNodeStatus_Ok);
            if(data.ok){    
              //on rafraichis le pere
              node.parent.reloadChildren(function(node, isOk){});
            }else{
              alert(data.msg)
            }
          }
        }).error(function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText+"erreur");
          node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
        );
      break;
      case "supprimer":
        copyPaste("cut", node);
        copyPaste("paste", $("#arbre_new").dynatree("getTree").getNodeByKey("pb"));
      break;
      case "renommer":
        //gérer le renommage prevoir le bouble click aussi
      break;
      case "bas":
        logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
        //alert(DTNodeStatus_Loading)
        pos = $.inArray(node, node.parent.childList);
        sourceNode=node.parent.childList[pos+1];
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampledrop.php',
          type: "POST",
          dataType: "json",
          data: {drop_id: node.data.key,drag_id: sourceNode.data.key,hitMode:"after"},
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
      break;
      case "haut":
        logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
        //alert(DTNodeStatus_Loading)
        pos = $.inArray(node, node.parent.childList);
        sourceNode=node.parent.childList[pos-1];
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampledrop.php',
          type: "POST",
          dataType: "json",
          data: {drop_id: node.data.key,drag_id: sourceNode.data.key,hitMode:"before"},
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
      break;
      case "premier":
        logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
        //alert(DTNodeStatus_Loading)
        pos = $.inArray(node, node.parent.childList);
        sourceNode=node.parent.childList[0];
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampledrop.php',
          type: "POST",
          dataType: "json",
          data: {drop_id: node.data.key,drag_id: sourceNode.data.key,hitMode:"before"},
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
      break;
      case "dernier":
        logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
        //alert(DTNodeStatus_Loading)
        pos = $.inArray(node, node.parent.childList);
        sourceNode=node.parent.childList[node.parent.childList.length];
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampledrop.php',
          type: "POST",
          dataType: "json",
          data: {drop_id: node.data.key,drag_id: sourceNode.data.key,hitMode:"after"},
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
      break;
      case "droits":
        moniframe=getIframe();
        pere=(node.parent.data.key=="root1")?0:node.parent.data.key;  
        moniframe.location='<?=__racineadminmenucore__?>/gabarit/droits.php?pere='+pere+'&arbre_id='+node.data.key;
      break;
      case "export":
        window.open("/bailleul/dev2/admin/arbre2/export.php?arbre_id="+node.data.key);
      break;
      case "import":
        moniframe=getIframe();
        moniframe.location='<?=__racineadminmenucore__?>/gabarit/import.php?arbre_id='+node.data.key;
      break;
      case "vider":
      case "suppression":
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampleDelete.php',
          type: "POST",
          dataType: "json",
          data: {branch_id: node.data.key},
          success: function(data) {
            node.setLazyNodeStatus(DTNodeStatus_Ok);
            $("#arbre_new").dynatree("getTree").getNodeByKey("pb").reloadChildren(function(node, isOk){});
          }
        }).error(function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText+"erreur");
        node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
        );
      break;
      case "restaurer":
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampleRestore.php',
          type: "POST",
          dataType: "json",
          data: {branch_id: node.data.key},
          success: function(data) {
            node.setLazyNodeStatus(DTNodeStatus_Ok);
            $("#arbre_new").dynatree("getTree").getNodeByKey(data.msg).reloadChildren(function(node, isOk){});       
          }
        }).error(function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText+"erreur");
        node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
        );
      break;
      case "copier":    
      case "coller":    
      case "couper":       
        //alert(node.data.title)
        cmd=(cmd=="copier")?"copy":cmd;
        cmd=(cmd=="coller")?"paste":cmd;
        cmd=(cmd=="couper")?"cut":cmd;
    		copyPaste(cmd, node);
      break;
      case "publier":
      case "depublier":
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampleEtat.php',
          type: "POST",
          dataType: "json",
          data: {branch_id: node.data.key},
          success: function(data) {
            node.setLazyNodeStatus(DTNodeStatus_Ok);
            if(data.ok){    
              //on rafraichis le pere
              node.parent.reloadChildren(function(node, isOk){});
            }else{
              alert(data.msg)
            }
          }
        }).error(function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText+"erreur");
          node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
        );
      break;
      default:
        if(cmd.indexOf("gabarit")<0){
          if(cmd.indexOf("version")<0){
            alert("Unhandled action '" + cmd + "'");
          }else{
            moniframe=getIframe();
            if(md.indexOf("apercu")==0){
              version_id=cmd.substring(14,cmd.length);    
              window.open("/bailleul/dev2/admin/arbre2/preview.php?mode=preview&version_id="+version_id+"&arbre_id="+node.data.key+"&etat_id="+node.data.etat+"&langue_id=<?=$_POST["langue_id"]?>");
            }else{
              version_id=cmd.substring(16,cmd.length);    
              pere=(node.parent.data.key=="root1")?0:node.parent.data.key;
              moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&arbre_id='+node.data.key+'&langue_id=<?=$_POST["langue_id"]?>&mode=modif&version_id='+version_id;
            }
          }
        }else{
          moniframe=getIframe();
          pere=(node.parent.data.key=="root1")?0:node.parent.data.key;
          moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&langue_id=<?=$_POST["langue_id"]?>&mode=ajout&gabarit_id='+cmd.substring(7,cmd.length);
        }
	  }
    currentnode.deactivate();
    currentnode=null;
  }
  function updatemenu(node){
    $(".context-menu-item").css("display","block");
    $(".icon-vider").css("display","none");
    $(".icon-coller").css("display","none");
    $(".icon-alias").css("display","none");
    $(".icon-arbo").css("display","none");
    $(".icon-restaurer").css("display","none");
    $(".icon-suppression").css("display","none");
    //on vérifie si l'éléments est a la poubelle
    var path = [];
		node.visitParents(function(node){
			if(node.parent){
				path.unshift(node.data.key);
			}
		}, !node);
    if(path[0]=='pb'){
      $(".context-menu-item").css("display","none");  
      if(node.getLevel()==2){
        //restaurer
        $(".icon-restaurer").css("display","block");
        //suppression definitive
        $(".icon-suppression").css("display","block");
        //informations
        $(".icon-informations").css("display","block");
      }
    } else if(node.data.key=="root1"){
      //on vérifie si le noeud choisi est le noeud root
      $(".context-menu-item").css("display","none");
      //on fait apparaitre nouveau
      $(".icon-nouveau").find("li").css("display","block");
      $(".icon-nouveau").css("display","block");
      //on fait apparaitre import
      $(".icon-import").css("display","block");
    } else if(node.data.key=="pb"){
       //on vérifie si le noeud choisi est le noeud la poubelle
      $(".context-menu-item").css("display","none");
      //on fait apparaitre import
      $(".icon-vider").css("display","block");
    } else if(node.data.alias){
      $(".context-menu-item").css("display","none");
      //suprimer
      $(".icon-supprimer").css("display","block");
      //renommer
      $(".icon-renommer").css("display","block");
      //En premier
      $(".icon-premier").css("display","block");
      //En haut
      $(".icon-haut").css("display","block");
      //En bas
      $(".icon-bas").css("display","block");
      //En dernier
      $(".icon-dernier").css("display","block");
      //Droits
      $(".icon-droits").css("display","block");
      //Export
      $(".icon-export").css("display","block");
      //Import
      $(".icon-import").css("display","block");
    } else {
      //vérification des positions
      pos = $.inArray(node, node.parent.childList);
      if(pos==0){
         $(".icon-haut").css("display","none");
         $(".icon-premier").css("display","none");
      }
      if(pos==node.parent.childList.length-1){
         $(".icon-bas").css("display","none");
         $(".icon-dernier").css("display","none");
      }
      //verification du verrou
      if(node.data.verrou){
         $(".icon-verrouiller").css("display","none");
         $(".icon-deverrouiller").css("display","block");
      }else{
         $(".icon-verrouiller").css("display","block");
         $(".icon-deverrouiller").css("display","none");
      }
      //verification de l'etat
      if(node.data.etat==1){
         $(".icon-publier").css("display","none");
         $(".icon-depubier").css("display","block");
      }else{
         $(".icon-publier").css("display","block");
         $(".icon-depubier").css("display","none");
      }
      //vérification si un éléments est dans le buffer
      if(clipboardNode!=null){
        $(".icon-coller").css("display","block");
        $(".icon-alias").css("display","block");
        $(".icon-arbo").css("display","block");
      }
    }
  }
  // --- Implement Cut/Copy/Paste --------------------------------------------
  var clipboardNode = null;
  var pasteMode = null;
  var currentnode=null;
  
  function copyPaste(action, node) {
  	switch( action ) {
  	case "cut":  
      //on reinitialise si il y a deja un élements sélectionné  
      if(clipboardNode!=null){
        $(clipboardNode.li).find("span:eq(0)").css({ opacity: 1 });  
      }   
      //on gere la couche alpha
      $(node.li).find("span:eq(0)").css({ opacity: 0.5 });
  	case "copy":
  		clipboardNode = node;
  		pasteMode = action;
  		break;
  	case "paste":
  		if( !clipboardNode ) {
  			alert("Clipoard is empty.");
  			break;
  		}
  		if( pasteMode == "cut" ) {
  			// Cut mode: check for recursion and remove source
  			var isRecursive = false;
  			var cb = clipboardNode.toDict(true, function(dict){
  				// If one of the source nodes is the target, we must not move
  				if( dict.key == node.data.key )
  					isRecursive = true;
  			});
  			if( isRecursive ) {
  				alert("Cannot move a node to a sub node.");
  				return;
  			}
        
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampledrop.php',
          type: "POST",
          dataType: "json",
          data: {drop_id: node.data.key,drag_id: clipboardNode.data.key},
          success: function(data) {
            node.setLazyNodeStatus(DTNodeStatus_Ok);
            if(data.ok){    
              //alert(hitMode)    
              node.addChild(cb);
  			      clipboardNode.remove();
            }else{
              alert(data.msg)
            }
          }
        }).error(function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText+"erreur");
          node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
        );
  		} else {
  			// Copy mode: prevent duplicate keys:
  			var cb = clipboardNode.toDict(true, function(dict){
  				dict.title = "Copy of " + dict.title;
  				delete dict.key; // Remove key, so a new one will be created
  			});
        node.setLazyNodeStatus(DTNodeStatus_Loading);
        $.ajax({
          url: '/bailleul/dev2/admin/arbre2/sampledrop.php',
          type: "POST",
          dataType: "json",
          data: {drop_id: node.data.key,drag_id: clipboardNode.data.key,copydrag:1},
          success: function(data) {
            node.setLazyNodeStatus(DTNodeStatus_Ok);
            if(data.ok){    
              //alert(hitMode)    
              node.addChild(cb);
            }else{
              alert(data.msg)
            }
          }
        }).error(function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText+"erreur");
          node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
        );
  			
  		}
  		$(clipboardNode.li).find("span:eq(0)").css({ opacity: 1 });
      clipboardNode = pasteMode = null;
  		break;
  	default:
  		alert("Unhandled clipboard action '" + action + "'");
  	}
  }; 
  var struct = [
  {
  "key":"root1",
  "title":"<?=__name__?>",
  "icon":"base.gif",
  "unselectable":true,
  "children":[
  
  <?php
  listnoeud2("null",$_POST["langue_id"]);
  ?>
  ]
  },
  {
  "key":"pb",
  "title":"<?=$trad["Poubelle"]?>",
  "icon":"trash.gif",
  "unselectable":true,
  "children":[
  <?php
  listnoeud2('pb',$_POST["langue_id"]);
  ?>
  ]
  }
  ];
  	$(function(){
  		$("#arbre_new").dynatree( {
        //persist: true,
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
        children:struct,
  			onLazyRead: function(node){node.appendAjax({url: "/bailleul/dev2//admin/arbre2/sampleOpen1JC.php",data: {key: node.data.key,langue_id: <?=$_POST["langue_id"]?>}});},
        onDblClick: function(node, event){rename(node)},
        //gestion du drag and drop
        dnd: {
              onDragStart: function(node) {
                logMsg("tree.onDragStart(%o)", node);
                return true;
              },
              autoExpandMS: 500,
              preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
              onDragEnter: function(node, sourceNode) {
                logMsg("tree.onDragEnter(%o, %o)", node, sourceNode);
                return true;
              },
              onDragOver: function(node, sourceNode, hitMode) {
                logMsg("tree.onDragOver(%o, %o, %o)", node, sourceNode, hitMode);
                if(node.isDescendantOf(sourceNode)){
                  return false;
                }
                if( !node.data.isFolder && hitMode === "over" ){
                  return "after";
                }
              },
              onDrop: function(node, sourceNode, hitMode, ui, draggable) {
                logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
                //alert(DTNodeStatus_Loading)
                node.setLazyNodeStatus(DTNodeStatus_Loading);
                $.ajax({
                  url: '/bailleul/dev2/admin/arbre2/sampledrop.php',
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
                logMsg("tree.onDragLeave(%o, %o)", node, sourceNode);
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
      "publier": {name: "<?=$trad["Publier"]?>", icon: "publier"},
      "depublier": {name: "<?=$trad["Dépublier"]?>", icon: "depublier"},
  		"supprimer": {name: "<?=$trad["Supprimer"]?>", icon: "supprimer"},
      "renommer": {name: "<?=$trad["Renommer"]?>", icon: "renommer"},
      "sep2": "---------",
      "couper": {name: "<?=$trad["Couper"]?>", icon: "couper"},
  		"copier": {name: "<?=$trad["Copier"]?>", icon: "copier"},
  		"coller": {name: "<?=$trad["Coller"]?>", icon: "coller"},
      "alias": {name: "<?=$trad["Créer un alias"]?>", icon: "alias"},
      "arbo": {name: "<?=$trad["Coller l'arborescence"]?>", icon: "arbo"},
  		"sep3": "---------",
      "premier": {name: "<?=$trad["En premier"]?>", icon: "premier"},
  		"haut": {name: "<?=$trad["Plus haut"]?>", icon: "haut"},
      "bas": {name: "<?=$trad["Plus bas"]?>", icon: "bas"},
      "dernier": {name: "<?=$trad["En dernier"]?>", icon: "dernier"},
      "sep4": "---------",
      "droits": {name: "<?=$trad["Droits"]?>", icon: "droits"},
      "sep5": "---------",
      "export": {name: "<?=$trad["Export"]?>", icon: "export"},
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
  .context-menu-item.icon-alias { background-image: url('imgs/globe.gif');}
  .nottranslate a{border-bottom: 1px dashed red !important;}
  .brouillon a{text-decoration: line-through !important;}
  </style>
</head>
<body>
<h1><?=__name__?></h1>
<div id="arbre_new"></div>
<!-- <div>Active node: <span id="echoActive">-</span></div> -->
</body>
</html>