function deletelieux(){
  if(confirm("Voulez vous vraiment supprimer ce lieu ?")){
    return true;
  }else{
    return false;
  }
}

function validerLieux(){
      var lieuxName = document.formLieux.libelle.value;
      var iconeName = document.formLieux.icon.value;
      var latName = document.formLieux.latitude.value;
      var longName = document.formLieux.longitude.value;
      var rayonLieux = document.formLieux.rayon.value;


  if(lieuxName == "")
  {
    alert("Le nom est obligatoire");
    (document.formLieux.libelle.style.backgroundColor = "red");
    return false;
  }
    if(latName == "")
  {
    alert("La latitute est obligatoire");
    (document.formLieux.latitude.style.backgroundColor = "red");
    return false;
  }
    if(longName == "")
  {
    alert("La longitude est obligatoire");
    (document.formLieux.longitude.style.backgroundColor = "red");
    return false;
  }
    if(rayonLieux == "")
  {
    alert("Le rayon (en m) est obligatoire");
    (document.formLieux.rayon.style.backgroundColor = "red");
    return false;
  }
    if(iconeName == "")
  {
    alert("L'icône est obligatoire");
    return false;
  }

  else{
    (document.formLieux.libelle.style.backgroundColor = "green");
    (document.formLieux.latitude.style.backgroundColor = "green");
    (document.formLieux.longitude.style.backgroundColor = "green");
    (document.formLieux.rayon.style.backgroundColor = "green");
  }
}

$(document).ready(function() {
  $('form').jqTransform({imgPath:'jqtransformplugin/img/'});
  //$("#content_onglet_l").hide();
  /*
  $("#ajout_l_button").on('click', function (){
    $("#content_onglet_l").show();
  });
  */
  $("#button_l_annuler").on('click', function (){
    $("#content_onglet_l").hide();
    $("#see_more_param").hide();
  });
  /*
  $('#ajout_l_button').click(function(){
    $('html, body').animate({
        scrollTop:$("#content_onglet_l").offset().top
    }, 'slow');
    return false
  });
  */
  $('.modal_test2').hide();

  $("#modif_em_bloc2").on('click', function (){
    $("#modif_etat_moteur").show();
  });
  $("#cancel_butt_em").on('click', function (){
    $("#modif_etat_moteur").hide();
  });

  $('.change_icon2').on('click',function(){
    $('.modal_test2').fadeIn(100);
    $('.form_param_l').css({
      "opacity" : "0.5"
    });
    return false;
  });
  $('.close_img').on('click',function(){
    $('.modal_test2').fadeOut(100);
    $('.form_param_l').css({
      "opacity" : "1"
    });
    return false;
  });

});
var map;

function initialize() {

/*
   
  var mapOptions = {
    zoom: 15,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map'), mapOptions);
  */
  /*
  var myLatlng = new google.maps.LatLng(51.50135, -0.14184000000000002);
  var mapOptions = {
    zoom: 15,
    center: myLatlng
  }
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
  */
  map = new google.maps.Map(document.getElementById('map'));
  //alert(map.getZoom())
  var marker_bounds = [];
  for(i=0;i<tab.length;i++){
    
    var myLatLng = new google.maps.LatLng(tab[i][1], tab[i][2]);
    var image = {
      url: racineimg+'/tpl/img/lieux/'+tab[i][0],   
      // This marker is 20 pixels wide by 32 pixels tall.
      size: new google.maps.Size(32, 32),
      // The origin for this image is 0,0.
      origin: new google.maps.Point(0,0),
      // The anchor for this image is the base of the flagpole at 0,32.
      anchor: new google.maps.Point(16, 16)
    };
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image
        //,
        //shape: shape,
        //title: item.nomvehicule
    });
    //alert(tab[i][3])
    var mycircle = {
      strokeColor:  "#FF0000",
      strokeOpacity: 0.4,
      strokeWeight: 2,
      fillColor: "#CACACA",
      fillOpacity: 0.35,
      map: map,
      center: myLatLng,
      radius:  (tab[i][3]*1)
    };
    listCircle = new google.maps.Circle(mycircle);
    marker_bounds.push(myLatLng);
  }
  
  //map.setZoom(18);
  
  var latlngbounds = new google.maps.LatLngBounds();
  for ( var i = 0; i < marker_bounds.length; i++ ) {
     latlngbounds.extend(marker_bounds[i]);
  }
  map.setCenter(latlngbounds.getCenter(),6);
  map.fitBounds(latlngbounds);
  
  //alert(map.getZoom());
  if(marker_bounds.length==1){
    map.setZoom(18);      
    
  } 
  
  /*
  
  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
  });

  var MonTrajet = [
    new google.maps.LatLng(51.50135, -0.14184000000000002),
    new google.maps.LatLng(51.50161000000001, -0.14113),
    new google.maps.LatLng(51.501400000000004, -0.14072),
    new google.maps.LatLng(51.50150000000001, -0.14032),
    new google.maps.LatLng(51.50175, -0.14008),
    new google.maps.LatLng(51.501990000000006, -0.14012000000000002),
    new google.maps.LatLng(51.50211, -0.14004),
    new google.maps.LatLng(51.505840000000006, -0.13083),
    new google.maps.LatLng(51.50524000000001, -0.12946000000000002),
    new google.maps.LatLng(51.50513, -0.12912),
    new google.maps.LatLng(51.50529, -0.12802000000000002)
  ];
  var DessinTrajet = new google.maps.Polyline({
    path: MonTrajet,
    geodesic: true,
    strokeColor: '#FF0000',
    strokeOpacity: 1.0,
    strokeWeight: 2
  });
  */
  /**var image = '../img/sedan2.png';
  var voiture = new google.maps.Marker({
      position: myLatLng,
      map: map,
      icon: image
  });
***/
  //DessinTrajet.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);


function chooseicon(icon){
  document.getElementById("imgicon").src=racineimg+'/tpl/img/lieux/'+icon;
  document.getElementById("icon").value=icon;
  $(".close_img").click();  
}
function hidemap(){
$('#map_bloc').addClass('map_bloc').removeClass('fullmap_bloc')
  $('#bandeau_map').removeClass('bandeau_fullmap').addClass('bandeau_map ')
  $('#map').removeClass('fullmap').addClass('littlemap ')
  $('.pb_affichage_map').hide()
  $('#closemaptest').replaceWith("<span id='full_leave_screen'>Plein écran <a href=\"javascript:showmap()\"><img class='full_screen_icon' src='"+racineimg+"/tpl/img/fullsreen_ico.png'></a></span>")
  $('html, body').animate({scrollTop:$("#map_bloc").offset().top}, 'slow').css({"overflow" : "scroll"});
  google.maps.event.trigger(map,'resize');
}
function showmap(){
  $('html,body').animate({scrollTop: 0}, 'slow').css({"overflow" :"hidden"});
  $('#map_bloc').removeClass('map_bloc').addClass('fullmap_bloc')
  $('#bandeau_map').removeClass('bandeau_map').addClass('bandeau_fullmap')
  $('#map').removeClass('littlemap').addClass('fullmap')
  $('#bandeau_map').append("<p class='pb_affichage_map font-bold'>S’il y a un problème d’affichage, veuillez agrandir ou réduire la fenêtre de votre navigateur.</p>")
  $('#full_leave_screen').replaceWith("<span id='closemaptest'>Quitter le mode plein écran <a href=\"javascript:hidemap()\"><img class='closemap font-bold' src='"+racineimg+"/tpl/img/crossmap.png'></a></span>")
  google.maps.event.trigger(map,'resize');
}

