    
<div class="container">
<?cache_require("rapport-menu.php")?>
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize rapport_km">
      <h1 class="bcktitle ajust_title">Rapport périodique</h1>
      
      <form class="form_rapportkm" action="<?=urlp($_GET["arbre"])?>" method="post">
      <input type="hidden" value="periodique" name="template">
      <input type="hidden" value="<?=$_POST["vehicule"]?>" name="vehicule">
       <!--
        <div class="first_info_bloc_period">
          <div>Nom du véhicule :</div>
          <div>207 INTERVENTION</div>
       </div>
       <div class="first_info_bloc_period">
          <div>Immatriculation :</div>
         <div>AA905SH</div>
       </div>  -->
        <div>
          <label>Du</label>
          <input class="datepicker first_input" type="text" id="datepicker" name="date_debut" value="<?=$_POST["date_debut"]?>">
          <input class="second_input timepicker" type="text"  name="heure_debut" value="<?=$_POST["heure_debut"]?>">
        </div>
        <div>
          <label>Au</label>
          <input class="first_input datepicker" type="text" name="date_fin" value="<?=$_POST["date_fin"]?>">
          <input class="second_input timepicker" type="text" name="heure_fin" value="<?=$_POST["heure_fin"]?>">
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div>
        <?if($_POST["date_debut"]!=""&&$_POST["date_fin"]!=""){?> 
        <div>
          <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png"></a>
          <?=showexport("periodique",array("Départ","Arrivée","Durée","Distance","Vit.moy.","Vit.max."),array("debuttxt","fintxt","datediff","km","moy","max"))?> 
          <a class="itinery" href="javascript:showmap2()"><img src="<?=__racineweb__?>/tpl/img/itinerary.gif" alt="trajet" title='Trajet'></a>
          <!-- <a href="#"><img src="<?=__racineweb__?>/tpl/img/kml.png"></a> -->
        </div>
        <?}?>
      </form>
    </div>
  </div>
  <?if($_POST["date_debut"]!=""&&$_POST["date_fin"]!=""){?> 
  <div class="bottom_content">
    <div id="map_bloc4" class="map_bloc2">
      <div id="map" class="littlemap2"></div>
    </div> 
    <table class="tableau_content tableau_comtperapport tableau_periodique">
      <tr>
        <th><div class="active_tableau"><a href="#">Trajet n°</a></div></th>
        <th><div><a href="#">Départ</a></div></th>
        <th><div><a href="#">Arrivée</a></div></th>
        <th><div><a href="#">Durée</a></div></th>
        <th><div><a href="#">Distance</a></div></th>
        <th><div><a href="#">Vit.moy.</a></div></th>
        <th><div><a href="#">Vit.max.</a></div></th>
        <!-- <th><div><a href="#">Tpsd'attente</a></div></th>  -->
        <!-- <th><div><a href="#">Tpsd'arrêt</a></div></th>  -->
      </tr>
      <?for($i=0;$i<count($trajet);$i++){
       //$contenttabcoordonnee.="tabcoordonnee.push(new Array(".$trajet[$i]["lat1"].",".$trajet[$i]["lon1"]."));";
       //$contenttabcoordonnee.="tabcoordonnee.push(new google.maps.LatLng(".$trajet[$i]["lat1"].",".$trajet[$i]["lon1"]."));";
      ?>
      <tr>
        <td class=""><?=($i+1)?></td>
        <td><?=$trajet[$i]["debuttxt"]?>
        </td>
        <td><?=$trajet[$i]["fintxt"]?>
        </td>
        <td><?=$trajet[$i]["datediff"]?></td>
        <td><?=$trajet[$i]["km"]?></td>
        <td><?=$trajet[$i]["moy"]?></td>
        <td><?=$trajet[$i]["max"]?></td>
        <!-- <td>-</td> 
        <td><?=$trajet[$i]["arret"]?></td> -->
      </tr>
      <?}?>
    </table>
  </div>
  <?}?>
</div>



    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script>
    var tab=new Array();
    <?=$contenttab?>   
    var tabcoordonnee=new Array();
    <?=$contenttabcoordonnee2?>
    </script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-menu.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-periodique.js"></script>
    
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
