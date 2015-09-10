<?
//largeur 480px hauteur 20px

header("Content-type: image/png");
$string = $_GET['text'];
$im     = imagecreate(480,20);
/*
$orange = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
imagestring($im, 3, $px, 9, $string, $orange);
*/
$background_color = imagecolorallocate($im, 255, 255, 255);
//gestion de la couleur
//imagecolorallocate ( resource $image , int $red , int $green , int $blue )
$couleur=imagecolorallocate ( $im , 255 ,0 ,0 );
//bool imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
imagefilledrectangle ( $im , 20 ,0 , 40 , 20 , $couleur );

imagepng($im);
imagedestroy($im);
?>