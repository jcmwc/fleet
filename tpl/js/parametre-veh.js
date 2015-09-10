$(document).ready(function() {

/*  document.getElementById("ajout_nv_veh_button").onclick = function (){
  document.getElementById("content_onglet_veh").style.display='block'
  } 
  document.getElementById("button_veh_annuler").onclick = function (){
  document.getElementById("content_onglet_veh").style.display='none'
  } 
*/
  
  $('form').jqTransform({imgPath:'jqtransformplugin/img/'});

  //$("#content_onglet_veh").hide();
  /*
  $("#ajout_nv_veh_button").on('click', function (){
    $("#content_onglet_veh").show();
  });*/
  $("#button_veh_annuler").on('click', function (){
    $("#content_onglet_veh").hide();
  });

  $('tr:odd').css({
    "background-color" : "white", 
    "color" : "#333132",
    "z-index" : "1"
    });


  $('#ajout_nv_veh_button').click(function(){
    $('html, body').animate({
        scrollTop:$("#content_onglet_veh").offset().top
    }, 'slow');
    $('#content_onglet_veh').show();

  });
  $('#pre-selected-options').multiSelect();      
});

function deletevehicule(url,id){
  if(confirm("Voulez vous vraiment supprimer ce vehicule ")){
    window.location=url+"&id="+id+"&mode=delete";
  }
}
function modifvehicule(url,id){
    window.location=url+"&id="+id+"&mode=modif";
}