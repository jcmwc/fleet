  <div class="container">
<?cache_require("rapport-menu.php")?>
  <div class="main_resize backgroundbloc ajustmargin">
    <div class="resize rapport_km">
      <h1 class="bcktitle ajust_title">Rapport horaire</h1>
      <form class="form_rapportkm" action="<?=urlp($_GET["arbre"])?>" method="post">
      <input type="hidden" value="horaire" name="template">
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
        
        <a href="javascript:window.print()"><img src="<?=__racineweb__?>/tpl/img/imprimer_ico.png"></a>
        <?=showexport("horaire",array("Véhicule","Nb. d'heures d'utilisation"),array("nomvehicule","datediff"))?>
      </span>
    </div>
  </div>
  <div class="bottom_content">
    <table class="tableau_content tableau_comtperapport">
      <tr>
        <th><div class="active_tableau"><a href="#">Nom du véhicule</a></div></th>
        <!--
        <th><div><a href="#">Immatriculation</a></div></th>
        <th><div><a href="#">Agence</a></div></th>-->
        <th><div><a href="#">Nb. d'heures d'utilisation</a></div></th>
        <!--
        <th><div><a href="#">Relevé init.</a></div></th>
        <th><div><a href="#">Relevé final</a></div></th>
        -->
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
        <td>912443416</td>
        <td>3F ASSISTANCE</td>-->
        <td><?=$tbl_list_vehicule[$i]["datediff"]?></td>
        <!--
        <td>47 h </td>
        <td>49 h </td>
        -->
      </tr>
      <?}?>
    </table>
  </div>
</div>



    </div><!-- end .main-wrapper -->
    <script src="<?=__racineweb__?>/tpl/js/app.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-horaire.js"></script>
    <script src="<?=__racineweb__?>/tpl/js/rapport-menu2.js"></script>   
    
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
