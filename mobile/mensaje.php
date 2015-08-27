<?php header('Access-Control-Allow-Origin: *'); ?>
<?php 
require "lib/Pusher.php";
$pusher = PusherInstance::get_pusher();
$pusher->trigger(
'dot_mensaje',
'mensaje',
array('mensaje' => "Nuevo mensaje!!!")
);
 ?>