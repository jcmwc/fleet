<?
require("../../require/function.php");
testGenRulesDie("EXP");
function contenuarbre($value,$arbre_id){
      $tabkey=array();
      $tabvalue=array();
      foreach($value as $key2 => $value2 ){
        //print $key2."<br>";
        if(!is_array($value2)){
          $tabkey[]=$key2;
          $tabvalue[]="'".str_replace("'","\'",$value2)."'";
        }
      } 
      if(count($tabkey)>0){
        $sql="insert into ".__racinebd__."contenu (arbre_id,".implode(",",$tabkey).") values (".$arbre_id.",".implode(",",$tabvalue).")";
        //print $sql."<br>";
        
        $link=query($sql);
        return insert_id();
      }
}
function contentarbre($value,$contenu_id){
      
        $tabkey=array();
        $tabvalue=array();
        foreach($value as $key2 => $value2 ){
          //print $key2."<br>";
          if(!is_array($value2)){
            $tabkey[]=$key2;
            $tabvalue[]="'".str_replace("'","\'",$value2)."'";
          }
        } 
        if(count($tabkey)>0){
          $sql="insert into ".__racinebd__."content (contenu_id,".implode(",",$tabkey).") values (".$contenu_id.",".implode(",",$tabvalue).")";
          //print $sql."<br>";
        
          $link=query($sql);
        }
        /*
        $arbre_id=insert_id();
        */      
}
function importarbre($tab,$arbre_id){
  $arbre_id=($arbre_id=="root1")?"":$arbre_id;
  foreach( $tab as $key => $value ){
    //print $value."<br>";
    $tabkey=array();
    $tabvalue=array();
    foreach( $value as $key2 => $value2 ){
      //print $key2."<br>";
      if(!is_array($value2)){
        $tabkey[]=$key2;
        $tabvalue[]="'".str_replace("'","\'",$value2)."'";
      }
    }
    if($arbre_id!=""){
      //on regarde le pere et le root
      $sql="select root from ".__racinebd__."arbre where arbre_id=".$arbre_id;
      $link=query($sql);
      $tbl_result=fetch($link);
      if($tbl_result["root"]==""){
        $sql="insert into ".__racinebd__."arbre (".implode(",",$tabkey).",pere,root) values (".implode(",",$tabvalue).",".$arbre_id.",".$arbre_id.")";
      }else{
        $sql="insert into ".__racinebd__."arbre (".implode(",",$tabkey).",pere,root) values (".implode(",",$tabvalue).",".$arbre_id.",".$tbl_result["root"].")";
      }
    }else{
      $sql="insert into ".__racinebd__."arbre (".implode(",",$tabkey).") values (".implode(",",$tabvalue).")";
    }
    //print $sql."<br>";
    
    $link=query($sql);
    $arbre_id=insert_id();
    
    if(is_array($value["contenu"])){
      if(is_array($value["contenu"][0])){
        for($i=0;$i<count($value["contenu"]);$i++){
          $contenu_id=contenuarbre($value["contenu"][$j],$arbre_id);
          if(is_array($value["contenu"]["content"])){
            if(is_array($value["contenu"]["content"][0])){
              for($j=0;$j<count($value["contenu"]["content"]);$j++){
                contentarbre($value["contenu"]["content"][$j],$contenu_id);
              }
            }else{
              contentarbre($value["contenu"]["content"],$contenu_id);
            }
          }
        }
      }else{
        $contenu_id=contenuarbre($value["contenu"],$arbre_id);
        if(is_array($value["contenu"]["content"])){
          if(is_array($value["contenu"]["content"][0])){
            for($j=0;$j<count($value["contenu"]["content"]);$j++){
              contentarbre($value["contenu"]["content"][$j],$contenu_id);
            }
          }else{
            contentarbre($value["contenu"]["content"],$contenu_id);
          }
        }
      }
    }
    if(is_array($value["childs"])){
      if($value["childs"]["arbre"]==""){
        for($i=0;$i<count($value["childs"]);$i++){
          //print $value["childs"][$i]."ici";
          if(is_array($value["childs"][$i])){
            importarbre($value["childs"][$i],$arbre_id);
          }
        }
      }else{
        importarbre($value["childs"],$arbre_id);
      }
    }
  }
}
if($_FILES["fichier"]["tmp_name"]!=""){
  //print_r(readdump($_FILES["fichier"]["tmp_name"]));
  $tab=readdump($_FILES["fichier"]["tmp_name"]);
  importarbre($tab,$_GET["arbre_id"]);
}
require("../../include/template_haut.php");?>
<form  target="framecontent" action="<?=$_SERVER["PHP_SELF"]?>?arbre_id=<?=$_GET["arbre_id"]?>" method="post" enctype="multipart/form-data" onsubmit="return validateImport(this)">
<input type="hidden" name="fichiertxt" value="<?=$trad["Veuillez choisir un fichier"]?>" />
<center>
  <?=$trad["Fichier"]?> <input type="file" name="fichier" /><input type="submit" name="valider" value="<?=$trad["valider"]?>" />
</center>
</form>
<?require("../../include/template_bas.php");?>