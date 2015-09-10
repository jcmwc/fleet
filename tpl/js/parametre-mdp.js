$(document).ready(function(){$(function(){$("form").jqTransform({imgPath:"jqtransformplugin/img/"})})});


function validerMdp(){
      var ancienmdpname = document.formMdp.lastmdp.value;
      var newmdpname = document.formMdp.newmdp.value;
      var confirmnewmdpname = document.formMdp.newmdp2.value;


  if(ancienmdpname == "")
  {
    alert("Votre ancien mot de passe est obligatoire");
    (document.formMdp.lastmdp.style.backgroundColor = "red");
    return false;
  }

  if(newmdpname == "")
  {
    alert("Votre nouveau mot de passe est obligatoire");
    (document.formMdp.newmdp.style.backgroundColor = "red");
    return false;
  }
 
  if(confirmnewmdpname == "")
  {
    alert("La confirmation du nouveau mot de passe est obligatoire");
    (document.formMdp.newmdp2.style.backgroundColor = "red");
    return false;
  }

  if(newmdpname != confirmnewmdpname)
  {
    alert("Votre nouveau mot de passe et la confirmation de votre nouveau mot de passe ne sont pas identiques");
    return false;
  }
  else{ 
    (document.formMdp.lastmdp.style.backgroundColor = "green");
    (document.formMdp.newmdp.style.backgroundColor = "green");
    (document.formMdp.newmdp2.style.backgroundColor = "green");

    alert("Le formulaire a bien été envoyé !");
    return true;
  }
}