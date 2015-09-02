<?php 
 base64_decode($_POST['imagen']);
$expediente=$_POST['expediente'];

include"../../conexion.php";
$consulta="UPDATE expediente SET firma='firma_".$expediente.".png' WHERE id_expediente=".$expediente;
mysqli_query($conexion,$consulta);

//imagen png codificada en base64
$Base64Img = $_POST['imagen'];
 
//eliminamos data:image/png; y base64, de la cadena que tenemos
//hay otras formas de hacerlo				   
list(, $Base64Img) = explode(';', $Base64Img);
list(, $Base64Img) = explode(',', $Base64Img);
//Decodificamos $Base64Img codificada en base64.
$Base64Img = base64_decode($Base64Img);
//escribimos la información obtenida en un archivo llamado 
//unodepiera.png para que se cree la imagen correctamente
file_put_contents('firma_'.$expediente.'.png', $Base64Img);	
//echo "<img src='firma.png' alt='unodepiera' />";
move_uploaded_file($Base64Img, '/test/firma_'.$expediente.'.png');


 ?>