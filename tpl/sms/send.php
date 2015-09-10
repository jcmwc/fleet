<?
require("../../admin/require/function.php");
if($_SESSION["logfront"]!=1){
  die;
}
if($_POST["message"]!=""){
  include_once('smsMode_API.inc');
  $api = new smsMode_api;
  $response_string=$api->send_sms($_POST["num"] , $_POST["message"] );
  
}
?>
<!DOCTYPE html>
  
  <html lang="fr" > 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>mister fleet | situation</title>
    <style>
    body{margin:0;padding:0;background:#b3d4fc;font-family:Arial;color:white;height:300px;overflow:hidden}
    input,textarea {
        color: white;
        border: 2px solid white;
        background: #b3d4fc;
        ;font-family:Arial;
        font-size:12px;
        border-radius:4px;
      }
      input {width:100px;height:25px;font-weight:bold;font-size:14px;}
      textarea {width:300px;height:150px;font-weight:bold;font-size:14px;}
    </style>
    
  </head>
  <body>
    <center>
     <?if($response_string!=""){?>
     <?//=$response_string?>
     Message envoyé
     <?}else{?>
     <form action="send.php" method="post">
     <input type="hidden" name="num" value="<?=$_GET["num"]?>">
     <h2>Message :</h2>
     <textarea name="message"></textarea>  <br>
     <input type="submit" name="Envoyer" value="Envoyer" />
     </form>
     <?}?>
    </center>
  </body>
</html>
