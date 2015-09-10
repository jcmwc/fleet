<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<HEAD>
<TITLE>Interface d'administration de Phantom</TITLE>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<script type="text/javascript" src="/bailleul/dev2//admin/js/formulaire.js"></script>	
<script type="text/javascript" src="/bailleul/dev2//admin/js/select.js"></script>
<script type="text/javascript" src="/bailleul/dev2//admin/libexterne/fckeditor/fckeditor.js"></script>
<script type="text/javascript" src="/bailleul/dev2//admin/libexterne/calendar/js/jscal2.js"></script> 
<script type="text/javascript" src="/bailleul/dev2//admin/libexterne/calendar/js/lang/fr.js"></script>
<script type="text/javascript" src="/bailleul/dev2//admin/js/function.js"></script>
<script type="text/javascript" src="/bailleul/dev2//admin/custom/function.js"></script>
	<script>
fckdir='/bailleul/dev2//admin/libexterne/fckeditor/';
cssdir='/bailleul/dev2//custom/css/';
defaultlanguage    = 'fr' ;
</script>

<script>
closetxt='FERMER';
</script>

<link href="/bailleul/dev2//admin/libexterne/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/bailleul/dev2//admin/libexterne/fckeditor/_samples/sample.css" />
<link rel="stylesheet" type="text/css" href="/bailleul/dev2//admin/libexterne/calendar/css/jscal2.css" /> 
<link rel="stylesheet" type="text/css" href="/bailleul/dev2//admin/libexterne/calendar/css/border-radius.css" /> 
<link rel="stylesheet" type="text/css" href="/bailleul/dev2//admin/libexterne/calendar/css/steel/steel.css" /> 
<link rel="stylesheet" type="text/css" href="/bailleul/dev2//admin/styles/index_p01.css">

