<?require("../../require/function.php")?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$file=$_GET["file"];
if ($file != "." && $file != ".." && $file != "") {
  //print $_SERVER["DOCUMENT_ROOT"].$_GET['folder']."/".$file;
  unlink($_SERVER["DOCUMENT_ROOT"].$_GET['folder']."/".$file);
}
?>
<script language="JavaScript" type="text/javascript" src="swfobject.js"></script>
<script>
function deleteFile(file) {
  if(confirm("Etes vous sur ?")){
    //alert("listfile.php?file="+file+"&folder=<?=$_GET['folder']?>")
  	self.location.href="listfile.php?file="+file+"&folder=<?=$_GET['folder']?>";
	}
}  
</script>
</head>
<body>
    <?
    if (is_dir($_SERVER["DOCUMENT_ROOT"].$_GET["folder"])) {
      if ($dh = opendir($_SERVER["DOCUMENT_ROOT"].$_GET["folder"])) {
       			while (($file = readdir($dh)) !== false) {			 			
           		if ($file != "." && $file != ".." && !ereg("^\.",$file) && !is_dir($_SERVER["DOCUMENT_ROOT"].$_GET['folder']."/".$file)) {?>
              <div>
               
                  <?=$file?>
                  -
                  <?=fsize($_SERVER["DOCUMENT_ROOT"].$_GET['folder']."/".$file)?> 
                  -
                  <?=date("d/m/Y h:i:s",filectime($_SERVER["DOCUMENT_ROOT"].$_GET['folder']."/".$file))?>
                  -
                  <a href="javascript:deleteFile('<?=urlencode($file)?>')">supprimer</a> 
               
                <hr size="1"/>
              </div>
              <?}
            }
          ?>
      <?closedir($dh);
			}
		}
  ?>
</body>
</html>