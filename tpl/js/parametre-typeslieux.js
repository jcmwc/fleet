$(document).ready(function() {
  $('#ajout_tl_button').click(function(){
    $('html, body').animate({
        scrollTop:$("#ajout_nv_tl_bloc").offset().top
    }, 'slow');
    return false
  });
});


document.getElementById("ajout_tl_button").onclick = function() {
 document.getElementById("ajout_nv_tl_bloc").style.display = "block", document.getElementById("tl_bloc").style.padding = "0px 0px 311px 0px";
 if(document.getElementById("modif_nv_tl_bloc")!=null){
  document.getElementById("modif_nv_tl_bloc").style.display = "none";
 }
}, document.getElementById("cancel_tl_button").onclick = function() {
 document.getElementById("ajout_nv_tl_bloc").style.display = "none", document.getElementById("tl_bloc").style.padding = "0px 0px 457px 0px"
};
if(document.getElementById("cancel_tl_button2")!=null){
  document.getElementById("cancel_tl_button2").onclick = function() {
    document.getElementById("modif_nv_tl_bloc").style.display = "none";
  }
}


function validerLieux(){
      var lieuxName = document.formLieux.libelle.value;
  if(lieuxName == "")
  {
    alert("Le nom de l'agence est obligatoire");
    (document.formLieux.libelle.style.backgroundColor = "red");
    return false;
  }
  else{
    (document.formLieux.libelle.style.backgroundColor = "green");
  }
}