
<!-- DEBUT CONTAINER -->
<div class="container">
  <!-- DEBUT MAIN CONTENT TOP -->
  <div class="main_content_top">
<?
$_GET["mainmenu"]=3;
cache_require("parametre-menu.php")?>
    <div class="main_resize backgroundbloc">
      <div id="onglet_alarmes_entretien_bloc">
        <div class="resize clearfix">
          <h1 class="bcktitle ajust_title title_alarme_entretien">Alarmes entretien</h1>
          <div class="clearfix content_agence_date_alarmentretien">
            <form class="clearfix form_param_lieu" action="<?=urlp($_GET["arbre"])?>?template=alarm-entretien" method="POST">
            <div class="left rowElem">
              <label class="specmargin">Liste des agences consultables : </label>
              <select name="agence" onchange="this.form.submit()">
                <option value="">Choisir une agence</option>
                <?for($i=0;$i<count($tbl_list_agence);$i++){?>
                  <option value="<?=$tbl_list_agence[$i]["agence_compte_id"]?>" <?=($tbl_list_agence[$i]["agence_compte_id"]==$_POST["agence"])?"selected":""?>><?=$tbl_list_agence[$i]["libelle"]?></option>
                <?}?>  
              </select>           
            </div>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- FIN MAIN CONTENT TOP -->
<!-- DEBUT CONTAINER RESIZE -->
<?if($_POST["agence"]!=""){?>
  <div class="container_resize">
    <table class="tableau_content tableau_alarme_entretien">
      <tr>
        <th><div class="active_tableau"><a href="#">Nom Véhicule</a></div></th>
        <th><div><a href="#">Kilomètres</a></div></th>
        <th><div><a href="#">Date</a></div></th>
        <th><div><a href="#">Type d'entretien</a></div></th>
        <th><div><a href="#">&nbsp;</a></div></th>
      </tr>
      <form id="formajout" action="<?=urlp($_GET["arbre"])?>?template=alarm-entretien" method="POST">
      <input type="hidden" name="agence" value="<?=$_POST["agence"]?>" />
      <input type="hidden" name="mode" value="ajout" />
      <tr>
        <td class="">
          <select name="vehicule">
          <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
          <option value="<?=$tbl_list_vehicule[$i]["phantom_device_id"]?>">
          <?=$tbl_list_vehicule[$i]["nomvehicule"]?> 
          ( <?=$tbl_list_vehicule[$i]["kmactuel"]+$tbl_list_vehicule[$i]["kminit"]+$tbl_list_vehicule[$i]["correctifkm"]?> km)
          </option>
          <?}?>
          </select>
        </td>
        <td><input type="text" name="km" placeholder="0" value=""></td>
        <td><input type="text" name="date" placeholder="jj/mm/aa" value=""></td>
        <td>
        <select name="entretien_compte">
        <?for($i=0;$i<count($tbl_list_type);$i++){?>
        <option value="<?=$tbl_list_type[$i]["entretien_compte_id"]?>"><?=$tbl_list_type[$i]["libelle"]?></option>
        <?}?>
        </select></td>
        <td><a href="javascript:document.getElementById('formajout').submit()"> Ajouter</a></td>
      </tr>
      </form>
      <?for($i=0;$i<count($tbl_list_alarme);$i++){?>
      <form name="form<?=$tbl_list_alarme[$i]["alarme_entretien_id"]?>" id="form<?=$tbl_list_alarme[$i]["alarme_entretien_id"]?>" action="<?=urlp($_GET["arbre"])?>?template=alarm-entretien" method="POST">
      <input type="hidden" name="agence" value="<?=$_POST["agence"]?>" />
      <input type="hidden" name="mode" id="mode" value="modif" />
      <input type="hidden" name="id" value="<?=$tbl_list_alarme[$i]["alarme_entretien_id"]?>" />
      <tr>
        <td class="">
          <span><?=$tbl_list_alarme[$i]["nomvehicule"]?></span><img class="seemore_img" src="<?=__racineweb__?>/tpl/img/plus_ico.png">
          <div class="morecontent_tableau">
            <p>Véhicule : <span class="uppercase font-italic"><?=$tbl_list_alarme[$i]["marque"]?></span> <?=$tbl_list_alarme[$i]["modele"]?></p>
            <p>Immatriculation : <span><?=$tbl_list_alarme[$i]["immatriculation"]?></span></p>
            <p>Type : <span><?=$tbl_list_alarme[$i]["type"]["libelle"]?></span></p>
            <p>Catégorie : <span><?=$tbl_list_alarme[$i]["listcat"]?></span></p>  
            <p>Km compteur : <span><?=$tbl_list_alarme[$i]["kmactuel"]+$tbl_list_alarme[$i]["kminit"]+$tbl_list_alarme[$i]["correctifkm"]?></span></p>          
          </div>
        </td>
        <td><input type="text" name="km" placeholder="0" value="<?=$tbl_list_alarme[$i]["km"]?>"></td>
        <td><input type="text" name="date" placeholder="jj/mm/aa" value="<?=affichedateiso($tbl_list_alarme[$i]["date"])?>"></td>
        <td>
        <select name="entretien_compte">
        <?for($j=0;$j<count($tbl_list_type);$j++){?>
        <option value="<?=$tbl_list_type[$j]["entretien_compte_id"]?>" <?=($tbl_list_type[$j]["entretien_compte_id"]==$tbl_list_alarme[$j]["entretien_compte_id"])?"selected":""?>><?=$tbl_list_type[$j]["libelle"]?></option>
        <?}?>
        </select>
        </td>
        <td><a href="javascript:document.getElementById('form<?=$tbl_list_alarme[$i]["alarme_entretien_id"]?>').submit()"> Modifer</a>/<a href="javascript:document.form<?=$tbl_list_alarme[$i]["alarme_entretien_id"]?>.mode.value='suppr';document.getElementById('form<?=$tbl_list_alarme[$i]["alarme_entretien_id"]?>').submit()"> Supprimer</a></td>
      </tr>
      </form>
      <?}?>      
    </table>
  </div>
  <?}?>
<!-- FIN CONTAINER RESIZE -->
</div>
<!-- FIN CONTAINER -->


    </div><!-- end .main-wrapper -->
    
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/parametre-alarm-entretien.js"></script>
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
