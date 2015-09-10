
   madate=obj.<?=$tabelem[0]?>.value.split(' ');
   monheure=madate[1].split(":");
   if(!testdate(madate[0])||monheure[0]>23||monheure[1]>59){
		alert("<?=$trad["Le format de date est non valide (jj/mm/yyyy hh:mm)"]?>");
		obj.<?=$tabelem[0]?>.focus();
		return false;
	}
