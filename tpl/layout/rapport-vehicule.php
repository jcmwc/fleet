   
<div class="container">
<?cache_require("rapport-menu.php")?>
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize rapport_flotte">
      <h1 class="bcktitle ajust_title ">Rapport véhicule</h1>
      <form class="form_rapport_vehicule" action="<?=urlp($_GET["arbre"])?>" method="post">
      <input type="hidden" value="vehicule" name="template">
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
         </p>
         <p>
          <label>Agence :</label>
           <span>3F ASSISTANCE</span>
         </p>
         -->
          <p>
            <label>Date : </label>
            <input class="datepicker first_input" type="text" id="datepicker" name="date_jour" value="<?=$_POST["date_jour"]?>">
          </p>
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div> 
      </form>
        <!-- <a href=""><img src="<?=__racineweb__?>/tpl/img/help.gif"></a> -->
        <?=showexport("vehicule",array("Départ","Arrivée","Durée","Distance","Vit.moy.","Vit.max.","Arrêt"),array("debuttxt","fintxt","datediff","km","moy","max","arret"))?>
        <a class="itinery" href="javascript:showmap2()"><img src="<?=__racineweb__?>/tpl/img/itinerary.gif" alt="trajet" title='Trajet'></a>
        <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png"></a>
        
        
    </div>
  </div>
  <div class="bottom_content">
    <div id="map_bloc3" class="map_bloc2">
      <div id="map" class="littlemap2"></div>
      
      <div class='legende overflow_content'>
        <div class="left_legende overflow_content left">
          <div class="legende_bloc_veh">
            <span class="font-bold left"></span>
            <span><img src="<?=__racineweb__?>/tpl/img/green_flag.gif">Départ</span>
            <span><img src="<?=__racineweb__?>/tpl/img/orange_flag.gif">Etape</span>
            <span><img src="<?=__racineweb__?>/tpl/img/red_flag.gif">Arrivée</span>
            <!--
            <span><img src="<?=__racineweb__?>/tpl/img/route.gif">Trajet</span>
            <span><img src="<?=__racineweb__?>/tpl/img/selected_route.gif">Trajet sélectionné</span>
            <span><img src="<?=__racineweb__?>/tpl/img/red_zone.gif">Vitesse (km/h)></span>
            <input type="text" value="131">
            <input type="button" value="OK" class="wbg_input spec_ok_butt_rpveh">
            -->
          </div>
         <!--
          <div class="input_bloc_rappveh">
            <input type="button" value="Centrer sur le parcours entier" class="wbg_input">
            <input type="button" value="Centrer sur le trajet sélectionné" class="wbg_input">
            <input type="button" value="Annulr sélection" class="wbg_input">
          </div> -->
        </div>
        <!--
        <div class="right_legende overflow_content left">
          <div>
            <img src="<?=__racineweb__?>/tpl/img/flag.gif">
            <span>Cliquez gauche sur la carte pour planter le drapeau</span>
          </div>
        </div>-->
      </div> 
    </div> 
    <table class="tableau_content tableau_comtperapport tableau_vehicule">
      <tr>
        <th><div class="active_tableau"><a href="#">N°</a></div></th>
        <th><div><a href="#">Départ</a></div></th>
        <th><div><a href="#">Arrivée</a></div></th>
        <th><div><a href="#">Durée</a></div></th>
        <th><div><a href="#">Dist(km)</a></div></th>
        <th><div><a href="#">Vit.moy.(km/h)</a></div></th>
        <th><div><a href="#">Vit.max (km/h)</a></div></th>
        <!-- <th><div><a href="#">Attente</a></div></th>--> 
        <th><div><a href="#">Arrêt (Min)</a></div></th>
      </tr>
      <?
      for($i=0;$i<count($trajet);$i++){
       //$contenttabcoordonnee.="tabcoordonnee.push(new Array(".$trajet[$i]["lat1"].",".$trajet[$i]["lon1"]."));";
      //print "ici"; 
      ?>
      <tr onmouseover="changecouleur(<?=$i?>)" onmouseout="hidecouleur(<?=$i?>)">
        <td class=""><?=($i+1)?></td>
        <td>
        <?=$trajet[$i]["debuttxt"]?>
        </td>
        <td>
        <?=$trajet[$i]["fintxt"]?>
        </td>
        <td><?=$trajet[$i]["datediff"]?></td>
        <td><?=$trajet[$i]["km"]?></td>
        <td><?=$trajet[$i]["moy"]?></td>
        <td><?=$trajet[$i]["max"]?></td>
        <!-- <td>-</td>    -->
        <td><?=$trajet[$i]["arret"]?></td> 
      </tr>
      <?}?>
      
    </table>
  </div>
</div>
    </div><!-- end .main-wrapper -->
    <script>
    var tab=new Array();
    <?=$contenttab?>   
    var tablist=new Array();
    <?=$contenttabcoordonnee?>
    </script>
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-menu.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-vehicule.js"></script>
    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
  var racineimg="<?=__racineweb__?>";
  
  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
  e.src='//www.google-analytics.com/analytics.js';
  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','UA-XXXXX-X');ga('send','pageview');
</script>

  </body>
</html>
