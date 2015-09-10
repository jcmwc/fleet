<?php
$sql="select v.libelle as valeur,a.libelle as attribut from prix p 
inner join valeur_prix vp on p.prix_id=vp.prix_id and p.content_id=".$tbl_result["content_id"]." and p.prix_id=".$tbl_result["prix_id"]."
inner join valeur v on v.valeur_id=vp.valeur_id
inner join attribut a on a.attribut_id=vp.attribut_id";
//print $sql."<br>";
$link=query($sql);
while($tbl=fetch($link)){?>
<b><?=$tbl["attribut"]?></b> : <?=$tbl["valeur"]?><br>
<?}
//print value_print($myvalue);

?>