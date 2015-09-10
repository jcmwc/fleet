<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=1;
cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc tv_bloc relative_info_bloc">
      <div class="resize clearfix">
        <h1 class="bcktitle ajust_title title_agence">Type de véhicule</h1>
        <div class="infobloc_param clearfix">
          <div class="left font-bold">Nombre de types de véhicule enregistrés :  <?=count($tbl_list_type)?></div>
        </div>
        <?for($i=0;$i<count($tbl_list_type);$i++){?>
        <div class="infobloc_param02">
          <div>
            <p>Identifiant : <span> <?=$tbl_list_type[$i]["type_compte_id"]?> </span></p>
            <p>Nom : <span><?=$tbl_list_type[$i]["libelle"]?></span></p>
            <p>Icône : <span> <?if($tbl_list_type[$i]["icon"]!=""){?><img src="<?=__racineweb__?>/tpl/img/vehicules/<?=$tbl_list_type[$i]["icon"]?>"><?}?> </span></p>
            <p>Consommation (L/100km) : <span> <?=$tbl_list_type[$i]["consommation"]?></span></p>
            <p>Vitesse d'attente (Km/h) : <span> <?=$tbl_list_type[$i]["vitesseattente"]?></span></p>
          </div>
          <div class="clearfix">
            <form method="post" action="<?=urlp($_GET["arbre"])?>?template=tv#bas">
            <input type="hidden" name="id" value="<?=$tbl_list_type[$i]["type_compte_id"]?>" />
            <input class="right submit_butt" type="submit" value="modifier">
            </form>
            <form method="post" action="<?=urlp($_GET["arbre"])?>?template=tv" onsubmit="return deletetv()">
            <input type="hidden" name="id" value="<?=$tbl_list_type[$i]["type_compte_id"]?>" />
            <input type="hidden" name="mode" value="delete" />
            <input id="delete_butt_tv" class="right submit_butt input_supp_param_user" type="submit" value="supprimer">
            </form>
          </div>
        </div>
        <?}?>
        <form class="infobloc_param02 clearfix" method="post" action="<?=urlp($_GET["arbre"])?>?template=tv#bas">
          <input type="hidden" name="mode" value="add" />
          <input id="ajout_tv_button" class="right submit_butt" type="submit" value="Ajouter un type de véhicule">
        </form>
        <?if($msgsave!=""){?>
        <div id="msgform"><?=$msgsave?></div>
        <?}?>    
        <br><br>     
      </div>
      <div id="nv_tv_bloc" class="resize relative_info_bloc" <?=(count($tbl_modif_type)>0||$_POST["mode"]=="add")?"style=\"display:block\"":"style=\"display:none\""?>>
        <a name="bas"></a>
        <form id="formTv" name="formTv" action="<?=urlp($_GET["arbre"])?>?template=tv" method="post" onsubmit="return validerTv();">
          <?if(count($tbl_modif_type)>0){?>
            <input type="hidden" name="id" value="<?=$tbl_modif_type["type_compte_id"]?>" />
            <input type="hidden" name="mode" value="modif" />
            <h1 class="bcktitle ajust_title title_nv_tl">Modification d'un type de véhicule</h1>
          <?}else{?>
            <input type="hidden" name="mode" value="ajout" />
            <h1 class="bcktitle ajust_title title_nv_tl">Nouveau type de véhicule</h1>
          <?}?>
            <div class="decale">
              <div class="infobloc_tv">
                <label class="left font-bold" for="nametv">Nom :</label>
                <input id="nametv" class="right spec_inp_tv" name="libelle" type="text" value="<?=$tbl_modif_type["libelle"]?>">
              </div>
              <div class="infobloc_tv">
                <label class="left font-bold" for="consom_tv">Consommation :</label>
                <span class="right">(L/100km)</span>
                <input id="consom_tv" class="right" name="consommation" type="text" value="<?=$tbl_modif_type["consommation"]?>">
              </div>
              <div class="infobloc_tv">
                <label class="left font-bold" for="vit_tv">Vitesse d'attente :</label>
                <span class="right">(Km/h)</span>
                <input id="vit_tv" class="right" name="vitesseattente" type="text" value="<?=$tbl_modif_type["vitesseattente"]?>">
              </div>
              <div class="bloc_change_icon">
                <label class="left font-bold" for="icon">Icône :</label>
                <input type="hidden" name="icon" id="icon" value="<?=$tbl_modif_type["icon"]?>" />
                <?if($tbl_modif_type["icon"]!=""){?>
                <img class="left" id="imgicon" src="<?=__racineweb__?>/tpl/img/vehicules/<?=$tbl_modif_type["icon"]?>">
                <?}else{?>
                <img class="left" id="imgicon" src="<?=__racineweb__?>/tpl/img/pix.png">
                <?}?>
                <div class="modif_icon left">Changer d'icône</div> 
             </div>     
              <div class="infobloc_tv">
                <input class="right submit_butt" type="submit" value="Valider">
                <input id="cancel_tv_button" class="right submit_butt" type="button" value="Annuler">
              </div>
            </div>
        </form>
              <div class="modal_test">
        <div class="position_info_bloc">
          <h1>Icônes</h1>
          <?
          $tbl_list_icon=scandir($_SERVER["DOCUMENT_ROOT"].__racineweb__."/tpl/img/vehicules");
          $j;
          for($i=0;$i<count($tbl_list_icon);$i++){
            if($tbl_list_icon[$i]!="."&&$tbl_list_icon[$i]!=".."){
            if($j%2==0){
            if($j!=0){?>
            </div>
            <?}?>
            <div class="spec_icon_zone">
            <?}?>
            <a href="javascript:chooseicon('<?=$tbl_list_icon[$i]?>')"><img <?=($j%2==0)?"class=\"left\"":"class=\"right\""?> src="<?=__racineweb__?>/tpl/img/vehicules/<?=$tbl_list_icon[$i]?>"></a>
          <?
          $j++;
          }}?>
          </div>
          <!--
          <div class="spec_icon_zone">
            <img class="left"src="<?=__racineweb__?>/tpl/img/vehicules/bus_icon.png">
            <img class="right"src="<?=__racineweb__?>/tpl/img/vehicules/supercamion_icon.png">
          </div>
          <div class="spec_icon_zone">
            <img class="left"src="<?=__racineweb__?>/tpl/img/vehicules/moto_icon.png">
          </div>
          -->
          <img src="<?=__racineweb__?>/tpl/img/cross29.png" class="position_absolute close_img">
        </div>
      </div>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
<!-- DEBUT CONTAINER RESIZE -->
<!-- FIN CONTAINER RESIZE -->
</div>
<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
   <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-tv.js"></script>
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
