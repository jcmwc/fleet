<?php
$querystring= substr($searchstring[1],0,-1);
if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
  ?>
  <div style="border:1px solid black;width:500px;height:200px">
  <iframe frameborder="0" border="0" src="../element/listfichier3/insertfile.php?nomobj=<?=$tabelem[0]?>" width="500" height="200" scrolling="no"></iframe>
  </div>
  <br>
  <span id="listfile">
  <?
  if($_GET["mode"]=="modif"){
 	$resultatselect=query($$querystring);
  while($tbl_resultselect = fetch ($resultatselect)){
   		//print "Supprimer <input type=\"hidden\" name=\"list2".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\"><input type=\"checkbox\" name=\"".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."<br>";
   		?>
   		<table width="100%" style="border-bottom:1px solid black" id="table_fichier_<?=$tbl_resultselect["fichiers_id"]?>">
   		<input type="hidden" name="listfichiers[]" value="<?=$tbl_resultselect["fichiers_id"]?>"/>
   		<input type="hidden" id="fichiers_<?=$tbl_resultselect["fichiers_id"]?>" name="fichiers_<?=$tbl_resultselect["fichiers_id"]?>" value="0" />
      <tr>
        <td>Fichier :</td> 
        <td><a href="<?=__uploaddir__.__racinebd__?>fichiers<?=$tbl_resultselect["fichiers_id"]?>.<?=$tbl_resultselect["ext"]?>" target="_blank"><?=$tbl_resultselect["nom_fichier"]?></a></td>
      </tr>
      <tr>
        <td>Titre :</td>
        <td><?=$tbl_resultselect["titre"]?></td>
      </tr>
      <tr>
        <td>Description :</td>
        <td><?=$tbl_resultselect["abstract"]?></td>
      </tr>
      <tr>
        <td colspan="2" align="right"><input type="button" name="supprimer" value="supprimer" onclick="document.getElementById('table_fichier_<?=$tbl_resultselect["fichiers_id"]?>').style.display='none';document.getElementById('fichiers_<?=$tbl_resultselect["fichiers_id"]?>').value='1'"/></td>
      </tr>
      </table>
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
        <td>Fichier :</td> 
        <td><?=$tbl_resultselect["nom_fichier"]?></td>
      </tr>
      <tr>
        <td>Titre :</td>
        <td><?=$tbl_resultselect["titre"]?></td>
      </tr>
      <tr>
        <td>Description :</td>
        <td><?=$tbl_resultselect["abstract"]?></td>
      </tr>
      </table>
      <?
  }
}
?>