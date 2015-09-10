    
<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=1;
cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc" id="tl_bloc">
      <div class="resize clearfix">
        <h1 class="bcktitle ajust_title title_agence">Types de lieux</h1>
        <?if($msgsave!=""){?>
        <div id="msgform">Sauvegarde effectuée</div>
        <?}?>
		<div class="infobloc_param clearfix">
            <div class="left font-bold">Nombre de types de lieux enregistrés :  <?=count($tbl_list_typelieu)?></div>
          </div>
        <div style="clear:both"></div>
        <?for($i=0;$i<count($tbl_list_typelieu);$i++){?>
        <div class="infobloc_param relative_info_bloc">
          <div class="overflow_content">
            <p>Nom : <span> <?=$tbl_list_typelieu[$i]["libelle"]?> </span></p>
            <p>Nb lieux : <span> <?=$tbl_list_typelieu[$i]["nb"]?> </span></p>
          </div>           

          <form method="post" action="#bas">
            <input type="hidden" name="id" value="<?=$tbl_list_typelieu[$i]["type_lieu_compte_id"]?>" />
            <input class="left submit_butt " type="submit" value="modifier" >
          </form>
          <?if($tbl_list_typelieu[$i]["nb"]==0){?>    
          <form method="post" action="#" onsubmit="return confirm('Voulez vous vraiment supprimer ce type de lieu')">
            <input type="hidden" name="mode" value="suppr" />
            <input type="hidden" name="id" value="<?=$tbl_list_typelieu[$i]["type_lieu_compte_id"]?>" />
            <input class="right submit_butt " type="submit" value="supprimer" >
          </form>
          <?}?>
        </div>
        <div style="clear:both"></div>
        <?}?>
        <form  action="#down">
          <div class="infobloc_param02">
            <input id="ajout_tl_button" class="right submit_butt" type="button" value="Ajouter un type de lieu">
          </div>             
        </form>
      </div>
      
      <div id="ajout_nv_tl_bloc" class="resize">
        <form id="formLieux" name="formLieux" action="<?=urlp($_GET["arbre"])?>?template=typeslieux" method="post" onsubmit="return validerLieux();">
          <input type="hidden" name="mode" value="ajout" />
          <a name="down"></a>
          <h1 class="bcktitle ajust_title title_nv_tl">Ajout d'un nouveau type de lieu</h1>
          <div class="infobloc_nv_tl">
            <label for="nameType" class="left font-bold" for="">Nom du type :</label>
            <input id="nameType" class="right" name="libelle" type="text">
          </div>
          <div class="infobloc_nv_tl">
            <input class="right submit_butt" type="submit" value="Valider">
            <input id="cancel_tl_button" class="right submit_butt" type="button" value="Annuler">
          </div>
        </form>
      </div>
      <?if(count($tbl_modif_typelieu)>0){?>
      <form action="<?=urlp($_GET["arbre"])?>?template=typeslieux" method="post">
      <input type="hidden" name="id" value="<?=$tbl_modif_typelieu["type_lieu_compte_id"]?>" />
      <input type="hidden" name="mode" value="modif" />
      <div id="modif_nv_tl_bloc" class="resize">
        <a name="bas"></a>
        <h1 class="bcktitle ajust_title title_nv_tl">Modification d'un type de lieu</h1>
        <div class="infobloc_nv_tl">
          <label class="left font-bold" for="">Nom du type :</label>
          <input class="right" name="libelle" type="text" value="<?=$tbl_modif_typelieu["libelle"]?>">
        </div>
        <div class="infobloc_nv_tl">
          <input class="right submit_butt" type="submit" value="Modifier">
          <input id="cancel_tl_button2" class="right submit_butt" type="button" value="Annuler">
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
    <script src="<?=__racineweb__?>/tpl/js/parametre-typeslieux.js"></script>
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
