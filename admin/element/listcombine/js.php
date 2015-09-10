<?$subtabelem= split(",",$tabelem[0]);?>
	if(obj.<?=$subtabelem[0]?>.value=="null"){
		alert("<?=$trad["Le champ"]?> <?=$key?> <?=$trad["est obligatoire"]?>");
		obj.<?=$subtabelem[0]?>.focus();
		return false;
	}
