// This is a file copied by your subgenerator.
$( document ).ready(function() {
  var plusmoins =0;

    $('.more_vehiculebloc').hide();

  $('.seemore_img02').click(function(){
    var that = this;
    $(this).closest(".vehicule_bloc").find(".more_vehiculebloc").slideToggle(500, function() {
      if ($(this).is(':visible')) {
        $(that).attr('src',racineimg+'/tpl/img/moins_ico.png');
      } else {
        $(that).attr('src',racineimg+'/tpl/img/plus_ico.png');
      }
    });
      
  })

  $(function(){
      $('form').jqTransform({imgPath:'jqtransformplugin/img/'});
  })
});

 function load(){
  var map = new GMap2(document.getElementById("map"));
  map.setCenter(new GLatLng(51.50135, -0.14184000000000002), 15);
// Ajout de la propriété "Marker" (repère personnalisé)
  var point = new GLatLng(51.50529, -0.12802000000000002); // Position du marker
// Initialisation d'un nouvel objet GIcon et de ses propriétés
  var MonIcon = new GIcon(G_DEFAULT_ICON);
  MonIcon.iconSize=new GSize(32,32);
  MonIcon.iconAnchor=new GPoint(10,20);
  MonIcon.image=racineimg+"tpl/img/sedan2.png";
// Affichage du marker (repère)
  var marker = new GMarker(point,MonIcon);
  map.addOverlay(marker);
  // Initialisation de l'array "maligne" préchargé par le contenu des cordonnées
// délimitant les segments constituant la polyligne
  var maligne = new GPolyline([
    new GLatLng(51.50135, -0.14184000000000002),
    new GLatLng(51.50161000000001, -0.14113),
    new GLatLng(51.501400000000004, -0.14072),
    new GLatLng(51.50150000000001, -0.14032),
    new GLatLng(51.50175, -0.14008),
    new GLatLng(51.501990000000006, -0.14012000000000002),
    new GLatLng(51.50211, -0.14004),
    new GLatLng(51.505840000000006, -0.13083),
    new GLatLng(51.50524000000001, -0.12946000000000002),
    new GLatLng(51.50513, -0.12912),
    new GLatLng(51.50529, -0.12802000000000002)
    ], "#000000;", 4);
// Affichage de la ligne
  map.addOverlay(maligne);
// marqueur N° 1
/*
var origin = new GLatLng(51.50135, -0.14184000000000002);
map.addOverlay(new GMarker(origin));
*/
// Ajout de la propriété "Marker" (repère personnalisé)
  var origin = new GLatLng(51.50135, -0.14184000000000002); // Position du marker
// Initialisation d'un nouvel objet GIcon et de ses propriétés
  var MonIcon = new GIcon(G_DEFAULT_ICON);
  MonIcon.iconSize=new GSize(24,41);
  MonIcon.iconAnchor=new GPoint(15,40);
  MonIcon.image=racineimg+"tpl/img/map80.png";
// Affichage du marker (repère)
  var marker02 = new GMarker(origin,MonIcon);
  map.addOverlay(marker02);

}


//google.maps.event.addDomListener(window, 'load', load);

/*function supportFullScreen(){
    var doc = document.documentElement;
    return ('requestFullscreen' in doc) || ('mozRequestFullScreen' in doc && document.mozFullScreenEnabled) || ('webkitRequestFullScreen' in doc);
}

var fullscreen = document.getElementById("map");
function requestFullScreen(elem){
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullScreen) {
        elem.webkitRequestFullScreen();
    }
  document.getElementById('map').style.width='100%';
  document.getElementById('map').style.height='100%';
}

function exitFullscreen() {
        if(document.cancelFullScreen) {
                //fonction officielle du w3c
                document.cancelFullScreen();
        } else if(document.webkitCancelFullScreen) {
                //fonction pour Google Chrome
                document.webkitCancelFullScreen();
        } else if(document.mozCancelFullScreen){
                //fonction pour Firefox
                document.mozCancelFullScreen();
        }
 }

element.onfullscreenchange = callback;
element.onwebkitfullscreenchange = callback;
element.onmozfullscreenchange = callback;
*/
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
  reloadmap();
}
var markers = [];
var marker_bounds = [];
var Box = [];
var Circle = [];
var map;
var listCircle;

function initmap(){
  map = new google.maps.Map(document.getElementById("map"));
  
  reloadmap()
}
function reloadmap(val){
  
  $.getJSON(racineimg+"/tpl/script/listvehicule.php",$("#formlistvehicule").serialize())
       .done(function( json ) {
          //alert(json);
          //affichage des vehicules
          
          deleteMarkers();
          
          showbulle=document.getElementById('bulle').checked
          if(document.getElementById('lieu').checked==true){
          showlieux(map)
          }
          $.each(json.listvehicule, function( i, item ) {
            
            // Ajout de la propriété "Marker" (repère personnalisé)

            var myLatLng = new google.maps.LatLng(item.latitude, item.longitude);
            var image = {
              url: item.img,   
              // This marker is 20 pixels wide by 32 pixels tall.
              //size: new google.maps.Size(32, 32),
              // The origin for this image is 0,0.
              //origin: new google.maps.Point(0,0),
              // The anchor for this image is the base of the flagpole at 0,32.
              //anchor: new google.maps.Point(16, 16)
            };
            
            if(showbulle){
            //creation du cercle
            var circle="<div class=\"circle\" style=\"background:"+item.couleur+";border-color:"+item.bordure+"\"></div>";
            var labelText = circle+"<div class=\"labels\">"+item.nomvehicule+"<br>"+item.date+"</div>";

        		var myOptions = {
        			 content: labelText
        			,boxClass:''
        			,disableAutoPan: true
        			,pixelOffset: new google.maps.Size(-54,-25)
        			,position: myLatLng
        			,closeBoxURL: ""
        			,isHidden: false
        			,enableEventPropagation: true
        		};
        
        		var ibLabel = new InfoBox(myOptions);
        		ibLabel.open(map);
            Box.push(ibLabel);
            }
             
            /*
            var mycircle = {
              strokeColor: item.couleur,
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: item.bordure,
              fillOpacity: 0.35,
              map: map,
              center: myLatLng,
              radius:  15000
            };
            //alert(Math.sqrt(8405837) * 100)
            listCircle = new google.maps.Circle(mycircle);
            */
            
            //console.log(myLatLng)
            // Affichage du marker (repère)
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: image,
                //shape: shape,
                title: item.nomvehicule
            });
            markers.push(marker);
            marker_bounds.push(myLatLng);  
            
          });
          if(val!="not"){
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
          }
          if(document.getElementById('suivichk').checked==true){
            //alert('ici');
            setTimeout(reloadmap,2000);
          }
        })
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            console.log( "Request Failed: " + err );
        });    
}

function deleteMarkers() {
  clearMarkers();
  markers = [];
  deleteAllBox();
  Box = [];
  marker_bounds =[];
}
function clearMarkers() {
  setAllMap(null);
}
function setAllMap(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}
function deleteAllBox() {
  for (var i = 0; i < Box.length; i++) {
    Box[i].close();
  }
}

var intervalSuivi=null;
google.maps.event.addDomListener(window, 'load', initmap);
function fctsuivi(obj){
  /*
  if(obj.checked==true){
    intervalSuivi=setInterval(reloadmap,1000);
  }else{
    clearInterval(intervalSuivi);  
  } */
  if(obj.checked==true){
    reloadmap();
  }
}


function showlieux(map){
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
    markers.push(listCircle);
    marker_bounds.push(myLatLng);
    markers.push(marker);
  }

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