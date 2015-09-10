<?php
/**

 * AjaxCrop version 0.6
 * version 0.5
 *
 * Copyright (c) 2009-2010 Keith Levi Lumanog
 * www.keithics.com . webmaster@keithics.com
 * DUAL LICENSE - MIT (MIT.TXT) AND GNL (GNL.TXT)
 *
 * portfolio: http://keithics.com/gallery.php
 *
 *
**/

function resizeImg($arr){
	
	//you can change the name of the file here
	$date 		= md5(time());
	
	//////////// upload image and resize
	
	$uploaddir 	= $arr['uploaddir'];
	$tempdir	= $arr['tempdir'];
	
	
	$temp_name 	= $_FILES['photo']['tmp_name'];
	
	//echo $temp_name;
	
	$img_parts 	= pathinfo($_FILES['photo']['name']);
	$new_name 	= strtolower($date.'.'.$img_parts['extension']);
	
	$ext = strtolower($img_parts['extension']);
	
	$allowed_ext = array('gif','jpg','jpeg','png');
	if(!in_array($ext,$allowed_ext)){
		echo '<p class="uperror">Please upload again. Only GIF, JPG and PNG files please.</p>';
		exit;
	}
	
	
		$temp_uploadfile = $tempdir . $new_name;
		$new_uploadfile = $uploaddir . $new_name;
	
	// less than 1.3MB
		if($_FILES['file']['size'] <   2097000 ){
					if (move_uploaded_file($temp_name, $temp_uploadfile)) {
					
					// add key value to arr
					$arr['temp_uploadfile'] = $temp_uploadfile;
					$arr['new_uploadfile'] = $new_uploadfile;
					
					asidoImg($arr);
					
					unlink($temp_uploadfile);
					exit;
					}
		}
		else
		{
			echo '<p class="uperror">Please upload again. Maximum filesize is 1.3MB.</p>';
			exit;
		}

}


function resizeThumb($arr){
	
	$date = md5(time());	
	$arr['temp_uploadfile'] = $arr['img_src'];
	$arr['new_uploadfile'] = $arr['uploaddir'].strtolower($date).'.jpg';
	
	asidoImg($arr);
	exit;
}

function asidoImg($arr){
		
	include('asido/class.asido.php');
	asido::driver('gd');
	
	$height		= $arr['height'];
	$width		= $arr['width'];
	$x			= $arr['x'];
	$y			= $arr['y'];				
		
	// process
	$i1 = asido::image($arr['temp_uploadfile'], $arr['new_uploadfile']);	
	// fit and add white frame										
	if($arr['thumb'] === true){
		Asido::Crop($i1, $x, $y, $width, $height);

	}
	else{
		Asido::Frame($i1, $width, $height, Asido::Color(255, 255, 255));			
	}

	// always convert to jpg	
	Asido::convert($i1, 'image/jpg');

	$i1->Save(ASIDO_OVERWRITE_ENABLED);
		$data = array(
		'photo'=> $arr['new_uploadfile']
	  );
		// echo $user_id;
	// delete old file
	echo $data['photo'];	

}

?>