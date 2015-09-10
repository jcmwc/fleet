<?print '<?xml version="1.0" encoding="utf-8" ?>';?> 
<Styles>
<?
$filename=$_SERVER["DOCUMENT_ROOT"].$_SERVER["QUERY_STRING"];
$handle = fopen($filename, "rb");
$contents = fread ($handle, filesize ($filename));
fclose ($handle);
$myarray=split("}",$contents);
for($i=0;$i<count($myarray)-1;$i++){
ereg ("\.([a-zA-Z0-9].*){",$myarray[$i],$regs);
//ereg ("[a-zA-Z0-9]",$myarray[$i],$regs);
if($regs[1]!=""){
?>
	<Style name="<?=$regs[1]?>" element="span">
		<Attribute name="class" value="<?=$regs[1]?>" />
	</Style>
<?}}?>
</Styles>