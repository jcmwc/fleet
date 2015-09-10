<?php
if($_GET["mode"]!="ajout"){
  print "<a href=\"".urlp($_GET["arbre_id"])."\" target=\"_blank\">".urlp($_GET["arbre_id"])."</a>";
}
?>