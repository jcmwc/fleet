<?php

$querystring= substr($searchstring[1],0,-1);
         if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
             print "<table border=0><tr><td>";
             $resultatselect=query($$querystring);
             print "Liste des documents validés<br><select name=\"list2".$tabelem[0]."\" class=\"selectstyle\" size=\"6\" multiple>";
           	 if($_GET["mode"]=="modif"){
             while($tbl_resultselect = fetch ($resultatselect)){
               print "<option value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."</option>";
             }
             }
             print "</select></td><td><input type=button name=new value=\"Télécharger un fichier\" onclick=\"openwin('fichier.php?mode=ajout&template=_popup&nomobj=list2".$tabelem[0]."',780,150,'yes')\"><br><input type=button name=add value=\"Supprimer le document >>\" onclick=\"newelem4(this.form.elements['list2".$tabelem[0]."'],this.form.elements['".$tabelem[0]."'])\"><br><input type=button name=delete value=\"Reprendre le document <<\" onclick=\"newelem4(this.form.elements['".$tabelem[0]."'],this.form.elements['list2".$tabelem[0]."'])\"></td><td>";
         	 if($_GET["mode"]=="modif"){
             	$resultatselect=query($$querystring[1]);
             }
	          print "Liste des documents supprimés<br><select name=\"".$tabelem[0]."\" class=\"selectstyle\" size=\"6\" multiple></select></td></tr></table>";
         }else{
         	$resultatselect=query($$querystring[1]);
            while($tbl_resultselect = fetch ($resultatselect)){
           		print value_print($tbl_resultselect[1])."<br>";
            }
         }

?>