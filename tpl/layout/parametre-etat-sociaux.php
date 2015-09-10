    
<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?cache_require("parametre-menu.php")?>
    <div class="main_resize backgroundbloc relative_info_bloc etat-moteur_bloc">
      <div class="resize">
        <h1 class="bcktitle ajust_title title_entretien">Paramétrage des états sociaux</h1>
        <div class="infobloc_param_lieu">  
        <table class="tableau_etat_moteur">
          <tr>
            <th><div><a href="#">Etat</a></div></th>
            <th><div><a href="#">Nom</a></div></th>
            <th><div><a href="#">Couleur</a></div></th>
            <th><div class="th_modif"><a href="#"></a></div></th>
          </tr>
          <div class="tr_bloc">
            <tr>
                <td class="">Aucune activité</td>
                <td>Aucune activité </td>
                <td></td>
                <td class="modif_em_bloc2"><a href="#">Modifier</a></td>
            </tr>
            </div>
           <tr>
            <td class="">Vie privée</td>
            <td>Vie privée</td>
            <td><img src="img/carre_rouge.png"></td>
            <td class"modif_em_bloc2"><a href="#">Modifier</a></td>
          </tr>
          <tr>
            <td class="">Conduite</td>
            <td>Conduite</td>
            <td><img src="img/carre_vert.png"></td>
            <td class="modif_em_bloc2"><a href="#">Modifier</a></td>
          </tr>
          <tr>
            <td class="">Travail</td>
            <td>Travail</td>
            <td><img src="img/carre_bleu.png"></td>
            <td class="modif_em_bloc2"><a href="#">Modifier</a></td>
          </tr>
          <tr>
            <td class="">Repos</td>
            <td>Repos</td>
            <td><img src="img/carre_orange.png"></td>
            <td class="modif_em_bloc2"><a href="#">Modifier</a></td>
          </tr>
          <tr>
            <td class="">Attente</td>
            <td>Attente</td>
            <td><img src="img/carre_jaune.png"></td>
            <td class="modif_em_bloc2"><a href="#">Modifier</a></td>
          </tr>
        </table>       
        </div>
      </div>
      <div class="resize" id="modif_etat_sociaux">
        <h1 class="bcktitle ajust_title title_nv_tl">Mise à jour d'un état social</h1>
        <div class="decale">
          <div class="infobloc_modif_em">
            <label>Etat</label>
            <input value="Moteur éteint" disabled> 
          </div>
          <div class="infobloc_modif_em">
            <label>Nom</label>
            <input value="Moteur éteint"> 
          </div>
          <div class="infobloc_modif_em_spec_colorpicker">
            <label>Icône</label>
              <div class="left spec_span_ch_icon modif_icon"><a href="#">Choisir une couleur</a></div>
              <div id="customWidget">
                <div id="colorSelector2">
                  <div style="background-color: #00ff00"></div>
                </div>
                <div id="colorpickerHolder2"></div>
              </div>  
          </div>
          <div class="infobloc_modif_em_spec_input">
            <input type='submit' class="right submit_butt" value="Valider">
            <input id="cancel_butt_em" type='button' class="right submit_butt" value="Annuler">
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
</div>
<!-- FIN CONTAINER -->



    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-etat-sociaux.js"></script>
    
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

