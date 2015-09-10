
   	exist=false;
   	for(i=0;i<obj.<?=$tabelem[0]?>.length;i++){
      	if(obj.<?=$tabelem[0]?>[i].checked){
         	exist=true;
            break;
         }
      }
      if(!exist){
			alert("<?=$trad["Le champ"]?> <?=$key?> <?=$trad["est obligatoire"]?>");
         obj.<?=$tabelem[0]?>[0].focus();
         return false;
      }
