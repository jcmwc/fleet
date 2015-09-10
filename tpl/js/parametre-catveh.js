$(document).ready(function() {
  $('#ajout_cat_veh_button').click(function(){
    $('html, body').animate({
        scrollTop:$("#nvl_cat_veh_bloc").offset().top
    }, 'slow');
    return false
  });
});

document.getElementById("ajout_cat_veh_button").onclick = function() {
 document.getElementById("nvl_cat_veh_bloc").style.display = "block";
 if(document.getElementById("nvl_cat_veh_bloc2")!=null){
  document.getElementById("nvl_cat_veh_bloc2").style.display = "none";
 }
}, document.getElementById("cancel_cat_veh_bouton").onclick = function() {
 document.getElementById("nvl_cat_veh_bloc").style.display = "none"
};
if(document.getElementById("cancel_cat_veh_bouton2")!=null){
  document.getElementById("cancel_cat_veh_bouton2").onclick = function() {
    document.getElementById("nvl_cat_veh_bloc2").style.display = "none";
  }
}

function validerCatveh(){
      var catvehName = document.formCatveh.libelle.value;
  if(catvehName == "")
  {
    alert("Le nom de la catégorie du véhicule est obligatoire");
    (document.formCatveh.libelle.style.backgroundColor = "red");
    return false;
  }
  else{
      (document.formCatveh.libelle.style.backgroundColor = "green");
  }
}
