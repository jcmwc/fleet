<?
  require("../../require/function.php");
  require("../../require/back_include.php");
  //print_r($_POST);
  //print_r($_GET);
  //$imageData=$_POST["img"];

  $fp = fopen('data.txt', 'wb' );
  fwrite( $fp, print_r($_POST,true));
  fwrite( $fp, print_r($_GET,true));
  fclose( $fp );
  $imageData="";
  //print count($_POST["img"]);
  for($i=0;$i<count($_POST["img"]);$i++){
    $imageData.=$_POST["img"][$i];
  }
  //print $imageData;
  $filteredData=substr($imageData, strpos($imageData, ",")+1);
  $unencodedData=base64_decode($filteredData);  
  $fp = fopen($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'file.png', 'wb' );

  
  fwrite( $fp, $unencodedData);
  fclose( $fp );
  $image = imagecreatefrompng($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'file.png');
  imagejpeg($image, $_SERVER["DOCUMENT_ROOT"].__uploaddir__.'file.jpg', '100');
  imagedestroy($image);

  //génération du pdf
  $pdf=new HTML2FPDF();
  $pdf->SetFont('Arial','',11);
  $pdf->AddPage();
  $pdf->Text(5, 10, $_POST["urlpage"]);
  $pdf->Text(170, 10, date("d/m/Y H:i:s"));
  $pdf->Image($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'file.jpg',5,20,200);
  $pdf->Output($_SERVER["DOCUMENT_ROOT"].__uploaddir__.'doc.pdf');
  //$pdf->Output();
  
?>
<center><a href="<?=__uploaddir__?>doc.pdf"><?=$trad["Cliquez ici pour voir le pdf"]?></a></center>