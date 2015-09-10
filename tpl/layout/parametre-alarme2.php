<!-- DEBUT CONTAINER -->
<div class="container">
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=2;
cache_require("parametre-menu.php")?>
    <div class="main_resize backgroundbloc">
      <div id="onglet01_alarmes_bloc2">
        <div class="resize clearfix">
          <h1 class="bcktitle ajust_title title_alarmes">Alarmes</h1>
          <div class="info_bloc_alarm">
            <form class="alarmes_form" action="<?=urlp($_GET["arbre"])?>?template=alarme2" method="POST">
              <div class="rowElem">
                <label>Liste des agences consultables</label>
                <select name="agence" onchange="this.form.submit()">
                <option value="">Choisir une agence</option>
                <?for($i=0;$i<count($tbl_list_agence);$i++){?>
                  <option value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($tbl_list_agence[$i]["agence_compte_id"]==$_POST["agence"])?"selected":""?>><?=$tbl_list_agence[$i]["libelle"]?></option>
                <?}?>                  
                </select>
              </div>
              </form>
              <?if($_POST["agence"]!=""){?>
              <br><br>
              <div class="infobloc_param nbr_alarm_bloc">
                <label>Nombre d'alarmes pour cette agence : </label>
                <span><?=count($tbl_list_alarme)?> </span>
              </div>
              <?for($i=0;$i<count($tbl_list_alarme);$i++){?>
              <div class="infobloc_param02">              
              <p> <?=$tbl_list_alarme[$i]["libelle"]?> </p>            
              </div>         
              <div class="alarm_valid_bloc">
                
                <form action="<?=urlp($_GET["arbre"])?>?template=alarme2" method="POST" onsubmit="return deletealarmope()">
                <input type="hidden" name="agence" value="<?=$_POST["agence"]?>" >
                <input type="hidden" name="mode" value="add" >
                <input type="hidden" name="id" value="<?=$tbl_list_alarme[$i]["alarme_compte_id"]?>" />
                <input class="submit_butt" type="submit" value="Supprimer">
                </form>
                <form action="<?=urlp($_GET["arbre"])?>?template=alarme2#bas" method="POST">
                <input type="hidden" name="agence" value="<?=$_POST["agence"]?>" >
                <input type="hidden" name="id" value="<?=$tbl_list_alarme[$i]["alarme_compte_id"]?>" />
                <input class="submit_butt input_supp_param_user" type="submit" value="Modifier">
                </form>
              </div>
              <?}?>
              <div class="alarm_valid_bloc">
                <form action="<?=urlp($_GET["arbre"])?>?template=alarme2#bas" method="POST">
                <input type="hidden" name="mode" value="add" >
                <input type="hidden" name="agence" value="<?=$_POST["agence"]?>" />
                <input class="submit_butt" id="ajouter_alarme_button" type="submit" value="Ajouter">
                </form>
              </div>
              <?}?>
              <?if($msgsave!=""){?>
              <div id="msgform"><?=$msgsave?></div>
              <?}?>       
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
<!-- DEBUT CONTAINER RESIZE -->
  <div class="container_resize">
    <a name="bas"></a>
    <div id="content_onglet_alarm_param_param2" <?=(count($tbl_modif_alarme)>4||$_POST["mode"]=="add")?"style=\"display:block\"":""?>>

      <div id="content_onglet02_alarmes_bloc2">
        <div class="onglet02_alarmes_bloc">
          <?if(count($tbl_modif_alarme)>4){?>
            <h1 class="bcktitle ajust_title title_nvllealarme">Modifier l'Alarme</h1> 
          <?}else{?>
            <h1 class="bcktitle ajust_title title_nvllealarme">Nouvelle Alarme</h1> 
          <?}?>
          
          <div class="onglet_alarm_param_bloc">
            <h2 id="type_onglet" class="onglet_ajust bcktitle_onglet title_onglet_param">Types</h2>
            <h2 id="parametre2_onglet" class="onglet_ajust bcktitle title_onglet_param">Paramètres</h2>
            <h2 id="horaire_onglet" class="onglet_ajust bcktitle title_onglet_param">Horaires</h2>
            <h2 id="vehicule_onglet" class="onglet_ajust bcktitle title_onglet_param">Véhicules</h2>
            <h2 id="utilisateur_onglet" class="onglet_ajust bcktitle title_onglet_param">Utilisateurs</h2>
          </div>
        </div>
        <form class="formulaire_alarm_param" id="formAlarmParam" name="formAlarmParam" action="<?=urlp($_GET["arbre"])?>?template=alarme2" onsubmit="return validerAlarm();" method="post">
          <input type="hidden" name="agence" value="<?=$_POST["agence"]?>" />
          <?if(count($tbl_modif_alarme)>4){?>
          <input type="hidden" name="mode" value="modif" />
          <input type="hidden" name="id" value="<?=$_POST["id"]?>" />
          <input type="hidden" name="idgps" value="<?=$_POST["idgps"]?>" />
          <?}else{?>
          <input type="hidden" name="mode" value="ajout" />
          <?}?>
        
          <div id='content_onglet_type_param' style="display:block">
            <div class="bck_onglet_param ajust_content_onglet_alarm">
              <div class="left main_resize">
                <div class="decale_onglet_alarm">
                  <div class="content_cate_alarm">
                    <div class="sujet_text_alarm left">Type</div>
                    <div class="left content_input_alarm">
                      <?for($i=0;$i<count($tbl_list_type_alarme_agence);$i++){
                      $lastchamps=($tbl_list_type_alarme_agence[$i]["typealarme_agence_id"]==$tbl_modif_alarme["typealarme_agence_id"]||($i==0&&count($tbl_modif_alarme)<5))?str_replace("'","\'",$tbl_list_type_alarme_agence[$i]["libchamps"]):$lastchamps;
                      ?>
                      <p>
                        <input class="left" name="typealarme_agence_id" type="radio" <?=($tbl_list_type_alarme_agence[$i]["typealarme_agence_id"]==$tbl_modif_alarme["typealarme_agence_id"]||($i==0&&count($tbl_modif_alarme)<5))?"checked":""?> value="<?=$tbl_list_type_alarme_agence[$i]["typealarme_agence_id"]?>" onchange="modifchamps('<?=str_replace("'","\'",$tbl_list_type_alarme_agence[$i]["libchamps"])?>')">
                        <label for="" class="left"><?=$tbl_list_type_alarme_agence[$i]["libelle"]?></label>
                      </p>
                      <?}?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="pagination_onglet_alarm">
              <input type="button" value="Annuler" class="left button_butt button_annuler_alarm2">
              <input id="next_type_butt" type="button" value="Suivant" class="right submit_butt">  
            </div>
          </div>
          <div id='content_onglet_param_param2'>
            <div class="bck_onglet_param ajust_content_onglet_alarm">
              <div class="left main_resize">
                <div class="decale_onglet_alarm">
                  <div class="content_cate_alarm">
                    <div class="content_desc_alarm_alarm2">
                      <div class="overflow_content">
                        <label> Description</label>
                        <input name="name_descparam" id="descparam_name" type="text" value="<?=$tbl_modif_alarme["libelle"]?>"> 
                      </div>
                      <!--
                      <div class="overflow_content">
                        <label class="left"> Alarme de démarrage moteur :</label>
                        <input type="checkbox"> 
                      </div>  
                      <div class="overflow_content">
                        <label class="left"> Sélection rapide :</label>
                        <input class="" name="rapidselect2" type="radio" checked> 
                        <input class="rapidselectinput" name="rapidselect2" type="radio"> 
                      </div> 
                      -->
                      <div class="content_lieu_alarm2">
                        <div class="overflow_content">
                          <label> Lieux : </label>
                          <div class="left content_input_alarm">
                            <?for($i=0;$i<count($tbl_list_lieu);$i++){?>
                            <p>
                              <input class="left" type="checkbox" name="lieu[]" value="<?=$tbl_list_lieu[$i]["lieu_compte_id"]?>" <?=(in_array ($tbl_list_lieu[$i]["lieu_compte_id"],$tbl_modif_alarme["listlieu"])?"checked":"")?>>
                              <label for="" class="left"><?=$tbl_list_lieu[$i]["libelle"]?></label>
                            </p>
                            <?}?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="left main_resize">
                <div class="decale_onglet_alarm">
                  <div class="content_cate_alarm">
                    <input type="hidden" name="champsval" id="champsval" value="namevaleur" />
                    <div class="overflow_content spec_alarm_entrante_alarm2" id="alarmeradio" <?if($tbl_modif_alarme["typealarme_agence_id"]==11){?>style="display:none"<?}?>>
                      <label> Alarme entrante : </label>
                      <input type="radio" name="namevaleur" value="1" <?=($tbl_modif_alarme["valeur"]=="1")?"checked":""?>><span>Entrante</span>
                      <input type="radio" name="namevaleur" value="0" <?=($tbl_modif_alarme["valeur"]=="0")?"checked":""?>><span>Sortante</span>
                    </div>
                    <div class="overflow_content spec_alarm_entrante_alarm2" id="alarmetxt" <?if($tbl_modif_alarme["typealarme_agence_id"]==10||$tbl_modif_alarme["typealarme_agence_id"]==""){?>style="display:none"<?}?>>
                      <label> Durée (en min) : </label>
                      <input id="tpsarret_name" name="namevaleur2" type="text" placeholder="0" value="<?=$tbl_modif_alarme["valeur"]?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="pagination_onglet_alarm">
              <input  type="button" value="Annuler" class="left button_butt button_annuler_alarm2">
              <input id="next_butt_param2"type="button" value="Suivant" class="right submit_butt">  
              <input type="button" id="precendent_butt_param2" value="Precedent" class="ajust_button_param2 right button_butt">  
            </div>
          </div>
          <div id='content_onglet_horaire_param2'>
            <div class="bck_onglet_param ajust_content_onglet_alarm">
              <div class="left main_resize">
                <div class="decale_onglet_alarm">
                  <div class="content_cate_alarm">
                    <div class="left content_input_alarm">
                      <?for($i=0;$i<count($tbl_list_jour)&&$i<4;$i++){?>
                      <p class="content_day_alarm2">
                        <input class="left" type="checkbox" name="jour[]" value="<?=$tbl_list_jour[$i]["jour_id"]?>" <?=(in_array ($tbl_list_jour[$i]["jour_id"],$tbl_modif_alarme["listjour"])?"checked":"")?>>
                        <label for="" class="left"><?=$tbl_list_jour[$i]["libelle"]?></label>
                      </p>
                      <?}?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="left main_resize">
                <div class="decale_onglet_alarm">
                  <div class="content_cate_alarm ">
                    <div class="left content_input_alarm">
                      <?for($i=4;$i<count($tbl_list_jour);$i++){?>
                      <p class="content_day_alarm2">
                        <input class="left" type="checkbox" name="jour[]" value="<?=$tbl_list_jour[$i]["jour_id"]?>" <?=(in_array ($tbl_list_jour[$i]["jour_id"],$tbl_modif_alarme["listjour"])?"checked":"")?>>
                        <label for="" class="left"><?=$tbl_list_jour[$i]["libelle"]?></label>
                      </p>
                      <?}?>
                    </div>
                    <!--
                    <div class="spec_remarq_alarm2"><span class="font-bold">Remarque :</span> (Pour 18 h 35, tapez 1835</div>
                    -->
                  </div>
                </div>
              </div>
            </div>
            <div class="pagination_onglet_alarm">
              <input type="button" value="Annuler" class="left button_butt button_annuler_alarm2">
              <input id="next_butt_horaire" type="button" value="Suivant" class="right submit_butt">  
              <input type="button" id="precedent_butt_horaire" value="Precedent" class="right ajust_button_param2 button_butt">  
            </div>
          </div>
          <div id='content_onglet_vehicule_param2'>
            <div class="bck_onglet_param ajust_content_onglet_alarm">
              <div class="left main_resize">
                <div class="decale_onglet_alarm">
                  <div class="content_cate_alarm">
                    <div class="content_desc_alarm_alarm2">
                      <div class="overflow_content">
                        <label class="left"> Tous les véhicules :</label>
                        <input type="checkbox" id="tsvehicule_alarm" onclick="checkall(this,'vehicule[]')"> 
                      </div>  
                      
                      <div class="content_lieu_alarm2">
                        <div class="overflow_content">
                          <label> Véhicules choisis : </label>
                          <div class="left content_input_alarm">
                            <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
                            <p>
                              <input id="vehicule1_alarm" class="left" name="vehicule[]" value="<?=$tbl_list_vehicule[$i]["phantom_device_id"]?>" type="checkbox" <?=(in_array($tbl_list_vehicule[$i]["phantom_device_id"],$tbl_modif_alarme["listvehicule"])?"checked":"")?>>
                              <label for="vehicule1_alarm" class="left"><?=$tbl_list_vehicule[$i]["nomvehicule"]?> <span><?=$tbl_list_vehicule[$i]["immatriculation"]?></span></label>
                            </p>
                            <?}?> 
                          </div>
                        </div>
                      </div>   
                    </div>
                  </div>
                </div>
              </div>
              <!--
              <div class="left main_resize">
                <div class="decale_onglet_alarm">
                  <div class="content_cate_alarm">
                    <div class="overflow_content spec_alarm_entrante_alarm2">
                      <label> Alarme entrante : </label>
                      <input type="radio" name="alarmentrante"><span>Entrante</span>
                      <input type="radio" name="alarmentrante" checked><span>Sortante</span>
                    </div>
                  </div>
                </div>
              </div>-->
            </div>
            <div class="pagination_onglet_alarm">
              <input  type="button" value="Annuler" class="left button_butt button_annuler_alarm2">
              <input  id="next_butt_vehicule"type="button" value="Suivant" class="right submit_butt">  
              <input type="button" id="precedent_butt_vehicule" value="Precedent" class="right button_butt ajust_button_param2">  
            </div>
          </div>
          <div id='content_onglet_utilisateur_param2'>
            <div class="bck_onglet_param ajust_content_onglet_alarm">
              <div class="left main_resize">
                <div class="decale_onglet_alarm">
                  <div class="content_cate_alarm">
                    <div class="sujet_text_alarm left ">Alerte Utilisateurs</div>
                    <div class="right content_input_param">
                      <div class=" content_title_input_param">
                        
                        <div class="left bloc_title_input_param">
                        
                          <div class="title_param">Utilisateurs</div>
                        <?for($i=0;$i<count($tbl_list_user);$i++){?>
                          <div class="user_param"><input class="input_param" type="checkbox" name="user[]" value="<?=$tbl_list_user[$i]["usergps_id"]?>" <?=(in_array ($tbl_list_user[$i]["usergps_id"],$tbl_modif_alarme["listusergps"])?"checked":"")?>>&nbsp;<?=$tbl_list_user[$i]["username"]?></div>
                        <?}?>   
                  </div>
                  </div>
                  </div>
                </div>
              </div> 
            </div>
            </div>
            <div class="pagination_onglet_alarm">
              <input type="button" value="Annuler" class="left button_butt button_annuler_alarm2">
              <input type="submit" value="Valider" class="right submit_butt">  
              <input type="button" id="precdent_butt_utilisateur" value="Precedent" class="right button_butt ajust_button_param2">  
            </div>
          
        </form>
      </div>
    </div>
  </div>
  <!-- FIN CONTAINER RESIZE -->
</div>
<!-- FIN CONTAINER -->
    </div><!-- end .main-wrapper -->
    <script>
    var lastshow='<?=$lastchamps?>';
    </script>
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-alarme2.js"></script>
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
