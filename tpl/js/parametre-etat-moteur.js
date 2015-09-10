$(document).ready(function() {
  $('.picker').farbtastic('#color');
  

 /*
  $('#modif_etat_moteur').hide();
  $(".modif_em_bloc").on('click', function (){
    $("#modif_etat_moteur").show();
  });
 $('.modif_em_bloc').click(function(){
    $('html, body').animate({
      scrollTop:$("#modif_etat_moteur").offset().top
    }, 'slow');
  });
*/  

  $("#cancel_butt_em").on('click', function (){
    $("#modif_etat_moteur").hide();
  });
});



function validerMoteur(){
      var moteurName = document.formMoteur.libelle.value;
      var colorName = document.formMoteur.couleur.value;


  if(moteurName == "")
  {
    alert("Le nom est obligatoire");
    (document.formMoteur.libelle.style.backgroundColor = "red");
    return false;
  }
    if(colorName == "")
  {
    alert("La couleur est obligatoire");
    return false;
  }

  else{
    (document.formMoteur.libelle.style.backgroundColor = "green");
  }
}

