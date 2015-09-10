<?
class class_rules {
	var $user_id;
	var $genericRules=array();
  var $groupe_id=array();
	function class_rules($user_id,$tbl_result=""){
    $this->user_id = $user_id;
    $this->login = ($tbl_result["login"]=="")?"Super Admin":$tbl_result["login"];
    $this->listgroupeid = "";
		if($user_id!=-1){
			$sql_getPerms = "select shortright from ".__racinebd__."droits d inner join ".__racinebd__."groupe_droits gd on d.droits_id=gd.droits_id inner join ".__racinebd__."groupe_users gu on gd.groupe_id=gu.groupe_id where gu.users_id=".$user_id." and droitarbre=0";
			$link=query($sql_getPerms);
		 	while($li = fetch ($link)){
          $this->genericRules[$li["shortright"]]=1;
			}
			$this->list_groupe_id=implode(",",$listgroupe_id);
      $sql_getPerms = "select * from ".__racinebd__."groupe_users gu where users_id=".$user_id;
			//print $sql_getPerms;
			$link=query($sql_getPerms);
			$listgroupe_id=array();
			$tmptab=array();
			$tmptab[]=0;
		 	while($li = fetch ($link)){
        $this->groupe_id[$li["groupe_id"]]=1;
        $tmptab[]=$li["groupe_id"];
			}
			$this->listgroupeid=implode(",",$tmptab).",0";
    }else{
      $this->listgroupeid=0;
    }
	}
	function close(){
    	$this->user_id=null;
    	$this->genericRules=null;
	}
	function getGenericRules($val){
		$result=($this->user_id==-1)?1:($this->genericRules[$val]==1)?1:0;
    return $result;
	}
	function isInGroupe($val){
      return ($this->groupe_id[$val]==1)?1:0;
	}
}
function showlogin(){
  global $_SESSION;
	$myobj=&$_SESSION['obj_users_id'];
	if(is_object($myobj)){
    //print "icijc";
    return $myobj->login;
  }else{
    return "";
  }
}
function testGenRules($lib){
  global $_SESSION;
	$myobj=&$_SESSION['obj_users_id'];
	if(is_object($myobj)){
    //print "icijc";
    return $myobj->getGenericRules($lib);
  }else{
    return 0;
  }
}
function testGenRulesDie($lib){
  global $trad;
  testIpDie();
  if(!testGenRules($lib)){
    require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_haut.php");?>
    <div id="error">
      <?=$trad["Vous n'avez pas les droits pour effectuer cette action"]?> 
    </div> 
    <?
    require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_bas.php");
    die;
  }
}
function testIpDie(){
  global $trad;
  if(__limitip__!=""){
    $tabip=split(",",__limitip__);
    if(!in_array($_SERVER["REMOTE_ADDR"],$tabip)){
      unset($_SESSION);
	    session_destroy();
	    $notlogpage=1;
      require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_haut.php");?>
      <div id="error">
        <?=$trad["Vous n'avez pas les droits pour effectuer cette action"]?>
      </div> 
      <?
      require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_bas.php");
      die;
    }
  }
}
function testdroitarbredie($arbre_id,$shortlib){
  testIpDie();
  global $trad;
  if(!testdroitarbre($arbre_id,$shortlib)){
    require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_haut.php");?>
    <div id="error">
      <?=$trad["Vous n'avez pas les droits pour effectuer cette action"]?>
    </div> 
    <?
    require($_SERVER["DOCUMENT_ROOT"].__racineadmin__."/include/template_bas.php");
    die;
  }
}
function testdroitarbre($arbre_id,$shortlib){
  global $_SESSION,$trad;
	$myobj=&$_SESSION['obj_users_id'];
	if(is_object($myobj)){
    $sql="select * from ".__racinebd__."groupe_arbre ga inner join ".__racinebd__."droits d on ga.droits_id=d.droits_id where arbre_id=".$arbre_id." and shortright='".$shortlib."' and groupe_id in(".$myobj->listgroupeid.")";
    $link=query($sql);
    if(num_rows($link)>0){
      return 1;
    }else{
      return $myobj->user_id==-1?1:0;
    }
  }else{
    return 0;
  }
}
function testsession(){
  global $_SESSION,$trad;
  if ($_SESSION['islog']=="") {
      print $trad["Session terminée, ré-identifié vous."];
      //print_r($trad);
      die;
  }
}
?>