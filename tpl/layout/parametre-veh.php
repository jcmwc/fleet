
<!-- DEBUT CONTAINER -->
<div class="container">
 
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=1;
cache_require("parametre-menu.php")?> 
    <div class="main_resize backgroundbloc">
      <div class="resize veh_bloc">
        <h1 class="bcktitle ajust_title title_agence">Véhicules</h1>
		<div class="infobloc_param clearfix">
          <div class="left font-bold">Nombre de véhicules enregistrés :  <?=count($tbl_list_boitier)?></div>
        </div>
        <div class="infobloc_param_pref">
          <form class="form_param_lieu" action="<?=urlp($_GET["arbre"])?>?template=veh" method="post">
            <input type="hidden" name="mode" value="search" />
            <div class="rowElem">
              <label for="">Nom du véhicule :</label>
              <input type="text" name="nomvehicule" value="<?=$_POST["nomvehicule"]?>">
            </div>
            <div class="rowElem ">
              <label for="">Immatriculation :</label>
              <input type="text" name="immatriculation" value="<?=$_POST["immatriculation"]?>">
            </div>
            <div class="rowElem ">
              <label for="">Boîtier :</label>
              <select name="IMEI">
                <option value="">Choisir</option>
                <?for($i=0;$i<count($tbl_list_boitier);$i++){?>
                  <option value="<?=$tbl_list_boitier[$i]["IMEI"]?>" <?=($_POST["IMEI"]==$tbl_list_boitier[$i]["IMEI"])?"selected":""?>><?=$tbl_list_boitier[$i]["IMEI"]?></option>
                <?}?>
              </select>
            </div>
            <div class="rowElem ">
              <label for="">N° appel boîtier :</label>
              <input type="text" name="phone_number" value="<?=$_POST["phone_number"]?>">
            </div>
            <div class="rowElem ">
              <label for="">Type :</label>
              <select class="" name="type">
                <option value="">Choisir</option>
                <?for($i=0;$i<count($tbl_list_type);$i++){?>
                  <option value="<?=$tbl_list_type[$i]["type_compte_id"]?>" <?=($_POST["type"]==$tbl_list_type[$i]["type_compte_id"])?"selected":""?>><?=$tbl_list_type[$i]["libelle"]?></option>
                <?}?>
              </select>
            </div>
            <div class="rowElem ">
              <label for="">Agence :</label>
              <select class="" name="agence">
                <option value="">Choisir</option>
                <?for($i=0;$i<count($tbl_list_agence);$i++){?>
                  <option value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($_POST["agence"]==$tbl_list_agence[$i]["agence_compte_id"])?"selected":""?>><?=$tbl_list_agence[$i]["libelle"]?></option>
                <?}?>
              </select>
            </div>
            <div class="spec_butt_filter">
              <input class="right submit_butt" type="submit" value="Filtrer">
            </div>
          </form>  
          <!--
          <div class="ajout_button_bloc">
            <form action="<?=urlp($_GET["arbre"])?>?template=veh" method="post">
            <input type="hidden" name="mode" value="add" />
            <input id="ajout_nv_veh_button" class="right submit_butt" type="submit" value="Ajouter un véhicule"><br><br> 
            </form>
          </div>
          -->        
        </div>
        <?if($msgsave!=""){?>
        <div id="msgform"><?=$msgsave?></div>
        <?}?>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
