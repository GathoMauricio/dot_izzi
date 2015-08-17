<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Geolocalización Google API v3</title>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#map_canvas").css("width",screen.width);
  $("#map_canvas").css("height",screen.height);
});
var map; //importante definirla fuera de la funcion initialize() para poderla usar desde otras funciones.
 
 function initialize() {
   var punto = new google.maps.LatLng(<?php echo $_GET['lat']; ?>,<?php echo $_GET['lon']; ?>); //ubicación del Plaza Central de Tikal, Guatemala
   var myOptions = {
     zoom: 18, //nivel de zoom para poder ver de cerca.
     center: punto,
     mapTypeId: google.maps.MapTypeId.ROADMAP //Tipo de mapa inicial, satélite para ver las pirámides
   }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
    var marcador = new google.maps.Marker({
      position:punto,
      map:map,
      animation:google.maps.Animation.DROP,
      draggable:false
     });
    var infowindow = new google.maps.InfoWindow({ content: "El técnico se encuentra aproximadamente a <?php echo $_GET['aprox']; ?> Metros de este punto" }); 
     infowindow.open(map, marcador);
 }
  
 //copiamos la función de geolocalización del ejemplo anterior.
  
 function pedirPosicion(pos) {
   var centro = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
   map.setCenter(centro); //pedimos que centre el mapa..
   map.setMapTypeId(google.maps.MapTypeId.ROADMAP); //y lo volvemos un mapa callejero
  alert("¡Hola! Estas en : "+pos.coords.latitude+ ","+pos.coords.longitude+" Rango de localización de +/- "+pos.coords.accuracy+" metros");
}
 
function geolocalizame(){
navigator.geolocation.getCurrentPosition(pedirPosicion);
 }
  
  
</script>
</head>
<body onload="initialize()">
 <div id="map_canvas"></div>
</body>
</html>