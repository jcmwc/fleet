<?
require("../../admin/require/function.php");
$html="Société : ".$_POST["soc"];
$html.="<br>Nom, Prénom : ".$_POST["nom"];
$html.="<br>Fonction : ".$_POST["fonc"];
$html.="<br>Email : ".$_POST["mail"];
$html.="<br>Téléphone : ".$_POST["tel"];
$html.="<br>Sujet du message : ".$_POST["mess"];
$html.="<br>Message : ".$_POST["message"];
sendmail('','','Demande de contact',$html);
?>
ok