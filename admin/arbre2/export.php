<?
require("../require/function.php");
require("../require/back_include.php");
testsession();
//print dumparbre($_GET["arbre_id"]);

header("Cache-control: private");
ob_start();
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
dumpxml($_GET["arbre_id"]);
print "</xml>";
$streamXML = ob_get_contents();
ob_end_clean();
Header('Content-Type: application/octet-stream');
if(headers_sent())
echo 'Some data has already been output to browser, can\'t send CSV file';
Header('Content-Type: application/xml');
Header('Content-Length: '.strlen($streamXML));
Header('Content-disposition: attachment; filename=dump.xml');
echo $streamXML;
?>