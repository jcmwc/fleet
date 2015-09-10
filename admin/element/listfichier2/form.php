<?php

$querystring= substr($searchstring[1],0,-1);
         if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){
    	      ?>
            <iframe frameborder="0" border="0" src="../include/insertfile.php?nomobj=<?=$tabelem[0]?>" width="300" height="40" scrolling="no"></iframe>
            <br>
            <span id="listfile">
            <?
            if($_GET["mode"]=="modif"){
      	   	$resultatselect=query($$querystring);
            while($tbl_resultselect = fetch ($resultatselect)){
  	         		print "Supprimer <input type=\"hidden\" name=\"list2".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\"><input type=\"checkbox\" name=\"".$tabelem[0]."\" value=\"".$tbl_resultselect[0]."\">".$tbl_resultselect[1]."<br>";
	          }
            }
            ?>
            </span>
            <?
         }else{
         $resultatselect=query($$querystring);
          while($tbl_resultselect = fetch ($resultatselect)){
           		print value_print($tbl_resultselect[1])."<br>";
          }
         }

?>