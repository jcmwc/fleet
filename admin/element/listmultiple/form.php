<?php

$querystring= split(",",substr($searchstring[1],0,-1));
         if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
             //<div style=\"height:40px;overflow:hidden;\">
             print "<table border=0 ><tr><td>";
             //print $$querystring[0];
             $resultatselect=query($$querystring[0]);
             //print "<select name=\"list".$tabelem[0]."\" class=\"selectstyle\" size=\"6\" multiple style=\"max-width:337px\">";
             print "<select name=\"list".$tabelem[0]."\" class=\"selectstyle\" size=\"6\" multiple style=\"min-width:250px\">";
             while($tbl_resultselect = fetch ($resultatselect)){
               print "<option value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."</option>";
             }
             print "</select></td><td><input type=button name=add value=\"ajouter >>\" onclick=\"newelem4(this.form.elements['list".$tabelem[0]."'],this.form.elements['".$tabelem[0]."'])\"><br><input type=button name=delete value=\"enlever <<\" onclick=\"newelem4(this.form.elements['".$tabelem[0]."'],this.form.elements['list".$tabelem[0]."'])\"></td><td>";
         	 if($_GET["mode"]=="modif"){
             	$resultatselect=query($$querystring[1]);
             }
	          //print "<select name=\"".$tabelem[0]."\" class=\"selectstyle\" size=\"6\" multiple style=\"max-width:337px\">";
            print "<select name=\"".$tabelem[0]."\" class=\"selectstyle\" size=\"6\" multiple style=\"min-width:250px\">>";
             while($tbl_resultselect = fetch ($resultatselect)){
                	print "<option value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."</option>";
             }
	          print "</select></td></tr></table>";
            //</div>
         }else{
         	$resultatselect=query($$querystring[1]);
            while($tbl_resultselect = fetch ($resultatselect)){
           		print value_print($tbl_resultselect[1])."<br>";
            }
         }

?>