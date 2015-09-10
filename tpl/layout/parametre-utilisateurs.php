<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=1;
cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc">
        <div class="resize alarm_bloc">
          <h1 class="bcktitle ajust_title title_agence">Utilisateurs</h1>
		  <div class="infobloc_param clearfix">
            <div class="left font-bold">Nombre d'utilisateurs enregistrés :  <?=count($tbl_list_user)?></div>
          </div>
          <?for($i=0;$i<count($tbl_list_user);$i++){?>
          <div class="infobloc_param02">            
            <div>
              <p>Login : <span> <?=$tbl_list_user[$i]["username"]?> </span></p>
              <div class="module_param_user">
                <h2>Modules</h2>
                <?=$tbl_list_user[$i]["module"]?>
              </div>
              <?if($tbl_list_user[$i]["nbvehicule"]==0){?>
              <p>Tous les véhicules : <span><img src="<?=__racineweb__?>/tpl/img/rond_vert.png"></span></p>
              <?}else{?>
              <p>Certains véhicule(s)</p>
              <?}?>
              <p>Téléphone :<span><?=$tbl_list_user[$i]["tel"]?></span></p>
              <p>Jours :<span> <?=$tbl_list_user[$i]["nbjour"]?>/7</span></p>
              
            </div>              
            <div class="clearfix">
              <form action="<?=urlp($_GET["arbre"])?>?template=utilisateurs#bas" method="post">
                <input type="hidden" name="id" value="<?=$tbl_list_user[$i]["usergps_id"]?>" />
                <input class="right submit_butt" type="submit" value="modifier">
              </form>
              <form action="<?=urlp($_GET["arbre"])?>?template=utilisateurs" method="post" onsubmit="return deleteuser()">
                <input type="hidden" name="id" value="<?=$tbl_list_user[$i]["usergps_id"]?>" />
                <input type="hidden" name="mode" value="delete" />
                <input class="right submit_butt input_supp_param_user" type="submit" value="supprimer">
              </form>              
            </div>
          </div>
          <?}?> 
          <form class="infobloc_param02" action="<?=urlp($_GET["arbre"])?>?template=utilisateurs#bas" method="post">
            <input type="hidden" name="mode" value="add" />
            <input id="ajout_user_button" class="right submit_butt" type="submit" value="Ajouter un utilisateur"><br><br> 
          </form>        
        </div>
         <?if($msgsave!=""){?>
        <div id="msgform"><?=$msgsave?></div>
        <?}?>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
