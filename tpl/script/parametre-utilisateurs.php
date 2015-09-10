<?
if($_POST["mode"]=="delete"){
   $sql="update ".__racinebd__."usergps set supprimer=1 where usergps_id=".$_POST["id"];
   query($sql);
   $msgsave="Suppression effectuée";
}

//sauvegarde de modification
if($_POST["id"]!=""&&$_POST["mode"]=="modif"){
    if($_POST["pwd"]!=""){
      $pwd=",password='".md5($_POST["pwd"])."'";
    }
    
    
    $szQuery="update ".__racinebd__."usergps set 
					username='".addquote($_POST["username"])."',
					name='".addquote($_POST["name"])."',
          email='".addquote($_POST["email"])."',
          tel='".addquote($_POST["tel"])."'
          $pwd
          where usergps_id=".$_POST["id"];
    
    query($szQuery);
    
    //sauvegarde des agences
    $sql="delete from ".__racinebd__."agence_compte_usergps where usergps_id=".$_POST["id"];
    query($sql);
    for($i=0;$i<count($_POST["agence"]);$i++){
      $sql="insert into ".__racinebd__."agence_compte_usergps (usergps_id,agence_compte_id) values(".$_POST["id"].",".$_POST["agence"][$i].")";
      query($sql);  
    } 
    if(count($_POST["agence"])>0){
      $listagence=implode(",",$_POST["agence"]);
    }else{
      $listagence="0";
    }
    
    //sauvegarde des vehicules
    //$sql="delete from ".__racinebd__."usergps_device where usergps_id=".$_POST["id"];
    $sql="delete from ".__racinebd__."usergps_device where usergps_id=".$_POST["id"];
    query($sql);
    for($i=0;$i<count($_POST["vehicule"]);$i++){
      //vérification que le véhicule est dans une agence autorisée
      $sql="select * from ".__racinebd__."device where device_id=".$_POST["vehicule"][$i]." and agence_compte_id in(".$listagence.")";
      $link=query($sql);
      if(num_rows($link)>0){
        $sql="insert into ".__racinebd__."usergps_device (usergps_id,device_id) values(".$_POST["id"].",".$_POST["vehicule"][$i].")";
        query($sql);  
      }
    }
    //sauvegarde des modules
    $sql="delete from ".__racinebd__."module_usersgps where usergps_id=".$_POST["id"];
    query($sql);
    for($i=0;$i<count($_POST["module"]);$i++){
      $sql="insert into ".__racinebd__."module_usersgps (usergps_id,module_id) values(".$_POST["id"].",".$_POST["module"][$i].")";
      query($sql);  
    }
    //sauvegarde des jours
    $sql="delete from ".__racinebd__."jour_usersgps where usergps_id=".$_POST["id"];
    query($sql);
    for($i=0;$i<count($_POST["jour"]);$i++){
      $sql="insert into ".__racinebd__."jour_usersgps (usergps_id,jour_id) values(".$_POST["id"].",".$_POST["jour"][$i].")";
      query($sql);  
    }   
    //sauvegarde des rapports
    $sql="delete from ".__racinebd__."rapport_usersgps where usergps_id=".$_POST["id"];
    query($sql);
    for($i=0;$i<count($_POST["rapport"]);$i++){
      $sql="insert into ".__racinebd__."rapport_usersgps (usergps_id,rapport_id) values(".$_POST["id"].",".$_POST["rapport"][$i].")";
      query($sql);  
    }
    $msgsave="Sauvegarde effectuée";
}


//sauvegarde d'ajout
if($_POST["id"]==""&&$_POST["mode"]=="ajout"){
    
    $sql="insert into ".__racinebd__."usergps (tel,name,email,password,username,date_creation,compte_id) 
    values('".addquote($_POST["tel"])."','".addquote($_POST["name"])."','".addquote($_POST["email"])."','".md5($_POST["password"])."','".addquote($_POST["username"])."',now(),'".$_GET["pere"]."')";
    query($sql);
          
    $usergpd_id=insert_id();
    
    //sauvegarde des agences
    for($i=0;$i<count($_POST["agence"]);$i++){
      $sql="insert into ".__racinebd__."agence_compte_usergps (usergps_id,agence_compte_id) values(".$usergpd_id.",".$_POST["agence"][$i].")";
      query($sql);  
    } 
    
    //sauvegarde des vehicules
    for($i=0;$i<count($_POST["vehicule"]);$i++){
      $sql="insert into ".__racinebd__."usergps_device (usergps_id,device_id) values(".$usergpd_id.",".$_POST["vehicule"][$i].")";
      query($sql);  
    }
    //sauvegarde des modules
    for($i=0;$i<count($_POST["module"]);$i++){
      $sql="insert into ".__racinebd__."module_usersgps (usergps_id,module_id) values(".$usergpd_id.",".$_POST["module"][$i].")";
      query($sql);  
    }
    
    //sauvegarde des jours
    for($i=0;$i<count($_POST["jour"]);$i++){
      $sql="insert into ".__racinebd__."jour_usersgps (usergps_id,jour_id) values(".$usergpd_id.",".$_POST["jour"][$i].")";
      query($sql);  
    }
    
    //sauvegarde des rapports
    for($i=0;$i<count($_POST["rapport"]);$i++){
      $sql="insert into ".__racinebd__."rapport_usersgps (usergps_id,rapport_id) values(".$usergpd_id.",".$_POST["rapport"][$i].")";
      query($sql);  
    }
    $msgsave="Sauvegarde effectuée";
}

