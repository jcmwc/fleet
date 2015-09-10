 </div> <!-- #content -->
 <div id="topNav">
		 <ul>
		 	<li>
		 		  <?if($_SESSION["islog"]==1){?>
		 		<a href="#menuProfile" class="menu"><?=showlogin()?></a>
		 		<?}?>
		 		<?php
		        if(count($tabmenu2)>0&&__light__!=true){
		        ?>
		 		<div id="menuProfile" class="menu-container menu-dropdown">
					<div class="menu-content">
						<ul class="">
						<?php for($i=0;$i<count($tabmenu2);$i++){
        				echo "<li><a href=\"".$tabmenu2[$i][1]."?mode=list\" target=\"framecontent\">".$tabmenu2[$i][0]."</a></li>";
	        				}?>
						</ul>
					</div>
				</div>
				<?}?>
	 		</li>
		 	<?php if($_SESSION["islog"]==1){?>
		 	<li><a href="../home/index.php?deco=out"><?=$trad["Deconnexion"]?></a></li>
		 	<?}?>
		 </ul>
	</div> <!-- #topNav -->
	
<div id="quickNav">
  <? if($_SESSION['islog']!=""){ ?>
  	<ul>
    <?
      for($i=0;$i<count($tabmenu);$i++){
      $bool = 1;
      if(is_array($tabmenu[$i][1])){
      ?>
      <li class="menu_<?=$i?>">
      <a href="#sous_menu_<?=$i?>" class="menu"><?=$tabmenu[$i][0]?></a>	
        <div id="sous_menu_<?=$i?>" class="menu-container menu-dropdown">
					<div class="menu-content">
						<ul class="">
						<?
        foreach($tabmenu[$i][1] as $key => $value){
        $tab=explode(":",$value);
        if($bool == 1){
          if(count($tab)>1){?>
            <li><a href="<?=$value?>" target="framecontent"><?=$key?></a>&nbsp;</li>
          <? }else{ ?>
            <li><a href="<?=$value?>?mode=list&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$key?></a>&nbsp;</li>
          <? }
          $bool = 2;
        } else {
          if(count($tab)>1){ ?>
            <li><a href="<?=$value?>" target="framecontent"><?=$key?></a>&nbsp;</li>
          <? }else{ ?>
            <li><a href="<?=$value?>?mode=list&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$key?></a>&nbsp;</li>
          <? }
          $bool = 1;
          }
        } ?>
						</ul>
					</div>				
					</div>
      </li>
      <? } else if(is_array($tabmenu[$i][2])){ ?>      
        <li class="menu_<?=$i?>">
        <a href="<?=$tabmenu[$i][1]?>?mode=list" class="menu-master"><?=$tabmenu[$i][0]?></a>
        	
        	<div id="sous_menu_<?=$i?>" class="menu-container menu-dropdown">
					<div class="menu-content">
						<ul class="">
							<li><a href="<?=$tabmenu[$i][1]?>?mode=ajout&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$tabmenu[$i][2][0]?></a></li>
							<li><a href="<?=$tabmenu[$i][1]?>?mode=list&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$tabmenu[$i][2][1]?></a></li>
						</ul>
					</div>				
					</div>
        </li>
      <? } else {
        $tab=explode(":",$tabmenu[$i][1]);
        if(count($tab)>1){?>
          <li><a href="<?=$tabmenu[$i][1]?>" target="framecontent"><?=$tabmenu[$i][0]?>&nbsp;</a></li>
        <? }else{ ?>
          <li><a href="<?=$tabmenu[$i][1]?>?mode=list&lang=<?=$_GET["lang"]?>" target="framecontent"><?=$tabmenu[$i][0]?>&nbsp;</a></li>
        <? }
        }
    } ?>
  </ul>
<?
} ?>
</div> <!-- .quickNav -->
</div>
<div id="footer">

</div>
</div>
</body>
</html>
<?@bdd_close();?>