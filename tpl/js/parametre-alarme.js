$(document).ready(function() {
  $('form').jqTransform({imgPath:'jqtransformplugin/img/'});

/*
  $('.see_more_param').click(function(){
  var that = this;
  $(this).closest('.ss_img_bloc').find('.ss_menu').slideToggle(500, function() {
    if ($(this).is(':visible')) {
      $(that).attr('src',racineimg+'/tpl/img/moins_ico.png');
    } else {
      $(that).attr('src',racineimg+'/tpl/img/plus_ico.png');
    }
  });
}); 
*/

$('#ajouter_alarme_button').click(function(){
    $('#content_onglet_alarm_param_param').show();
    $('html, body').animate({
            scrollTop:$(".title_nvllealarme").offset().top
        }, 'slow');
    $('.ss_menu').hide();
    $('#onglet01_alarmes_bloc').css({'padding-bottom':'50px'});
    $('.see_more_param').css({'display':'block'});
    return false
  });


  $(".button_annuler_alarm2").click(function(){
    $('#onglet01_alarmes_bloc').show();
    $('#content_onglet_alarm_param_param').hide();
    $('.see_more_param').css({'display':'none'});
    $('.ss_menu').show();
    $('#onglet01_alarmes_bloc').css({'padding-bottom':'520px'});
    return false
  });
});
    
/*  
document.getElementById("ajouter_alarme_button2").onclick = function(){
  document.getElementById("content_onglet_alarm_param_param").style.display='block' 
return false
}
*/

