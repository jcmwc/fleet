<?php
$querystring= substr($searchstring[1],0,-1);
if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
  ?>
  
  <div style="border:1px solid black;width:500px;height:120px">
  <iframe id="listidvaliframe" frameborder="0" border="0" src="<?=__racineadmin__?>/element/listval/insertfile.php?nomobj=<?=$tabelem[0]?>" width="500" height="120" scrolling="no"></iframe>
  </div>
  <br>
  <span id="listvals">
  <?
  if($_GET["mode"]=="modif"){
 	$resultatselect=query($$querystring);
  while($tbl_resultselect = fetch ($resultatselect)){
   		//print "Supprimer <input type=\"hidden\" name=\"list2".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\"><input type=\"checkbox\" name=\"".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."<br>";
   		?>      
      <table width="100%" style="border-bottom:1px solid black" id="table_val_<?=$tbl_resultselect["val_id"]?>">
      <input type="hidden" name="listvals[]" value="<?=$tbl_resultselect["val_id"]?>"/>
      <input type="hidden" name="listtitre[]" value="<?=$tbl_resultselect["titre"]?>"/>
      <input type="hidden" name="listval[]" value="<?=$tbl_resultselect["val"]?>"/>
      <input type="hidden" id="val_<?=$tbl_resultselect["val_id"]?>" name="val_<?=$tbl_resultselect["val_id"]?>" value="2" />
      <tr><td><?=$trad["Titre"]?> :</td><td><?=$tbl_resultselect["titre"]?></td></tr>
      <tr><td>Valeur :</td><td><?=$tbl_resultselect["val"]?></td></tr>
      <tr><td colspan="2" align="right"><input type="button" name="supprimer" value="<?=$trad["Supprimer"]?>" onclick="document.getElementById('table_val_<?=$tbl_resultselect["val_id"]?>').style.display='none';document.getElementById('val_<?=$tbl_resultselect["val_id"]?>').value='1'"/>
      <input type="button" name="modifier" value="modifier" onclick="modifelemlistval(<?=$tbl_resultselect["val_id"]?>,this)"/></td></tr></table>
      <?
  }
  }
  ?>
  </span>
  <?
}else{
  $resultatselect=query($$querystring);
  while($tbl_resultselect = fetch ($resultatselect)){
   		//print value_print($tbl_resultselect[1])."<br>";
   		?>
   		<table width="100%" style="border-bottom:1px solid black">     
      <tr>
        <td>Titre :</td>
        <td><?=$tbl_resultselect["titre"]?></td>
      </tr>
      
      <tr>
        <td>Valeur :</td>
        <td><?=$tbl_resultselect["val"]?></td>
      </tr>
      </table>
      <?
  }
}
?>