<!-- DEBUT CONTAINER RESIZE -->
  <div class="container_resize">
    <div id="content_onglet_veh" <?=(count($tbl_modif_veh)>0||$_POST["mode"]=="add")?"style=\"display:block\"":"style=\"display:none\""?>>
      <div class="onglet_info_perso">
        <?if(count($tbl_modif_veh)>0){?>
        <h1 class="bcktitle ajust_title title_modifveh">Modification du véhicule</h1>
        <?}else{?>
        <h1 class="bcktitle ajust_title title_veh">Nouveau véhicule</h1>
        <?}?>  
      </div>
      <form class="form_param_veh" action="<?=urlp($_GET["arbre"])?>?template=veh" method="post">
        <?if(count($tbl_modif_veh)>0){?>
        <input type="hidden" name="mode" value="modif" />
        <input type="hidden" name="id" value="<?=$_GET["id"]?>" />
        <input type="hidden" name="pdevice_id" value="<?=$tbl_modif_veh["phantom_device_id"]?>" />
        <?}else{?>
        <input type="hidden" name="mode" value="ajout" />
        <?}?>
        <div class="bck_onglet_param ajust_content_onglet_veh">
          <div class="main_resize left content_nv_veh_bloc">
            <div class="rowElem">
              <label for="">Agence : </label>
              <select name="agence_compte_id">
                <?for($i=0;$i<count($tbl_list_agence);$i++){?>
                  <option value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($tbl_modif_veh["agence_compte_id"]==$tbl_list_agence[$i]["agence_compte_id"])?"selected":""?>><?=$tbl_list_agence[$i]["libelle"]?></option>
                <?}?>
              </select>
            </div>
            <div class="rowElem">
              <label for="">Boîtier: </label>
              <?=$tbl_modif_veh["IMEI"]?>
            </div>
            <div class="rowElem">
              <label for="">Type : </label>
              <select name="type_compte_id">
                <?for($i=0;$i<count($tbl_list_type);$i++){?>
                  <option value="<?=$tbl_list_type[$i]["type_compte_id"]?>" <?=($tbl_modif_veh["type_compte_id"]==$tbl_list_type[$i]["type_compte_id"])?"selected":""?>><?=$tbl_list_type[$i]["libelle"]?></option>
                <?}?>
              </select>
            </div>
            <div class="rowElem">
              <p><a href="<?=urlp($_GET["arbre"])?>?template=tv" target="_blank" class="spec_a_veh">Administrer les types de véhicule</a></p>
            </div>
            <div class="rowElem">
              <label for="">Type de moteur : </label>
              <select name="type_moteur_id">
                <?for($i=0;$i<count($tbl_list_type_moteur);$i++){?>
                  <option value="<?=$tbl_list_type_moteur[$i]["type_moteur_id"]?>" <?=($tbl_modif_veh["type_moteur_id"]==$tbl_list_type_moteur[$i]["type_moteur_id"])?"selected":""?>><?=$tbl_list_type_moteur[$i]["libelle"]?></option>
                <?}?>
              </select>
            </div>
            <div class="rowElem">
              <label for="">Consommation : </label>
              <!-- <input name="" type="checkbox">-->
              <input  type="text" name="consommation" value="<?=$tbl_modif_veh["consommation"]?>">
            </div>
            <div class="rowElem">
              <label for="">Utiliser la consommation du type : </label>
              <!-- <input name="" type="checkbox">-->
              <input type="checkbox" value="1" name="consommationtype" <?=($tbl_modif_veh["consommationtype"]==1)?"checked":""?>>
            </div>
            <div class="rowElem">
              <label for="">Catégories : </label>
                           
              <div class="content_veh_oc">
                <div class="option_title2 left">
                  <h2>Options sélectionnées</h2>
                </div>
                <div class="option_title2 right">
                  <h2>Options Disponibles</h2>
                </div>
                <div>
                  <select id='pre-selected-options' name="categorie[]"  multiple>
                  <?for($i=0;$i<count($tbl_list_categorie);$i++){?>
                      <option value="<?=$tbl_list_categorie[$i]["categorie_compte_id"]?>" <?=in_array($tbl_list_categorie[$i]["categorie_compte_id"],$tbl_list_cat_id)?"selected":""?>><?=$tbl_list_categorie[$i]["libelle"]?></option>
                    <?}?>
                  </select>

                </div>
              </div>
              
            </div> 
            <div class="rowElem">
              <p><a href="<?=urlp($_GET["arbre"])?>?template=catveh" target="_blank" class="spec_a_veh">Administrer les catégories de véhicule</a></p>
            </div>
            <div class="rowElem">
              <label for="">Nom du véhicule : </label>
              <input type="text"  name="nomvehicule" value="<?=$tbl_modif_veh["nomvehicule"]?>">
            </div>
            <div class="rowElem">
              <label for="">Immatriculation : </label>
              <input type="text" name="immatriculation" value="<?=$tbl_modif_veh["immatriculation"]?>">
            </div>          
          </div>
          <div class="main_resize left content_nv_veh_bloc">
            <div class="rowElem">
              <label for="">Châssis : </label>
              <input type="text" name="chassis" value="<?=$tbl_modif_veh["chassis"]?>">
            </div>
            <div class="rowElem">
              <label for="">Marque : </label>
              <input type="text" name="marque" value="<?=$tbl_modif_veh["marque"]?>">
            </div>
            <div class="rowElem">
              <label for="">Modèle : </label>
              <input type="text" name="modele" value="<?=$tbl_modif_veh["modele"]?>">
            </div>
            <!--
            <div class="rowElem">
              <p><a href="<?=urlp($_GET["arbre"])?>?template=tv" target="_blank" class="spec_a_veh">Administrer les types de véhicule</a></p>
            </div>  -->
            <div class="rowElem">
              <label for="">Relevé kilométrique à l'installation (km) : </label>
              <input type="text" name="kminit" value="<?=$tbl_modif_veh["kminit"]?>">
            </div>
            <div class="rowElem">
              <label for="">Correctif (km) : </label>
              <input  type="text" name="correctifkm" value="<?=$tbl_modif_veh["correctifkm"]?>">
            </div>
            <!--
            <div class="rowElem">
              <label for="">Correctif horaire (heure) : </label>
              <input  type="text" name="correctifh" value="<?=$tbl_modif_veh["correctifh"]?>">
            </div> 
            -->
            <div class="rowElem">
              <label for="">Téléphone : </label>
              <input  type="text" name="tel" value="<?=$tbl_modif_veh["tel"]?>">
            </div>
            <!--
            <div class="rowElem">
              <label for="">Utilisateurs à droit limités : </label>              
            </div>  
            -->         
          </div>
        </div>
        <div class="pagination_onglet_alarm">
          <input id="button_veh_annuler" type="button" value="Annuler" class="left button_butt">
          <input type="submit" value="Valider" class="right submit_butt" id="button_next_alarm">  
        </div>
      </form>
    </div>     
  </div>
