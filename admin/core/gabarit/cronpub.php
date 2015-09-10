<?
require("../../require/function.php");
//vérification des droits
$droit=true;
if($_GET["pere"]==""){
  $droit=testGenRules("RULR");
}
$droit=$droit||testdroitarbre($_GET["arbre_id"],"PUB");
if($droit){
  require("../../include/template_haut.php");
  if($_POST["mode"]=="save"){
  $sql="update ".__racinebd__."arbre set datepublication='".datetimebdd($_POST["datepublication"])."' where arbre_id=".$_GET["arbre_id"];
  $link=query($sql);
  ?>
    <center><?=$trad["L'élément a &eacute;t&eacute; modifi&eacute;"]?></center>
  <?}else{
  $sql="select * from ".__racinebd__."arbre where arbre_id=".$_GET["arbre_id"];
  $link=query($sql);
  $tbl=fetch($link);
  ?>
  <form  target="framecontent" action="<?=$_SERVER["PHP_SELF"]?>?arbre_id=<?=$_GET["arbre_id"]?>&pere=<?=$_GET["pere"]?>" method="post">
  <input type="hidden" name="mode" value="save" />
  <center>
    <?=$trad["Date de publication"]?><br><input type="texte" id="datepublication" name="datepublication" value="<?=affichedatetime($tbl["datepublication"])?>"/><img src="../images/datepopup.gif" id="triggerdatepublication" style="cursor:pointer; cursor:hand;"><br><input type="submit" name="valider" value="<?=$trad["valider"]?>" />
  </center>
  <script type="text/javascript">
      top.calendar[top.calendar.length]={
        inputField  : "datepublication",         // ID of the input field
        ifFormat    : "%d/%m/%Y %H:%M",    // the date format
        showsTime      :    true,
        timeFormat     :    "24",
        button      : "triggerdatepublication"       // ID of the button
      };
  </script>
  </form>  
  <?}
  require("../../include/template_bas.php");
}else{
  require("../../include/template_haut.php"); ?>
  <div id="error">
  <?=$trad["Vous n'avez pas les droits pour effectuer cette action"]?>
  </div>
  <?
  require("../../include/template_bas.php");
}?>