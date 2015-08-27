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
              console.log(contador);
              
                console.log("Actualizado...");
                
                $.post("get_position.php",{},function(data){
                
                var json = eval(data);
                datos=json;
                for (var i =  0; i < json.length; i++) {
                    marcadores[i].setPosition(new google.maps.LatLng(json[i].lat,json[i].lon));
                    marcadores[i].setTitle(rol+json[i].nombre+"\nUltima conexión: "+json[i].fecha+" a las "+json[i].hora+" Hrs.\nAproximación: "+json[i].aprox+" Metros");
                    
                };
              });
              
              
              Concurrent.Thread.sleep(1000);
            }
          });


}

function buscarLocacion(id)
{
  if(id>0)
  {
    window.open("busqueda_locacion.php?id="+id);
  }
}
function buscarEmpleado(id)
{
  if(id>0)
  {
    window.open("busqueda_Empleado.php?id="+id);
  }
}
function enviarAlerta()
{
  $.post("http://dotredes.dyndns.biz:18888/dot_izzi/mobile/mensaje.php",{
    id:$("#txt_id_alerta").prop("value")
  },function(data){});
}
</script>
</head>
<body onload="initialize();" style="background-color:black">
<br>
<label style="color:white">Buscar locación</label>
<select onchange="buscarLocacion(this.value);">
 <option value="0">Selecionar locacion</option> 
<?php 
$consulta = "SELECT * FROM locacion ";
$datos=mysqli_query($conexion,$consulta);
while ($fila=mysqli_fetch_array($datos)) {
  echo '<option id="txt_buscar_mapa" value="'.$fila['id_locacion'].'">'.$fila['locacion'].'</option>';
}
 ?>
</select>
<label style="color:white">Buscar Empleado</label>
<select onchange="buscarEmpleado(this.value);">
 <option value="0">Selecionar Empleado</option> 
<?php 
$consulta = "SELECT * FROM empleado ";
$datos=mysqli_query($conexion,$consulta);
while ($fila=mysqli_fetch_array($datos)) {
  echo '<option id="txt_buscar_mapa" value="'.$fila['id_empleado'].'">'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'</option>';
}
 ?>
</select>
<label style="color:white">Enviar alerta</label>
<select>
 <option value="0">Enviar a todos</option> 
<?php 
$consulta = "SELECT * FROM empleado ";
$datos=mysqli_query($conexion,$consulta);
while ($fila=mysqli_fetch_array($datos)) {
  echo '<option id="txt_id_alerta" value="'.$fila['id_empleado'].'">'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'</option>';
}
 ?>
</select>
<button onclick="enviarAlerta();">Eviar Alerta</button>
<br><br>

 <div id="map_canvas" ></div>
</body>
</html>