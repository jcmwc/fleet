<div class="container">
  <div class="main_resize">
      <div class="resize filter_info">
        <h1 class="bcktitle ajust_title">FILTRER LES INFORMATIONS</h1>
      <form class="" method="post">
        <div class="rowElem">
          <label>Etat</label>
          <select class="" name="etat">         
          <option value="">Choisir</option>
          <?for($i=0;$i<count($tbl_list_etat);$i++){?>
            <option value="<?=$tbl_list_etat[$i]["etat_moteur_id"]?>" <?=($_POST["etat"]==$tbl_list_etat[$i]["etat_moteur_id"])?"selected":""?>><?=$tbl_list_etat[$i]["libelle"]?></option>
          <?}?>    
          </select>
        </div>
        <div class="rowElem">
          <label>Type</label>
          <select class="" name="type">
            <option value="">Choisir</option>
            <?for($i=0;$i<count($tbl_list_type);$i++){?>
              <option value="<?=$tbl_list_type[$i]["type_compte_id"]?>" <?=($_POST["type"]==$tbl_list_type[$i]["type_compte_id"])?"selected":""?>><?=$tbl_list_type[$i]["libelle"]?></option>
            <?}?>
          </select>
        </div>
        <?if(count($tbl_list_agence)>1){?>
        <div class="rowElem">
          <label>Agence</label>
          <select class="" name="agence">
            <option value="">Choisir</option>
            <?for($i=0;$i<count($tbl_list_agence);$i++){?>
              <option value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($_POST["agence"]==$tbl_list_agence[$i]["agence_compte_id"])?"selected":""?>><?=$tbl_list_agence[$i]["libelle"]?></option>
            <?}?>
          </select>
        </div>
        <?}else{?>
        <input type="hidden" name="agence" value="<?=$tbl_list_agence[0]["agence_compte_id"]?>"/>
        <?}?>
        <div class="content_filt_input rowElem">
          <label class="lastlabel_situation">Nom</label>
          <input class="filt_input" name="nom" type="text" value="<?=$_POST["nom"]?>">
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Filtrer">
        </div>
      </form>
      </div>
  </div>
  <div class="main_resize backgroundbloc situation_bloc02">
    <div class="resize situation_flotte02">
      <h1 class="bcktitle ajust_title">Situation de la flotte</h1>
      <form id="formlistvehicule">
      <div class="content_form_situation">        
          <!--
          <div class="rowElem">
            <label class="font-bold">Trier la liste</label>
            <select class="long_select">
              <option size="1">Ordre Alphabétique</option>
              <option size="2">Type véhicule</option>
              <option size="3">Etat véhicule</option>
              <option size="4">Date</option>
              <option size="5">Alarmes</option>
              <option size="6">Entretiens</option>
            </select>
          </div>
          -->
          <div class="rowElem">
            <label class="font-bold">Options d'affichage</label>     
            <div class="spec_content_cb_carto">      
              <p>
                <input type="checkbox" value="1" id="bulle" name="bulle" onclick="reloadmap('not');">
                <span>Afficher infos bulles</span>
              </p>
              <p>
                <input type="checkbox" value="2" id="lieu" name="lieu" onclick="reloadmap('not');">
                <span>Afficher les lieux</span>
              </p>
              <p>
                <input type="checkbox" value="3" name="suivi" onclick="fctsuivi(this)" id="suivichk">
                <span>Suivi automatique des véhicules sélectionnés</span>
              </p>      
            </div>
          </div>  
      </div>
      <div class="vehicule_content full_bloc">
        <div class="checkbox_vehicule">
          <input type="checkbox"  value="Selectionner tous les véhicules" id="selall" onclick="checkall(this,'vehicule[]')">
          Sélectionner tous les véhicules
        </div>
        <div class="overflow_vehiculebloc">
        <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
          <div class="vehicule_bloc">
            <div class="left etat_vehiculebloc">
              <div class="left">
              <input type="checkbox"  name="vehicule[]" value="<?=$tbl_list_vehicule[$i]["phantom_device_id"]?>" <?=($_GET["id"]==$tbl_list_vehicule[$i]["phantom_device_id"])?"checked":""?> onchange="reloadmap()">
              </div> 
              <div class="left">
              <?etatvoiture($tbl_list_vehicule[$i]["phantom_device_id"])?>
              </div>
              <div class="left">
              <span class="desc_vehiculebloc"><?=$tbl_list_vehicule[$i]["nomvehicule"]?> - <span class="uppercase"><?=$tbl_list_vehicule[$i]["marque"]?> </span> <?=$tbl_list_vehicule[$i]["modele"]?></span>
              </div>
            </div>
            <div class="right">
                <?iconvoiture($tbl_list_vehicule[$i]["phantom_device_id"])?>
                <img class="seemore_img02" src="<?=__racineweb__?>/tpl/img/plus_ico.png">
            </div>
            <div class="more_vehiculebloc">
              <div class="left more_descleft_vehiculebloc">
                <div class="font-bold">Immat :<span class="font-italic"><?=$tbl_list_vehicule[$i]["immatriculation"]?></span></div>
                <div class="font-bold">Type :<span class="font-italic"> <?=$key_list_type[$tbl_list_vehicule[$i]["type_compte_id"]]?></span></div>
                <div class="italic">Date :<span class="font-italic"> <?=$tbl_list_vehicule[$i]["time"]?></span></div>
                <div class="font-italic">Etat :<span class="font-italic"> <?=etatvoituretxt($tbl_list_vehicule[$i]["phantom_device_id"])?></span></div>
              </div>
              <div class="left font-italic">
                <div>Vitesse :<span> <?=vitessekmh($tbl_list_vehicule[$i]["speed"])?> km/h</span></div>   
                <div>Latitude :<span> <?=round($tbl_list_vehicule[$i]["latitude"],4)?></span></div>
                <div>Longitude :<span> <?=round($tbl_list_vehicule[$i]["longitude"],5)?></span></div>
              </div>
            </div>
          </div>
        <?}?>  
        </div>
      </div>
      </form>
    </div>
  </div>
  
  
    <div id="map_bloc" class="map_bloc">
    <div id="bandeau_map" class="bandeau_map">
      <span id="full_leave_screen">Plein écran 
      <a href="javascript:showmap()"><img class="full_screen_icon" src="<?=__racineweb__?>/tpl/img/fullsreen_ico.png"></a>
      </span>
    </div>
    <div id="map" class="littlemap"></div>
  </div> 
  
</div>

    </div><!-- end .main-wrapper -->
    
    
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>  
    <script>racineimg="<?=__racineweb__?>";</script>  
    <script src="<?=__racineweb__?>/tpl/js/cartographie.js"></script>
    
    
    
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>  
  <?if($_GET["id"]==""){?>
  document.getElementById('selall').checked=true;
  checkall(document.getElementById('selall'),'vehicule[]');
  <?}?>
  var tab=new Array();
  <?=$contenttab?>
  
  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
  e.src='//www.google-analytics.com/analytics.js';
  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','<?=__analytics__?>');ga('send','pageview');
</script>
  </body>
</html>