$sql = "select * from ".__racinebd__."usergps ".__racinebd__."usergps where compte_id=".$_SESSION["compte_id"];
$link=query($sql);	
while($tbl=fetch($link)){
  //recherche des modules
  $sql="select cm.*,count(cm.cat_module_id) as nb from ".__racinebd__."cat_module cm inner join ".__racinebd__."module m on cm.cat_module_id=m.cat_module_id group by cm.cat_module_id";
  $link2=query($sql);
  $content="";
  while($tbl2=fetch($link2)){
    $sql="select * from ".__racinebd__."module_usersgps u
    inner join ".__racinebd__."module cm on cm.module_id=u.module_id
    where usergps_id=".$tbl["usergps_id"]." and cat_module_id=".$tbl2["cat_module_id"];
    //print $sql."<br>";
    $link3=query($sql);
    $content.="<div>".$tbl2["libelle"]." : <span> ".num_rows($link3)."/".$tbl2["nb"]." </span></div>";
  }
  $tbl["module"]=$content;  
  //recherche du nombre de vehicule
  $sql="select * from ".__racinebd__."usergps_device where usergps_id=".$tbl["usergps_id"];
  $link4=query($sql);
  $tbl["nbvehicule"]=num_rows($link4);    
  //recherche du nombre de jour
  $sql="select * from ".__racinebd__."jour_usersgps where usergps_id=".$tbl["usergps_id"];
  $link4=query($sql);
  $tbl["nbjour"]=num_rows($link4);
  $tbl_list_user[]=$tbl;
}	
//print_r($tbl_list_user);	

if($_POST["id"]!=""&&$_POST["mode"]==""){
  
   $sql = "select * from ".__racinebd__."usergps ".__racinebd__."usergps where compte_id=".$_SESSION["compte_id"]." and usergps_id=".$_POST["id"];  
   $link=query($sql);
   $tbl_modif_user=fetch($link);
}

$nbchk=0;
$sql="select * from ".__racinebd__."agence_compte where compte_id=".$_SESSION["compte_id"]." and supprimer=0 order by libelle";
$link=query($sql);
while($tbl=fetch($link)){
  //on verifie si l'agence est selectionnée
  $tbl["checked"]=false;
  if($_POST["id"]!=""&&$_POST["mode"]!="delete"){
    $sql="select * from ".__racinebd__."agence_compte_usergps where usergps_id=".$_POST["id"]." and agence_compte_id=".$tbl["agence_compte_id"];
    //print $sql;
    $link2=query($sql);
    if(num_rows($link2)>0){
      $tbl["checked"]=true;
      $nbchk++;  
    }
  }
  $tbl_list_agence[]=$tbl;
}

$sql=getsqllistvehicule();
$link=query($sql);
while($tbl=fetch($link)){
  //on verifie si le vehicule est selectionné
  $tbl["checked"]=false;
  if($_POST["id"]!=""&&$_POST["mode"]!="delete"){
    $sql="select * from ".__racinebd__."usergps_device where usergps_id=".$_POST["id"]." and device_id=".$tbl["phantom_device_id"];
    
    $link2=query($sql);
    if(num_rows($link2)>0){
      $tbl["checked"]=true;
      $nbchk++;  
    }
  }
  $tbl_list_vehicule[]=$tbl;
}

$sql="select * from ".__racinebd__."cat_module";
$link=query($sql);
$content="<div class=\"left main_resize\">";
$i=0;
while($tbl=fetch($link)){
$content.="
  <div class=\"p_checkbox_veh\">
    <p>".$tbl["libelle"]."</p>";
    
    $sql="select * from ".__racinebd__."module cm 
    where cat_module_id=".$tbl["cat_module_id"];
    $link2=query($sql);
    while($tbl2=fetch($link2)){
      //on verifie si le vehicule est selectionné
      $checked="";
      if($_POST["id"]!=""&&$_POST["mode"]!="delete"){
        $sql="select * from ".__racinebd__."module_usersgps where usergps_id=".$_POST["id"]." and module_id=".$tbl2["module_id"];
        $link3=query($sql);
        if(num_rows($link3)>0){
          $checked="checked";
        }
      }
      $content.="
      <div class=\"checkbox_veh\">
        <input type=\"checkbox\" name=\"module[]\" value=\"".$tbl2["module_id"]."\" ".$checked.">
        <label>".$tbl2["libelle"]."</label>
      </div>";
    }
  $content.="</div>";
  if($i++==1){
  $content.="</div>";
  }
}

$sql="select * from ".__racinebd__."jour";
$link=query($sql);
while($tbl=fetch($link)){
  //on verifie si le jour est selectionné
  $tbl["checked"]=false;
  if($_POST["id"]!=""&&$_POST["mode"]!="delete"){
    $sql="select * from ".__racinebd__."jour_usersgps where usergps_id=".$_POST["id"]." and jour_id=".$tbl["jour_id"];
    $link2=query($sql);
    if(num_rows($link2)>0){
      $tbl["checked"]=true;
 
    }
  }
  $tbl_list_jour[]=$tbl;
}

$sql="select * from ".__racinebd__."rapport";
//print $sql;
$link=query($sql);
while($tbl=fetch($link)){
  //on verifie si le rapport est selectionné
  $tbl["checked"]=false;
  if($_POST["id"]!=""&&$_POST["mode"]!="delete"){
    $sql="select * from ".__racinebd__."rapport_usersgps where usergps_id=".$_POST["id"]." and rapport_id=".$tbl["rapport_id"];
    $link2=query($sql);
    if(num_rows($link2)>0){
      $tbl["checked"]=true;
       
    }
  }
  $tbl_list_rapport[]=$tbl;
}
//print_r($tbl_list_rapport);

?>