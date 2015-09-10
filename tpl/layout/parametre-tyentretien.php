
<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=3;
cache_require("parametre-menu.php")?>
    <div class="main_resize backgroundbloc relative_info_bloc entretien_bloc">
      <div class="resize">
        <h1 class="bcktitle ajust_title title_entretien">Modification des types d'entretien</h1>
        <div class="infobloc_param_lieu">
          <div class="form_param_lieu">
            <div class="infobloc_param">
              <div class="left font-bold"><p>Nombre de types d'entretien enregistrés :</p> </div>
              <div class="left nbr_tl_enr"><p><?=count($tbl_list_type)?></p></div>
            </div>
            <div style="clear:both"></div>
            <?for($i=0;$i<count($tbl_list_type);$i++){?>
            <div class="infobloc_param relative_info_bloc">
              <div>
                <p>Identifiant : <span> <?=$tbl_list_type[$i]["entretien_compte_id"]?> </span></p>
                <p>Nom : <span> <?=$tbl_list_type[$i]["libelle"]?> </span></p>
                <!--
                <p>Icône : <span> <?if($tbl_list_type[$i]["icon"]!=""){?><img src="<?=__racineweb__?>/tpl/img/entretien/<?=$tbl_list_type[$i]["icon"]?>"><?}?> </span></p>
                -->
              </div>
              <div style="clear:both"></div>
              <form method="post" action="<?=urlp($_GET["arbre"])?>?template=tyentretien">
              <input type="hidden" name="id" value="<?=$tbl_list_type[$i]["entretien_compte_id"]?>" />
              <input name="" class="right submit_butt decale" type="submit" value="modifier">
              </form>
              <form method="post" action="<?=urlp($_GET["arbre"])?>?template=tyentretien">
              <input type="hidden" name="id" value="<?=$tbl_list_type[$i]["entretien_compte_id"]?>" />
              <input type="hidden" name="mode" value="delete" />
              <input name="" class="left submit_butt" type="submit" value="supprimer">
              </form>
            </div>
            <div style="clear:both"></div>
            <?}?>
            <div class="infobloc_param">
              <form method="post" action="<?=urlp($_GET["arbre"])?>?template=tyentretien">
                <input type="hidden" name="mode" value="add" />
                <input name="" id="ajout_nv_tyentretien_button" class="right submit_butt" type="submit" value="Ajouter un type d'entretien">
              </form>
              <br><br>
            </div> 
            <?if($msgsave!=""){?>
            <div id="msgform"><?=$msgsave?></div>
            <?}?>     
          </form>          
        </div>
      </div>
      
      <div class="resize nv_ty_entretien_bloc" id="ajout_nv_ty_entretien_bloc" <?=(count($tbl_modif_type)>0||$_POST["mode"]=="add")?"style=\"display:block\"":"style=\"display:none\""?>>
        <form  action="<?=urlp($_GET["arbre"])?>?template=tyentretien" method="post" id="formTyentretien" name="formTyentretien" onsubmit="return validertyentretien();">
        <?if(count($tbl_modif_type)>0){?>
          <input type="hidden" name="id" value="<?=$tbl_modif_type["entretien_compte_id"]?>" />
          <input type="hidden" name="mode" value="modif" />
          <h1 class="bcktitle ajust_title title_entretien">Modification d'un type d'entretien</h1>
        <?}else{?>
          <input type="hidden" name="mode" value="ajout" />
          <h1 class="bcktitle ajust_title title_entretien">Nouveau type d'entretien</h1>
        <?}?>
        <div>
          <form id="formTyentretien" name="formTyentretien" onsubmit="return validertyentretien();">
            <div class="infobloc_nv_tyentretien">
              <label for="nametyentretien">Nom : </label>
              <input id="nametyentretien" name="libelle" type="text" value="<?=$tbl_modif_type["libelle"]?>">
            </div>
            <!--
            <div class="infobloc_nv_tyentretien spec_label_tyentretien">
              <label>Icône : </label>
              <div class="right spec_span_ch_icon modif_icon chang_icon3"><a href="#">Changer d'icône</a></div>
              <?if($tbl_modif_type["icon"]!=""){?>
              <img  id="imgicon" src="<?=__racineweb__?>/tpl/img/entretien/<?=$tbl_modif_type["icon"]?>">
              <?}else{?>
              <img id="imgicon" src="<?=__racineweb__?>/tpl/img/pix.png">
              <?}?>
               
              <input type="hidden" name="icon" id="icon" value="<?=$tbl_modif_type["icon"]?>" />
              </div>
              -->
            <!--
            <div class="infobloc_nv_tyentretien">
              <label>Utilisateurs : </label>
              <div class="spec_cb_tyentretien">
                <input type="checkbox" name="">
                <span>3fassist</span>
              </div>
            </div>-->
            <div class="infobloc_nv_tyentretien">
              <input class="right submit_butt" type="submit" value="Valider">
              <input id="cancel_ty_entretien_button" class="right submit_butt" type="submit" value="Annuler">
            </div>
          
        </div>
        </form>
      </div>
      </div>
      <div class="modal_test3" style="display:none">
        <div class="position_info_bloc">
          <h1>Icônes</h1>
          <?
          $tbl_list_icon=scandir($_SERVER["DOCUMENT_ROOT"].__racineweb__."/tpl/img/entretien");
          $j;
          for($i=0;$i<count($tbl_list_icon);$i++){
            if($tbl_list_icon[$i]!="."&&$tbl_list_icon[$i]!=".."){
            if($j%2==0){
            if($j!=0){?>
            </div>
            <?}?>
            <div class="spec_icon_zone">
            <?}?>
            <a href="javascript:chooseicon('<?=$tbl_list_icon[$i]?>')"><img <?=($j%2==0)?"class=\"left\"":"class=\"right\""?> src="<?=__racineweb__?>/tpl/img/entretien/<?=$tbl_list_icon[$i]?>"></a>
          <?
          $j++;
          }}?>
          
          <img src="<?=__racineweb__?>/tpl/img/cross29.png" class="position_absolute close_img">
        </div>
      </div>
    
  </div>
<!-- FIN MAIN CONTENT TOP -->
</div>
<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-tyentretien.js"></script>
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
