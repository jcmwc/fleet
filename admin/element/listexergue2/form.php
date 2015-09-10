<?php
$querystring= substr($searchstring[1],0,-1);
if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
  ?>
  
  <div style="border:1px solid black;width:500px;height:500px">
  <iframe id="listidimageiframe" frameborder="0" border="0" src="../element/listexergue/insertfile.php?nomobj=<?=$tabelem[0]?>" width="500" height="500" scrolling="no"></iframe>
  </div>
  <br>
  <span id="listimages">
  <?
  if($_GET["mode"]=="modif"){
 	$resultatselect=query($$querystring);
  while($tbl_resultselect = fetch ($resultatselect)){
   		//print "Supprimer <input type=\"hidden\" name=\"list2".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\"><input type=\"checkbox\" name=\"".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."<br>";
   		?>
   		<table width="100%" style="border-bottom:1px solid black" id="table_images_<?=$tbl_resultselect["images_id"]?>">
   		<input type="hidden" name="listimages[]" value="<?=$tbl_resultselect["images_id"]?>"/>
   		<textarea name="listimagescontenu[]" style="display:none"><?=$tbl_resultselect["contenulightbox"]?></textarea>
      <input type="hidden" name="listimageschk[]" value="<?=$tbl_resultselect["lightbox"]?>"/>
      <input type="hidden" name="listimagestitre1[]" value="<?=$tbl_resultselect["titre1"]?>"/>
      <input type="hidden" name="listimagestitre2[]" value="<?=$tbl_resultselect["titre2"]?>"/>
   		<input type="hidden" id="list_images_<?=$tbl_resultselect["images_id"]?>" name="images_<?=$tbl_resultselect["images_id"]?>" value="0" />
      <tr>
        <td>Fichier  :</td> 
        <td><a href="<?=__uploaddir__.__racinebd__?>list_images<?=$tbl_resultselect["images_id"]?>.<?=$tbl_resultselect["ext1"]?>" target="_blank"><?=$tbl_resultselect["nom_fichier1"]?></a></td>
      </tr>
      <tr>
        <td>Titre 1:</td>
        <td><?=$tbl_resultselect["titre1"]?></td>
      </tr>
      <!-- <tr>
        <td>Fichier 2 :</td> 
        <td><a href="<?=__uploaddir__.__racinebd__?>list_images2_<?=$tbl_resultselect["images_id"]?>.<?=$tbl_resultselect["ext2"]?>" target="_blank"><?=$tbl_resultselect["nom_fichier2"]?></a></td>
      </tr>    -->
      <!--
      <tr>
        <td>Lien (id si interne) :</td>
        <td><?=$tbl_resultselect["titre2"]?></td>
      </tr>-->
      <tr>
        <td colspan="2" align="right">
        <input type="button" name="supprimer" value="supprimer" onclick="document.getElementById('table_images_<?=$tbl_resultselect["images_id"]?>').style.display='none';document.getElementById('list_images_<?=$tbl_resultselect["images_id"]?>').value='1'"/>
        <input type="button" name="modifier" value="modifier" onclick="modifelemlistimage(<?=$tbl_resultselect["images_id"]?>,this)"/>
        </td>
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
        <td>Image :</td> 
        <td><?=$tbl_resultselect["nom_fichier1"]?></td>
      </tr>
      <tr>
        <td>Titre :</td>
        <td><?=$tbl_resultselect["titre1"]?></td>
      </tr>
      <!--<tr>
        <td>Fichier 2 :</td> 
        <td><?=$tbl_resultselect["nom_fichier2"]?></td>
      </tr>  -->
      <!--
      <tr>
        <td>Lien (id si interne) :</td>
        <td><?=$tbl_resultselect["titre2"]?></td>
      </tr> -->
      </table>
      <?
  }
}
?>