<div class="container">
<?cache_require("rapport-menu.php")?>
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize rapport_km">
      <h1 class="bcktitle ajust_title">Rapport kilométrique</h1>
      <form class="form_rapportkm" action="<?=urlp($_GET["arbre"])?>" method="post">
       <input type="hidden" value="kilometrique" name="template">
       <input type="hidden" value="<?=$_POST["agence"]?>" name="agence">
        <span>Pour la période :</span>
        <div>
          <label>Du</label>
          <input class="datepicker first_input" name="date_debut" type="text" id="datepicker" value="<?=$_POST["date_debut"]?>">
          <input class="second_input timepicker" name="heure_debut" type="text" value="<?=$_POST["heure_debut"]?>">
        </div>
        <div>
          <label>Au</label>
          <input class="first_input datepicker" name="date_fin" type="text" value="<?=$_POST["date_fin"]?>">
          <input class="second_input timepicker" name="heure_fin" type="text" value="<?=$_POST["heure_fin"]?>">
        </div>
        <div class="content_filt_submit">
          <input class="submit_butt" type="submit" value="Valider">
        </div> 
      </form>
      <span class="info_rapportkm">
        <p>Cumul total des distances : <span><?=$totalalldistance?></span> km</p>
        <p>Cumul total du carburant consommé : <span><?=$totalallconso?> </span>L</p>
        <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png"></a>
        <?=showexport("kilometrique",array("Véhicule","Distance","Durée (min)","Conso. Théorique","Conso. Carburant"),array("nomvehicule","km","datediff","consotheorique","conso"))?>
      </span>
    </div>
  </div>
   <div class="bottom_content">
  <table class="tableau_content tableau_comtperapport">
    <tr>
      <th><div class="active_tableau"><a href="#">Véhicule</a></div></th>
      <!-- <th><div><a href="#">Relevé initial</a></div></th> -->
      <!-- <th><div><a href="#">Relevé final</a></div></th> -->
      <th><div><a href="#">Distance</a></div></th>
      <th><div><a href="#">Durée (min)</a></div></th>
      <th><div><a href="#">Conso. Théorique</a></div></th>
      <th><div><a href="#">Conso. Carburant</a></div></th>
    </tr>
    <?for($i=0;$i<count($tbl_list_vehicule);$i++){?>
    <tr>
      <td><?=$tbl_list_vehicule[$i]["nomvehicule"]?> <img class="seemore_img"src="<?=__racineweb__?>/tpl/img/plus_ico.png">
        <div class="morecontent_tableau">
          <p>Véhicule : <span class="uppercase font-italic"><?=$tbl_list_vehicule[$i]["marque"]?></span> <?=$tbl_list_vehicule[$i]["modele"]?></p>
          <p>Immatriculation : <span><?=$tbl_list_vehicule[$i]["immatriculation"]?></span></p>
          <p>Type : <span><?=$key_list_type[$tbl_list_vehicule[$i]["type_compte_id"]]?></span></p>
          <p>Catégorie : <span><?=$tbl_list_vehicule[$i]["listcat"]?></span></p>  
        </div>
      </td>                                     
      <!--
      <td><?=$tbl_list_vehicule[$i]["kminit"]?> km</td>
      <td><?=$tbl_list_vehicule[$i]["kminit"]+$tbl_list_vehicule[$i]["km"]?> km </td>-->
      <td><?=(int)$tbl_list_vehicule[$i]["km"]?> km</td>
      <td><?=$tbl_list_vehicule[$i]["datediff"]?></td>      
      <td><?=$tbl_list_vehicule[$i]["consotheorique"]?> L/100km </td>
      <td><?=$tbl_list_vehicule[$i]["conso"]?> L</td>
    </tr> 
    <?}?>   
  </table>
  </div>
</div>


    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    
    <script src="<?=__racineweb__?>/tpl/js/compterapport.js"></script>
    
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
