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
var map;
var listCircle;

function initmap(){
  map = new google.maps.Map(document.getElementById("map"));
  reloadmap()
}
function reloadmap(){
  
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
          
          var latlngbounds = new google.maps.LatLngBounds();
          for ( var i = 0; i < marker_bounds.length; i++ ) {
             latlngbounds.extend(marker_bounds[i]);
          }
          map.setCenter(latlngbounds.getCenter(),6);
          map.fitBounds(latlngbounds);
          
          
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
  if(obj.checked==true){
    intervalSuivi=setInterval(reloadmap,1000);
  }else{
    clearInterval(intervalSuivi);  
  }
}


function showlieux(map){
  for(i=0;i<tab.length;i++){
    
    var myLatLng = new google.maps.LatLng(tab[i][1], tab[i][2]);
    var image = {
      url: racineimg+'tpl/img/lieux/'+tab[i][0],   
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

}