<!-- DEBUT CONTAINER RESIZE -->
  <div class="container_resize">
    <a name="bas"></a>
    <div id="content_onglet_user" <?=(count($tbl_modif_user)>0||$_POST["mode"]=="add")?"style=\"display:block\"":""?>>
      <div id="content_onglet_info_perso">
        <div class="onglet_info_perso">
          <?if(count($tbl_modif_user)>0){?>
          <h1 class="bcktitle ajust_title title_nvllealarme">Modification de l'utilisateur</h1>
          <?}else{?>
          <h1 class="bcktitle ajust_title title_nvllealarme">Nouvel Utilisateur</h1>
          <?}?> 
          <div class="onglet_alarm_param_bloc">
            <h2 id="info_perso_onglet" class="onglet_ajust_user bcktitle_onglet title_onglet_user">Infos. personnelles</h2>
            <h2 id="vehicule_onglet" class="onglet_ajust_user bcktitle title_onglet_user">Véhicules</h2>
            <h2 id="modules_onglet" class="onglet_ajust_user bcktitle title_onglet_user">Modules</h2>
            <h2 id="jours_onglet" class="onglet_ajust_user bcktitle title_onglet_user">Jours</h2>
            <?if(testoption("RMAI")){?>
            <h2 id="mail_onglet" class="onglet_ajust_user bcktitle title_onglet_user">Rapports par mail</h2>
            <?}?>
          </div>
        </div>
        <form name="formUser" id="formUser" class="formulaire_alarm_param" action="<?=urlp($_GET["arbre"])?>?template=utilisateurs" method="post" onsubmit="return validerUser();">
          <?if(count($tbl_modif_user)>0){?>
          <input type="hidden" name="mode" value="modif" />
          <input type="hidden" name="id" value="<?=$_POST["id"]?>" />
          <input type="hidden" name="idgps" value="<?=$_POST["idgps"]?>" />
          <?}else{?>
          <input type="hidden" name="mode" value="ajout" />
          <?}?>
          <div id='content_onglet_alarm_param'>
            <div class="bck_onglet_param ajust_content_onglet_user">
              <div class="decale_onglet_user">
                <div id="content_info_perso" class="content_info_perso">
                  <div>
                    <label for="loguser">Login</label>
                    <input id="loguser" type="text" name="username" value="<?=$tbl_modif_user["username"]?>">
                  </div>
                  <div>
                    <label for="mdpuser">Mot de passe</label>
                    <input id="mdpuser" type="password" name="pwd" value="">
                    </div>
                  <div>
                    <label for="">Confirmation</label>
                    <input type="password" name="pwd2" value="">
                    </div>
                  <div>
                    <label for="">Nom</label>
                    <input type="text" name="name" value="<?=$tbl_modif_user["name"]?>">
                    </div>
                  <!--
                  <div>
                    <label for="">Prénom</label>
                    <input type="text" name="surname" value="<?=$tbl_modif_user["surname"]?>">
                    </div> -->
                  <div>
                    <label for="">N° tel</label>
                    <input type="text" name="tel" value="<?=$tbl_modif_user["tel"]?>">
                    <span class="right info_tel_user"> au format international. Par exemple pour la france +33674869587 ou pour le luxembourg +352612345684.)</span>
                    </div>
                  <div>
                    <label for="">Email</label>
                    <input type="text" name="email" value="<?=$tbl_modif_user["email"]?>">
                    </div>
                  
                </div>
                <div id="content_veh" class="content_veh">
                  <div class="checkbox_veh">
                    <input type="checkbox" name="all" value="1" <?=($nbchk==0)?"checked":""?>>
                    <label>Afficher tous les véhicules</label>
                  </div>
                  <div class="main_resize">
                    <div class="left main_resize">
                    <div class="p_checkbox_veh">
                      <p>Agences</p>
                      <?for($i=0;$i<count($tbl_list_agence);$i++){?>
                      <div class="checkbox_veh">
                        <input type="checkbox" name="agence[]" value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($tbl_list_agence[$i]["checked"]==true)?"checked":""?>>
                        <label><?=$tbl_list_agence[$i]["libelle"]?></label>
                      </div>                      
                      <?}?>
                    </div>
                    </div>
                  <div class="p_checkbox_veh">
                    <p>Véhicules</p>
                    <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>                 
                    <div class="checkbox_veh">       
                      <input type="checkbox" name="vehicule[]" value="<?=$tbl_list_vehicule[$i]["phantom_device_id"]?>" <?=($tbl_list_vehicule[$i]["checked"]==true)?"checked":""?>>
                      <label><?=$tbl_list_vehicule[$i]["nomvehicule"]?></label>
                    </div>
                    <?}?>  
                                  
                  </div>
                  </div>
                </div>
                <div id="content_modules"  class="content_modules">

                  <?=$content?>
                </div>
                <div id="content_jours" class="content_jours">
                  <?for($i=0;$i<count($tbl_list_jour);$i++){?>
                  <div class="checkbox_veh">
                    <input type="checkbox" name="jour[]" value="<?=$tbl_list_jour[$i]["jour_id"]?>" <?=($tbl_list_jour[$i]["checked"]==true)?"checked":""?>>
                    <label><?=$tbl_list_jour[$i]["libelle"]?></label>
                  </div>
                  <?}?>
                  
                </div>
                <div id="content_mail" class="content_mail">
                <?for($i=0;$i<count($tbl_list_rapport);$i++){?>
                  <div class="checkbox_veh">
                    <input type="checkbox" name="rapport[]" value="<?=$tbl_list_rapport[$i]["rapport_id"]?>" <?=($tbl_list_rapport[$i]["checked"]==true)?"checked":""?>>
                    <label><?=$tbl_list_rapport[$i]["libelle"]?></label>
                  </div>
                <?}?>
                </div>
              </div>
            </div>
            <div class="pagination_onglet_alarm">
              <input id="button_annuler" type="button" value="Annuler" class="button_butt left">
              <input type="submit" value="Valider" class="right submit_butt" id="button_next_alarm">  
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- FIN CONTAINER RESIZE -->
</div>
<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-utilisateurs.js"></script>
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
