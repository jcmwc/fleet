<!-- debut contenaire_texte -->
<div id="contenaire_texte">
  <?if($_SESSION['islog']!=""){?>
  <ul id="menu">
    <?
      for($i=0;$i<count($tabmenu);$i++){
      $bool = 1;
      if(is_array($tabmenu[$i][1])){
      ?>     
      <li class="bt_menu" onmouseover="showhideMenu(this,'block')"  onmouseout="showhideMenu(this,'none')"><?=$tabmenu[$i][0]?>&nbsp;      
        <ul class="sous_menu" id="sous_menu_<?=$i?>">
        <?
        foreach($tabmenu[$i][1] as $key => $value){
        $tab=explode(":",$value);
        if($bool == 1){
          if(count($tab)>1){?>
            <li class="color_1" onmouseover="fond(this)" onmouseout="nofond_1(this)"><a href="<?=$value?>" target="framecontent"><?=$key?></a>&nbsp;</li>
          <?}else{?>
            <li class="color_1" onmouseover="fond(this)" onmouseout="nofond_1(this)"><a href="<?=$value?>?mode=list&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$key?></a>&nbsp;</li>
          <?}
          $bool = 2;
        } else {
          if(count($tab)>1){?>
            <li class="color_2" onmouseover="fond(this)" onmouseout="nofond_2(this)"><a href="<?=$value?>" target="framecontent"><?=$key?></a>&nbsp;</li>
          <?}else{?>
            <li class="color_2" onmouseover="fond(this)" onmouseout="nofond_2(this)"><a href="<?=$value?>?mode=list&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$key?></a>&nbsp;</li>
          <?}
          $bool = 1;
          }
        }?>
        </ul>
      </li>
      <?}else if(is_array($tabmenu[$i][2])){?>
        <li class="bt_menu" onmouseover="show('sous_menu_<?=$i?>')"  onclick="window.location='<?=$tabmenu[$i][1]?>?mode=list'"><?=$tabmenu[$i][0]?>
          <ul class="sous_menu" id="sous_menu_<?=$i?>" onmouseout="cache('sous_menu_<?=$i?>')">
            <li class="color_1" onmouseover="fond(this)" onmouseout="nofond_1(this)"><a href="<?=$tabmenu[$i][1]?>?mode=ajout&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$tabmenu[$i][2][0]?></a></li>
            <li class="color_2" onmouseover="fond(this)" onmouseout="nofond_2(this)"><a href="<?=$tabmenu[$i][1]?>?mode=list&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$tabmenu[$i][2][1]?></a></li>
          </ul>
        </li>
      <?}else{
        $tab=explode(":",$tabmenu[$i][1]);
        if(count($tab)>1){?>
          <li class="bt_menu2"><a href="<?=$tabmenu[$i][1]?>" target="framecontent"><?=$tabmenu[$i][0]?>&nbsp;</a></li>
        <?}else{?>
          <li class="bt_menu2"><a href="<?=$tabmenu[$i][1]?>?mode=list&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$tabmenu[$i][0]?>&nbsp;</a></li>
        <?}
      }
    }?>
  </ul>
<?
}
if($_SESSION["islog"]==1){?>
  <div class="btn_05"><a href="../home/index.php?deco=out"><?=$trad["Deconnexion"]?></a></div>
  <!--<div class="btn_06"><a href="<?=__urlsite__.__racine__?>">Retour site</a></div>-->
<?}?>
<div class="clear"></div>