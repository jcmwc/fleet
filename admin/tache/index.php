<?
require("../require/function.php");

/*
$sql="select * from action";
$link=query($sql);
while($tbl=fetch($link)){
  $sql="insert into action_users (action_id,users_id) values('".$tbl["action_id"]."','".$tbl["users_id"]."')";
  query($sql);
}
die;
*/

//dump sql + envoi de mail
$emaildest="jcleveque@wanadoo.fr";

$file=$_SERVER["DOCUMENT_ROOT"].__racine__."tache/dump".date("d-m-Y-H-i-s").".sql";
//$query="SELECT * INTO OUTFILE '$file' FROM professionnel";
//query($query);
echo exec("mysqldump --user=".__userbdd__." --password=".__passbdd__." --compress --databases ".__bdd__." > ".$file);
//echo exec("whoami");
//print "mysqldump --user=".__userbdd__." --password=".__passbdd__." --compress --databases ".__bdd__." > ".$file;
sendmail(__smtpusername__,'Intranet By','Sauvegarde de la base internet','Sauvegarde de la base internet',$emaildest,'',array(array($file,'Dump.sql')));
sleep(1);

//envoi des action du jour
$sql="select a.*,ta.* from `action` a inner join type_action ta on ta.type_action_id=a.type_action_id inner join contact c on c.contact_id=a.contact_id where c.supprimer=0 and a.supprimer=0 and date_actu=CURDATE()";
$link=query($sql);
while($tbl=fetch($link)){
  $query="select nom,prenom,email,fixe,portable,fixe,email,poste,raison_social,adresse,siteinternet from contact c inner join client e on c.client_id=e.client_id where contact_id=".$tbl["contact_id"];

  $result=mysql_query($query) or die("Query ($query) sucks!");
  $fields=mysql_num_fields($result);
  
  $content= "<table border=\"1\">\n<tr>";
  for ($i=0; $i < mysql_num_fields($result); $i++) //Table Header
  { 
  $content.= "<th>".mysql_field_name($result, $i)."</th>"; }
  $content.= "</tr>\n";
  while ($row = mysql_fetch_row($result)) { //Table body
  $content.= "<tr>";
      for ($f=0; $f < $fields; $f++) {
      $content.= "<td>$row[$f]</td>"; 
      }
  $content.= "</tr>\n";
  }
  $content.= "</table><p>";
  
  $content="<b>".$tbl["libelle"]."</b><br><br>".$tbl["description"]."<br><br><b>Information sur le client :</b><br>".$content;
  //print $tbl["email"];
  //recherche des destinataires
  $sql="select * from action_users au inner join users u on au.users_id=u.users_id where action_id=".$tbl["action_id"];
  $linkdest=query($sql);
  $tbl_list_mail=array();
  while($tbldest=fetch($linkdest)){
    $tbl_list_mail[]=$tbldest["email"];
  } 
  sendmail(__smtpusername__,'Intranet By','Rappel du jour',$content,implode(",",$tbl_list_mail));
  sleep(1);
}
print date("d-m-Y-H-i-s")."\n";
?>