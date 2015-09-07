<?php header('Access-Control-Allow-Origin: *'); ?>
<?php 
require "lib/Pusher.php";
$pusher = PusherInstance::get_pusher();
$pusher->trigger(
'dot_mensaje',
'mensaje'.$_POST['id'],
array('mensaje' => "Favor de actualizar la aplicación!!!")
);
echo "Alerta enviada!!!";
 ?>