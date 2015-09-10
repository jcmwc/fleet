<?
require("../require/function.php");
testIpDie();
$notlogpage=1;
if($_GET['deco']){
	unset($_SESSION);
	session_destroy();
}
if($_SESSION['islog']==""){
    require("../include/template_haut_login.php");    
    ?>
    
  <div id="login_container">
	<h1><?=__name__?></h1>
	<div id="login_panel">
		<form action="dashboard.html" method="post" accept-charset="utf-8" name="formlog" onsubmit="verifId(login.value,pwd.value,langue.value);return false">		
			<div class="login_fields">
				<div class="field">
					<label for="email"><?=$trad["Login"]?></label>
					<input type="text" name="login" id="login" value="" tabindex="1" placeholder="email@example.com" />		
				</div>
				
				<div class="field">
					<label for="password"><?=$trad["Mot de passe"]?></label>
					<input type="password" name="pwd" id="pwd" value="" tabindex="2" placeholder="password" />			
				</div>
				<div class="field">
					<label for="langue"><?=$trad["Langue"]?></label>
						<div class="contenaire_champs">
								<select name="langue">
									<option value="fr" <?=(__langueadmin__=="fr")?"selected":""?>>Français</option>
									<option value="en" <?=(__langueadmin__=="en")?"selected":""?>>English</option>
									<option value="pl" <?=(__langueadmin__=="pl")?"selected":""?>>Polski</option>
									<option value="es" <?=(__langueadmin__=="es")?"selected":""?>>Español</option>
								</select>
						</div>
						<div class="clear"></div>
					</div>
			</div> <!-- .login_fields -->
			
			<div class="login_actions">
				<button type="submit" class="btn btn-primary" tabindex="3"><?=$trad["entrer"]?></button>
			</div>
		</form>
	</div> <!-- #login_panel -->		
</div> <!-- #login -->
  <?
  require("../include/template_bas_login.php");
} else if(__light__==true){
  require("../require/back_include.php");
  /*
  require("../include/template_haut_login.php");
  require("../include/template_bas_login.php");
  */
  require("../include/template_haut.php");
  require("../include/template_bas.php");
}else{ 
  require("../require/back_include.php");
  $_GET["mode"]="list";
  $TxtSousTitrelist=$trad["Créé par"]." ".$tbl_result["login1"];
  if($tbl_result["login2"]){
    $TxtSousTitrelist.=" ".$trad["Vérouillé par"]." ".$tbl_result["login2"];
  }
  $nbelemparpage=15;
  $szQuery = "select * from ".__racinebd__."log l inner join ".__racinebd__."contenu c on l.arbre_id = c.arbre_id and c.langue_id = ".__defaultlangueid__." left join ".__racinebd__."users u on l.users_id=u.users_id where l.supprimer = 0";
  $ImgAjout=false;
  $tabcolonne=array($trad["Nom du noeud"]=> "nom",$trad["Libelle"]=> "libelle",$trad["Utilisateur"]=>"login",$trad["Date"]=>"date_evt");
  $tradchamps[]="libelle";
  $update=false;
  $delete=false;
  $search=false;
  $notview=true;
  $defaultorder="desc";
  $defaultcoltri="date_evt";
  $TxtTitre="";
  $TxtSousTitre="";
  $TxtSousTitrelist=$trad["Derniers événements"];
  $typeElem = $trad["événement"];
  require('../include/template_list.php');
}
?>
<script type="text/javascript">

<?php
if($_SESSION['islog']!=""){
?>
if (parent.frames.length < 1){
  document.location.href = '../frame/index.php';
}
<?php
} else {
?>
if (parent.frames.length > 0){
  top.location.href = '../home/index.php';
}
<?php
}
?> 
</script>