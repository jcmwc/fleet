<?	
require("../../require/function.php");
require("../../require/back_include.php");

$nbelemparpage=50;
$typeElem=$trad["événement"];
$sql="select a.*,u.login login1,u2.login login2,c.nom from ".__racinebd__."arbre a inner join ".__racinebd__."contenu c on a.arbre_id=c.arbre_id and langue_id=1 left join ".__racinebd__."users u on a.users_id_crea=u.users_id left join ".__racinebd__."users u2 on a.users_id_verrou=u2.users_id where a.arbre_id=".$_GET["arbre_id"];
//rajouter le nom francais
$link=query($sql);
$tbl_result=fetch($link);
$TxtTitre=$trad["Informations du noeud"]." \"".$tbl_result["nom"]."\"";
$_GET["mode"]="list";
if($tbl_result["login1"]!=""){
  $TxtSousTitrelist=$trad["Créé par"]." ".$tbl_result["login1"];
}
if($tbl_result["login2"]!=""){
  $TxtSousTitrelist.=$trad["Vérouillé par"]." ".$tbl_result["login2"];
}
$szQuery = "select * from ".__racinebd__."log l left join ".__racinebd__."users u on l.users_id=u.users_id where l.supprimer = 0 and arbre_id=".$_GET["arbre_id"];
$ImgAjout=false;
$tabcolonne=array($trad["Libelle"]=> "libelle",$trad["Utilisateur"]=>"login",$trad["Date"]=>"date_evt");
$tradchamps[]="libelle";
$update=false;
$delete=false;
$search=false;
$notview=true;
$defaultorder="desc";
$defaultcoltri="date_evt";
require("../../include/template_list.php");
?>