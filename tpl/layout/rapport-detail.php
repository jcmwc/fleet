    
<div class="container">
<?cache_require("rapport-menu.php")?>
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize rapport_flotte">
      <h1 class="bcktitle ajust_title ">Rapport detaillé  </h1>
      <form class="form_rapport_vehicule">
        <div class="decale">
          <p>
            <label>Nom du véhicule :</label>
           <span>207 INTERVENTION</span>
         </p>
         <p>
          <label>Immatriculation :</label>
           <span>AA905SH</span>
         </p>
          <p>
            <label>Date : </label>
            <input class="datepicker first_input" type="text" id="datepicker">
          </p>
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div> 
      </form>
      <div class="info_rapportkm">
        <a class="itinery" href="javascript:showmap2()"><img src="<?=__racineweb__?>/tpl/img/itinerary.gif" alt="trajet" title='Trajet'></a>
        <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png" alt='imprimer' title="Imprimer"></a>
      </div>
    </div>
  </div>
  <div class="bottom_content">
    <div id="map_bloc2" class="map_bloc2">
      <div id="map" class="littlemap2"></div>
    </div> 
    <div class="font-bold title_etat_veh_rpdetail left"><h2>Liste des états du véhicule</h2></div>
    <table class="tableau_content tableau_comtperapport tableau_periodique">
      <tr>
        <th><div class="active_tableau"><a href="#">Etat</a></div></th>
        <th><div><a href="#">Heure</a></div></th>
        <th><div><a href="#">Lieu</a></div></th>
        <th><div><a href="#">Latitude</a></div></th>
        <th><div><a href="#">Longitude</a></div></th>
        <th><div><a href="#">Vitesse</a></div></th>
      </tr>
      <tr>
        <td><img class="left" src="<?=__racineweb__?>/tpl/img/carre_rouge.png"><span>Arrêt moteur</span></td>
        <td>01:05:47</td>
        <td><img src="<?=__racineweb__?>/tpl/img/lieux/cross1.gif"><span>INTERMARCHE</span></td>
        <td><span>4364492</span></td>
        <td><span>688751</span> </td>
        <td><span>0</span>km/h</td>
      </tr>
      <tr>
        <td><img class='left' src="<?=__racineweb__?>/tpl/img/carre_jaune.png"><span>Démarrage moteur</span></td>
        <td>01:05:47</td>
        <td><img src="<?=__racineweb__?>/tpl/img/house.gif"><span>P.A.P</span></td>
        <td><span>4364492</span></td>
        <td><span>688751</span> </td>
        <td><span>0</span>km/h</td>
      </tr>
    </table>  
  </div>
</div>
    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-menu.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-detail.js"></script>
    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
  racineimg="<?=__racineweb__?>";
  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
  e.src='//www.google-analytics.com/analytics.js';
  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','UA-XXXXX-X');ga('send','pageview');
</script>

  </body>
</html>
