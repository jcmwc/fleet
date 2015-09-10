$(document).ready(function() {
  $('.picker').farbtastic('#color');
  $("#modif_etat_sociaux").hide();
  
  $(".modif_em_bloc2").on('click', function (){
    $("#modif_etat_sociaux").show();
  });

  $("#cancel_butt_em").on('click', function (){
    $("#modif_etat_sociaux").hide();
  });

});


function validerSociaux(){
      var sociauxName = document.formSociaux.sociaux_name.value;
      var colorName = document.formSociaux.colorname.value;


  if(sociauxName == "")
  {
    alert("Le nom est obligatoire");
    (document.formSociaux.sociaux_name.style.backgroundColor = "red");
    return false;
  }
    if(colorName == "")
  {
    alert("La couleur est obligatoire");
    return false;
  }

  else{
    alert('Votre formulaire a bien été envoyé !');
    (document.formSociaux.sociaux_name.style.backgroundColor = "green");
    return false;
  }
}