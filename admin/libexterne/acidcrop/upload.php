<?php
include('func.php');

if($_GET['act'] == 'thumb'){

	$arr = array(
	'uploaddir' 	=> 'uploads/',
	'tempdir'		=> 'uploads/temp/',
	'height'		=> $_POST['height'],
	'width'			=> $_POST['width'],
	'x'				=> $_POST['x'],
	'y'				=> $_POST['y'],
	'img_src'		=> $_POST['img_src'],
	'thumb'			=> true
	);
	resizeThumb($arr);
	exit;
}

elseif($_GET['act'] == 'upload'){
	
	$big_arr = array(
	'uploaddir'	=> 'uploads/big/',
	'tempdir'	=> 'uploads/temp/',
	'height'	=> $_POST['height'],
	'width'		=> $_POST['width'],
	'x'			=> 0,
	'y'			=> 0
	);
	
	resizeImg($big_arr);	
}
else
{
	//
}
?>