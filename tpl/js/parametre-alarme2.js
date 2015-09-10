$(document).ready(function() {
  $('form').jqTransform({imgPath:'jqtransformplugin/img/'});


  $('.see_more_param').click(function(){
  var that = this;
  $(this).closest('ss_img_bloc').find('.ss_menu').slideToggle(500, function() {
    if ($(this).is(':visible')) {
      $(that).attr('src',racineimg+'/tpl/img/moins_ico.png');
    } else {
      $(that).attr('src',racineimg+'/tpl/img/plus_ico.png');
    }
  });
}); 


  /*$('#ajouter_alarme_button').click(function(){
    $('#content_onglet_alarm_param_param2').show();
    $('html, body').animate({
            scrollTop:$("#content_onglet_alarm_param_param2").offset().top
        }, 'slow');
    $('.ss_menu').hide();
    $('#onglet01_alarmes_bloc2').css({'padding-bottom':'166px'});
    $('.see_more_param').css({'display':'block'});
    return false
  }); 
*/

  $(".button_annuler_alarm2").click(function(){
    $('#onglet01_alarmes_bloc2').show();
    $('#content_onglet_alarm_param_param2').hide();
    $('.see_more_param').css({'display':'none'});
    $('.ss_menu').show();
    $('#onglet01_alarmes_bloc2').css({'padding-bottom':'520px'});
    return false
  });
});
    
/*  
document.getElementById("ajouter_alarme_button2").onclick = function(){
  document.getElementById("content_onglet_alarm_param_param2").style.display='block' 
return false
}
*/

