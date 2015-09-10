<?
function requetepagin($nbelemparpage,$debut){
	return " limit ".((int)$debut).",$nbelemparpage";
}
function countElem($sql){
	$tableauquery= preg_split ("/(from)|(FROM)/", $sql);
	$tableauquery2= preg_split ("/(limit)|(LIMIT)/", $tableauquery[1]);
  $mysql=(count($tableauquery2)>1)?$tableauquery2[0]:$tableauquery[1];
  $mysql=preg_split ("/(order)|(ORDER)/", $mysql);
	query("SELECT SQL_CALC_FOUND_ROWS * FROM ".$mysql[0]." LIMIT 1");
   return mysql_result(query("SELECT FOUND_ROWS() as count"), 0, "count");
}
function query($sql,$return=false){
	//print $sql."<br>";
   if($sql!=""){
		$ressource_link=mysql_query($sql);
     	if($ressource_link){
     		return $ressource_link;
     	}else{
        if(!$return){
       		print "<br>".$sql."<br>";
       		print mysql_error()."<br>";
         	die;
        }else{
          return false;
        }
     	}
   }
}
function fetch($link){
  return mysql_fetch_array($link);
}

function fetchtbl($link,$val=''){
  while($tbl=mysql_fetch_array($link)){
    if($val=='')
    $tbl_all[]=$tbl;
    else
    $tbl_all[]=$tbl[$val];
  }
  return $tbl_all;
}
function num_rows($link){
  return mysql_num_rows($link);
}
function insert_id(){
  return mysql_insert_id();
}
function connect($host,$user,$pass){
  return @mysql_connect($host,$user,$pass);
}
function select_db($bdd){
  return mysql_select_db($bdd);
}
function bdd_close(){
  return mysql_close();
}
function affected_rows(){
  return mysql_affected_rows();
}
?>