    
<div class="container">
<?cache_require("rapport-menu.php")?>
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize rapport_flotte">
      <h1 class="bcktitle ajust_title ">Rapport Mensuel</h1>
      <form class="form_rapport_vehicule" action="<?=urlp($_GET["arbre"])?>" method="post">
      <input type="hidden" value="mensuel" name="template">
      <input type="hidden" value="<?=$_POST["vehicule"]?>" name="vehicule">
        <div class="decale">
         <!--
          <p>
            <label>Nom du véhicule :</label>
           <span>207 INTERVENTION</span>
         </p>
         <p>
          <label>Immatriculation :</label>
           <span>AA905SH</span>
         </p> -->
         <p>
          <label> Mois :</label>
          <span><?=date2month($_POST["date_jour"])?></span>
         </p>
          <p>
            <label>Date : </label>
            <input class="datepicker first_input" type="text" id="datepicker" name="date_jour" value="<?=$_POST["date_jour"]?>">
          </p>
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div> 
      </form>
      <span class="info_rapportkm">
        <!-- 
        <p>Conduite : <span> 06 h 48 </span> min</p>
        <p>Arrêt : <span>39 h 17 </span> min</p>
        <p>Attente : <span> 00 </span> min </p>
        <p>Km début : <span> 90 943 </span>Km</p>
        <p>Km fin : <span> 91 131 </span>Km</p>
        <p>Distance : <span> 188.5 </span>Km</p>
        <p>Consomation théorique (0.0L/100km): <span> 0.0 </span>L</p>
        -->
        <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png"></a>
        <?=showexport("mensuel",array("Date","Début","Fin","Ampl.","Conduite","Arrêt","Distance","Vit.max."),array("date","debut","fin","datediff","conduite","arret","km","vitessemax"))?>
      </span> 
    </div>
  </div>
  <div class="bottom_content">
    <table class="tableau_content tableau_comtperapport tableau_vehicule">
      <tr>
        <th><div class="active_tableau"><a href="#">Date</a></div></th>
        <th><div><a href="#">Début</a></div></th>
        <th><div><a href="#">Fin</a></div></th>
        <th><div><a href="#">Ampl.</a></div></th>
        <th><div><a href="#">Conduite</a></div></th>
        <th><div><a href="#">Arrêt</a></div></th>
        <!-- <th><div><a href="#">Attente</a></div></th> -->
        <th><div><a href="#">Distance</a></div></th>
        <th><div><a href="#">Vit.max.</a></div></th>
        <!-- <th><div><a href="#"><img src="<?=__racineweb__?>/tpl/img/tableau_time.png"></a></div></th> -->
      </tr>
      <?foreach ($semaine as $key => $val){?>
      <tr>
        <td class=""><?=$val["date"]?></td>
        <td><?=affichedatetime($val["debut"])?></td>
        <td><?=affichedatetime($val["fin"])?></td>
        <td><?=$val["datediff"]?></td>
        <td><?=$val["conduite"]?></td>
        <td><?=$val["arret"]?></td>
        <!-- <td><span>00 </span> min</td>  -->
        <td><?=$val["km"]?></td>
        <td><?=$val["vitessemax"]?>km/h</td>
        <!-- <td><img src="<?=__racineweb__?>/tpl/img/tableau_time2.png"></td>-->
      </tr>
      <?}?>
    </table>  
    
  </div>
</div>
    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-menu.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-mensuel.js"></script>
    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
  racineimg="<?=__racineweb__?>";
  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
  e.src='//www.google-analytics.com/analytics.js';
  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','<?=__analytics__?>');ga('send','pageview');
</script>

  </body>
</html>
