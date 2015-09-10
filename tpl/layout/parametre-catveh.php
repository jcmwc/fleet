
<!-- DEBUT CONTAINER -->
<div class="container">
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=1;
cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc catveh_bloc">
      <div class="resize clearfix">
        <h1 class="bcktitle ajust_title title_agence">Catégories de véhicule</h1>
        <div class="infobloc_param clearfix">
          <div class="left font-bold">Nombres de catégories de véhicule enregistrés : <?=count($tbl_list_categorie)?></div>

        </div>
        <?for($i=0;$i<count($tbl_list_categorie);$i++){?>
        <div class="infobloc_param relative_info_bloc">
          <div>
            <p>Identifiant : <span> <?=$tbl_list_categorie[$i]["categorie_compte_id"]?></span></p>
            <p>Nom : <span> <?=$tbl_list_categorie[$i]["libelle"]?> </span></p>
          </div>
          <div class="clear"></div>
          <form method="post" action="#bas">
            <input type="hidden" name="id" value="<?=$tbl_list_categorie[$i]["categorie_compte_id"]?>" />
            <input class="right submit_butt" type="submit" value="modifier" >
          </form>  
          <?if($tbl_list_categorie[$i]["nb"]==0){?>
          <form method="post" action="#" onsubmit="return confirm('Voulez vous vraiment supprimer cette catégorie')">
            <input type="hidden" name="mode" value="suppr" />
            <input type="hidden" name="id" value="<?=$tbl_list_categorie[$i]["categorie_compte_id"]?>" />
            <input class="left submit_butt" type="submit" value="supprimer" >
          </form>  
          <?}?>    
        </div>
        <div class="clear"></div>
        <?}?>
        <form action="#down">
          <div class="infobloc_param02 clearfix">
            <input id="ajout_cat_veh_button" class="right submit_butt" type="button" value="Ajouter une catégorie de véhicule">
          </div>
        </form>          
      </div>
      
      <?if($msgsave!=""){?>
      <div id="msgform">Sauvegarde effectuée</div>
      <?}?>
      
      <div id="nvl_cat_veh_bloc">
        <a name="down"></a>
        <form id="formCatveh" name="formCatveh" action="<?=urlp($_GET["arbre"])?>?template=catveh" method="post"onsubmit="return validerCatveh();">
        <input type="hidden" name="mode" value="ajout" />
        <div class="resize">
          <h1 class="bcktitle ajust_title title_catveh">Nouvelle catégorie de véhicule</h1>
          <div class="decale">
            <div class="nvl_cat_veh_bloc">
              <label for="name_cat_veh">Nom : </label>
              <input id="name_cat_veh" type="text" name="libelle">
            </div>
            <div class="nvl_cat_veh_bloc">
              <input class="ajouter_param submit_butt" type="submit" value="Ajouter">
              <input id="cancel_cat_veh_bouton" class="annuler_param button_butt" type="button" value="Annuler">  
            </div>
          </div>
        </div>
        </form>
      </div>
      <?if(count($tbl_modif_categorie)>0){?>
      <form action="<?=urlp($_GET["arbre"])?>?template=catveh" method="post">
        <a name="bas"></a>
        <input type="hidden" name="id" value="<?=$tbl_modif_categorie["categorie_compte_id"]?>" />
        <input type="hidden" name="mode" value="modif" />
        <div id="nvl_cat_veh_bloc2">
          <div class="resize clearfix">
            <h1 class="bcktitle ajust_title title_modif_catveh">Modification d'une catégorie de véhicule</h1>
            <div>
              <div class="nvl_cat_veh_bloc">
                <label>Nom : </label>
                <input type="text" name="libelle" value="<?=$tbl_modif_categorie["libelle"]?>">
              </div>
              <div class="nvl_cat_veh_bloc">
                <input class="ajouter_param submit_butt" type="submit" value="Modifier">
                <input id="cancel_cat_veh_bouton2" class="annuler_param submit_butt" type="button" value="Annuler">  
              </div>
            </div>
          </div>
        </div>
      </form>
      <?}?>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
</div>
<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>    
    <script src="<?=__racineweb__?>/tpl/js/parametre-catveh.js"></script>
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
