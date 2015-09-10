<!-- DEBUT CONTAINER -->
<div class="container">
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
    <?
    $_GET["mainmenu"]=1;
    cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc">
      <div id="onglet_agence_bloc">
        <div class="resize">
          <h1 class="bcktitle ajust_title title_agence">Agence</h1>
          <div class="infobloc_param clearfix">
            <div class="left">
              <p>Nombre d'agence enregistrées : <span><?=count($tbl_list_agence)?></span></p>
            </div>
          </div>
          <?for($i=0;$i<count($tbl_list_agence);$i++){?>
          <div class="infobloc_param relative_info_bloc">
            <div>
              <p>Nom : <span><?=$tbl_list_agence[$i]["libelle"]?></span></p>
              <p>Identifiant : <span><?=$tbl_list_agence[$i]["agence_compte_id"]?></span></p>
              <p>Statut : <span><?=($tbl_list_agence[$i]["principal"]==1)?"Principal":"Secondaire"?></span></p>
            </div>
            <form method="post" action="#bas">
              <input type="hidden" name="id" value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" />
              <input class="right submit_butt position_input" type="submit" value="modifier" >
              </form>
          </div>
          <?}?>
            <div class="infobloc_param clearfix">
              <input id="ajout_agence_button01" class="right submit_butt" type="button" value="Ajouter">
            </div>
        </div>
        <?if($msgsave!=""){?>
        <div id="msgform">Sauvegarde effectuée</div>
        <?}?>
        
        <div id="onglet_nvl_agence_bloc" class="resize agencebloc onglet_nvl_agence_bloc">
          <form id="formAgence" name="formAgence" action="<?=urlp($_GET["arbre"])?>?template=default" method="post" onsubmit="return validerAgence();">
          <input type="hidden" name="mode" value="ajout" />
            <h1 class="bcktitle ajust_title title_agence">Nouvelle agence</h1>
            <div class="nvlagence_bloc">
              <span>
                <label for="agence_name">Nom</label>
                <input id="agence_name" class="agencename_input" type="text" placeholder="Nom de l'agence" name="libelle">
              </span>
              <span>
                <label>Principal</label>
                <input type="checkbox" name="principal" value="1">
              </span>
              <input class="ajouter_param submit_butt" type="submit" value="Ajouter">
              <input id="cancel_agence_bouton" class="annuler_param submit_butt" type="button" value="Annuler">
            </div>
        </form>
        </div>
        <?if(count($tbl_modif_agence)>0){?>
        <form action="<?=urlp($_GET["arbre"])?>?template=default" method="post">
        <input type="hidden" name="id" value="<?=$tbl_modif_agence["agence_compte_id"]?>" />
        <input type="hidden" name="mode" value="modif" />
        <div id="onglet_nvl_agence_bloc2" class="resize agencebloc">
          <a name="bas"></a>
          <h1 class="bcktitle ajust_title title_agence">Modifier agence</h1>
          <div class="nvlagence_bloc">
            <span>
              <label>Nom</label>
              <input class="agencename_input" type="text" placeholder="Nom de l'agence" name="libelle" value="<?=$tbl_modif_agence["libelle"]?>">
            </span>
            <span>
              <label>Principal</label>
              <input type="checkbox" name="principal" value="1" <?=($tbl_modif_agence["principal"]==1)?"checked":""?>>
            </span>
            <input class="ajouter_param submit_butt" type="submit" value="Modifier">
            <input id="cancel_agence_bouton2" class="annuler_param submit_butt" type="button" value="Annuler">
          </div>
        </div>
        </form>
        <?}?>
      </div>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
</div>
<!-- FIN CONTAINER -->
    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/parametre.js"></script>
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
