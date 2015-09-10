<div style="position : absolute; top : 0; left : 0px; width : <?=__widtharbre__+20?>px; border-top : solid 4px #006666; border-bottom : solid 4px #006666; border-right : solid 4px #006666; background-color:#DDDDDD; font-family:Arial;z-index:50000" id="contenaire_arbre">
 <div onClick="javascript:show_arbre();" style="left : <?=(__widtharbre__+24)?>px;" id="img_pointer_arbre" class="img_pointer_arbre_on"></div>
  <div style="float : left; width : <?=__widtharbre__?>px; background-color:#DDDDDD; min-height : 320px;">
	  <div id="choix_de_langue" style="width : 190px; background-color:#DDDDDD; height : 20px; padding-left : 10px; padding-top : 5px; font-size : 12px;">
    <!-- Selecteur -->
    <?php
    $requete = "select * from ".__racinebd__."langue where active=1 order by libelle";
    $resultat = query($requete);
    if(num_rows($resultat)>1){
		  echo "<select id='options' name='options' class='autocomplete'>";
	    while ($ligne=fetch($resultat)){
    	   //echo "<option value='".$ligne['shortlib']."|../images/langue/".$ligne['shortlib'].".gif' ".(($_POST["langue_id"]==$ligne['langue_id'])?"selected":"").">&nbsp;".$ligne['libelle']."</option>";
    	   echo "<option value='".$ligne['shortlib']."|".__uploaddir__.__racinebd__."langue".$ligne['langue_id'].".".$ligne['ext']."' ".(($_POST["langue_id"]==$ligne['langue_id'])?"selected":"").">&nbsp;".$ligne['libelle']."</option>";
    	}
      echo "</select>";	
		  echo "<script type='text/javascript'>";
		  echo" new Autocompleter.SelectBox('options',{width:'150',margin:'0',padding:'0',redirect:'?lang='});";
		  echo"</script>";
		}
    ?>
    </div>
    <div id="arbre_new" style="position:relative;min-width : <?=__widtharbre__?>px; background-color:#DDDDDD; min-height : 315px;padding-bottom:20px;overflow-x : scroll;overflow-y : hidden"></div>
    <div style="clear : both"></div>
    </div>
    <div style="width:20px;height:100%;float:left;background-color:#DDDDDD;bottom:0px;">
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
                    echo "<li><a href=\"javascript:ajout(".$ligne_name["gabarit_id"].",".$_POST["langue_id"].")\" >".$ligne_name["libelle"]."</a></li>";
                }
                ?></ul></td></tr></table></span></a>
                </div>
        <div><a href="javascript:informations()" class="enabled" title="<?=$trad["Informations"]?>"><img src="<?=__reparbre__?>icones_arbre/informations.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:verrou()" class="enabled" title="<?=$trad["Verrouiller/Déverrouiller"]?>"><img src="<?=__reparbre__?>icones_arbre/verrouiller.gif" width="20" height="20" border="0"  /></a></div>
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
        <div><a href="javascript:supprimer()" class="enabled" title="<?=$trad["Supprimer"]?>"><img src="<?=__reparbre__?>icones_arbre/supprimer.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="#" onclick="renommer()" class="enabled" title="<?=$trad["Renommer"]?>"><img src="<?=__reparbre__?>icones_arbre/renommer.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:copier()" class="enabled" title="<?=$trad["Copier"]?>"><img src="<?=__reparbre__?>icones_arbre/copier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:couper()" class="enabled" title="<?=$trad["Couper"]?>"><img src="<?=__reparbre__?>icones_arbre/couper.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:coller()" class="enabled" title="<?=$trad["Coller"]?>"><img src="<?=__reparbre__?>icones_arbre/coller.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:enpremier()" class="enabled" title="<?=$trad["En premier"]?>"><img src="<?=__reparbre__?>icones_arbre/en_premier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:plushaut()" class="enabled" title="<?=$trad["Plus haut"]?>"><img src="<?=__reparbre__?>icones_arbre/plus_haut.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:plusbas()" class="enabled" title="<?=$trad["Plus bas"]?>"><img src="<?=__reparbre__?>icones_arbre/plus_bas.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:endernier()" class="enabled" title="<?=$trad["En dernier"]?>"><img src="<?=__reparbre__?>icones_arbre/en_dernier.gif" width="20" height="20" border="0" /></a></div>
        <div><a href="javascript:creeralias()" class="enabled" title="<?=$trad["Créer un alias"]?>"><img src="<?=__reparbre__?>icones_arbre/creer_alias.gif" width="20" height="20" border="0" /></a></div>
        <div id="menu_voir">
        <a href="#" class="enabled ss_menu_nouveau" title="<?=$trad["Aperçu"]?>"><img src="<?=__reparbre__?>icones_arbre/voir.gif" width="20" height="20" border="0" />
        <span class="ss_menu_nouveau"><table><tr><td><ul>
            <?php
        				$requete_name = "select libelle,version_id from ".__racinebd__."version order by version_id";
                $link_name=query($requete_name);
                while ($ligne_name=fetch($link_name)){
                    echo "<li><a href=\"javascript:show(".$_POST["langue_id"].",".$ligne_name["version_id"].")\" >".$trad[$ligne_name["libelle"]]."</a></li>";
                }
                ?></ul></td></tr></table></span></a>
        </div>
        <div><a href="javascript:publier()" class="enabled" title="<?=$trad["Publier"]?>"><img src="<?=__reparbre__?>icones_arbre/publier.gif" width="20" height="20" border="0" /></a></div>
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
                        echo "<img src='../../upload/".__racinebd__."gabarit".$ligne_name["gabarit_id"].".".$ligne_g["iconnormal"]."' />&nbsp;".$ligne_name["libelle"]."<br/>";
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
                        echo "<img src='../../upload/".__racinebd__."gabarit2_".$ligne_name["gabarit_id"].".".$ligne_g["iconsecure"]."' />&nbsp;".$ligne_name["libelle"]."<br/>";
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