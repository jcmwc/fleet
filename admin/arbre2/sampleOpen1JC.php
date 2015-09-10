<?php
require("../require/function.php");
require("../require/back_include.php");

/*
$_POST['key']=1;
$_POST['langue_id']=1;
*/
$requete_style = "select style from ".__racinebd__."etat order by etat_id ASC";
$link_style=query($requete_style);
while ($ligne_style=fetch($link_style)){
    $style++;
    $le_style[$style] = $ligne_style["style"];
}

if (isset($_GET['key'])) {
      			echo "[";
      			listnoeud2($_GET['key'],$_GET['langue_id']);
      			echo "]";

}
?>