<!--[if IE 6]>
<style type="text/css">
#img_pointer_arbre{background:none;width:20px;height:65px;}
.img_pointer_arbre_on{filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/bailleul/dev2//admin/arbre2/icones_arbre/fleche_on.png');}
.img_pointer_arbre_off{filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='/bailleul/dev2//admin/arbre2/icones_arbre/fleche_off.png');}
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
<![endif]--><link href="/bailleul/dev2//admin/arbre2//src/skin-vista/ui.dynatree.css" rel="stylesheet" type="text/css">
<link href="/bailleul/dev2//admin/arbre2//src/skin-vista/jquery.tooltip.css" rel="stylesheet" type="text/css">
<link href="/bailleul/dev2//admin/arbre2//jq.context/jquery.contextMenu.css" rel="stylesheet" type="text/css" />  
<script src="/bailleul/dev2//admin/arbre2//jquery/jquery.js" type="text/javascript"></script>
<script src="/bailleul/dev2//admin/arbre2//jquery/jquery-ui.custom.js" type="text/javascript"></script>
<script src="/bailleul/dev2//admin/arbre2//jquery/jquery.cookie.js" type="text/javascript"></script>
<script src="/bailleul/dev2//admin/arbre2//jquery/jquery.tooltip.js" type="text/javascript"></script>
<script src="/bailleul/dev2//admin/arbre2//jq.context/jquery.contextMenu.js" type="text/javascript"></script>
<script src="/bailleul/dev2//admin/arbre2//src/jquery.dynatree.jc.js" type="text/javascript"></script>

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
        data: {branch_id: key,name:obj.value,langue_id:1,old_value:oldvalue},
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
      alert('Veuillez sélectionner un élément');  
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
        moniframe.location='/bailleul/dev2//admin/core/gabarit/article.php?&arbre_id='+node.data.key+'&langue_id=1&mode=list';
      break;
      case "informations":
        moniframe=getIframe();
        moniframe.location='/bailleul/dev2//admin/core/gabarit/log.php?arbre_id='+node.data.key;
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
        moniframe.location='/bailleul/dev2//admin/core/gabarit/droits.php?pere='+pere+'&arbre_id='+node.data.key;
      break;
      case "export":
        window.open("/bailleul/dev2/admin/arbre2/export.php?arbre_id="+node.data.key);
      break;
      case "import":
        moniframe=getIframe();
        moniframe.location='/bailleul/dev2//admin/core/gabarit/import.php?arbre_id='+node.data.key;
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
              window.open("/bailleul/dev2/admin/arbre2/preview.php?mode=preview&version_id="+version_id+"&arbre_id="+node.data.key+"&etat_id="+node.data.etat+"&langue_id=1");
            }else{
              version_id=cmd.substring(16,cmd.length);    
              pere=(node.parent.data.key=="root1")?0:node.parent.data.key;
              moniframe.location='/bailleul/dev2//admin/core/gabarit/article.php?pere='+pere+'&arbre_id='+node.data.key+'&langue_id=1&mode=modif&version_id='+version_id;
            }
          }
        }else{
          moniframe=getIframe();
          pere=(node.parent.data.key=="root1")?0:node.parent.data.key;
          moniframe.location='/bailleul/dev2//admin/core/gabarit/article.php?pere='+pere+'&langue_id=1&mode=ajout&gabarit_id='+cmd.substring(7,cmd.length);
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
  "title":"Phantom",
  "icon":"base.gif",
  "unselectable":true,
  "children":[
  
  {"key":"1", "title":"http://www.byagency.com/bailleul/dev2/","isLazy" : true,"tooltip" : "id : 1 (site)","etat" : 1,"icon":"../../../upload/phantom_gabarit1.gif","alias" : 0,"addClass" : " nottranslate"}  ]
  },
  {
  "key":"pb",
  "title":"Poubelle",
  "icon":"trash.gif",
  "unselectable":true,
  "children":[
  {"key":"17", "title":"privilegier_les_innovations_incrementales","tooltip" : "id : 17 (Article)","etat" : 1,"icon":"../../../upload/phantom_gabarit28.gif","alias" : 0,"addClass" : " nottranslate"},{"key":"26", "title":"contactez-nous","tooltip" : "id : 26 (Article)","etat" : 1,"icon":"../../../upload/phantom_gabarit28.gif","alias" : 0,"addClass" : " nottranslate"},{"key":"23", "title":"ouverture_d___une_filiale_au_portugal","verrou":true,"tooltip" : "id : 23 (Actualité)","tooltipuser" : "Super Admin","etat" : 2,"icon":"../../../upload/phantom_gabarit32.gif","alias" : 0,"addClass" : "brouillon nottranslate"},{"key":"31", "title":"boutoncontact","isLazy" : true,"tooltip" : "id : 31 (Dossier)","etat" : 2,"icon":"../../../upload/phantom_gabarit29.gif","alias" : 0,"addClass" : "brouillon nottranslate"}  ]
  }
  ];
  	$(function(){
  		$("#arbre_new").dynatree( {
        //persist: true,
  			title: "Phantom",
        imagePath:'/bailleul/dev2//admin/arbre2/imgs/',
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
  			onLazyRead: function(node){node.appendAjax({url: "/bailleul/dev2//admin/arbre2/sampleOpen1JC.php",data: {key: node.data.key,langue_id: 1}});},
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
  		nouveau: {name: "Nouveau", icon:"nouveau",items: {
              "gabarit32": {name: "Actualité",icon:"gabarit32ico"}
        ,        "gabarit28": {name: "Article",icon:"gabarit28ico"}
        ,        "gabarit30": {name: "Dates clefs",icon:"gabarit30ico"}
        ,        "gabarit29": {name: "Dossier",icon:"gabarit29ico"}
        ,        "gabarit31": {name: "Lien",icon:"gabarit31ico"}
        ,        "gabarit27": {name: "Rubrique",icon:"gabarit27ico"}
        ,        "gabarit1": {name: "site",icon:"gabarit1ico"}
          
      }},
      "sep1": "---------",
      "explorer": {name: "Explorer", icon: "explore"},
      "informations": {name: "Informations", icon: "informations"},
      "apercu": {name: "Aperçu", icon: "apercu",items:{
                    "apercu_version1": {name: "En ligne",icon:"version1ico"}
            ,            "apercu_version2": {name: "Brouillon",icon:"version2ico"}
                  }},
      "verrouiller": {name: "Verrouiller", icon: "verrouiller"},
      "deverrouiller": {name: "Déverrouiller", icon: "deverrouiller"},
      "modifier": {name: "Modifier", icon: "modifier",items:{
                    "modifier_version1": {name: "En ligne",icon:"version1ico"}
            ,            "modifier_version2": {name: "Brouillon",icon:"version2ico"}
                  }},
      "publier": {name: "Publier", icon: "publier"},
      "depublier": {name: "Dépublier", icon: "depublier"},
  		"supprimer": {name: "Supprimer", icon: "supprimer"},
      "renommer": {name: "Renommer", icon: "renommer"},
      "sep2": "---------",
      "couper": {name: "Couper", icon: "couper"},
  		"copier": {name: "Copier", icon: "copier"},
  		"coller": {name: "Coller", icon: "coller"},
      "alias": {name: "Créer un alias", icon: "alias"},
      "arbo": {name: "", icon: "arbo"},
  		"sep3": "---------",
      "premier": {name: "En premier", icon: "premier"},
  		"haut": {name: "Plus haut", icon: "haut"},
      "bas": {name: "Plus bas", icon: "bas"},
      "dernier": {name: "En dernier", icon: "dernier"},
      "sep4": "---------",
      "droits": {name: "Droits", icon: "droits"},
      "sep5": "---------",
      "export": {name: "Export", icon: "export"},
      "import": {name: "Import", icon: "import"},
      "vider": {name: "Vider la corbeille", icon: "vider"},
      "restaurer": {name: "Restaurer", icon: "restaurer"},
      "suppression": {name: "Suppression définitive", icon: "suppression"}
  	}
  }); // $.contextMenu()
  		});
  </script>
