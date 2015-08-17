<?php session_start() ?>
<?php include "../control/conexion.php" ?>
<?php 
$empleado=$_POST['id'];
$archivos_disp_ar = array('jpg', 'jpeg', 'gif', 'png'); 

 $carpeta = '../img/'; 
  //recibimos el campo de imagen 
  $imagen = $_FILES['imagen']['tmp_name']; 
  //guardamos el nombre original de la imagen en una variable 
  $nombrebre_orig = $_FILES['imagen']['name']; 
  
  //el proximo codigo es para ver que extension es la imagen 
  $array_nombre = explode('.',$nombrebre_orig); 
  $cuenta_arr_nombre = count($array_nombre); 
  $extension = strtolower($array_nombre[--$cuenta_arr_nombre]);

   //validamos la extension 
  if(!in_array($extension, $archivos_disp_ar)) $error = "Este tipo de archivo no es permitido"; $error_img = "error";
  
  if(empty($error)){ 

/*echo 'Nombre: ' . $_FILES['imagen']['name'] . '<br>';
echo 'Tipo: ' . $_FILES['imagen']['type'] . '<br>';
echo 'Tamaño: ' . ($_FILES['imagen']['size'] / 1024) . ' Kb<br/>';
echo 'Guardado en: ' . $_FILES['imagen']['tmp_name'];*/
move_uploaded_file($_FILES['imagen']['tmp_name'],"../img/" . $_FILES['imagen']['name']);
echo "Nombre del archivo". $_FILES['imagen']['name'];

$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
mysqli_set_charset($conexion, "utf8");
$consulta="UPDATE empleado SET foto='".$_FILES['imagen']['name']."' WHERE id_empleado=".$empleado;
mysqli_query($conexion,$consulta);
mysqli_close($conexion);
  echo "<h3>La imagen se almacenó con éxito.<br>";
  echo "Redireccionando....</3>";
  header('refresh:2; url=../view/empleados.php');


  }else
  {
  	echo "<h3>La extencion del archivo no coincide con el de una imagen.<br>";	
  	echo "Redireccionando....</h3>";
  	header('refresh:2; url=../view/empleados.php');
  }




?>