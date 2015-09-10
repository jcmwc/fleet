$(document).ready(function() {
  $('#map_bloc2').hide();
  $('form').jqTransform({imgPath:'jqtransformplugin/img/'});

  $('tr:odd')
    .css({
      "background-color" : "white", 
      "color" : "#333132",
      "z-index" : "1"
  });

  $( ".datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
  $(".datepicker").datepicker({
    dateFormat : 'dd/mm/yy',
  });

  $( ".timepicker" ).timepicker( $.timepicker.regional[ "fr" ] );
    $(function(){
      $('.timepicker').timepicker({
        showPeriodLabels: false,
      });
  });
});
 function showmap2(){
  $('#map_bloc2').fadeIn(500);
  $('.itinery').replaceWith("<a class='itinery' href=\"javascript:hidemap2()\"><img src='img/itinerary.gif'></a>")
  google.maps.event.trigger(map,'resize');
  $('html, body').animate({
    scrollTop:$("#map_bloc2").offset().top
  }, 'slow');
 }

function hidemap2(){
  $('#map_bloc2').hide(500);
  $('.itinery').replaceWith("<a class='itinery' href='javascript:showmap2()'><img src='img/itinerary.gif'></a>")
 }

function initialize() {
    var a = new google.maps.LatLng(51.50135, -.14184000000000002),
        b = {
            zoom: 15,
            center: a
        },
        c = new google.maps.Map(document.getElementById("map"), b),
        d = (new google.maps.Marker({
            position: a,
            map: c
        }), [new google.maps.LatLng(51.50135, -.14184000000000002), new google.maps.LatLng(51.50161000000001, -.14113), new google.maps.LatLng(51.501400000000004, -.14072), new google.maps.LatLng(51.50150000000001, -.14032), new google.maps.LatLng(51.50175, -.14008), new google.maps.LatLng(51.501990000000006, -.14012000000000002), new google.maps.LatLng(51.50211, -.14004), new google.maps.LatLng(51.505840000000006, -.13083), new google.maps.LatLng(51.50524000000001, -.12946000000000002), new google.maps.LatLng(51.50513, -.12912), new google.maps.LatLng(51.50529, -.12802000000000002)]),
        e = new google.maps.Polyline({
            path: d,
            geodesic: !0,
            strokeColor: "#FF0000",
            strokeOpacity: 1,
            strokeWeight: 2
        });
    e.setMap(c)
}
google.maps.event.addDomListener(window, "load", initialize);

