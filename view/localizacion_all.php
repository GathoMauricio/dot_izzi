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
   var punto = new google.maps.LatLng(23.1340755,-100.5197195);
   var myOptions = {
     zoom: 5, //nivel de zoom para poder ver de cerca.
     center: punto,
     mapTypeId: google.maps.MapTypeId.ROADMAP //Tipo de mapa inicial, satélite para ver las pirámides
   }
     map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

     <?php 
     include "../control/conexion.php";
     date_default_timezone_set("Mexico/General");
     $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
     mysqli_set_charset($conexion, "utf8");
     $consulta = "SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=3";
     $datos=mysqli_query($conexion,$consulta);
     while($fila=mysqli_fetch_array($datos)){
    ?>
    var lon=<?php echo $fila['lon']; ?>;
    var lat=<?php echo $fila['lat']; ?>;
    
    var direccion = new google.maps.LatLng(lat,lon);
     var marcador = new google.maps.Marker({
      position:direccion,
      map:map,
      animation:google.maps.Animation.DROP,
      draggable:false
     });
     var infowindow = new google.maps.InfoWindow({ content: "<?php echo $fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno']; ?> \n Ultima conexión: <?php echo $fila['fecha_conexion']; ?> a las <?php echo $fila['hora_conexion']; ?> Hrs" }); 
     infowindow.open(map, marcador);

     google.maps.event.addListener(marcador,'click',function(){
      
     });
     marcador.setMap(map);
<?php  } ?>
}
  

  
  
</script>
</head>
<body onload="initialize()">
 <div id="map_canvas" ></div>
</body>
</html>