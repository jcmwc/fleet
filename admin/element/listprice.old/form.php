<?php
//$querystring= substr($searchstring[1],0,-1);
$querystring="select* from prix where content_id=".$tbl_result["content_id"];
if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
  ?>
  <div style="border:1px solid black;width:500px;height:200px">
  <iframe frameborder="0" border="0" src="../element/listprice/insertprice.php?nomobj=<?=$tabelem[0]?>" width="500" height="200" scrolling="no"></iframe>
  </div>
  <br>
  <span id="listprice">
  <?
  if($_GET["mode"]=="modif"){
  //$querystring="select * from attribut where supprimer=0 order by libelle";
 	$resultatselect=query($querystring);
  while($tbl_resultselect = fetch ($resultatselect)){
   		//print "Supprimer <input type=\"hidden\" name=\"list2".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\"><input type=\"checkbox\" name=\"".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."<br>";
   		?>
   		<table width="100%" style="border-bottom:1px solid black" id="table_prix_<?=$tbl_resultselect["prix_id"]?>">
      <input type="hidden" name="listprix[]" value="<?=$tbl_resultselect["prix_id"]?>"/>
      <input type="hidden" id="prix_<?=$tbl_resultselect["prix_id"]?>" name="prix_<?=$tbl_resultselect["prix_id"]?>" value="0" />
      <?
      $querystring="select * from ".__racinebd__."attribut where supprimer=0 order by libelle";
      $link=query($querystring);
      while($tbl=fetch($link)){
        $sql="select libelle from valeur_prix vp inner join valeur v on vp.valeur_id=v.valeur_id where vp.attribut_id=".$tbl["attribut_id"]." and prix_id=".$tbl_resultselect["prix_id"];
        $link2=query($sql);
        $tbl2=fetch($link2);
        if($tbl2["libelle"]!=""){
          ?>
          <tr><td><?=$tbl["libelle"]?> :</td><td><?=$tbl2["libelle"]?></td></tr>
        <?}
      }?>
      <tr><td>Prix :</td><td><?=$tbl_resultselect["montant"]?></td></tr>
      <tr><td>Quantité :</td><td><?=$tbl_resultselect["quantite"]?></td></tr>
      <tr><td>Référence :</td><td><?=$tbl_resultselect["ref"]?></td></tr>
      <tr><td colspan="2" align="right"><input type="button" name="supprimer" value="<?=$trad["Supprimer"]?>" onclick="document.getElementById('table_prix_<?=$tbl_resultselect["prix_id"]?>').style.display='none';document.getElementById('prix_<?=$tbl_resultselect["prix_id"]?>').value='1'"/></td></tr></table>
      <?
  }
  }
  ?>
  </span>
  <?
}else{
  $resultatselect=query($querystring);
  while($tbl_resultselect = fetch ($resultatselect)){
   		//print value_print($tbl_resultselect[1])."<br>";
   		?>
   		<table width="100%" style="border-bottom:1px solid black" id="table_prix_<?=$tbl_resultselect["prix_id"]?>">
      <input type="hidden" name="listprix[]" value="<?=$tbl_resultselect["prix_id"]?>"/>
      <input type="hidden" id="prix_<?=$tbl_resultselect["prix_id"]?>" name="prix_<?=$tbl_resultselect["prix_id"]?>" value="0" />
      <?
      $querystring="select * from ".__racinebd__."attribut where supprimer=0 order by libelle";
      $link=query($querystring);
      while($tbl=fetch($link)){
        $sql="select libelle from valeur_prix vp inner join valeur v on vp.valeur_id=v.valeur_id where vp.attribut_id=".$tbl["attribut_id"]." and prix_id=".$tbl_resultselect["prix_id"];
        $link2=query($sql);
        $tbl2=fetch($link2);
        if($tbl2["libelle"]!=""){
          ?>
          <tr><td><?=$tbl["libelle"]?> :</td><td><?=$tbl2["libelle"]?></td></tr>
        <?}
      }?>
      <tr><td>Prix :</td><td><?=$tbl_resultselect["montant"]?></td></tr>
      <tr><td>Quantité :</td><td><?=$tbl_resultselect["quantite"]?></td></tr>
      <tr><td>Référence :</td><td><?=$tbl_resultselect["ref"]?></td></tr>
      </table>
      <?
  }
}
?>