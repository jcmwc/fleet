<div id="dialog-form" title="<?=$trad["Renommer"]?>">
   <input type="text" name="rennametxt" id="rennametxt" class="text ui-widget-content ui-corner-all" style="width:95%;padding:.4em;"/>  
</div>
<div id="dialog" style="display:none">
<iframe width="100%" height="100%" src=""  marginheight="0" marginwidth="0" frameBorder="0" border="0" id="contentdialog" ></iframe>
</div>

<div style="position : absolute; top : 0px; left : 0px; width : 320px; z-index:50000" id="contenaire_arbre">
<div class="top_header">
<h1><a href="<?=__racineadmin__?>/index.php"><?=__name__?></a><span><?if(__light__==true){?>Light<?}else{?>v <?=__version__?><?}?></span></h1>
</div>	
<div onClick="javascript:show_arbre();" style="left :290px; " id="img_pointer_arbre"><span class="reveal-bar"></span><span class="reveal-bar"></span><span class="reveal-bar"></span></div>
  <div style="float : left; width : 320px; background-color:transparent; min-height : 320px;" class="container_arbre">
	  <div id="choix_de_langue">
    <!-- Selecteur -->
    <?php
    $requete = "select * from ".__racinebd__."langue where active=1 order by libelle";
    $resultat = query($requete);
    if(num_rows($resultat)>1){
		  echo "<select id='options' name='options' onchange=\"locationlangue(this)\">";
	    while ($ligne=fetch($resultat)){
    	   //echo "<option value='".$ligne['shortlib']."|../images/langue/".$ligne['shortlib'].".gif' ".(($_POST["langue_id"]==$ligne['langue_id'])?"selected":"").">&nbsp;".$ligne['libelle']."</option>";
    	   echo "<option value='".$ligne['shortlib']."|".__uploaddir__.__racinebd__."langue".$ligne['langue_id'].".".$ligne['ext']."' ".(($_POST["langue_id"]==$ligne['langue_id'])?"selected":"").">&nbsp;".$ligne['libelle']."</option>";
    	}
      echo "</select>";	
      /*
		  echo "<script type='text/javascript'>";
		  echo" new Autocompleter.SelectBox('options',{width:'150',margin:'0',padding:'0',redirect:'?lang='});";
		  echo"</script>";
      */
		}
    ?>
    
    <div id="languagesBevel"></div>
    </div>
    <div id="arbre_new"></div>
    <div style="clear : both"></div>
    </div>
    <div style="width:20px;height:100%;float:left;background-color:transparent;top:137px;position:absolute;right:0px;">
        <div><a href="javascript:refreshA()" class="enabled" title="<?=$trad["Actualiser"]?>"><img src="<?=__reparbre__?>icones_arbre/refresh.gif"  width="20" height="20" border="0" /></a></div>
        <div id="menu_nouveau">
        <a href="#" class="enabled ss_menu_nouveau" title="<?=$trad["Nouveau"]?>">
        		<img src="<?=__reparbre__?>icones_arbre/nouvel_article.gif"  width="20" height="20" border="0" />
        		<span class="ss_menu_nouveau" style="top:-20px;"><table><tr><td><ul><?php
        		    $myobj=&$_SESSION['obj_users_id'];
        		    if($myobj->user_id=="-1"){
        				  $requete_name = "select libelle,gabarit_id from ".__racinebd__."gabarit where supprimer=0 order by libelle";
        				}else{
                  $requete_name = "select libelle,gg.gabarit_id from ".__racinebd__."gabarit g inner join ".__racinebd__."groupe_gabarit gg on g.gabarit_id=gg.gabarit_id and gg.groupe_id in(".$_SESSION['obj_users_id']->listgroupeid.") where supprimer=0 group by g.gabarit_id order by g.libelle";
                }
                $link_name=query($requete_name);
                while ($ligne_name=fetch($link_name)){
                    //echo "<li><a href=\"javascript:ajout(".$ligne_name["gabarit_id"].",".$_POST["langue_id"].")\" >".$ligne_name["libelle"]."</a></li>";
                    echo "<li><a href=\"javascript:action('gabarit".$ligne_name["gabarit_id"]."')\" >".$ligne_name["libelle"]."</a></li>";
                }
                ?></ul></td></tr></table></span></a>
                </div>
        <div><a href="javascript:action('informations')" class="enabled" title="<?=$trad["Informations"]?>"><img src="<?=__reparbre__?>icones_arbre/informations.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('verrouiller')" class="enabled" title="<?=$trad["Verrouiller/Déverrouiller"]?>"><img src="<?=__reparbre__?>icones_arbre/verrouiller.gif" width="20" height="20" border="0"  /></a></div>
        <div id="menu_modifier">
        <a href="#" class="enabled ss_menu_nouveau" title="Modifier"><img src="<?=__reparbre__?>icones_arbre/modifier.gif" width="20" height="20" border="0" />
        <span class="ss_menu_nouveau"><table><tr><td>
              <ul>
              <?php
        				$requete_name = "select libelle,version_id from ".__racinebd__."version order by version_id";
                $link_name=query($requete_name);
                while ($ligne_name=fetch($link_name)){
                    echo "<li><a href=\"javascript:modifier(".$_POST["langue_id"].",".$ligne_name["version_id"].")\" >".$trad[$ligne_name["libelle"]]."</a></li>";
                }
                ?>
                </ul></td></tr></table></span></a>
        </div>
        <div><a href="javascript:action('supprimer')" class="enabled" title="<?=$trad["Supprimer"]?>"><img src="<?=__reparbre__?>icones_arbre/supprimer.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('renommer')" class="enabled" title="<?=$trad["Renommer"]?>"><img src="<?=__reparbre__?>icones_arbre/renommer.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('copier')" class="enabled" title="<?=$trad["Copier"]?>"><img src="<?=__reparbre__?>icones_arbre/copier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('couper')" class="enabled" title="<?=$trad["Couper"]?>"><img src="<?=__reparbre__?>icones_arbre/couper.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('coller')" class="enabled" title="<?=$trad["Coller"]?>"><img src="<?=__reparbre__?>icones_arbre/coller.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('premier')" class="enabled" title="<?=$trad["En premier"]?>"><img src="<?=__reparbre__?>icones_arbre/en_premier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('haut')" class="enabled" title="<?=$trad["Plus haut"]?>"><img src="<?=__reparbre__?>icones_arbre/plus_haut.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('bas')" class="enabled" title="<?=$trad["Plus bas"]?>"><img src="<?=__reparbre__?>icones_arbre/plus_bas.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('dernier')" class="enabled" title="<?=$trad["En dernier"]?>"><img src="<?=__reparbre__?>icones_arbre/en_dernier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:action('alias')" class="enabled" title="<?=$trad["Créer un alias"]?>"><img src="<?=__reparbre__?>icones_arbre/creer_alias.gif" width="20" height="20" border="0" /></a></div>
        <div id="menu_voir">
        <a href="#" class="enabled ss_menu_nouveau" title="<?=$trad["Aperçu"]?>"><img src="<?=__reparbre__?>icones_arbre/voir.gif" width="20" height="20" border="0" />
        <span class="ss_menu_nouveau"><table><tr><td><ul>
            <?php
        				$requete_name = "select libelle,version_id from ".__racinebd__."version order by version_id";
                $link_name=query($requete_name);
                while ($ligne_name=fetch($link_name)){
                    echo "<li><a href=\"javascript:action('apercu_version".$ligne_name["version_id"]."')\" >".$trad[$ligne_name["libelle"]]."</a></li>";
                }
                ?></ul></td></tr></table></span></a>
        </div>
        <div><a href="javascript:action('publier')" class="enabled" title="<?=$trad["Publier"]?>"><img src="<?=__reparbre__?>icones_arbre/publier.gif" width="20" height="20" border="0" /></a></div>
        <!-- Legende -->
        <div id="menu_modifier">
        <a href="#" class="enabled ss_menu_nouveau2" title="<?=$trad["Legende"]?>" style='text-decoration:none;'><img src="<?=__reparbre__?>icones_arbre/legende.gif" width="20" height="20" border="0" />
         		<span class="ss_menu_nouveau2 "><table><tr><td>
        		<ul style="width:300px">	
        		    <li><center><b>LEGENDE</b></center></li>
        				<?php
        				$requete_name = "select * from ".__racinebd__."etat order by etat_id";
                $link_name=query($requete_name);
                while ($ligne_name=fetch($link_name)){?>
                  <li><div class="<?=$ligne_name["style"]?>"><?=$ligne_name["libelle"]?></div></li>
                <?}?>
                <li><div class="nottranslate">non traduit</div></li>
                <li style="text-decoration:none; ">
                verrouill&eacute;&nbsp;<img src="<?=__reparbre__?>imgs/lock.gif" />
                </li>
                <li style="text-decoration:none; ">
                alias&nbsp;<img src="<?=__reparbre__?>imgs/globe.gif" />
                </li>
                 <li class="legende" >
                <table cellpadding="0" cellspacing="0" width="300">
                  <tr>
                    <td class="table_legende_gabarit legendepadding" width="50%">
                    gabarit normal&nbsp;<br/>
                    </td>
                    <td class="marge" width="50%">
                    gabarit s&eacute;curis&eacute;<br/>
                    </td>
                  </tr>
                  <tr>
                    <td class="taille_table table_legende_gabarit legendepadding">
                    <?php
                    $requete_name = "select libelle,gabarit_id from ".__racinebd__."gabarit where supprimer=0 order by libelle";
                    $link_name=query($requete_name);
                    while ($ligne_name=fetch($link_name)){

                				$requete_g = "select iconnormal from ".__racinebd__."gabarit where gabarit_id = '".$ligne_name["gabarit_id"]."'";
                        $link_g=query($requete_g);
                    
                        while ($ligne_g=fetch($link_g)){ 
                        echo "<img src='".__uploaddir__.__racinebd__."gabarit".$ligne_name["gabarit_id"].".".$ligne_g["iconnormal"]."' />&nbsp;".$ligne_name["libelle"]."<br/>";
                        }
                    }
                    ?>
                    </td>
                    <td class="taille_table marge">
                    <?php
                    $requete_name = "select libelle,gabarit_id from ".__racinebd__."gabarit where supprimer=0 order by libelle";
                    $link_name=query($requete_name);
                    while ($ligne_name=fetch($link_name)){

                				$requete_g = "select iconsecure from ".__racinebd__."gabarit where gabarit_id = '".$ligne_name["gabarit_id"]."'";
                        $link_g=query($requete_g);
                    
                        while ($ligne_g=fetch($link_g)){ 
                        echo "<img src='".__uploaddir__.__racinebd__."gabarit2_".$ligne_name["gabarit_id"].".".$ligne_g["iconsecure"]."' />&nbsp;".$ligne_name["libelle"]."<br/>";
                        }
                    }
                    ?>
                    </td>
                  </tr>
                 </table>
                </li>
          		</ul></td></tr></table></span></a>
        </div>        
        <div style="clear : both"></div>
    </div>
    <div style="clear : both"></div> 
    </div>