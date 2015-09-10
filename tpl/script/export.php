<?
require("../../admin/require/function.php");
require("../../conf_front.php");
if($_SESSION["compte_id"]!=""){
  $filename=exportexcel($_GET["template"],$_GET["args"],$_GET["menu"],$_GET["champs"]);
  //lancement du téléchargement du fichier
  header("Pragma: public"); // required
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private",false); // required for certain browsers 
  header("Content-Type: application/force-download");
  // change, added quotes to allow spaces in filenames, by Rajkumar Singh
  header("Content-Disposition: attachment; filename=\"".$filename[1]."\";" );
  header("Content-Transfer-Encoding: binary");
  header("Content-Length: ".filesize($filename[0]));
  readfile($filename[0]);
}
?>