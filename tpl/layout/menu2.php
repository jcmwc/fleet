<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="fr" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="fr" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="fr" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr" class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>mister fleet | situation</title>
    <meta name="description" content="">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="stylesheet" href="<?=__racineweb__?>/tpl/css/screen.css">


    <!--[if lte IE 8]><link rel="stylesheet" href="<?=__racineweb__?>/tpl/css/ie.css"><![endif]-->
    <script src="<?=__racineweb__?>/tpl/js/modernizr.min.js"></script>
    
    
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?=__googlekey__?>"></script>
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&client=<?=__googleclient__?>"></script> -->
    
    <link href='http://fonts.googleapis.com/css?family=Economica:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='<?=__racineweb__?>/tpl/fancybox/jquery.fancybox.css' rel='stylesheet' type='text/css'>


  </head>
  <body>
    <?=$news?>
    <div class="main-wrapper">
    <div class="header header-mobile">
      <div class="logo-mobile">
        <a href="<?=urlp(__defaultfather__)?>" class="link-home-mobile"><img alt="Logo Mister fleet" src="<?=__racineweb__?>/tpl/img/logo-mobile.png"></a>

        <a href="#" class="btn-menu-mobile"><img alt="Menu" src="<?=__racineweb__?>/tpl/img/btn-menu-mobile.png"></a>
      </div>
      <div class="menu-wrapper">
        <div class="logo">
          <!--<a href=" <?=urlp(__defaultfather__)?>"><img src="<?=__racineweb__?>/tpl/img/logo.png"></a>-->
          <img src="<?=__racineweb__?>/tpl/img/logo.png">
        </div>
        <div class="main_menu">
          <p class="message_header active_menu">Bienvenue, <?=$_SESSION["raisonsociale"]?></p>
          <div class="main_navigation">
            <ul class="menu">
      <!--    <li><a href="<?=urlp(__defaultfather__)?>" >Accueil</a></li> -->
              <?for($i=0;$i<count($tbl_list)&&$i<3;$i++){
              if(verifdroitid($tbl_list[$i]["note1"])){?>
              <li><a href="<?=urlp($tbl_list[$i]["arbre_id"])?>" <?=($tbl_list[$i]["arbre_id"]==$_GET["arbre"])?"class=\"acitve_menu\"":""?>><?=$tbl_list[$i]["titre1"]?></a></li>
              <?}}?>

            </ul>
            <div class="second_navigation">
              <ul class="menu">
                <?for($i=3;$i<count($tbl_list);$i++){
                if(verifdroitid($tbl_list[$i]["note1"])){?>
                <li><a href="<?=urlp($tbl_list[$i]["arbre_id"])?>" <?=($tbl_list[$i]["arbre_id"]==$_GET["arbre"])?"class=\"acitve_menu\"":""?>><?=$tbl_list[$i]["titre1"]?></a></li>
                <?}}?>
                <li><a href="<?=urlp(__defaultfather__)?>/deco">Déconnexion</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
