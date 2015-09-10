<div class="container">
  <!-- CONTENUE FIXE -->
  <?cache_require("rapport-menu.php")?>
 <!-- CONTENU FIXE-->
  <div class="content_flex">
    <div class="main_resize backgroundbloc ajustmargin">
      <div class="resize rapport_km">
        <h1 class="bcktitle ajust_title">Rapport compteurs</h1>
          <div class="content_info_rapport">
            <!--
            <p>Agence : <span>toutes les agences :</span></p>
            -->
            <p>Date : <span><?=$datehier;?></span></p>
          </div>
        <span class="info_rapportkm">
          <p>Cumul total des relevés théoriques : <span><?=$totalkm?></span> km</p>
          <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png"></a>
          <?=showexport("compteurs",array("Nom du Véhicule","Compteur","Kilométrage","Correctif","Relevé théorique"),array("nomvehicule","kminit","km","correctifkm","theorique"))?>
        </span>
      </div>
    </div>
    <div class="bottom_content">
      <table class="tableau_content tableau_comtperapport">
        <tr>
          <th><div class="active_tableau"><a href="#">Nom du Véhicule</a></div></th>
          <!--
          <th><div><a href="#">Immatriculation</a></div></th>
          <th><div><a href="#">Agence</a></div></th>
          -->
          <th><div><a href="#">Compteur*</a></div></th>
          <th><div><a href="#">Kilométrage**</a></div></th>
          <th><div><a href="#">Correctif</a></div></th>
          <th><div><a href="#">Relevé théorique</a></div></th>
        </tr>
        <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
        <tr>
          <td><?=$tbl_list_vehicule[$i]["nomvehicule"]?> <img class="seemore_img"src="<?=__racineweb__?>/tpl/img/plus_ico.png">
            <div class="morecontent_tableau">
              <p>Véhicule : <span class="uppercase font-italic"><?=$tbl_list_vehicule[$i]["marque"]?></span> <?=$tbl_list_vehicule[$i]["modele"]?></p>
              <p>Immatriculation : <span><?=$tbl_list_vehicule[$i]["immatriculation"]?></span></p>
              <p>Type : <span><?=$key_list_type[$tbl_list_vehicule[$i]["type_compte_id"]]?></span></p>
              <p>Catégorie : <span><?=$tbl_list_vehicule[$i]["listcat"]?></span></p>  
            </div>
          </td>
          <!--
          <td>AA905SH</td>
          <td>3F ASSISTANCE</td> -->
          <td><?=$tbl_list_vehicule[$i]["kminit"]?> km</td>
          <td><?=$tbl_list_vehicule[$i]["kmactuel"]?> km</td>
          <td><?=$tbl_list_vehicule[$i]["correctifkm"]?> km</td>     
          <td><?=$tbl_list_vehicule[$i]["theorique"]?> km</td>
        </tr>
        <?}?>
        
      </table>
      <p class="spec_p_rapport">* Relevé compteur à l'installation du boîtier ** Distance parcourue enregistrée par le boîtier depuis son installation.</p>
    </div>
  </div>
</div>
    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/rapport-compteurs.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-menu2.js"></script>
    
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
