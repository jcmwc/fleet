$(document).ready(function() {
  $('.modal_test').hide();

  $("#modif_em_bloc2").on('click', function (){
    $("#modif_etat_moteur").show();
  });
  $("#cancel_butt_em").on('click', function (){
    $("#modif_etat_moteur").hide();
  });
  $('.modif_icon').on('click',function(){
    $('.modal_test').fadeIn(100);
    return false;
  });
  $('.close_img').on('click',function(){
    $('.modal_test').fadeOut(100);
    $('.resize').css({
      "opacity" : "1"
    });
    return false;
  });
});

function deletetv(){
  if(confirm("Voulez vous vraiment supprimer ce type de véhicule")){
    return true;
  }else{
    return false;
  }
}

function validerTv(){
      var tv = document.formTv.libelle.value;
      var icontv = document.formTv.icon.value;
      var tvconsomName = document.formTv.consommation.value;
      var tvvitName = document.formTv.vitesseattente.value;
  if(tv == "")
  {
    alert("Le nom du type de véhicule est obligatoire");
    (document.formTv.libelle.style.backgroundColor = "red");
    return false;
  }
     if(tvconsomName == "")
  {
    alert("Ce champs est obligatoire");
    (document.formTv.consommation.style.backgroundColor = "red");
    return false;
  }
     if(tvvitName == "")
  {
    alert("La vitesse d'attente est obligatoire");
    (document.formTv.vitesseattente.style.backgroundColor = "red");
    return false;
  }
    if(icontv == "")
  {
    alert("L'icone est obligatoire");
    return false;
  }

  else{
    (document.formTv.libelle.style.backgroundColor = "green");
    (document.formTv.consommation.style.backgroundColor = "green");
    (document.formTv.vitesseattente.style.backgroundColor = "green");
  }
}

/*
document.getElementById("ajout_tv_button").onclick = function (){
  document.getElementById("nv_tv_bloc").style.display='block';
} 
*/

document.getElementById("cancel_tv_button").onclick = function (){
  document.getElementById("nv_tv_bloc").style.display='none';
} 

function chooseicon(icon){
  document.getElementById("imgicon").src=racineimg+'/tpl/img/vehicules/'+icon;
  document.getElementById("icon").value=icon;
  $(".close_img").click();  
}