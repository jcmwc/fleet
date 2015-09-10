    
<div class="container">
<?cache_require("rapport-menu.php")?>
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize rapport_flotte02">
      <h1 class="bcktitle ajust_title ">Rapport de flotte hebdomadaire</h1>

      <form class="form_rapport_flotte02" action="<?=urlp($_GET["arbre"])?>" method="post">
      <input type="hidden" value="flotte02" name="template">
      <input type="hidden" value="<?=$_POST["agence"]?>" name="agence">
        <div>
          <!-- <p>Agence : <span>toutes les agences</span></p>  -->
          <p class="left spec_p_rpfl02">
            <label>Semaine : <span><?=date2week($_POST["date_jour"])?></label>
          </p>
          <p class='left'>
          <label>Date : </label>
          <input class="datepicker first_input" type="text" id="datepicker" name="date_jour" value="<?=$_POST["date_jour"]?>">
          </p>
          <div style="clear:both"></div>
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div> 
      </form>
      <span class="info_rapportkm">
        <p>Conduite : <span> <?=secondsToTime($totalallconduite)?> </span></p>
        <p>Arrêt : <span> <?=secondsToTime($totalallarret)?> </span></p>
        <!-- <p>Attente : <span> 00 </span> min </p> -->
        <p>Distance : <span> <?=$totalalldistance?> </span>Km</p>
        
        <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png"></a>
        <?=showexport("flotte02",array("Nom","Activité","Conduite","Arrêt","Distance","Vit.max.","Conso."),array("nomvehicule","amplitude","datediff","arret","km","vitesse","conso"))?>
      </span>
    </div>
  </div>
  <div class="bottom_content">
    <table class="tableau_content tableau_comtperapport">
      <tr>
        <th><div class="active_tableau"><a href="#">Nom</a></div></th>
        <!--<th><div><a href="#">Immat.</a></div></th>
        <th><div><a href="#">Agence</a></div></th>--> 
        <th><div><a href="#">Activité</a></div></th>  
        <th><div><a href="#">Conduite</a></div></th>
        <th><div><a href="#">Arrêt</a></div></th>
       <!-- <th><div><a href="#">Attente</a></div></th> -->
        <th><div><a href="#">Distance</a></div></th>
        <th><div><a href="#">Vit.max.</a></div></th>
        <th><div><a href="#">Conso.</a></div></th>
      </tr>
      <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
      <tr>
        <td class=""><?=$tbl_list_vehicule[$i]["nomvehicule"]?> <img class="seemore_img"src="<?=__racineweb__?>/tpl/img/plus_ico.png">
          <div class="morecontent_tableau">
            <p>Véhicule : <span class="uppercase font-italic"><?=$tbl_list_vehicule[$i]["marque"]?></span> <?=$tbl_list_vehicule[$i]["modele"]?></p>
            <p>Immatriculation : <span><?=$tbl_list_vehicule[$i]["immatriculation"]?></span></p>
            <p>Type : <span><?=$key_list_type[$tbl_list_vehicule[$i]["type_compte_id"]]?></span></p>
            <p>Catégorie : <span><?=$tbl_list_vehicule[$i]["listcat"]?></span></p>  
          </div>
        </td>        
        <td><?=$tbl_list_vehicule[$i]["amplitude"]?></td>
        <td><?=$tbl_list_vehicule[$i]["datediff"]?></td>
        <td><?=$tbl_list_vehicule[$i]["arret"]?></td>
        <<td><?=$tbl_list_vehicule[$i]["km"]?> km</td>
        <td><?=$tbl_list_vehicule[$i]["vitesse"]?> km/h</td>
        <td><?=$tbl_list_vehicule[$i]["consotheorique"]*((int)$tbl_list_vehicule[$i]["km"])/100?> L</td>
      </tr>
      <?}?>
    </table>
  </div>
</div>



    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-menu2.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-flotte02.js"></script>
    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
  var racineimg='<?=__racineweb__?>';
  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
  e.src='//www.google-analytics.com/analytics.js';
  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','<?=__analytics__?>');ga('send','pageview');
</script>

  </body>
</html>
