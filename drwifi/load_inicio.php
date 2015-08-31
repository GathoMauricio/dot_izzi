
<?php 
header('Access-Control-Allow-Origin: *');
include "../mobile/conexion.php";
$consulta="SELECT * FROM expediente WHERE id_expediente=".$_POST['expediente'];
$datos=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($datos))
{
	$expediente=$fila['id_expediente'];
	$usuario=$fila['usuario'];
	$lat=$fila['lat_expediente'];
	$lon=$fila['lon_expediente'];
}
 ?>
 <center>
 	<img src="img/logo.png" width="40"><br>
 <label style="color:#FFF;">Asistencia izzi Dr. Wifi</label>
 </center>
 <h3 style="color:#FF8000;">Expediente: <?php echo $expediente; ?></h3>
 <h3 style="color:#FF8000;">Usuario: <?php echo $usuario; ?></h3>

 <script type="text/javascript">
 var map;
function initialize() {

           var punto = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lon; ?>); 
           var myOptions = {
             zoom: 16, 
             center: punto,
             mapTypeId: google.maps.MapTypeId.ROADMAP 
           }
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            
            var marcador = new google.maps.Marker({
              position:punto,
              map:map,
              animation:google.maps.Animation.DROP,
              draggable:false
             });
            var infowindow = new google.maps.InfoWindow({ content: "El servicio es aquí" }); 
             infowindow.open(map, marcador);
             
             map.addListener('dblclick', function(e) {
    			marcador.setPosition(e.latLng);
    			$.post("http://dotredes.dyndns.biz:18888/dot_izzi/drwifi/update_location_expediente.php",
				{
				expediente:window.localStorage.getItem("expediente"),
				lat:marcador.getPosition().lat(),
				lon:marcador.getPosition().lng()
				},function(data){
					swal("posición cambiada!","Este será el punto donde llegará nuestro técnico","success");
				});
  			});

         }
         initialize();
 </script>
 <style type="text/css">
#map_canvas{
	width: 90%;
	height: 300px;
}
 </style>
 <label style="color:#FFF;">Para brindarle un mejor servicio hemos detectado su posición actual, 
 	para cambiar el lugar donde se llevará acabo el servicio técnico por favor toque 2 veces seguidas 
 	sobre el mapa para indicarnos la posición. 
 	<br><br> También puedes 
 	<a href="#" onclick="comentar();" style="color:white;">AGREGAR DETALLES.</a></label><br><br>
 <center>
 	<div id="map_canvas"></div>
 </center>
 <br><br>
 <center>
<a href="#" onclick="cerrarSesion();" style="color:white;">Cerrar sesión</a>
 </center>