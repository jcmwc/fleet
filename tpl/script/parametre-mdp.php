<?
$msgsave="";
if($_POST["lastmdp"]!=""&&$_POST["newmdp"]!=""&&$_POST["newmdp2"]!=""&&$_POST["newmdp"]==$_POST["newmdp2"]){
  $sql="update users set password='".md5($_POST["newmdp"])."' where user_id=".$_SESSION["users_id"]." and password='".md5($_POST["lastmdp"])."'";
  query($sql);
  $msgsave="ok";
}
?>