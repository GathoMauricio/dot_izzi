<?php 
if(isset($_GET['id'])){
  $lat="";
  $lon="";
switch ($_GET['id']) {
    case 1:
    $lat="";
    $lon="";
    break;
    case 2:
    $lat="";
    $lon="";
    break;
    case 3:
    $lat="";
    $lon="";
    break;
    case 4:
    $lat="";
    $lon="";
    break;
    case 5:
    $lat="";
    $lon="";
    break;
    case 6:
    $lat="";
    $lon="";
    break;
    case 7:
    $lat="";
    $lon="";
    break;
    case 8:
    $lat="";
    $lon="";
    break;
    case 9:
    $lat="";
    $lon="";
    break;
    case 10:
    $lat="";
    $lon="";
    break;
    case 11:
    $lat="";
    $lon="";
    break;
    case 12:
    $lat="";
    $lon="";
    break;
    case 13:
    $lat="";
    $lon="";
    break;
    case 14:
    $lat="";
    $lon="";
    break;
    case 15:
    $lat="";
    $lon="";
    break;
    case 16:
    $lat="";
    $lon="";
    break;
    case 17:
    $lat="";
    $lon="";
    break;
    case 18:
    $lat="";
    $lon="";
    break;
    case 19:
    $lat="";
    $lon="";
    break;
    case 20:
    $lat="";
    $lon="";
    break;
    case 21:
    $lat="";
    $lon="";
    break;
    case 22:
    $lat="";
    $lon="";
    break;
    case 23:
    $lat="";
    $lon="";
    break;
    case 24:
    $lat="";
    $lon="";
    break;
    case 25:
    $lat="";
    $lon="";
    break;
    case 26:
    $lat="";
    $lon="";
    break;

  
  default:
    $lat="23.1340755";
    $lon="-100.5197195";
    break;
}

} 
?>
  
<?php endif ?>

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
 var ico="";
 var rol="";
 
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
           $consulta = "SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=2 OR u.id_rol=3 ORDER BY e.id_empleado";
           $datos=mysqli_query($conexion,$consulta);
           while($fila=mysqli_fetch_array($datos)){
          ?>
          var lon=<?php echo $fila['lon']; ?>;
          var lat=<?php echo $fila['lat']; ?>;
          var aprox="<?php echo $fila['aprox']; ?>";
          
          var direccion = new google.maps.LatLng(lat,lon);
         
          if("<?php echo $fila['id_rol']; ?>"==2)
          {
            ico="ico_g.png";
            rol="Gerente: ";
          }else{
            ico="ico_t.png";
            rol="Técnico: ";
          }

            marcadores.add(new google.maps.Marker({
            position:new google.maps.LatLng(lat,lon),
            map:null,
            animation:google.maps.Animation.DROP,
            draggable:false,
            icon:ico,
            title:rol+"<?php echo $fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno']; ?>\n Ultima conexión: <?php echo $fila['fecha_conexion']; ?> a las <?php echo $fila['hora_conexion']; ?> Hrs\nAproximación: "+aprox+" Metros"
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
                    marcadores[i].setTitle(rol+json[i].nombre+"\nUltima conexión: "+json[i].fecha+" a las "+json[i].hora+" Hrs.\nAproximación: "+json[i].aprox+" Metros");
                    
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