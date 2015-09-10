<?
require("../../require/function.php");
?>
<script type="text/javascript" src="swfobject.js"></script>
<script>
function maj(val,linkitune,vignette,linkmusic,genre){
  window.opener.document.form1.titre.value=val;
  window.opener.document.form1.iditune2.value=linkitune;
  window.opener.document.form1.vignette2.value=vignette;
  window.opener.document.form1.linkmusic2.value=linkmusic;
  window.opener.document.form1.libelle2.value=genre;
  self.close();
}
function lecteur(l,previewUrl) {
	var flashvars = {
		file:previewUrl, 
		autostart:"true"
	}

	var params = {
		allowfullscreen:"true", 
		allowscriptaccess:"always"
	}

	var attributes = {
		id:"player"+l,  
		name:"player"+l
	}

	swfobject.embedSWF("<?=__racine__?>/tpl/images/player-viral.swf", "divplayer"+l, "200", "24", "9.0.115", false, flashvars, params, attributes);
}
</script>
<!--<a href="#" onclick="window.document['player2'].sendEvent('PLAY').sendEvent('PLAY')">play/pause toggle</a><hr>-->
<?
completeAll($_GET["name"]);
?>