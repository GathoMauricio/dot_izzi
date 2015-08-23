<?php 
if(isset($_GET['id'])){
  $lat="";
  $lon="";
switch ($_GET['id']) {
    //Distrito FederaL
    case 1:
    $lat="19.3907336";
    $lon="-99.1436127";
    break;
    //Merida
    case 2:
    $lat="20.972843";
    $lon="-89.632918";
    break;
    //Ensenada BC
    case 3:
    $lat="31.8402533";
    $lon="-116.610074";
    break;
    //Tijuana
    case 4:
    $lat="32.4969499";
    $lon="-116.9726224";
    break;
    //Chihuahua
    case 7:
    $lat="28.6716648";
    $lon="-106.1908274";
    break;
    //Mexicali
    case 8:
    $lat="32.6132623";
    $lon="-115.450291";
    break;
    //Pozarica
    case 9:
    $lat="20.5343213";
    $lon="-97.4449087";
    break;
    //Cuernavaca
    case 10:
    $lat="18.9318816";
    $lon="-99.240565";
    break;
    //CD Juarez
    case 11:
    $lat="31.6538628";
    $lon="-106.4432072";
    break;
    //Acapulco
    case 12:
    $lat="16.8354901";
    $lon="-99.8622709";
    break;
    //Cancún
    case 13:
    $lat="21.121445";
    $lon="-86.8494402";
    break;
    //Parral
    case 14:
    $lat="26.9490009";
    $lon="-105.6775866";
    break;
    //Monterrey
    case 15:
    $lat="25.648795";
    $lon="-100.3030961";
    break;
    //Oaxaca
    case 16:
    $lat="17.163454";
    $lon="-96.210067";
    break;
    //Campeche
    case 17:
    $lat="19.3305991";
    $lon="-90.7947859";
    break;
    //coatzacoalcos
    case 18:
    $lat="18.134214";
    $lon="-94.4629468";
    $zoom="13";
    break;
    //Chilpancingo
    case 19:
    $lat="17.5477102";
    $lon="-99.4974153";
    break;
    //Lagos
    case 20:
    $lat="";
    $lon="";
    break;
    //Villahermosa
    case 21:
    $lat="17.9925296";
    $lon="-92.9531211";
    break;
    //Edo de mexico
    case 22:
    $lat="19.3264047";
    $lon="-99.6049788";
    break;
    //delicias
    case 23:
    $lat="18.9379556";
    $lon="-99.2021258";
    break;
    //Meoqui
    case 24:
    $lat="28.2744074";
    $lon="-105.4790369";
    break;
    //Camargo
    case 25:
    $lat="28.058209";
    $lon="-104.4595833";
    break;
    //Cuautemoc
    case 26:
    $lat="19.432807";
    $lon="-99.1532724";
    break;
   default:
    $lat="23.1340755";
    $lon="-100.5197195";
    break;
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
     zoom: 11, //nivel de zoom para poder ver de cerca.
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