$(document).ready(function() {
  $("form").jqTransform({imgPath: "jqtransformplugin/img/"})
  $('#ajout_agence_button01').click(function(){
    $('html, body').animate({
        scrollTop:$("#onglet_nvl_agence_bloc").offset().top
    }, 'slow');
    return false
  });
});
   document.getElementById("ajout_agence_button01").onclick = function() {
 document.getElementById("onglet_nvl_agence_bloc").style.display = "block", document.getElementById("onglet_agence_bloc").style.padding = "0px 0px 100px 0px";
 if(document.getElementById("onglet_nvl_agence_bloc2")!=null){
  document.getElementById("onglet_nvl_agence_bloc2").style.display = "none";
 }
}, document.getElementById("cancel_agence_bouton").onclick = function() {
 document.getElementById("onglet_nvl_agence_bloc").style.display = "none", document.getElementById("onglet_agence_bloc").style.padding = "0px 0px 344px 0px"
};

if(document.getElementById("cancel_agence_bouton2")!=null){
  document.getElementById("cancel_agence_bouton2").onclick = function() {
    document.getElementById("onglet_nvl_agence_bloc2").style.display = "none";
  }
}

function validerAgence(){
      var agenceName = document.formAgence.libelle.value;
  if(agenceName == "")
  {
    alert("Le nom de l'agence est obligatoire");
    (document.formAgence.libelle.style.backgroundColor = "red");
    return false;
  }
  else{
    (document.formAgence.libelle.style.backgroundColor = "green");
    return true;
  }
}
