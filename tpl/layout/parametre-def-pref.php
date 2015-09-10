    
<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc">
      <div class="resize def_pref_bloc">
        <h1 class="bcktitle ajust_title title_entretien">Personnalisation des paramètres</h1>
        <div class="title_bloc_mp">
          <h2 class="onglet_ajust bcktitle title_pd">Paramètres disponibles</h2>
        </div>
        <div class="content_bloc_dp">
          <form class="form_pd">
            <div class="overflow_content">
              <p class="font-bold">Informations à afficher sur la page de situation de la flotte</p>
              <div>
                <div class="option_title left">
                  <h2>Options sélectionnées</h2>
                </div>
                <div class="option_title right">
                  <h2>Options Disponibles</h2>
                </div>
                <div>
                  <select id='pre-selected-options' multiple='multiple'>
                    <option value='elem_1' >elem 1</option>
                    <option value='elem_2'>elem 2</option>
                    <option value='elem_3' >elem 3</option>
                    <option value='elem_4' >elem 4</option>
                  </select>
                </div>
              </div>
            <div class="overflow_content">
              <p class="font-bold">Options d'affichage</p>
              <div class="content_bloc_oa">
                <p class="overflow_content">
                  <span class="left">Nombre de lignes à afficher sur une page dans les tableaux : </span>
                  <input class="right spec_input_oa" name="" type="text" value="10">
                </p>
                <p class="overflow_content">
                  <input class="left" type="checkbox">
                  <span class="left" for="">Coordonnées géographiques dans l'info-bulle des Lieux * </span>   
                </p>              
              </div>
            </div>
            <div>
              <p class="font-bold">Coordonnés géographiques</p>
              <div class="content_bloc_cg">
                <div class="spec_div_cg">
                  <span class="left">Format des coordonnées géographiques: * </span>
                  <div class="left rowElem">
                    <input type="radio"> Décimaux entiers (ex : 4880050 / 212973)<br>
                    <input type="radio"> Décimaux entiers (ex : 4880050 / 212973)
                    
                  </div>
                </div>             
              </div>
            </div>
            <div class="spec_ita_cg">
              <p>Ces paramètres necéssitent une déconnexion puis reconnexion pour être totalement pris en compte.</p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
</div>
<!-- FIN CONTAINER -->



    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-def-pref.js"></script>
    
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
