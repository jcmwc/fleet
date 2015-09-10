<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=1;
cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc">
      <div class="resize l_bloc">
        <h1 class="bcktitle ajust_title title_agence">Lieux</h1>
		<div class="infobloc_param clearfix">
            <div class="left font-bold">Nombre de lieux enregistrés :  <?=count($tbl_list_type)?></div>
          </div>
        <div class="infobloc_param_lieu">
          <div class="left rowElem spec_afflieu_lieu">
              <label class="spec_margin">Afficher les lieux du type : </label>
              <form class="spec_formselect_lieu" method="post" action="<?=urlp($_GET["arbre"])?>?template=lieux">
                <select name="type_lieu_compte" onchange="this.form.submit()">
                  <option value="">Tous</option>
                  <?for($i=0;$i<count($tbl_list_typelieu);$i++){?>
                    <option value="<?=$tbl_list_typelieu[$i]["type_lieu_compte_id"]?>" <?=($tbl_list_typelieu[$i]["type_lieu_compte_id"]==$_POST["type_lieu_compte"])?"selected":""?>><?=$tbl_list_typelieu[$i]["libelle"]?></option>
                  <?}?>
                </select>
              </form>
            </div>
            
          <?
          $contenttab="";
          for($i=0;$i<count($tbl_list_type);$i++){
          $contenttab.="tab.push(new Array('".$tbl_list_type[$i]["icon"]."','".$tbl_list_type[$i]["latitude"]."','".$tbl_list_type[$i]["longitude"]."','".$tbl_list_type[$i]["rayon"]."'));";
          ?>
          
          <div class="form_param_lieu">
            <div class="left infobloc_param infobloc_lieu relative_info_bloc">
              <div>
                <p>Voir : <span> <?=$tbl_list_type[$i]["lib"]?> </span></p>
                <p>Nom : <span> <?=$tbl_list_type[$i]["libelle"]?> </span></p>
                <p>Icone : <span> <?if($tbl_list_type[$i]["icon"]!=""){?><img src="<?=__racineweb__?>/tpl/img/lieux/<?=$tbl_list_type[$i]["icon"]?>"><?}?></span></p>
              </div>
              <form method="post" action="<?=urlp($_GET["arbre"])?>?template=lieux#bas">
                <input type="hidden" name="id" value="<?=$tbl_list_type[$i]["lieu_compte_id"]?>" />
                <input name="" class="right submit_butt position_input" type="submit" value="modifier">
              </form>
              <form method="post" action="<?=urlp($_GET["arbre"])?>?template=lieux" onsubmit="return deletelieux()">
                <input type="hidden" name="id" value="<?=$tbl_list_type[$i]["lieu_compte_id"]?>" />
                <input type="hidden" name="mode" value="delete" />
                <input name="" class="right submit_butt input_supp_param_user position_input02" type="submit" value="supprimer">
              </form>
            </div>
          </div>
          <?}?> 
          
          <div class="infobloc_param_lieu">
            <div class="clearfix spec_butt_ajoutlieu_lieu">
              <form class="spec_form_Lieu" method="post" action="<?=urlp($_GET["arbre"])?>?template=lieux#bas">
              <input type="hidden" name="mode" value="add" />
              <input id="ajout_l_button" name="" class="right submit_butt" type="submit" value="Ajouter un lieu">
              </form>
            </div>
            <?if($msgsave!=""){?>
              <div id="msgform"><?=$msgsave?></div>
              <?}?>
            <!--
            <div>
              <input name="" class="right submit_butt importer_button_lieu" type="bouton" value="Importer des lieux depuis un fichier">
            </div>
            <div>
              <input name="" class="right submit_butt exporter_button_lieu" type="bouton" value="Exporter liste des lieux">
            </div>
            -->
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
<!-- DEBUT CONTAINER RESIZE -->
  <div class="container_resize">
    <a name="bas"></a> 
    <div id="content_onglet_l" class="relative_info_bloc" <?=(count($tbl_modif_type)>0||$_POST["mode"]=="add")?"style=\"display:block\"":"style=\"display:none\""?>>
      <form id="formLieux" name="formLieux" action="<?=urlp($_GET["arbre"])?>?template=lieux" method="post" class="form_param_l" onsubmit="return validerLieux();">
      <?if(count($tbl_modif_type)>0){?>
      <input type="hidden" name="id" value="<?=$tbl_modif_type["lieu_compte_id"]?>" />
      <input type="hidden" name="mode" value="modif" />
      <?}else{?>
      <input type="hidden" name="mode" value="ajout" />
      <?}?>
      <div class="onglet_info_perso">
      <?if(count($tbl_modif_type)>0){?>
        <h1 class="bcktitle ajust_title title_nvllealarme">Modification d'un lieu</h1>
      <?}else{?>
        <h1 class="bcktitle ajust_title title_nvllealarme">Création d'un lieu</h1>
      <?}?>       
      </div>
      <div >
        <div class="bck_onglet_param ajust_content_onglet_l">
          <div class="main_resize left">
            <div class="spec_width_form_l">
              <div class="label_input_bloc_l rowElem">
                <label for="lieux_name">Nom :</label>
                <input id="lieux_name" name="libelle" type="text" value="<?=$tbl_modif_type["libelle"]?>">
              </div>
              <div class="label_input_bloc_l rowElem">
                <label for="">Type :</label>
                <select name="type_lieu_compte_id">
                <?for($i=0;$i<count($tbl_list_typelieu);$i++){?>
                  <option value="<?=$tbl_list_typelieu[$i]["type_lieu_compte_id"]?>" <?=($tbl_list_typelieu[$i]["type_lieu_compte_id"]==$tbl_modif_type["type_lieu_compte_id"])?"selected":""?>><?=$tbl_list_typelieu[$i]["libelle"]?></option>
                <?}?>
                </select>  
                <p><a href="<?=urlp($_GET["arbre"])?>?template=typeslieux" target="_blank">Administrer les types de lieux</a></p>          
              </div>
              <div class="label_input_bloc_l rowElem">
                <label for="">Agence :</label>
                <select name="agence_compte_id">
                  <?for($i=0;$i<count($tbl_list_agence);$i++){?>
                  <option value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($tbl_list_agence[$i]["agence_compte_id"]==$tbl_modif_type["agence_compte_id"])?"selected":""?>><?=$tbl_list_agence[$i]["libelle"]?></option>
                <?}?>
                </select>
              </div>
              <div class="iconebloc_l">
                <label for="icon">Icône :</label>
                <input type="hidden" name="icon" id="icon" value="<?=$tbl_modif_type["icon"]?>">
                <?if($tbl_modif_type["icon"]==""){?>
                <img class="left" src="<?=__racineweb__?>/tpl/img/pix.png" id="imgicon">
                <?}else{?>
                <img class="left" src="<?=__racineweb__?>/tpl/img/lieux/<?=$tbl_modif_type["icon"]?>" id="imgicon">
                <?}?>
                <div class="change_icon2 left">Changer d'icône</div>
                        
             </div>
             <div class="label_input_bloc_l rowElem spec_label_cb_l">
                <label for="">Affichage :</label>
                <input name="affichage" type="checkbox" value="1" <?=($tbl_modif_type["affichage"]==1)?"checked":""?>>
               <p>(Ce lieu sera affiché sur les différentes cartes.)</p>
              </div>
              <div class="label_input_bloc_l rowElem spec_label_cb_l">
                <label for="">Alarme :</label>
                <input name="alarme" type="checkbox" value="1" <?=($tbl_modif_type["alarme"]==1)?"checked":""?>>
                <p>(Ce lieu sera utilisé pour générer des alarmes.)</p>
              </div>
            </div> 
          </div>
          <div class="main_resize left">
            <div class="spec_width_form_l">
              <div class="label_input_bloc_l rowElem">
                <label for="latlieux_name">Latitude (mettre 0 si non connu) :</label>
                <input id="latlieux_name" name="latitude" type="text" value="<?=$tbl_modif_type["latitude"]?>">
              </div>
              <div class="label_input_bloc_l rowElem">
                <label for="longlieux_name">Longitude (mettre 0 si non connu):</label> 
                <input id="longlieux_name"  name="longitude" type="text" value="<?=$tbl_modif_type["longitude"]?>">
                 <p>Coordonnées au format Décimaux entiers (ex: 48.8005 / 2.1297)</p> 
              </div> 
              <div class="label_input_bloc_l rowElem">
                <label for="rayonlieux_name">Rayon (en m) :</label>
                <input id="rayonlieux_name" name="rayon" type="text" input="text" value="<?=$tbl_modif_type["rayon"]?>">
              </div>
              <div class="label_input_bloc_l rowElem">
                <label for="rayonlieux_name">Adresse :<br> </label>
                <textarea  name="adresse" id="adresse"><?=$tbl_modif_type["adresse"]?></textarea>
                <p>Si vous ne connaissez pas les coordonnées</p>
              </div>
            </div>
          </div> 
        </div>
        <div class="pagination_onglet_alarm">
          <input type="submit" value="Valider" class="right submit_butt" id="button_next_alarm">  
          <input id="button_l_annuler" type="button" value="Annuler" class="left button_butt">
        </div>
      </form>
 
    </div>
         <div class="modal_test2">
        <div class="position_info_bloc">
          <h1>Icônes</h1>
          
          <?
          $tbl_list_icon=scandir($_SERVER["DOCUMENT_ROOT"].__racineweb__."/tpl/img/lieux");
          $j;
          for($i=0;$i<count($tbl_list_icon);$i++){
            if($tbl_list_icon[$i]!="."&&$tbl_list_icon[$i]!=".."){
            if($j%9==0){
            if($j!=0){?>
            </div>
            <?}?>
            <div class="spec_icon_zone3 left">
            <?}?>
            <a href="javascript:chooseicon('<?=$tbl_list_icon[$i]?>')"><img class="left" src="<?=__racineweb__?>/tpl/img/lieux/<?=$tbl_list_icon[$i]?>"></a>
          <?
          $j++;
          }}?>
          <img src="<?=__racineweb__?>/tpl/img/cross29.png" class="position_absolute close_img">
        </div>
      </div>
  </div>
  <!-- FIN CONTAINER RESIZE -->
   
</div>

<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
  <div id="map_bloc" class="map_bloc">
    <div id="bandeau_map" class="bandeau_map">
      <span id="full_leave_screen">Plein écran 
      <a href="javascript:showmap()"><img class="full_screen_icon" src="<?=__racineweb__?>/tpl/img/fullsreen_ico.png"></a>
      </span>
    </div>
    <div id="map" class="littlemap"></div>
  </div> 
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-lieux.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/parametre-menu.js"></script>
    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
  var tab=new Array();
  <?=$contenttab?>  
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
