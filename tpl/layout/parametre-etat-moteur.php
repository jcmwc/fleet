<!-- DEBUT CONTAINER -->
<div class="container">
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=5;
cache_require("parametre-menu.php")?>
    <div class="main_resize backgroundbloc relative_info_bloc etat-moteur_bloc">
      <div class="resize">
        <h1 class="bcktitle ajust_title title_entretien">Paramétrage des états moteur</h1>
        <div class="infobloc_param_lieu">  
        <table class="tableau_etat_moteur">
          <tr>
            <th><div><a href="#">Etat</a></div></th>
            <th><div><a href="#">Nom</a></div></th>
            <th><div><a href="#">Couleur</a></div></th>
            <th><div class="th_modif"><a href="#"></a></div></th>
          </tr>
          <?for($i=0;$i<count($tbl_list_etat);$i++){?>
            <tr>
                <td class=""><?=$tbl_list_etat[$i]["libelle"]?></td>
                <td><?=(($tbl_list_etat[$i]["lib2"]=="")?$tbl_list_etat[$i]["libelle"]:$tbl_list_etat[$i]["lib2"])?></td>
                <td style="background:<?=(($tbl_list_etat[$i]["couleur"]=="")?$tbl_list_etat[$i]["defaultcouleur"]:$tbl_list_etat[$i]["couleur"])?>"><?=(($tbl_list_etat[$i]["couleur"]=="")?$tbl_list_etat[$i]["defaultcouleur"]:$tbl_list_etat[$i]["couleur"])?></td>
                <td class="modif_em_bloc">
                  <form method="post" id="form<?=$tbl_list_etat[$i]["etat_moteur_id"]?>" action="#bas">
                    <input type="hidden" name="id" value="<?=$tbl_list_etat[$i]["etat_moteur_id"]?>" />
                    <a href="javascript:document.getElementById('form<?=$tbl_list_etat[$i]["etat_moteur_id"]?>').submit()">Modifier</a>
                  </form>
                  
                </td>
            </tr>
          <?}?>           
        </table>       
        </div>
      </div>
      <?if($msgsave!=""){?>
      <div id="msgform">Sauvegarde effectuée</div>
      <?}?>
      
      <div class="resize" id="modif_etat_moteur" style="<?=($_POST["id"]!=""&&$_POST["mode"]=="")?"display:block":"display:none"?>">
        <a name="bas"></a>
        <h1 class="bcktitle ajust_title title_nv_tl">Mise à jour d'un état moteur</h1>
        <div class="decale">
          <form id="formMoteur" name="formMoteur" onsubmit="return validerMoteur();" action="<?=urlp($_GET["arbre"])?>?template=etat-moteur" method="post">
          <input type="hidden" name="id" value="<?=$_POST["id"]?>" />
          <input type="hidden" name="mode" value="modif" />
            <div class="infobloc_modif_em">
              <label>Etat</label>
              <input value="<?=$tbl_modif["libelle"]?>" disabled> 
            </div>
            <div class="infobloc_modif_em">
              <label for="name_moteur">Nom</label>
              <input value="<?=(($tbl_modif["lib2"]=="")?$tbl_modif["libelle"]:$tbl_modif["lib2"])?>" id="name_moteur" name="libelle"> 
            </div>
            <div class="infobloc_modif_em_spec_colorpicker">
              <label>Couleur</label>
                <div class="left spec_span_ch_icon modif_icon">Choisir une couleur</div>
                <div class="form-item">
                  <input type="text" id="color" name="couleur"  value="<?=(($tbl_modif["couleur"]=="")?$tbl_modif["defaultcouleur"]:$tbl_modif["couleur"])?>"/>
                </div>
                <div class="picker"></div> 
            </div>
            <div class="infobloc_modif_em_spec_input">
              <input type='submit' class="right submit_butt" value="Valider">
              <input id="cancel_butt_em" type='button' class="right submit_butt" value="Annuler">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
</div>
<!-- FIN CONTAINER -->



    </div><!-- end .main-wrapper -->
 <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/parametre-etat-moteur.js"></script>
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

