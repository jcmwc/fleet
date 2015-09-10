
<div class="container">
<?cache_require("rapport-menu.php")?>
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize rapport_flotte">
      <h1 class="bcktitle ajust_title ">Rapport de visite  </h1>
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
            <label>Du : </label>
            <input class="datepicker first_input" type="text" id="datepicker">
          </p>
          <p>
            <label>Au : </label>
            <input class="datepicker first_input" type="text" id="datepicker">
          </p>
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div> 
      </form>
      <span class="info_rapportkm">
        <p>Lieux visités : <span> 3/4</span></p>
        <p>Lieux non visités : <span>1/4</span> </p>
        <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png"></a>
        <a href="#"><img src="<?=__racineweb__?>/tpl/img/telecharger_ico.png"></a> 
      </span>
    </div>
  </div>
  <div class="bottom_content">
    <table class="tableau_content tableau_comtperapport tableau_periodique">
      <tr>
        <th><div class="active_tableau"><a href="#">Lieu</a></div></th>
        <th><div><a href="#">Date</a></div></th>
        <th><div><a href="#">Heure</a></div></th>
        <th><div><a href="#">Durée arrêt</a></div></th>
        <th><div><a href="#">Provenance</a></div></th>
        <th><div><a href="#">Départ</a></div></th>
        <th><div><a href="#">Destination</a></div></th>
        <th><div><a href="#">Lieux non visité</a></div></th>
      </tr>
      <tr>
        <td><img class="left" src="<?=__racineweb__?>/tpl/img//lieux/cross1.gif"><span>INTERMARCHE</span></td>
        <td>01/07/2014</td>
        <td><span>00:55</span></td>
        <td><span>31</span>min</td>
        <td><span class="font-bold">06370 MOUANS-SARTOUX</span></td>
        <td><span>01/07/2014</span><span>01:26</span></td>
        <td><img src="<?=__racineweb__?>/tpl/img/house.gif"><span>P.A.P</span></td>
        <td><img src="<?=__racineweb__?>/tpl/img/lieux/donut1.gif"><span>PC FABRE</span></td>
      </tr>
      <tr>
        <td><img class="left" src="<?=__racineweb__?>/tpl/img/lieux/cross1.gif"><span>INTERMARCHE</span></td>
        <td>01/07/2014</td>
        <td><span>00:55</span></td>
        <td><span>31</span>min</td>
        <td><span class="font-bold">06370 MOUANS-SARTOUX</span></td>
        <td><span>01/07/2014</span><span>01:26</span></td>
        <td><img src="<?=__racineweb__?>/tpl/img/house.gif"><span>P.A.P</span></td>
        <td><img src="<?=__racineweb__?>/tpl/img/lieux/donut1.gif"><span>PC FABRE</span></td>
      </tr>
    </table>  
  </div>
</div>
    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-menu.js"></script>    
    <script src="<?=__racineweb__?>/tpl/js/rapport-visite.js"></script>
    
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
