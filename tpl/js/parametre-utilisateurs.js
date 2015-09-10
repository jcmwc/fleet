$(document).ready(function() {
/*
$('#ajout_user_button').click(function(){
    $('.ss_menu').hide();
    $('.see_more_param').css({'display':'block'});
    $('.alarm_bloc').css({'padding-bottom':'15px'});
    $('#content_onglet_user').css({'display': 'block'});
    return false
  });
  */

$("#button_annuler").click(function(){
  $('#content_onglet_user').hide();
  $('.see_more_param').css({'display':'none'});
  $('.ss_menu').show();
  $('.alarm_bloc').css({'padding-bottom':'271px'});
  return false
});

/*
$('.see_more_param').click(function(){
  var that = this;
  $('.ss_menu').slideToggle(500, function() {
    if ($(this).is(':visible')) {
      $(that).attr('src',racineimg+'/tpl/img/moins_ico.png');
      } else {
        $(that).attr('src',racineimg+'/tpl/img/plus_ico.png');
    }
  }); 
    
}); */

document.getElementById("vehicule_onglet").onclick = function()
{
  document.getElementById("content_info_perso").style.display='none' 
  document.getElementById("content_modules").style.display='none' 
  document.getElementById("content_jours").style.display='none'
  document.getElementById("content_mail").style.display='none' 
  document.getElementById("content_veh").style.display='block' 
  document.getElementById("vehicule_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("info_perso_onglet").style.backgroundColor='#333132'
  document.getElementById("modules_onglet").style.backgroundColor='#333132'
  document.getElementById("mail_onglet").style.backgroundColor='#333132'
  document.getElementById("jours_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("info_perso_onglet").onclick = function()
{
  document.getElementById("content_veh").style.display='none' 
  document.getElementById("content_modules").style.display='none' 
  document.getElementById("content_jours").style.display='none' 
  document.getElementById("content_mail").style.display='none' 
  document.getElementById("content_info_perso").style.display='block' 
  document.getElementById("info_perso_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
  document.getElementById("jours_onglet").style.backgroundColor='#333132'
  document.getElementById("mail_onglet").style.backgroundColor='#333132'
  document.getElementById("modules_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("modules_onglet").onclick = function()
{
  document.getElementById("content_veh").style.display='none' 
  document.getElementById("content_info_perso").style.display='none' 
  document.getElementById("content_jours").style.display='none' 
  document.getElementById("content_mail").style.display='none' 
  document.getElementById("content_modules").style.display='block' 
  document.getElementById("modules_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
  document.getElementById("jours_onglet").style.backgroundColor='#333132'
  document.getElementById("mail_onglet").style.backgroundColor='#333132'
  document.getElementById("info_perso_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("jours_onglet").onclick = function()
{
  document.getElementById("content_veh").style.display='none' 
  document.getElementById("content_info_perso").style.display='none' 
  document.getElementById("content_modules").style.display='none' 
  document.getElementById("content_mail").style.display='none' 
  document.getElementById("content_jours").style.display='block' 
  document.getElementById("jours_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
  document.getElementById("modules_onglet").style.backgroundColor='#333132'
  document.getElementById("mail_onglet").style.backgroundColor='#333132'
  document.getElementById("info_perso_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("mail_onglet").onclick = function()
{
  document.getElementById("content_veh").style.display='none' 
  document.getElementById("content_info_perso").style.display='none' 
  document.getElementById("content_jours").style.display='none' 
  document.getElementById("content_modules").style.display='none' 
  document.getElementById("content_mail").style.display='block' 
  document.getElementById("mail_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
  document.getElementById("jours_onglet").style.backgroundColor='#333132'
  document.getElementById("modules_onglet").style.backgroundColor='#333132'
  document.getElementById("info_perso_onglet").style.backgroundColor='#333132'
return false
}

});

function deleteuser(){
  if(confirm("Voulez vous vraiment supprimer cet utilisateur ")){
    return true;
  }else{
    return false;
  }
}

function validerUser(){
      var logname = document.formUser.username.value;
      var mdpname = document.formUser.pwd.value;
      var confirmname = document.formUser.pwd2.value;
      var namename = document.formUser.name.value;
      //var firstnamename = document.formUser.surname.value;
      var mailname = document.formUser.email.value;

  if(logname == "")
  {
    alert("Le login est obligatoire");
    (document.formUser.username.style.backgroundColor = "red");
    return false;
  }

  /*
  if(mdpname == "")
  {
    alert("Le mot de passe est obligatoire");
    (document.formUser.pwd.style.backgroundColor = "red");
    return false;
  } 

    if(confirmname == "")
  {
    alert("La confirmation du mot de passe est obligatoire");
    (document.formUser.pwd2.style.backgroundColor = "red");
    return false;
  }

  if(mdpname != confirmname)
  {
    alert("Le mot de passe et la confirmation ne sont pas identiques !");
    return false;
  }  */
      if(namename == "")
  {
    alert("Le nom est obligatoire");
    (document.formUser.name.style.backgroundColor = "red");
    return false;
  }

  /*
      if(firstnamename == "")
  {
    alert("Le prénom est obligatoire");
    (document.formUser.surname.style.backgroundColor = "red");
    return false;
  }
  */
 if(mailname === "")
  {
    alert ('Le mail est obligatoire !');
    return false;
  }
    if (mailname !== "")
  {
    indexAroba = document.formUser.email.value.indexOf('@');
    indexPoint = document.formUser.email.value.indexOf('.');
    if ((indexAroba < 0) || (indexPoint < 0))
    {
      alert ('Le mail est incorrect');
      document.formUser.email.style.backgroundColor = "red";
      return false;
    }
  }

  else{
    (document.formUser.username.style.backgroundColor = "green");
    (document.formUser.pwd.style.backgroundColor = "green");
    (document.formUser.pwd2.style.backgroundColor = "green");
    (document.formUser.username.style.backgroundColor = "green");
    (document.formUser.surname.style.backgroundColor = "green");
    (document.formUser.email.style.backgroundColor = "green");
    return false;
  }
}

