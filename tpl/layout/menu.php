<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="fr" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="fr" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="fr" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr" class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>mister fleet | Home</title>
    <meta name="description" content="">
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1">
    -->
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="stylesheet" href="<?=__racineweb__?>/tpl/css/screen.css">
    <!--[if lte IE 8]><link rel="stylesheet" href="<?=__racineweb__?>/tpl/css/ie.css"><![endif]-->
    <script src="<?=__racineweb__?>/tpl/js/modernizr.min.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/placeholders.min.js"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?=__googlekey__?>"></script>
    <link href='http://fonts.googleapis.com/css?family=Economica:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <div class="main-wrapper">
    <div class="header_parent">
  <div class="header header-mobile">
    <div class="logo-mobile">
      <a href="<?=urlp(__defaultfather__)?>" class="link-home-mobile"><img alt="Logo Mister fleet" src="<?=__racineweb__?>/tpl/img/logo-mobile.png"></a>

      <a href="#" class="btn-menu-mobile"><img alt="Menu" src="<?=__racineweb__?>/tpl/img/btn-menu-mobile.png"></a>
    </div>
    <div class="menu-wrapper">
      <div class="logo">
        <a href="<?=urlp(__defaultfather__)?>"><img alt="Logo Mister fleet" src="<?=__racineweb__?>/tpl/img/logo.png"></a>
      </div>
      <div class="main_menu">
        <div class="main_navigation">
          <ul class="menu">
            
            <li><a href="<?=urlp(1)?>" class="acitve_menu">Accueil</a></li>
            <li><a href="<?=urlp(17)?>" >Qui sommes nous ?</a></li>
            <li><a href="<?=urlp(12)?>" >Fonctionnement</a></li>
            <li><a href="<?=urlp(13)?>" >Services</a></li>
            <li><a href="<?=urlp(15)?>" >Demande de test gratuit</a></li>
             <li><a href="<?=urlp(18)?>" >M&eacute;tiers</a></li>
          </ul>
        </div>
        <div class="compte_menu">
          <h2>Mon compte</h2>
          <form name="formulaire02" id="formulaire02" action="<?=__racineweb__?>/tpl/script/login.php" onsubmit="return valider02(this);">
              <label class="label_header">Identifiant</label>
              <input name="ident" type="text" placeholder="Identifiant">
              <label class="label_header">Mot de passe</label>
              <input name="mdp" class="input_mdp" type="password" placeholder="Mot de passe">
              <a href=""><img alt="cadenas" src="<?=__racineweb__?>/tpl/img/cadenas_ico.png"></a>
              <input name="connexion" class="connexion left" type="submit" value="Connexion">
          </form>
        </div>
        <div class="contact_menu">
          <h2>Nous contacter</h2>
          <img alt="Contact" src="<?=__racineweb__?>/tpl/img/contact_ico.png" class="left">
          <div class="number_contact">00 00 00 00</div>
        </div>
      
      </div>
      <div class="footer">
        <div class="content_footer">
          <?for($i=0;$i<count($tbl_list);$i++){?>
            <a href="<?=urlp($tbl_list[$i]["arbre_id"])?>"><span><?=$tbl_list[$i]["titre1"]?></span></a>
            <br>
          <?}?>

        </div>
      </div>
    </div>
  </div>
</div>
