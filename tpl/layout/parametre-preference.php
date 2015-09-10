    
<!-- DEBUT CONTAINER -->
<div class="container">
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
    <?
    $_GET["mainmenu"]=5;
    cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc">
      <div class="resize pref_bloc">
        <h1 class="bcktitle ajust_title title_agence">Préférences</h1>
        <div class="infobloc_param">
          <div class="left">
            <p>Options disponibles :</p>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="infobloc_param_pref">
          <form id="formPref" name="formPref" class="form_param_lieu" action="<?=urlp($_GET["arbre"])?>?template=preference" method="post" onsubmit="return validerPref();">
          <input type="hidden" name="mode" value="save" />
            <div class="pref_options">
              <label class="spec_label_pref">Délai en minutes entre deux envois de mail (min) :</label>
              <input class="spec_input_pref" type="text" name="delaimail" value='<?=$tbl_preference["delaimail"]?>'>
            </div>
            <!--
            <div class="pref_options">
              <label for="delaisname1">Durée minimale d'un trajet (s) :</label>
              <input id="delaisname1" class="shorts_input_pref" type="text" name="dureemintraj" value='<?=$tbl_preference["dureemintraj"]?>'>
            </div>
            -->
            <div class="pref_options">
              <label for="dureenamesec">Durée minimale d'une attente (s) :</label>
              <input id="dureenamesec" class="shorts_input_pref" type="text" name="dureeminattente" value='<?=$tbl_preference["dureeminattente"]?>'>
            </div>
            <div for="dureenameatt" class='ajout_button_bloc'>
              <input id="dureenameatt" class="submit_butt" type="submit" value="Valider">
            </div>
          </form>          
        </div>
        <?if($msgsave!=""){?>
        <div id="msgform">Changement effectué</div>
        <?}?>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
</div>
<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-preference.js"></script>
   <script src="<?=__racineweb__?>/tpl/js/parametre-menu.js"></script>
    
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
