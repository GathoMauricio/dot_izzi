<?php 
 base64_decode($_POST['imagen']);


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
file_put_contents('firma.png', $Base64Img);	
//echo "<img src='firma.png' alt='unodepiera' />";
move_uploaded_file($Base64Img, '/test/firma.png');
 ?>