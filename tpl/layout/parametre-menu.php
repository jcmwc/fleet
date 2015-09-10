    <div class="main_resize">
      <div class="resize parambloc">
        <h1 class="bcktitle ajust_title">Parametre du compte</h1>
        <ul>
          <li class="font-bold"><a href="#" class='<?if($_GET["mainmenu"]==1){?>active_menu02<?}?> see_more_param2'>Administration du site</a></li>
          <div class="relative_info_bloc ss_img_bloc">
            <div class="ss_menu">
            <?if(verifdroit("AGE")){?>
              <li><a href="<?=urlp($_GET["arbre"])?>?template=default" <?=($_GET["template"]=="default"||$_GET["template"]=="")?"class=\"active_menu02\"":""?>>Agences</a></li>
            <?}?>
            <?if(verifdroit("USER")){?>  
              <li><a href="<?=urlp($_GET["arbre"])?>?template=utilisateurs" <?=($_GET["template"]=="utilisateurs")?"class=\"active_menu02\"":""?>>Utilisateurs</a></li>            
            <?}?>
            <?if(verifdroit("LIEU")){?>  
              <li><a href="<?=urlp($_GET["arbre"])?>?template=typeslieux" <?=($_GET["template"]=="typeslieux")?"class=\"active_menu02\"":""?>>Types de lieux</a></li>
              <li><a href="<?=urlp($_GET["arbre"])?>?template=lieux" <?=($_GET["template"]=="lieux")?"class=\"active_menu02\"":""?>>Lieux</a></li>
            <?}?>
            <?if(verifdroit("VEH")){?>
              <li><a href="<?=urlp($_GET["arbre"])?>?template=tv" <?=($_GET["template"]=="tv")?"class=\"active_menu02\"":""?>>Types de véhicules</a></li>
              <li><a href="<?=urlp($_GET["arbre"])?>?template=catveh" <?=($_GET["template"]=="catveh")?"class=\"active_menu02\"":""?>>Catégories de véhicules</a></li>
              <li><a href="<?=urlp($_GET["arbre"])?>?template=veh" <?=($_GET["template"]=="veh")?"class=\"active_menu02\"":""?>>Véhicules</a></li>
            <?}?>
            </div>
            <img class="see_more_param" src="<?=__racineweb__?>/tpl/img/plus_ico.png" alt="See more">
          </div>
        </ul>
        <?if(testoption("ALAR")){?>
        <?if(verifdroit("ALA")){?>
        <ul>
          <li class="font-bold alarmes_menu_li"><a href="#" class='<?if($_GET["mainmenu"]==2){?>active_menu02<?}?> see_more_param2'>Alarmes</a></li>
          <div class="relative_info_bloc ss_img_bloc">
           <div class="ss_menu">
            <li><a href="<?=urlp($_GET["arbre"])?>?template=alarme" <?=($_GET["template"]=="alarme")?"class=\"active_menu02\"":""?>>Alarmes Sociales</a></li>
            <li><a href="<?=urlp($_GET["arbre"])?>?template=alarme2" <?=($_GET["template"]=="alarme2")?"class=\"active_menu02\"":""?>>Alarmes Operationelles</a></li>
            <li><a href="<?=urlp($_GET["arbre"])?>?template=alarm-vit" <?=($_GET["template"]=="alarm-vit")?"class=\"active_menu02\"":""?>>Alarmes de vitesse</a></li>            
          </div>
          <img class="see_more_param" src="<?=__racineweb__?>/tpl/img/plus_ico.png" alt="See more">
          </div>
        </ul>
        <?}?>
        <?}?>
        <?if(testoption("ENTR")){?>
        <?if(verifdroit("ENT")){?>
        <ul>
          <li class="font-bold"><a href="#" class='<?if($_GET["mainmenu"]==3){?>active_menu02<?}?> see_more_param2'>Entretien</a></li>
          <div class="relative_info_bloc ss_img_bloc">
            <div class="ss_menu ">
              <li><a href="<?=urlp($_GET["arbre"])?>?template=tyentretien" <?=($_GET["template"]=="tyentretien")?"class=\"active_menu02\"":""?>>Modification des types d'entretien</a></li>
              <li><a href="<?=urlp($_GET["arbre"])?>?template=alarm-entretien" <?=($_GET["template"]=="alarm-entretien")?"class=\"active_menu02\"":""?>>Alarmes d'entretien</a></li>
            </div>
            <img class="see_more_param" src="<?=__racineweb__?>/tpl/img/plus_ico.png" alt="See more">
          </div>
          </ul>
        <?}?>
        <?}?>
        <ul>
          <li class="font-bold"><a href="#" class='<?if($_GET["mainmenu"]==4){?>active_menu02<?}?> see_more_param2'>Gestion du compte</a></li>
          <div class="relative_info_bloc ss_img_bloc">
          <div class="ss_menu ">
            <li><a href="<?=urlp($_GET["arbre"])?>?template=mdp" <?=($_GET["template"]=="mdp")?"class=\"active_menu02\"":""?>>Modifier mon mot de passe</a></li>
            <!--
            <li><a href="<?=urlp($_GET["arbre"])?>?template=def-pref" <?=($_GET["template"]=="def-pref")?"class=\"active_menu02\"":""?>>Définir mes préférences</a></li>
            -->
          </div>
          <img class="see_more_param" src="<?=__racineweb__?>/tpl/img/plus_ico.png" alt="See more">
          </div>
          </ul>
          <ul>
            <li class="font-bold"><a href="#" class='<?if($_GET["mainmenu"]==5){?>active_menu02<?}?> see_more_param2'>Paramètres globaux</a></li>
            <div class="relative_info_bloc ss_img_bloc">
            <div class="ss_menu ">
              <li><a href="<?=urlp($_GET["arbre"])?>?template=etat-moteur" <?=($_GET["template"]=="etat-moteur")?"class=\"active_menu02\"":""?>>Personnalisation des états moteur</a></li>
              <!-- <li><a href="<?=urlp($_GET["arbre"])?>?template=etat-sociaux" <?=($_GET["template"]=="etat-sociaux")?"class=\"active_menu02\"":""?>>Personnalisation des états sociaux</a></li>  -->
              <li><a href="<?=urlp($_GET["arbre"])?>?template=preference" <?=($_GET["template"]=="preference")?"class=\"active_menu02\"":""?>>Préférences</a></li>
            </div>
          <img class="see_more_param" src="<?=__racineweb__?>/tpl/img/plus_ico.png" alt="See more">
        </div>
        </ul>
    </div>
</div>