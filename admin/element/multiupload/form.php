<?php
$querystring= $myvalue;
if($_GET["mode"]=="ajout"||$_GET["mode"]=="modif"){?>
  <div style="border:1px solid black;width:500px;height:450px">
  <iframe frameborder="0" border="0" src="../element/multiupload/upload.php?folder=<?=__uploaddir__."ged/".$querystring?>&name=<?=$tabelem[0]?>" width="500" height="450" scrolling="no" id="<?=$tabelem[0]?>_upload"></iframe>
  </div>
<?}?>
  <br>
  <div style="border:1px solid black;width:500px;height:450px">
  <iframe frameborder="0" border="0" src="../element/multiupload/listfile.php?folder=<?=__uploaddir__."ged/".$querystring?>&name=<?=$tabelem[0]?>" width="500" height="450" id="<?=$tabelem[0]?>_list"></iframe>
  </div>
  