
	if(obj.<?=$tabelem[0]?>.value=="null"){
		alert("<?=$trad["Le champ"]?> <?=$key?> <?=$trad["est obligatoire"]?>");
		obj.<?=$tabelem[0]?>.focus();
		return false;
	}
