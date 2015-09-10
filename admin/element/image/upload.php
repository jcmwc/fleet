<?php
require("../../require/function.php");
//print $_GET['act'];
if($_GET['act'] == 'thumb'){

	$arr = array(
	'uploaddir' 	=>__uploaddir__,
	'tempdir'		=> __uploaddir__,
	'height'		=> $_POST['height'],
	'width'			=> $_POST['width'],
	'x'				=> $_POST['x'],
	'y'				=> $_POST['y'],
	'img_src'		=> $_POST['img_src'],
	'thumb'			=> true,
	'new_name' => $_POST['indice'].$_POST['newname'].'.jpg'
	);
	resizeThumb($arr);
	exit;
}

elseif($_GET['act'] == 'upload'){
  
  $filename=$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$_POST['racine'].".jpg";
  @unlink($filename);
  $filename=$_SERVER["DOCUMENT_ROOT"].__uploaddir__."tbl_".$_POST['racine'].".jpg";
  @unlink($filename);
  for($i=1;$i<$_POST['nb']+1;$i++){
    $filename=$_SERVER["DOCUMENT_ROOT"].__uploaddir__."tbl_".$i.$_POST['racine'].".jpg";
    @unlink($filename);
  }
	$big_arr = array(
	'uploaddir'	=> __uploaddir__,
	'tempdir'	=> __uploaddir__,
	'height'	=> $_POST['height'],
	'width'		=> $_POST['width'],
	'x'			=> 0,
	'y'			=> 0,
	'new_name' => $_POST['newname'].'.jpg'
	);
	
	resizeImg($big_arr);	
}
else
{
	//
}
?>