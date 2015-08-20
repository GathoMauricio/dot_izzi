<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Geolocalización Google API v3</title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="Concurrent.Thread.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#map_canvas").css("width",screen.width);
  $("#map_canvas").css("height",screen.height);
});
var contador=0;
var map; //importante definirla fuera de la funcion initialize() para poderla usar desde otras funciones.
var marcadores=new Array();
//var textos=new Array();
var time=0;
 function initialize() {
   var punto = new google.maps.LatLng(23.1340755,-100.5197195);
   var myOptions = {
     zoom: 5, //nivel de zoom para poder ver de cerca.
     center: punto,
     mapTypeId: google.maps.MapTypeId.ROADMAP //Tipo de mapa inicial, satélite para ver las pirámides
   }
     map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
     google.maps.Map.prototype.markers = new Array();
 
       // marcadores[0].setPosition(new google.maps.LatLng(19.3737678,-98.9813983));
        <?php include "../mobile/conexion.php" ?>
          <?php 
      
           date_default_timezone_set("Mexico/General");
           $consulta = "SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=3 ORDER BY e.id_empleado";
           $datos=mysqli_query($conexion,$consulta);
           while($fila=mysqli_fetch_array($datos)){
          ?>
          var lon=<?php echo $fila['lon']; ?>;
          var lat=<?php echo $fila['lat']; ?>;
          
          var direccion = new google.maps.LatLng(lat,lon);

            marcadores.add(new google.maps.Marker({
            position:new google.maps.LatLng(lat,lon),
            map:null,
            animation:google.maps.Animation.DROP,
            draggable:false,
            icon:'ico.png',
            title: "<?php echo $fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno']; ?>\n Ultima conexión: <?php echo $fila['fecha_conexion']; ?> a las <?php echo $fila['hora_conexion']; ?> Hrs"
           }));
          <?php  } ?>//end while sql

          for (var i = 0; i < marcadores.length; i++) {

            marcadores[i].setMap(map);
          };//end for

          
          Concurrent.Thread.create(function(){
            while(1){
              contador++;
              console.log(contador);
              if(contador==10)
              {
                contador=0;
                console.log("Actualizado...");
                
                $.post("get_position.php",{},function(data){
                
                var json = eval(data);
                datos=json;
                for (var i =  0; i < json.length; i++) {
                    marcadores[i].setPosition(new google.maps.LatLng(json[i].lat,json[i].lon));
                    marcadores[i].setTitle(json[i].nombre+"\nUltima conexión: "+json[i].fecha+" a las "+json[i].hora+" Hrs.");
                    
                };
              });
              }
              
              Concurrent.Thread.sleep(1000);
            }
          });


}

  
</script>
</head>
<body onload="initialize();">
 <div id="map_canvas" ></div>
</body>
</html>