<!-- FIN CONTAINER RESIZE -->
<table class="tableau_veh">
    <tr>
      <th><div class="active_tableau"><a href="#">Nom</a></div></th>
      <th><div><a href="#">Agence </a></div></th>
      <th><div><a href="#">Immat.</a></div></th>
      <th><div><a href="#">Type</a></div></th>
      <th><div><a href="#">Boîtier</a></div></th>
      <th><div><a href="#">N°boîtier</a></div></th>
      <th><div><a href="#">Catégories</a></div></th>
      <th><div><a href="#">Compteur*</a></div></th>
      <th><div><a href="#">Correctif</a></div></th>
      <th><div><a href="#">Consommation</a></div></th>
      <th><div><a href="#">Téléphone</a></div></th>
      <th><div class="th_modif_supp_veh"><a href="#"></a></div></th>
    </tr>
    <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
    <tr>
      <td><?=$tbl_list_vehicule[$i]["nomvehicule"]?></td>
      <td><?=$key_list_agence[$tbl_list_vehicule[$i]["agence_compte_id"]]?></td>
      <td><?=$tbl_list_vehicule[$i]["immatriculation"]?></td>
      <td><?=$key_list_type[$tbl_list_vehicule[$i]["type_compte_id"]]?></td>
      <td><?=$tbl_list_vehicule[$i]["IMEI"]?></td>
      <td><?=$tbl_list_vehicule[$i]["telboitier"]?></td>       
      <td><?=$tbl_list_vehicule[$i]["listcat"]?></td>
      <td><?=$tbl_list_vehicule[$i]["correctifkm"]+$tbl_list_vehicule[$i]["kminit"]+$tbl_list_vehicule[$i]["kmactuel"]?> km</td>
      <td><?=$tbl_list_vehicule[$i]["correctifkm"]?> km</td>   
      <td><?=$tbl_list_vehicule[$i]["consommation"]?> L/100km</td>
      <td><?=$tbl_list_vehicule[$i]["tel"]?></td>
      <td>
      <a class="spec_lien_veh" href="javascript:modifvehicule('<?=urlp($_GET["arbre"])?>?template=veh',<?=$tbl_list_vehicule[$i]["phantom_device_id"]?>)">Modifier</a>
      <!--
      /
      <a class="spec_lien_veh" href="javascript:deletevehicule('<?=urlp($_GET["arbre"])?>?template=veh',<?=$tbl_list_vehicule[$i]["phantom_device_id"]?>)">Suppr.</a>
      -->
      </td>
    </tr>
    <?}?>
  </table>
</div>
<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-veh.js"></script>
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
