<?
require("../../require/function.php");
require("../../require/back_include.php");
?>
var tmprenametitle="";
var tmprenameid=0;
function locationlangue(obj){
    lang=obj.value.split("|");
    window.location='index.php?lang='+lang[0];
}
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
    /*
    content="<input type=\"text\" name=\"name_"+node.data.key+"\" id=\"name_"+node.data.key+"\" value=\""+node.data.title+"\" onKeyPress=\"if (((window.Event) ? event.which : event.keyDown) == 13) finishrename(this,"+node.data.key+",'"+node.data.title+"')\" onBlur=\"finishrename(this,"+node.data.key+",'"+node.data.title+"')\">"
    $(node.li).find("a:eq(0)").html(content)
    $("#name_"+node.data.key).focus();
    */
    tmprenametitle=node.data.title;
    tmprenameid=node.data.key;
    $( "#dialog-form" ).dialog( "open" );
  }
}
function finishrename(newvalue,key,oldvalue){       
    node=$("#arbre_new").dynatree("getTree").getNodeByKey(key)
    node.setLazyNodeStatus(DTNodeStatus_Loading);
    $.ajax({
      url: '<?=__reparbre__?>/sampleRename.php',
      type: "POST",
      dataType: "json",
      data: {branch_id: key,name:newvalue,langue_id:<?=$_GET["langue_id"]?>,old_value:oldvalue},
      success: function(data) {
        node.setLazyNodeStatus(DTNodeStatus_Ok);                 
        if(data.ok){    
           $(node.li).find("a:eq(0)").html(data.msg)
           //node.data.title=data.msg;
           $("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.title=data.msg;
           node.render(); 
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
  //alert(cmd)
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
      moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?arbre_id='+node.data.key+'&langue_id=<?=$_GET["langue_id"]?>&mode=list';
    break;
    case "informations":
      moniframe=getIframe();
      moniframe.location='<?=__racineadminmenucore__?>/gabarit/log.php?arbre_id='+node.data.key;
    break;
    case "deverrouiller":
    case "verrouiller":
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      $.ajax({
        url: '<?=__reparbre__?>/sampleVerrou.php',
        type: "POST",
        dataType: "json",
        data: {branch_id: node.data.key},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
            //on rafraichis le pere
            //refreshA(node.data.key);
            //alert($("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.title)
            //alert($("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.verrou)
            $("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.verrou=!$("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.verrou;
            //alert($("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.verrou)
            node.render();
            //refreshA(node.data.key);
            //node.reloadChildren();
            //node.parent.reloadChildren(function(node, isOk){});
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
      copyPaste("paste", $("#arbre_new").dynatree("getTree").getNodeByKey("_2"));
    break;
    case "replace":
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      $.ajax({
        url: '<?=__reparbre__?>/sampledrop.php',
        type: "POST",
        dataType: "json",
        data: {drag_id: node.data.key,drop_id: clipboardNode.data.key,replace:"1"},
        success: function(data) {
          //node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
            node.setLazyNodeStatus(DTNodeStatus_Ok);
            refreshA(clipboardNode.parent.data.key);
            refreshA("_2");
            /*
            refreshA("_1");//alert(hitMode)                
            refreshA("_2");//alert(hitMode)    
            node.move(sourceNode, "after");
            */
          }else{
            alert(data.msg)
          }
        }
      }).error(function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText+"erreur");
      node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
      );  
    break;
    case "bas":
      //logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
      //alert(DTNodeStatus_Loading)
      pos = $.inArray(node, node.parent.childList);
      sourceNode=node.parent.childList[pos+1];
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      //alert(sourceNode.data.title)
      //alert(node.data.title)
      
      $.ajax({
        url: '<?=__reparbre__?>/sampledrop.php',
        type: "POST",
        dataType: "json",
        data: {drag_id: node.data.key,drop_id: sourceNode.data.key,hitMode:"before"},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
            //alert(hitMode)    
            node.move(sourceNode, "after");
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
      //logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
      //alert(DTNodeStatus_Loading)
      pos = $.inArray(node, node.parent.childList);
      sourceNode=node.parent.childList[pos-1];
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      //alert(sourceNode.data.title)
      //alert(node.data.title)
      $.ajax({
        url: '<?=__reparbre__?>/sampledrop.php',
        type: "POST",
        dataType: "json",
        data: {drop_id: node.data.key,drag_id: sourceNode.data.key,hitMode:"before"},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
            //alert(hitMode)    
            node.move(sourceNode, "before");
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
      //logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
      //alert(DTNodeStatus_Loading)
      //pos = $.inArray(node, node.parent.childList);
      sourceNode=node.parent.childList[0];
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      //alert(node.data.key)
      //alert(sourceNode.data.key)
      
      $.ajax({
        url: '<?=__reparbre__?>/sampledrop.php',
        type: "POST",
        dataType: "json",
        data: {drag_id: node.data.key,drop_id: node.parent.data.key,hitMode:"first"},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
            //alert(hitMode)    
            node.move(sourceNode, "before");
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
      //logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
      //alert(DTNodeStatus_Loading)
      //pos = $.inArray(node, node.parent.childList);
      sourceNode=node.parent.childList[node.parent.childList.length-1];
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      $.ajax({
        url: '<?=__reparbre__?>/sampledrop.php',
        type: "POST",
        dataType: "json",
        data: {drag_id: node.data.key,drop_id: node.parent.data.key,hitMode:"last"},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
            //alert(hitMode)   
            //alert('ici'); 
            node.move(sourceNode, "after");
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
      pere=(node.parent.data.key=="_1")?0:node.parent.data.key;  
      moniframe.location='<?=__racineadminmenucore__?>/gabarit/droits.php?pere='+pere+'&arbre_id='+node.data.key;
    break;
    case "xml":
      window.open("<?=__reparbre__?>/export.php?arbre_id="+node.data.key);
    break;
    case "pdf":
      window.open("<?=__reparbre__?>/exportpdf/index.php?arbre_id="+node.data.key);
    break;
    case "import":
      moniframe=getIframe();
      moniframe.location='<?=__racineadminmenucore__?>/gabarit/import.php?arbre_id='+node.data.key;
    break;
    case "vider":
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      for(i=0;i<node.childList.length;i++){
        //alert(node.childList[i].data.key) 
        
        $.ajax({
          url: '<?=__reparbre__?>/sampleDelete.php',
          type: "POST",
          dataType: "json",
          data: {branch_id: node.childList[i].data.key},
          success: function(data) {
            //if(i==node.parent.childList.length-1){
              node.setLazyNodeStatus(DTNodeStatus_Ok);
              refreshA("_2");
            //}
            //$("#arbre_new").dynatree("getTree").getNodeByKey("pb").reloadChildren(function(node, isOk){});
          }
        }).error(function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText+"erreur");
        node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
        );
      }
    break;
    case "suppression":
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      $.ajax({
        url: '<?=__reparbre__?>/sampleDelete.php',
        type: "POST",
        dataType: "json",
        data: {branch_id: node.data.key},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          refreshA("_2");
          //$("#arbre_new").dynatree("getTree").getNodeByKey("pb").reloadChildren(function(node, isOk){});
        }
      }).error(function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText+"erreur");
      node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
      );
    break;
    case "restaurer":
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      $.ajax({
        url: '<?=__reparbre__?>/sampleRestore.php',
        type: "POST",
        dataType: "json",
        data: {branch_id: node.data.key},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          refreshA();
          //$("#arbre_new").dynatree("getTree").getNodeByKey(data.msg).reloadChildren(function(node, isOk){});       
        }
      }).error(function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText+"erreur");
      node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
      );
    break;
    case "copier":    
    case "coller":    
    case "couper":  
    case "arbo":     
    case "alias":
      //alert(node.data.title)
      cmd=(cmd=="copier")?"copy":cmd;
      cmd=(cmd=="coller")?"paste":cmd;
      cmd=(cmd=="couper")?"cut":cmd;
  		copyPaste(cmd, node);
    break;
    case "pubinstant":
    case "depubinstant":
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      $.ajax({
        url: '<?=__reparbre__?>/sampleEtat.php',
        type: "POST",
        dataType: "json",
        data: {branch_id: node.data.key},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
            tabclass=$("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.addClass;
            newtabclass="";           
            $("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.etat=($("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.etat==1)?2:1;
            if($("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.etat==1){
              if(tabclass.indexOf("nottranslate")>=0){                
                newtabclass="nottranslate";
              }
            }else{
              if(tabclass.indexOf("nottranslate")>=0){
                newtabclass="brouillon translate";
              }else{
                newtabclass="brouillon";              
              }
            }
            $("#arbre_new").dynatree("getTree").getNodeByKey(node.data.key).data.addClass=newtabclass;
            node.render();
          }else{
            alert(data.msg)
          }
        }
      }).error(function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText+"erreur");
        node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
      );
    break;
    case "depubcron":
     
      pere=(node.parent.data.key=="_1")?"":node.parent.data.key;
      //alert('<?=__racineadminmenucore__?>/gabarit/decronpub.php?arbre_id='+node.data.key+'&pere='+pere);
      moniframe=getIframe();
      moniframe.location='<?=__racineadminmenucore__?>/gabarit/decronpub.php?arbre_id='+node.data.key+'&pere='+pere;
    break;
    case "pubcron":
      //alert("pubcron");
      moniframe=getIframe();
      pere=(node.parent.data.key=="_1")?"":node.parent.data.key;
      moniframe.location='<?=__racineadminmenucore__?>/gabarit/cronpub.php?arbre_id='+node.data.key+'&pere='+pere;
    break;
    default:
      if(cmd.indexOf("gabarit")<0){
        //alert("ici");
        if(cmd.indexOf("version")<0){
          //alert("Unhandled action '" + cmd + "'");
        }else{
          moniframe=getIframe();
          if(cmd.indexOf("apercu")==0){
            version_id=cmd.substring(14,cmd.length);    
            window.open("<?=__reparbre__?>/preview.php?mode=preview&version_id="+version_id+"&arbre_id="+node.data.key+"&etat_id="+node.data.etat+"&langue_id=<?=$_GET["langue_id"]?>");
          }else{
            version_id=cmd.substring(16,cmd.length);    
            pere=(node.parent.data.key=="_1")?0:node.parent.data.key;
            //alert('<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&arbre_id='+node.data.key+'&langue_id=<?=$_GET["langue_id"]?>&mode=modif&version_id='+version_id)
            //window.open('<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&arbre_id='+node.data.key+'&langue_id=<?=$_GET["langue_id"]?>&mode=modif&version_id='+version_id);
            moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&arbre_id='+node.data.key+'&langue_id=<?=$_GET["langue_id"]?>&mode=modif&version_id='+version_id;
          }
        }
      }else{  
        //alert("la");        
        moniframe=getIframe(); 
        pere=(node.data.key=="_1")?0:node.data.key;
        //alert('<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&langue_id=<?=$_GET["langue_id"]?>&mode=ajout&gabarit_id='+cmd.substring(7,cmd.length))
        //alert(moniframe)
        moniframe.location='<?=__racineadminmenucore__?>/gabarit/article.php?pere='+pere+'&langue_id=<?=$_GET["langue_id"]?>&mode=ajout&gabarit_id='+cmd.substring(7,cmd.length);
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
  $(".icon-replace").css("display","none");
  $(".icon-restaurer").css("display","none");
  $(".icon-suppression").css("display","none");
  //on vérifie si l'éléments est a la poubelle
  var path = [];
	node.visitParents(function(node){
		if(node.parent){
			path.unshift(node.data.key);
		}
	}, !node);
  if(path[0]=='_2'){
    $(".context-menu-item").css("display","none");  
    if(node.getLevel()==2){
      //restaurer
      $(".icon-restaurer").css("display","block");
      //suppression definitive
      $(".icon-suppression").css("display","block");
      //informations
      $(".icon-informations").css("display","block");
    }
  } else if(node.data.key=="_1"){
    //on vérifie si le noeud choisi est le noeud root
    $(".context-menu-item").css("display","none");
    //on fait apparaitre nouveau
    $(".icon-nouveau").find("li").css("display","block");
    $(".icon-nouveau").css("display","block");
    //on fait apparaitre import
    $(".icon-import").css("display","block");
    
    if(clipboardNode!=null){
      $(".icon-coller").css("display","block");
      $(".icon-alias").css("display","block");
      $(".icon-arbo").css("display","block");
      $(".icon-replace").css("display","block");
    }
    
  } else if(node.data.key=="_2"){
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
    //alert(node.data.etat)
    if(node.data.etat==1){
       $(".icon-publier").css("display","none");
       $(".icon-depublier").css("display","block");
    }else{
       $(".icon-publier").css("display","block");
       $(".icon-depublier").css("display","none");
    }
    //vérification si un éléments est dans le buffer
    if(clipboardNode!=null){
      $(".icon-coller").css("display","block");
      $(".icon-alias").css("display","block");
      $(".icon-arbo").css("display","block");
      $(".icon-replace").css("display","block");
    }
  }
}
// --- Implement Cut/Copy/Paste --------------------------------------------
var clipboardNode = null;
var pasteMode = null;
var currentnode=null;

function copyPaste(action, node) {
  pere=(node.data.key=="_1")?"null":node.data.key;
  //alert("ici");
  recursive=(action=="arbo")?1:0;
  //alert(action)
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
  case "arbo":
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
        url: '<?=__reparbre__?>/sampledrop.php',
        type: "POST",
        dataType: "json",
        data: {drop_id: pere,drag_id: clipboardNode.data.key,recursive:recursive},
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
		} else  {
    
     
			// Copy mode: prevent duplicate keys:
		 node.setLazyNodeStatus(DTNodeStatus_Loading);
 
      $.ajax({
        url: '<?=__reparbre__?>/sampledrop.php',
        type: "POST",
        dataType: "json",
        data: {drop_id: pere,drag_id: clipboardNode.data.key,copydrag:1,recursive:recursive},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){    
            //refreshA(node.data.key);
            adchildinfo(node.data.key);
            $(clipboardNode.li).find("span:eq(0)").css({ opacity: 1 });
            clipboardNode = pasteMode = null;  
            
          }else{
            alert(data.msg)
          }
        }
      }).error(function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText+"erreur");
        node.setLazyNodeStatus(DTNodeStatus_Error, {info: textStatus, tooltip: "" + errorThrown});}
      );
      }
      
	break;
  case "alias":		
      //alert(clipboardNode.data.key)
	  	// Copy mode: prevent duplicate keys:
      node.setLazyNodeStatus(DTNodeStatus_Loading);
      $.ajax({
        url: '<?=__reparbre__?>/sampledrop.php',
        type: "POST",
        dataType: "json",
        data: {drop_id: node.data.key,drag_id: clipboardNode.data.key,alias:1},
        success: function(data) {
          node.setLazyNodeStatus(DTNodeStatus_Ok);
          if(data.ok){ 
            /*
            var cb = clipboardNode.toDict(true, function(dict){
      				dict.title = "alias__" + dict.title;
      			});   
            alert(cb.key)
            cb.key = data.msg;
            cb.alias=1;
            alert(cb.key)
            //alert(cb.title)
            //alert(hitMode)    
            node.addChild(cb);
            */
            refreshA(node.data.key);
            $(clipboardNode.li).find("span:eq(0)").css({ opacity: 1 });
            clipboardNode = pasteMode = null;
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
		alert("Unhandled clipboard action '" + action + "'");
	}
}; 

function refreshA(nodeid){
  //alert(nodeid)
  if(nodeid==null||nodeid==undefined||nodeid=="_1"||nodeid=="_2"){
    $("#arbre_new").dynatree("getTree").reload();
  }else{
    //vérification si le noeusd possède déjà des enfants
    //currentnode=$("#arbre_new").dynatree("getTree").getNodeByKey(nodeid).data.isLazy=true;
    //currentnode.data.isLazy=(currentnode.data.isLazy)?currentnode.data.isLazy:;
    $("#arbre_new").dynatree("getTree").getNodeByKey(nodeid).reloadChildren();
  } 
}
function adchildinfo(nodeid){
  $("#arbre_new").dynatree("getTree").getNodeByKey(nodeid).data.isLazy=true;
  refreshA(nodeid);
}
var sidebar = false;    
function show_arbre(){
	if(sidebar==false){
    $('#contenaire_arbre').animate({left: '-320px'}, 500);
    $('#content').animate({'margin-left': '0px'}, 500);
      $('#quickNav').animate({'left': '40px'}, 500);
       $('#img_pointer_arbre').animate({'left': '325px'}, 500);
    sidebar=true;
  }else{
    $('#contenaire_arbre').animate({left: '0px'}, 500);
    $('#content').animate({'margin-left': '320px'}, 500);
	  $('#quickNav').animate({'left': '325px'}, 500);
    $('#img_pointer_arbre').animate({'left': '290px'}, 500);
    sidebar=false;
  }
  return false;
}
