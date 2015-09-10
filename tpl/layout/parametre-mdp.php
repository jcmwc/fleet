
<!-- DEBUT CONTAINER -->
<div class="container">
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=4;
cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc">
      <div id="content_mdp_param">
        <div class="resize">
          <h1 class="bcktitle ajust_title title_mdp">Modifier mot de passe</h1>
          <div class="mdp_bloc_param">
            <p>Modification : </p>
            <div class="content_form_mdp_param">
              <form name="formMdp" id="formMdp" class="form_mdp_param" action="<?=urlp($_GET["arbre"])?>?template=mdp" method="post" onsubmit="return validerMdp();">
                <div>
                  <label class="left" for="ancien-mdp">Ancien mot de passe</label>
                  <input id="ancien-mdp" class="right" type="password" placeholder="mdp" name="lastmdp">
                </div>
                <div>
                  <label class="left" for="nouveau-mdp">Nouveau mot de passe</label>
                  <input id="nouveau-mdp" class="right" type="password" placeholder="mdp" name="newmdp">
                </div>
                <div>
                  <label class="left" for="confirm-mdp">Confirmation mot de passe</label>
                  <input id="confirm-mdp" class="right" type="password" placeholder="mdp" name="newmdp2">
                </div>
                <div>
                  <input class="right submit_butt" type="submit" value="Valider">
                  <input class="right button_butt" type='button' value="Annuler">
                </div>
              </form>
            </div>
          </div>
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
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-mdp.js"></script>
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
