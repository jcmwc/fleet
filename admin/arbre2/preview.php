<?php
require("../require/function.php");
require("../require/back_include.php");
testsession();
?>
<script>window.location='<?=urlp($_GET["arbre_id"],$_GET["langue_id"])?>?version_id=<?=$_GET["version_id"]?>&etat_id=<?=$_GET["etat_id"]?>&mode=view';</script>