document.getElementById("next_type_butt").onclick = function()
{
  document.getElementById("content_onglet_param_param2").style.display='block' 
  document.getElementById("content_onglet_type_param").style.display='none' 
  document.getElementById("parametre2_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("type_onglet").style.backgroundColor='#333132'
return false
}


document.getElementById("precendent_butt_param2").onclick = function()
{
  document.getElementById("content_onglet_type_param").style.display='block' 
  document.getElementById("content_onglet_param_param2").style.display='none' 
  document.getElementById("type_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("parametre2_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("next_butt_param2").onclick = function()
{
  document.getElementById("content_onglet_horaire_param2").style.display='block' 
  document.getElementById("content_onglet_param_param2").style.display='none' 
  document.getElementById("horaire_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("parametre2_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("next_butt_horaire").onclick = function()
{
  document.getElementById("content_onglet_vehicule_param2").style.display='block' 
  document.getElementById("content_onglet_horaire_param2").style.display='none' 
  document.getElementById("vehicule_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("horaire_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("precedent_butt_horaire").onclick = function()
{
  document.getElementById("content_onglet_param_param2").style.display='block' 
  document.getElementById("content_onglet_horaire_param2").style.display='none' 
  document.getElementById("parametre2_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("horaire_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("next_butt_vehicule").onclick = function()
{
  document.getElementById("content_onglet_utilisateur_param2").style.display='block' 
  document.getElementById("content_onglet_vehicule_param2").style.display='none' 
  document.getElementById("utilisateur_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("precedent_butt_vehicule").onclick = function()
{
  document.getElementById("content_onglet_horaire_param2").style.display='block' 
  document.getElementById("content_onglet_vehicule_param2").style.display='none' 
  document.getElementById("horaire_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
return false
}
document.getElementById("precdent_butt_utilisateur").onclick = function()
{
  document.getElementById("content_onglet_vehicule_param2").style.display='block' 
  document.getElementById("content_onglet_utilisateur_param2").style.display='none' 
  document.getElementById("vehicule_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("utilisateur_onglet").style.backgroundColor='#333132'
return false
}


document.getElementById("type_onglet").onclick = function()
{
  document.getElementById("content_onglet_type_param").style.display='block' 
  document.getElementById("content_onglet_utilisateur_param2").style.display='none' 
  document.getElementById("content_onglet_param_param2").style.display='none' 
  document.getElementById("content_onglet_horaire_param2").style.display='none' 
  document.getElementById("content_onglet_vehicule_param2").style.display='none' 
  document.getElementById("type_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("parametre2_onglet").style.backgroundColor='#333132'
  document.getElementById("horaire_onglet").style.backgroundColor='#333132'
  document.getElementById("utilisateur_onglet").style.backgroundColor='#333132'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'

return false
}

document.getElementById("parametre2_onglet").onclick = function()
{
  document.getElementById("content_onglet_param_param2").style.display='block' 
  document.getElementById("content_onglet_type_param").style.display='none'
  document.getElementById("content_onglet_horaire_param2").style.display='none'
  document.getElementById("content_onglet_utilisateur_param2").style.display='none'
  document.getElementById("content_onglet_vehicule_param2").style.display='none'
  document.getElementById("parametre2_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("type_onglet").style.backgroundColor='#333132'
  document.getElementById("horaire_onglet").style.backgroundColor='#333132'
  document.getElementById("utilisateur_onglet").style.backgroundColor='#333132'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("horaire_onglet").onclick = function()
{
  document.getElementById("content_onglet_horaire_param2").style.display='block' 
  document.getElementById("content_onglet_type_param").style.display='none'
  document.getElementById("content_onglet_utilisateur_param2").style.display='none'
  document.getElementById("content_onglet_param_param2").style.display='none'
  document.getElementById("content_onglet_vehicule_param2").style.display='none'
  document.getElementById("horaire_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("type_onglet").style.backgroundColor='#333132'
  document.getElementById("parametre2_onglet").style.backgroundColor='#333132'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
  document.getElementById("utilisateur_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("vehicule_onglet").onclick = function()
{
  document.getElementById("content_onglet_vehicule_param2").style.display='block' 
  document.getElementById("content_onglet_horaire_param2").style.display='none' 
  document.getElementById("content_onglet_utilisateur_param2").style.display='none' 
  document.getElementById("content_onglet_type_param").style.display='none'
  document.getElementById("content_onglet_param_param2").style.display='none'
  document.getElementById("vehicule_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("type_onglet").style.backgroundColor='#333132'
  document.getElementById("parametre2_onglet").style.backgroundColor='#333132'
  document.getElementById("horaire_onglet").style.backgroundColor='#333132'
  document.getElementById("utilisateur_onglet").style.backgroundColor='#333132'
return false
}

document.getElementById("utilisateur_onglet").onclick = function()
{
  document.getElementById("content_onglet_utilisateur_param2").style.display='block' 
  document.getElementById("content_onglet_vehicule_param2").style.display='none' 
  document.getElementById("content_onglet_horaire_param2").style.display='none' 
  document.getElementById("content_onglet_type_param").style.display='none'
  document.getElementById("content_onglet_param_param2").style.display='none'
  document.getElementById("utilisateur_onglet").style.backgroundColor='#3a9ed9'
  document.getElementById("type_onglet").style.backgroundColor='#333132'
  document.getElementById("parametre2_onglet").style.backgroundColor='#333132'
  document.getElementById("horaire_onglet").style.backgroundColor='#333132'
  document.getElementById("vehicule_onglet").style.backgroundColor='#333132'
return false
}

function deletealarmope(){
  if(confirm("Voulez vous vraiment supprimer ce lieu ?")){
    return true;
  }else{
    return false;
  }
}

function validerAlarm(){
      var descparamName = document.formAlarmParam.name_descparam.value;
  if(descparamName == "")
  {
    alert("La description  est obligatoire (dans l'onglet Paramètres)");
    (document.formAlarmParam.name_descparam.style.backgroundColor = "red");
    return false;
  }

  else{
    (document.formAlarmParam.name_descparam.style.backgroundColor = "green");
  }
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


function modifchamps(txt){
  $("#"+lastshow).css("display","none");
  $("#"+txt).css("display","block");
  $("#champsval").val("name_"+txt);
  lastshow=txt;
}