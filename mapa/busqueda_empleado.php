<?php include "../mobile/conexion.php" ?>
<?php 
if(isset($_GET['id'])){
  $consulta="SELECT lat,lon FROM empleado WHERE id_empleado=".$_GET['id'];
  $datos=mysqli_query($conexion,$consulta);
  if($fila=mysqli_fetch_array($datos))
  {
    $lat=$fila['lat'];
    $lon=$fila['lon'];
  }
}
?>


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
   var punto = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lon; ?>);
   var myOptions = {
     zoom: 13, //nivel de zoom para poder ver de cerca.
     center: punto,
     mapTypeId: google.maps.MapTypeId.ROADMAP //Tipo de mapa inicial, satélite para ver las pirámides
   }
     map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
     google.maps.Map.prototype.markers = new Array();
 
       // marcadores[0].setPosition(new google.maps.LatLng(19.3737678,-98.9813983));
        
          <?php 
      
           date_default_timezone_set("Mexico/General");
           $consulta = "SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=2 OR u.id_rol=3 AND fecha_conexion='".date('Y-m-d')."' ORDER BY e.id_empleado";
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
              
                contador=0;
                console.log("Actualizado...");
                
                $.post("get_position.php",{
                  id_empleado:<?php echo $_GET['id'] ?>
                },function(data){
                
                var json = eval(data);
                datos=json;
                for (var i =  0; i < json.length; i++) {
                    marcadores[i].setPosition(new google.maps.LatLng(json[i].lat,json[i].lon));
                    marcadores[i].setTitle(json[i].nombre+"\nUltima conexión: "+json[i].fecha+" a las "+json[i].hora+" Hrs.\nAproximación: "+json[i].aprox+" Metros");
                    
                };
              });
              
              
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