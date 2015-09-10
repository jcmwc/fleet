<?php
function resizeImg($arr){
	
	//you can change the name of the file here
	$date 		= md5(time());
	
	//////////// upload image and resize
	
	$uploaddir 	= $arr['uploaddir'];
	$tempdir	= $arr['tempdir'];
	
	
	$temp_name 	= $_FILES['photo']['tmp_name'];
	
	//echo $temp_name;
	
	$img_parts 	= pathinfo($_FILES['photo']['name']);
	if($arr["new_name"]==""){
	$new_name 	= strtolower($date.'.'.$img_parts['extension']);
	}else{
	$new_name = $arr["new_name"];
  }
	$ext = strtolower($img_parts['extension']);
	
	//$allowed_ext = array('gif','jpg','jpeg','png');
	$allowed_ext = array('jpg');
	if(!in_array($ext,$allowed_ext)){
		echo '<p class="uperror">Seul le jpg est autorisé</p>';
		exit;
	}
	
	
		$temp_uploadfile = $tempdir . $new_name;
		$new_uploadfile = $uploaddir . $new_name;
	// less than 1.3MB
		if($_FILES['file']['size'] <   2097000 ){
		      //print $_SERVER["DOCUMENT_ROOT"].$temp_name.",".$_SERVER["DOCUMENT_ROOT"].$temp_uploadfile;
					if (move_uploaded_file($temp_name, $_SERVER["DOCUMENT_ROOT"].$temp_uploadfile)) {
					$size=getimagesize($_SERVER["DOCUMENT_ROOT"].$temp_uploadfile);
					$arr['height']=($arr['height']=="*")?$size[1]:$arr['height'];
					$arr['width']=($arr['width']=="*")?$size[0]:$arr['width'];
					
					//on regarde la taille de resize nécessaire pour qu'il y ait du débord
					list($width_old, $height_old) = $size;
					$factor = $arr['height']/$height_old;
					$factor2 = $arr['width']/$width_old;
					if($factor>$factor2){
            $arr['width']=round($width_old*$factor);
          }else{
            $arr['height']=round($height_old*$factor2);
          }
          //print $arr['height']."/".$arr['width'];
					// add key value to arr
					$arr['temp_uploadfile'] = $temp_uploadfile;
					//$arr['new_uploadfile'] = $new_uploadfile;
					$arr['new_uploadfile'] = $uploaddir .'tbl_'. $new_name;
					
					
					print asidoImg($arr);
					
					//unlink($temp_uploadfile);
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
	if($arr["new_name"]!=""){
	$arr['new_uploadfile'] = $arr['uploaddir'].'tbl_'.$arr["new_name"];
  }else{
	$arr['new_uploadfile'] = $arr['uploaddir'].strtolower($date).'.jpg';
	}
	print asidoImg($arr);
	exit;
}

function asidoImg($arr){
	asido::driver('gd');
	
	$height		= $arr['height'];
	$width		= $arr['width'];
	$x			= $arr['x'];
	$y			= $arr['y'];				
		
	// process
	$i1 = asido::image($_SERVER["DOCUMENT_ROOT"].trim($arr['temp_uploadfile']), $_SERVER["DOCUMENT_ROOT"].trim($arr['new_uploadfile']));	
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
	return $data['photo']."|".$width."|".$height;	
}
function createdefault($input,$table,$id=0){
  //$id=($id=0)?$_GET["id"]:$id;
  //
  /*
  ?>
  <script>alert("<?=$input?> / <?=$_POST[$input]?>")</script>
  <?
  */
  $args=explode(",",$_POST["args_".$input]);
  //print_r($_POST);
  if($id!=0){
    //tbl_1tmp_phantom_content-1.jpg
    //tbl_tmp_phantom_content-1.jpg
    if(file_exists($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tmp_'.$table.$_SESSION['users_id'].'.jpg')){
      rename($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tmp_'.$table.$_SESSION['users_id'].'.jpg',$_SERVER["DOCUMENT_ROOT"].__uploaddir__.$table.$id.'.jpg');
      rename($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_tmp_'.$table.$_SESSION['users_id'].'.jpg',$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$table.$id.'.jpg');
      //on renone les vignettes
      
      for($i=0;$i<$_POST[$input];$i++){
      //tmp_phantom_content-1.jpg
        //if(!file_exists($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.($i+1).'tmp'.$table.$_SESSION['users_id'].'.jpg')){
          //on verifie si la vignette existe
          //tbl_1tmp_phantom_content-1.jpg
          //tbl_1tmp_phantom_content-1.jpg
          if(file_exists($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.($i+1).'tmp_'.$table.$_SESSION['users_id'].'.jpg')){
            //on renome
            rename($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.($i+1).'tmp_'.$table.$_SESSION['users_id'].'.jpg',$_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.($i+1).$table.$id.'.jpg');
          }else{
            $info=explode('/',$args[$i]);
            //on créé la vignette
            $arr['temp_uploadfile']=__uploaddir__.'tbl_'.$table.$id.'.jpg';
            $arr['new_uploadfile']=__uploaddir__.'tbl_'.($i+1).$table.$id.'.jpg';
            $size=getimagesize($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$table.$id.'.jpg');
            $arr['height']=($info[2]=="*")?$size[1]:$info[2];
            $arr['width']=($info[1]=="*")?$size[0]:$info[1];
    	      $arr['x']=($info[1]=="*")?0:($size[0]-$arr['width'])/2;
            $arr['y']=($info[2]=="*")?0:($size[1]-$arr['height'])/2;
            $arr['thumb']=true;
            asidoImg($arr);
          }
        //}
      }
    }
  }else{
    for($i=0;$i<$_POST[$input];$i++){
      //on verifie si la vignette existe
      if(!file_exists($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.($i+1).$table.$_GET["id"].'.jpg')){
        $info=explode('/',$args[$i]);
        //on créé la vignette
        $arr['temp_uploadfile']=__uploaddir__.'tbl_'.$table.$_GET["id"].'.jpg';
        $arr['new_uploadfile']=__uploaddir__.'tbl_'.($i+1).$table.$_GET["id"].'.jpg';
        $size=getimagesize($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'tbl_'.$table.$_GET["id"].'.jpg');
        //print $info[2];
        $arr['height']=($info[2]=="*")?$size[1]:$info[2];
        $arr['width']=($info[1]=="*")?$size[0]:$info[1];
	      $arr['x']=($info[1]=="*")?0:($size[0]-$arr['width'])/2;
        $arr['y']=($info[2]=="*")?0:($size[1]-$arr['height'])/2;
        $arr['thumb']=true;
        //print_r($arr);
        asidoImg($arr);
      }
    }
  }
}
?>