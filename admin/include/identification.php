<?php
include("../require/function.php");
if (!empty($_POST['login']) && !empty($_POST['mdp'])){
$resultat = identification($_POST['login'],$_POST['mdp'],$_POST['langue']);
} else {
$resultat = 'erreur ici';
}
echo $resultat;
?>