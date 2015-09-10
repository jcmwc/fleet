<?php
$key=($tablekey2=="")?$_GET["id"]:$tbl_result[$tablekey2];
$key=($key=="")?$tbl_result[$tablekey]:$key;
$args=substr($searchstring[1],0,-1);
	      if($_GET["mode"]=="visu"||$_GET["mode"]=="suppr"){
        	if($indice>1){
         	print affichemedia($key,$myvalue,$table.$indice."_");
          }else{
          print affichemedia($key,$myvalue,$table);
          }
					//print "".$key.",".$myvalue.",".$table.$indice."";
        }else{
         	print '<input type="hidden" name="'.$tabelem[0].'"><input type="hidden" name="args_'.$tabelem[0].'" value="'.$args.'""><input type="hidden" name="'.$tabelem[0].'_last" value="'.(($myvalue!='')?'1':'0').'"> '.(($tabelem[2]!="yes"&&$_GET["mode"]!="ajout"&&$myvalue!='')?' supprimer <input type="checkbox" name="'.$tabelem[0].'_chk" value="1">':'');
          if($indice>1){
          $matable=$table.$indice."_";
          //print "<a href=\"../element/image/popup.php?id=".$key."&table=".$matable."&name=".$tabelem[0]."&args=".$args."\" onclick=\"return GB_showCenter('Recadrage',this.href,600,850,closecrop)\">modif vignette</a><br>";
          print "<input type=\"button\" name=\"crop\" onclick=\"return GB_showCenter('Recadrage','../element/image/popup.php?id=".$key."&table=".$matable."&name=".$tabelem[0]."&args=".$args."&myvalue=".$myvalue."',600,850,closecrop)\" value=\"Modifier les vignettes\" class=\"btncrop\"><br>";
         	print affichemedia($key,$myvalue,$table.$indice."_");
          }else{
          $matable=$table;
          //print "<a href=\"../element/image/popup.php?id=".$key."&table=".$matable."&name=".$tabelem[0]."&args=".$args."\" onclick=\"return GB_showCenter('Recadrage',this.href,600,850,closecrop)\">modif vignette</a><br>";
          print "<input type=\"button\" name=\"crop\" onclick=\"return GB_showCenter('Recadrage','../element/image/popup.php?id=".$key."&table=".$matable."&name=".$tabelem[0]."&args=".$args."&myvalue=".$myvalue."',600,850,closecrop)\" value=\"Modifier les vignettes\" class=\"btncrop\"><br>";
          print affichemedia($key,$myvalue,$table);
          }
        }
        $indice++;
?>