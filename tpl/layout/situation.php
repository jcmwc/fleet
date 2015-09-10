<meta http-equiv="refresh" content="60"> 
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
        <!--<div class="rowElem">
          <label>Type</label>
          <select class="" name="type">
            <option value="">Choisir</option>
            <?for($i=0;$i<count($tbl_list_type);$i++){?>
              <option value="<?=$tbl_list_type[$i]["type_compte_id"]?>" <?=($_POST["type"]==$tbl_list_type[$i]["type_compte_id"])?"selected":""?>><?=$tbl_list_type[$i]["libelle"]?></option>
            <?}?>
          </select>
        </div>
        <div class="rowElem">
          <label>Catégorie</label>
          <select class="" name="categorie">
            <option value="">Choisir</option>
            <?for($i=0;$i<count($tbl_list_categorie);$i++){?>
              <option value="<?=$tbl_list_categorie[$i]["categorie_compte_id"]?>" <?=($_POST["categorie"]==$tbl_list_categorie[$i]["categorie_compte_id"])?"selected":""?>><?=$tbl_list_categorie[$i]["libelle"]?></option>
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
        <?}?>-->
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
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize situation_flotte">
      <h1 class="bcktitle ajust_title">Situation de la flotte</h1>
      <div class="info_situationflotte">
        <p>Compte : <span ><?=$_SESSION["raisonsociale"]?></span></p>
        <p>Nombre de véhicules : <span> <?=count($tbl_list_vehicule)?></span></p>
        <p>Nombre de véhicules en activité : <span> <?=$nbgo?></span></p>
        <p>Nombre de véhicules à l'arrêt : <span> <?=$nbstay?></span></p>
      </div>
      <?=showexport("situation",array("Date","état","Véhicule","position"),array("time","moteur","nomvehicule","adresse"))?>
    </div>
  </div>
  <div class="bottom_content">
    <table class="tableau_content">
      <tr>
        <th><div class="active_tableau"><a href="#">Date</a></div></th>
        <th><div><a href="">état</a></div></th>
        <th><div><a href="">Véhicule</a></div></th>
        <th><div><a nohref>Position</a></div></th>
		 <?if(testoption("sms")){?>
        <th><div><a nohref>SMS</a></div></th>
		 <? }?>
        <th><div><a nohref>Entretien</a></div></th>
      </tr>
      <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
      <tr>
        <td><?=str_replace(" ","<br>",$tbl_list_vehicule[$i]["time"])?></td>
        <td><?etatvoituremini($tbl_list_vehicule[$i]["couleur"],$tbl_list_vehicule[$i]["phantom_device_id"])?></td>
        <td><span><?=$tbl_list_vehicule[$i]["nomvehicule"]?></span><img class="seemore_img" src="<?=__racineweb__?>/tpl/img/plus_ico.png">
          <div class="morecontent_tableau">
            <p>Véhicule : <span class="uppercase font-italic"><?=$tbl_list_vehicule[$i]["marque"]?></span> <?=$tbl_list_vehicule[$i]["modele"]?></p>
            <p>Immatriculation : <span><?=$tbl_list_vehicule[$i]["immatriculation"]?></span></p>
            <!--<p>Type : <span><?=$key_list_type[$tbl_list_vehicule[$i]["type_compte_id"]]?></span></p>
            <p>Catégorie : <span><?=$tbl_list_vehicule[$i]["listcat"]?></span></p>-->
			<p>N° SIM : <span><?=$tbl_list_vehicule[$i]["telboitier"]?></span></p>
			<p>N° Boîtier : <span><?=$tbl_list_vehicule[$i]["IMEI"]?></span></p>
          </div>
        </td>
        <td><?=$tbl_list_vehicule[$i]["adresse"]?></td>
        <!-- <td><?etatgps($tbl_list_vehicule[$i]["user_id"])?></td>  -->
        <?if(testoption("sms")){?>
			<td>
			<?if($tbl_list_vehicule[$i]["tel"]!=""){?><a href="<?=__racineweb__?>/tpl/sms/send.php?num=<?=$tbl_list_vehicule[$i]["tel"]?>" data-fancybox-type="iframe" class="fancyiframe">Envoyer<br>un SMS</a><?}?>
			</td>
		<?}?>
      <td>
      <?if($tbl_list_vehicule[$i]["entretien"]!=""){?>
      Entretien <img class="seemore_img" src="<?=__racineweb__?>/tpl/img/plus_ico.png">
      <div class="morecontent_tableau">
      <?=$tbl_list_vehicule[$i]["entretien"]?>
      <?}?>
      </div>
      </td>
      </tr>
      
      <?}?>    
    </table>
  </div>
</div>
    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/situation.js"></script>
    
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
