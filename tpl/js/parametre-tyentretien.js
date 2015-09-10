/*
document.getElementById("ajout_nv_tyentretien_button").onclick = function (){
  document.getElementById("ajout_nv_ty_entretien_bloc").style.display='block'
} 
*/

document.getElementById("cancel_ty_entretien_button").onclick = function (){
  document.getElementById("ajout_nv_ty_entretien_bloc").style.display='none'
} 

$(document).ready(function() {
    $('.modal_test3').hide(100);

  $('.chang_icon3').on('click',function(){
    $('.modal_test3').fadeIn(100);
    $('.resize').css({
      "opacity" : "0.5"
    });
    return false;
  });

  $('.close_img').on('click',function(){
    $('.modal_test3').fadeOut(100);
    $('.resize').css({
      "opacity" : "1"
    });
    return false;
  });
});


function validertyentretien(){
      var nametyentretien = document.formTyentretien.libelle.value;
      var icontyentretien = document.formTyentretien.icon.value;

  if(nametyentretien == "")
  {
    alert("Le nom est obligatoire");
    (document.formTyentretien.libelle.style.backgroundColor = "red");
    return false;
  }
    if(icontyentretien == "")
  {
    alert("L'icone est obligatoire");
    (document.formTyentretien.icon.style.backgroundColor = "red");
    return false;
  }
  else{
    (document.formTyentretien.libelle.style.backgroundColor = "green");
    (document.formTyentretien.icon.style.backgroundColor = "green");
  }
}

function chooseicon(icon){
  document.getElementById("imgicon").src=racineimg+'/tpl/img/entretien/'+icon;
  document.getElementById("icon").value=icon;
  $(".close_img").click();  
}