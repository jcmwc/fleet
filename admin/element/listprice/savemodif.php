<?
require("../../require/function.php");
require("../../require/back_include.php");
$sql="update ".__racinebd__."prix set montant='".addquote($_POST["montant"])."',montantremise='".addquote($_POST["montantremise"])."',quantite='".addquote($_POST["quantite"])."',ref='".addquote($_POST["ref"])."' where prix_id=".$_POST["indice"];
query($sql);
?>
okmodif