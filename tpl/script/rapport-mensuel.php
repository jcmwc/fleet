<?
$_POST["date_jour"]=($_POST["date_jour"]=="")?date('d/m/Y'):$_POST["date_jour"];
if($_POST["date_jour"]!=""){   

  $where.=" and p.time>='".datebdd(jourdebutmois($_POST["date_jour"]))." 00:00:00'";
  $where.=" and p.time<='".datebdd(jourfinmois($_POST["date_jour"]))." 23:59:59'";
}

require("rapport-gen.php");
?>