<?php
$querystring= substr($searchstring[1],0,-1);
if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
  ?>
  
  <div style="border:1px solid black;height:150px">
  <iframe id="listidmontantiframe" frameborder="0" border="0" src="<?=__racineadmin__?>/element/listparag/insertfile.php?nomobj=<?=$tabelem[0]?>&id=<?=$tbl_result[$tablekey]?>" width="100%" height="150" scrolling="no"></iframe>
  </div>
  <br>
  <span id="listmontants">
  <?
  if($_GET["mode"]=="modif"){
  $link=query($$querystring);?>
  <div>
  <iframe id="listidmontantiframelist" frameborder="0" border="0" src="<?=__racineadmin__?>/element/listparag/listmontant.php?nomobj=<?=$tabelem[0]?>&id=<?=$tbl_result[$tablekey]?>&query=<?=urlencode($$querystring)?>" width="100%" height="<?=num_rows($link)*63+25?>" ></iframe>
  </div>
  <?
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
        <td>Contenu :</td>
        <td><?=$tbl_resultselect["contenu"]?></td>
      </tr>
      </table>
      <?
  }
}
?>