document.getElementById("next_type_butt").onclick = function()
{
  document.getElementById("content_onglet_param_param").style.display='block' 
  document.getElementById("content_onglet_type_param1").style.display='none' 
  document.getElementById("parametre_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("type1_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("precendent_butt_param2").onclick = function()
{
  document.getElementById("content_onglet_type_param1").style.display='block' 
  document.getElementById("content_onglet_param_param").style.display='none' 
  document.getElementById("type1_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("parametre_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("next_butt2_param2").onclick = function()
{
  document.getElementById("content_onglet_horaire_param").style.display='block' 
  document.getElementById("content_onglet_param_param").style.display='none' 
  document.getElementById("horaire1_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("parametre_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("next_butt2_horaire").onclick = function()
{
  document.getElementById("content_onglet_vehicule_param").style.display='block' 
  document.getElementById("content_onglet_horaire_param").style.display='none' 
  document.getElementById("vehicule1_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("horaire1_onglet").style.backgroundColor='#333132'

}
document.getElementById("precedent_butt2_horaire").onclick = function()
{
  document.getElementById("content_onglet_param_param").style.display='block' 
  document.getElementById("content_onglet_horaire_param").style.display='none' 
  document.getElementById("parametre_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("horaire1_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("next_butt2_vehicule").onclick = function()
{
  document.getElementById("content_onglet_utilisateur_param").style.display='block' 
  document.getElementById("content_onglet_vehicule_param").style.display='none' 
  document.getElementById("utilisateur1_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("vehicule1_onglet").style.backgroundColor='#333132'
return false
}             
document.getElementById("precedent_butt2_vehicule").onclick = function()
{
  document.getElementById("content_onglet_horaire_param").style.display='block' 
  document.getElementById("content_onglet_vehicule_param").style.display='none' 
  document.getElementById("horaire1_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("vehicule1_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("precedent_butt2_utilisateur").onclick = function()
{
  document.getElementById("content_onglet_vehicule_param").style.display='block' 
  document.getElementById("content_onglet_utilisateur_param").style.display='none' 
  document.getElementById("vehicule1_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("utilisateur1_onglet").style.backgroundColor='#333132'
return false
}


document.getElementById("type1_onglet").onclick = function()
{
  document.getElementById("content_onglet_type_param1").style.display='block' 
  //document.getElementById("content_onglet_categorie_param1").style.display='none' 
  document.getElementById("content_onglet_utilisateur_param").style.display='none' 
  document.getElementById("content_onglet_param_param").style.display='none' 
  document.getElementById("content_onglet_horaire_param").style.display='none' 
  document.getElementById("content_onglet_vehicule_param").style.display='none' 
  document.getElementById("type1_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("parametre_onglet").style.backgroundColor='#333132'
  document.getElementById("horaire1_onglet").style.backgroundColor='#333132'
  document.getElementById("utilisateur1_onglet").style.backgroundColor='#333132'
  document.getElementById("vehicule1_onglet").style.backgroundColor='#333132'

return false
}

document.getElementById("parametre_onglet").onclick = function()
{
  document.getElementById("content_onglet_param_param").style.display='block' 
  document.getElementById("content_onglet_type_param1").style.display='none'
  document.getElementById("content_onglet_horaire_param").style.display='none'
  document.getElementById("content_onglet_utilisateur_param").style.display='none'
  document.getElementById("content_onglet_vehicule_param").style.display='none'
  document.getElementById("parametre_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("type1_onglet").style.backgroundColor='#333132'
  document.getElementById("horaire1_onglet").style.backgroundColor='#333132'
  document.getElementById("utilisateur1_onglet").style.backgroundColor='#333132'
  document.getElementById("vehicule1_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("horaire1_onglet").onclick = function()
{
  document.getElementById("content_onglet_horaire_param").style.display='block' 
  document.getElementById("content_onglet_type_param1").style.display='none'
  document.getElementById("content_onglet_utilisateur_param").style.display='none'
  document.getElementById("content_onglet_param_param").style.display='none'
  document.getElementById("content_onglet_vehicule_param").style.display='none'
  document.getElementById("horaire1_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("type1_onglet").style.backgroundColor='#333132'
  document.getElementById("parametre_onglet").style.backgroundColor='#333132'
  document.getElementById("vehicule1_onglet").style.backgroundColor='#333132'
  document.getElementById("utilisateur1_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("vehicule1_onglet").onclick = function()
{
  document.getElementById("content_onglet_vehicule_param").style.display='block' 
  document.getElementById("content_onglet_horaire_param").style.display='none' 
  document.getElementById("content_onglet_utilisateur_param").style.display='none' 
  document.getElementById("content_onglet_type_param1").style.display='none'
  document.getElementById("content_onglet_param_param").style.display='none'
  document.getElementById("vehicule1_onglet").style.backgroundColor='#3a9ed9'
  //document.getElementById("categorie1_onglet").style.backgroundColor='#333132'
  document.getElementById("type1_onglet").style.backgroundColor='#333132'
  document.getElementById("parametre_onglet").style.backgroundColor='#333132'
  document.getElementById("horaire1_onglet").style.backgroundColor='#333132'
  document.getElementById("utilisateur1_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("utilisateur1_onglet").onclick = function()
{
  document.getElementById("content_onglet_utilisateur_param").style.display='block' 
  document.getElementById("content_onglet_vehicule_param").style.display='none' 
  document.getElementById("content_onglet_horaire_param").style.display='none' 
  document.getElementById("content_onglet_type_param1").style.display='none'
  document.getElementById("content_onglet_param_param").style.display='none'
  document.getElementById("utilisateur1_onglet").style.backgroundColor='#3a9ed9'
  //document.getElementById("categorie1_onglet").style.backgroundColor='#333132'
  document.getElementById("type1_onglet").style.backgroundColor='#333132'
  document.getElementById("parametre_onglet").style.backgroundColor='#333132'
  document.getElementById("horaire1_onglet").style.backgroundColor='#333132'
  document.getElementById("vehicule1_onglet").style.backgroundColor='#333132'
return false
}

function deletealarmsoc(){
  if(confirm("Voulez vous vraiment supprimer ce lieu ?")){
    return true;
  }else{
    return false;
  }
}

function validerAlarm(){
      var descparamName = document.formAlarmParam.name_descparam.value;
      var tpsparamName = document.formAlarmParam.name_tpsarret.value;
  if(descparamName == "")
  {
    alert("La description  est obligatoire (dans l'onglet Paramètres)");
    (document.formAlarmParam.name_descparam.style.backgroundColor = "red");
    return false;
  }
     if(tpsparamName == "")
  {
    alert("Ce champs est obligatoire (dans l'onglet Paramètres)");
    (document.formAlarmParam.name_tpsarret.style.backgroundColor = "red");
    return false;
  }

  else{
    (document.formAlarmParam.name_descparam.style.backgroundColor = "green");
    (document.formAlarmParam.name_tpsarret.style.backgroundColor = "green");    
  }
}
function modiftxt(txt){
  $("#libtempsduree").html(txt+" :");
}
function checkall(obj,name){
  //alert(name)
  if(obj.checked==true){
    if(typeof(obj.form.elements[name].length)=="undefined"){
      obj.form.elements[name].checked=true;
    }else{
      for(i=0;i<obj.form.elements[name].length;i++){
        obj.form.elements[name][i].checked=true;
      }
    }
  }else{
    if(typeof(obj.form.elements[name].length)=="undefined"){
      obj.form.elements[name].checked=false;
    }else{
      for(i=0;i<obj.form.elements[name].length;i++){
        obj.form.elements[name][i].checked=false;
      }
    }
  }
}