<style>
  .context-menu-item.icon-gabarit32ico { background-image: url('/bailleul/dev2//upload/phantom_gabarit32.gif');}
.context-menu-item.icon-gabarit28ico { background-image: url('/bailleul/dev2//upload/phantom_gabarit28.gif');}
.context-menu-item.icon-gabarit30ico { background-image: url('/bailleul/dev2//upload/phantom_gabarit30.gif');}
.context-menu-item.icon-gabarit29ico { background-image: url('/bailleul/dev2//upload/phantom_gabarit29.gif');}
.context-menu-item.icon-gabarit31ico { background-image: url('/bailleul/dev2//upload/phantom_gabarit31.gif');}
.context-menu-item.icon-gabarit27ico { background-image: url('/bailleul/dev2//upload/phantom_gabarit27.gif');}
.context-menu-item.icon-gabarit1ico { background-image: url('/bailleul/dev2//upload/phantom_gabarit1.gif');}
  .context-menu-item.icon-alias { background-image: url('imgs/globe.gif');}
  .nottranslate a{border-bottom: 1px dashed red !important;}
  .brouillon a{text-decoration: line-through !important;}
  .img_pointer_arbre_on{background-image:url(/bailleul/dev2//admin/arbre2/icones_arbre/fleche_on.png);}
  .img_pointer_arbre_off{background-image:url(/bailleul/dev2//admin/arbre2/icones_arbre/fleche_off.png);}
</style>
</HEAD>
<body>
<div id="global">Loading</div>
<iframe id="framecontent" name="framecontent" bgcolor="" marginheight="0" marginwidth="0" src="../home/index.php" height="0" width="0" style="border:none;" frameBorder="0" border="0" id="detailligne" name="detailligne" onload="aspirecontent()">
Your browser does not support iframes. 
</iframe>
<div style="position : absolute; top : 0; left : 0px; width : 320px; border-top : solid 4px #006666; border-bottom : solid 4px #006666; border-right : solid 4px #006666; background-color:#DDDDDD; font-family:Arial;z-index:50000" id="contenaire_arbre">
 <div onClick="javascript:show_arbre();" style="left : 324px;" id="img_pointer_arbre" class="img_pointer_arbre_on"></div>
  <div style="float : left; width : 300px; background-color:#DDDDDD; min-height : 320px;">
	  <div id="choix_de_langue" style="width : 190px; background-color:#DDDDDD; height : 20px; padding-left : 10px; padding-top : 5px; font-size : 12px;">
    <!-- Selecteur -->
    <select id='options' name='options' class='autocomplete'><option value='en|/bailleul/dev2//upload/phantom_langue5.gif' >&nbsp;Anglais</option><option value='fr|/bailleul/dev2//upload/phantom_langue1.gif' selected>&nbsp;Français</option></select>
   </div>
    <div id="arbre_new" style="position:relative;min-width : 300px; background-color:#DDDDDD; min-height : 315px;padding-bottom:20px;overflow-x : scroll;overflow-y : hidden"></div>
    <div style="clear : both"></div>
    </div>
    <div style="width:20px;height:100%;float:left;background-color:#DDDDDD;bottom:0px;">
        <div><a href="javascript:refreshA()" class="enabled" title="Actualiser"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/refresh.gif"  width="20" height="20" border="0" /></a></div>
        <div id="menu_nouveau">
        <a href="#" class="enabled ss_menu_nouveau" title="Nouveau">
        		<img src="/bailleul/dev2//admin/arbre2/icones_arbre/nouvel_article.gif"  width="20" height="20" border="0" />
        		<span class="ss_menu_nouveau" style="top:-20px;"><table><tr><td><ul><li><a href="javascript:ajout(32,1)" >Actualité</a></li><li><a href="javascript:ajout(28,1)" >Article</a></li><li><a href="javascript:ajout(30,1)" >Dates clefs</a></li><li><a href="javascript:ajout(29,1)" >Dossier</a></li><li><a href="javascript:ajout(31,1)" >Lien</a></li><li><a href="javascript:ajout(27,1)" >Rubrique</a></li><li><a href="javascript:ajout(1,1)" >site</a></li></ul></td></tr></table></span></a>
                </div>
        <div><a href="javascript:informations()" class="enabled" title="Informations"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/informations.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:verrou()" class="enabled" title="Verrouiller/Déverrouiller"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/verrouiller.gif" width="20" height="20" border="0"  /></a></div>
        <div id="menu_modifier">
        <a href="#" class="enabled ss_menu_nouveau" title="Modifier"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/modifier.gif" width="20" height="20" border="0" />
        <span class="ss_menu_nouveau"><table><tr><td>
              <ul>
              <li><a href="javascript:modifier(1,1)" >En ligne</a></li><li><a href="javascript:modifier(1,2)" >Brouillon</a></li>                </ul></td></tr></table></span></a>
        </div>
        <div><a href="javascript:supprimer()" class="enabled" title="Supprimer"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/supprimer.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="#" onclick="renommer()" class="enabled" title="Renommer"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/renommer.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:copier()" class="enabled" title="Copier"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/copier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:couper()" class="enabled" title="Couper"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/couper.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:coller()" class="enabled" title="Coller"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/coller.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:enpremier()" class="enabled" title="En premier"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/en_premier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:plushaut()" class="enabled" title="Plus haut"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/plus_haut.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:plusbas()" class="enabled" title="Plus bas"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/plus_bas.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:endernier()" class="enabled" title="En dernier"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/en_dernier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:creeralias()" class="enabled" title="Créer un alias"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/creer_alias.gif" width="20" height="20" border="0" /></a></div>
        <div id="menu_voir">
        <a href="#" class="enabled ss_menu_nouveau" title="Aperçu"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/voir.gif" width="20" height="20" border="0" />
        <span class="ss_menu_nouveau"><table><tr><td><ul>
            <li><a href="javascript:show(1,1)" >En ligne</a></li><li><a href="javascript:show(1,2)" >Brouillon</a></li></ul></td></tr></table></span></a>
        </div>
        <div><a href="javascript:publier()" class="enabled" title="Publier"><img src="/bailleul/dev2//admin/arbre2/icones_arbre/publier.gif" width="20" height="20" border="0" /></a></div>
        <!-- Legende -->
        <div id="menu_modifier">
        <a href="#" class="enabled ss_menu_nouveau2" title="Legende" style='text-decoration:none;'><img src="/bailleul/dev2//admin/arbre2/icones_arbre/legende.gif" width="20" height="20" border="0" />
         		<span class="ss_menu_nouveau2 "><table><tr><td>
        		<ul style="width:300px">	
        		    <li><center><b>LEGENDE</b></center></li>
        				                  <li><div class="enligne">publié</div></li>
                                  <li><div class="brouillon">non publié</div></li>
                                <li><div class="nottranslate">non traduit</div></li>
                <li style="text-decoration:none; ">
                verrouill&eacute;&nbsp;<img src="/bailleul/dev2//admin/arbre2/imgs/lock.gif" />
                </li>
                <li style="text-decoration:none; ">
                alias&nbsp;<img src="/bailleul/dev2//admin/arbre2/imgs/globe.gif" />
                </li>
                 <li class="legende" >
                <table cellpadding="0" cellspacing="0" width="300">
                  <tr>
                    <td class="table_legende_gabarit legendepadding" width="50%">
                    gabarit normal&nbsp;<br/>
                    </td>
                    <td class="marge" width="50%">
                    gabarit s&eacute;curis&eacute;<br/>
                    </td>
                  </tr>
                  <tr>
                    <td class="taille_table table_legende_gabarit legendepadding">
                    <img src='../../upload/phantom_gabarit32.gif' />&nbsp;Actualité<br/><img src='../../upload/phantom_gabarit28.gif' />&nbsp;Article<br/><img src='../../upload/phantom_gabarit30.gif' />&nbsp;Dates clefs<br/><img src='../../upload/phantom_gabarit29.gif' />&nbsp;Dossier<br/><img src='../../upload/phantom_gabarit31.gif' />&nbsp;Lien<br/><img src='../../upload/phantom_gabarit27.gif' />&nbsp;Rubrique<br/><img src='../../upload/phantom_gabarit1.gif' />&nbsp;site<br/>                    </td>
                    <td class="taille_table marge">
                    <img src='../../upload/phantom_gabarit2_32.gif' />&nbsp;Actualité<br/><img src='../../upload/phantom_gabarit2_28.gif' />&nbsp;Article<br/><img src='../../upload/phantom_gabarit2_30.gif' />&nbsp;Dates clefs<br/><img src='../../upload/phantom_gabarit2_29.gif' />&nbsp;Dossier<br/><img src='../../upload/phantom_gabarit2_31.gif' />&nbsp;Lien<br/><img src='../../upload/phantom_gabarit2_27.gif' />&nbsp;Rubrique<br/><img src='../../upload/phantom_gabarit2_1.gif' />&nbsp;site<br/>                    </td>
                  </tr>
                 </table>
                </li>
          		</ul></td></tr></table></span></a>
        </div>        
        <div style="clear : both"></div>
    </div>
    <div style="clear : both"></div> 
    </div><!--Fin tableau general-->
</BODY>
</HTML>
