
   if(obj.elements["<?=$tabelem[0]?>"].options.length<1){
		alert("<?=$trad["Aucun element dans la liste"]?>");
		obj.elements["<?=$tabelem[0]?>"].focus();
		return false;
	}
