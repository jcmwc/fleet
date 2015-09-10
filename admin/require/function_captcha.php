<?
require($_SERVER["DOCUMENT_ROOT"].__racineadminlib__."/securimage/securimage.php");

function captcha($width=280,$height=100,$word=false){
  $img = new securimage();
  //Change some settings
  $img->image_width = $width;
  $img->image_height = $height;
  $img->perturbation = 0.9;
  $img->code_length = rand(5,6);
  $img->image_bg_color = new Securimage_Color("#000000");
  $img->use_transparent_text = true;
  $img->text_transparency_percentage = 25; // 100 = completely transparent
  $img->num_lines = 15;
  $img->wordlist_file = $_SERVER["DOCUMENT_ROOT"].__racineadminlib__."/securimage/words/words.txt";
	$img->gd_font_file  = $_SERVER["DOCUMENT_ROOT"].__racineadminlib__."/securimage/gdfonts/automatic.gdf";
	$img->ttf_file      = $_SERVER["DOCUMENT_ROOT"].__racineadminlib__."/securimage/AHGBold.ttf";
	$img->use_wordlist  = $word;
  $img->image_signature = '';
  $img->text_color = new Securimage_Color("#FFFFFF");
  $img->line_color = new Securimage_Color("#FFFFFF");
  $img->show(''); // alternate use:  $img->show('/path/to/background_image.jpg');
}
function validcaptcha($code){
  $img = new Securimage();
  return $img->check($code);
}
//captcha();
?>