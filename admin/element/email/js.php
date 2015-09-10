
  	if(!estuneadresseemail(obj.<?=$tabelem[0]?>.value)){
		alert("<?=$trad["Email non valide"]?>");
		obj.<?=$tabelem[0]?>.focus();
		return false;
	}
