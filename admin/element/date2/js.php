
   if(!testdate(obj.<?=$tabelem[0]?>.value)){
		alert("<?=$trad["Le format de date est non valide (jj/mm/yyyy)"]?>");
		obj.<?=$tabelem[0]?>.focus();
		return false;
	}
