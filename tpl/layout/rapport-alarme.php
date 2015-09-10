<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="fr" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="fr" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="fr" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr" class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>mister fleet | rapport-alarme</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="stylesheet" href="css/screen.css">
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie.css"><![endif]-->
    <script src="js/modernizr.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyC4e8Gsf4BE6SVuZmt7PSdUGXnan-gBx4I"></script>
    <link href='http://fonts.googleapis.com/css?family=Economica:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <div class="main-wrapper">
    <div class="header_compte">
  <div class="logo">
    <a href=""><img src="img/logo.png"></a>
  </div>
  <div class="main_menu">
    <p class="message_header active_menu">Bienvenue, Accueil Taxi d'Eure et Loir</p>
    <div class="main_navigation">
      <ul class="menu">
        <li><a href="#"class="acitve_menu">Accueil</a></li>
        <li><a href="situation.html">Situation de la flotte</a></li>
        <li><a href="cartographie.html">Cartographie</a></li>
        <li><a href="compterapport.html">Rapport</a></li>
      </ul>
      <div class="second_navigation">
        <ul class="menu">
          <li><a href="#">Aide</a></li>
          <li><a href="parametre.html" >Paramètre du compte</a></li>
          <li><a href="index.html">Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
    
<div class="container">
  <div class="main_resize">
    <div class="resize param_comte">
      <h1 class="bcktitle ajust_title">Paramètre du compte</h1>
      <form class="" action="post.php" method="POST">
        <div class="rowElem">
          <label>Agence :</label>
          <select name="select">
            <option value="">Accueuil Taxi d'Eure et Loir</option>
            <option value="opt1">Test 1</option>
          </select>
        </div>
        <div class="rowElem">
          <label>Rapport :</label>
          <select name="select">
            <option value="">Kilométrique</option>
            <option value="opt1">Test 2</option>
          </select>
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div>
      </form>
    </div>
  </div>
  <div class="main_resize backgroundbloc">
    <div class="resize rapport_km" id="rapport-alarme-content">
      <h1 class="bcktitle ajust_title">Rapport d'alarmes</h1>
      <form class="form_rapportkm">
        <div class="first_info_bloc_period">
          <div>Nom du véhicule :</div>
          <div>207 INTERVENTION</div>
       </div>
       <div class="first_info_bloc_period">
          <div>Immatriculation :</div>
         <div>AA905SH</div>
       </div>
        <div>
          <label>Du</label>
          <input class="datepicker first_input" type="text" id="datepicker">
          <input class="second_input timepicker" type="text">
        </div>
        <div>
          <label>Au</label>
          <input class="first_input datepicker" type="text"><input class="second_input timepicker" type="text">
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div> 
        <div>
          <a href="javascript:window.print()"><img src="img/imprimer_ico.png"></a>
          <a href="#"><img src="img/telecharger_ico.png"></a>
        </div>
      </form>
    </div>
  </div>
  <div class="nocontent_rpalarm">Le véhicule n'a pas déclenché d'alarme durant cette pédiore</div>
</div>



    </div><!-- end .main-wrapper -->
    <script src="js/app.js"></script>
    
    <script src="js/rapport-alarme.js"></script>
    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
  e.src='//www.google-analytics.com/analytics.js';
  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','UA-XXXXX-X');ga('send','pageview');
</script>

  </body>
</html>
