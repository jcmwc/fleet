    
<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=2;
cache_require("parametre-menu.php")?>
    <div class="main_resize backgroundbloc l_bloc">
      <div class="resize">
        <h1 class="bcktitle ajust_title title_agence">Alarmes de vitesse</h1>
        <div class="infobloc_param_lieu">
           <form class="form_param_lieu" action="<?=urlp($_GET["arbre"])?>?template=alarm-vit" method="POST">
            <div class="left rowElem">
              <label class="spec_margin">Liste des agences consultables : </label>
              <select name="agence" onchange="this.form.submit()">
                <option value="">Choisir une agence</option>
                <?for($i=0;$i<count($tbl_list_agence);$i++){?>
                  <option value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($tbl_list_agence[$i]["agence_compte_id"]==$_POST["agence"])?"selected":""?>><?=$tbl_list_agence[$i]["libelle"]?></option>
                <?}?>  
              </select>           
            </div>
            </form> 
            <?if($_POST["agence"]!=""){?>
            <div class="infobloc_param">
              <div class="left font-bold"><p>Nombre de véhicules équipés de boîtiers :</p> </div>
              <div class="left nbr_tl_enr"><p><?=count($tbl_list_vehicule)?></p></div>
            </div>
            <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
            <div class="infobloc_alarmvit relative_info_bloc">
              <div>
                <p>Nom : <span> <?=$tbl_list_vehicule[$i]["nomvehicule"]?> </span></p>
                <p>Immatriculation : <span> <?=$tbl_list_vehicule[$i]["immatriculation"]?> </span></p>
                <p>Type : <span> <?=$tbl_list_vehicule[$i]["type"]["libelle"]?> </span></p>
                <p>Catégorie : <span> <?=$tbl_list_vehicule[$i]["listcat"]?> </span></p>
                <p>Vitesse max. autorisée : <span> <?=$tbl_list_vehicule[$i]["vitessemax"]?> km/h</span></p>
              </div>
              <form action="<?=urlp($_GET["arbre"])?>?template=alarm-vit#bas" method="POST">
              <input type="hidden" name="agence" value="<?=$_POST["agence"]?>" >
              <input type="hidden" name="id" value="<?=$tbl_list_vehicule[$i]["phantom_device_id"]?>" />
              <input class="right submit_butt position_input modif_butt_av" type="submit" value="Modifier">
              </form>              
            </div>
            <?}}?>
            <?if($msgsave!=""){?>
              <div id="msgform"><?=$msgsave?></div>
            <?}?>            
        </div>
      </div>
      <div class="resize modif_content_allvit" <?=(count($tbl_modif_vitesse)>0)?"style=\"display:block\"":"style=\"display:none\""?>>
        <h1 class="bcktitle ajust_title title_msaj_vit">Mise à jour d'une alarme de vitesse</h1>

        <form action="<?=urlp($_GET["arbre"])?>?template=alarm-vit"  method="post">
        <input type="hidden" name="agence" value="<?=$_POST["agence"]?>" />
        <input type="hidden" name="mode" value="modif" />
        <input type="hidden" name="id" value="<?=$_POST["id"]?>" />
          <div class="decale modif_content_av">
            <div class="infobloc_alvit">
              <div class="font-bold left">Nom du véhicule :&nbsp;</div>
              <div><?=$tbl_modif_vitesse["nomvehicule"]?></div>
            </div>
            <div class="infobloc_alvit">
              <div class="font-bold left">Vitesse limite :&nbsp;</div>
              <input type="text" name="vitessemax" value="<?=$tbl_modif_vitesse["vitessemax"]?>"> km/h</div>
            </div>
            <div>
              <input type="submit" class="right decale submit_butt" value="Valider">
              <input type="button" class="right  button_butt cancel_butt_allvit" value="Annuler">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
</div>
<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
   <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-alarm-vit.js"></script>
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
