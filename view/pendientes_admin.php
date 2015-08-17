<?php session_start() ?>
<?php if(!isset($_SESSION['login'])){ header("Location: ../index.php"); } ?>
<?php 
date_default_timezone_set("Mexico/General");
switch ($_SESSION['rol']) {
	case 2:
		header("Location: gerente.php");
		break;
	case 3:
		header("Location: tecnico.php");
		break;
    case 4:
        header("Location: ike.php");
        break;
    case 5:
        header("Location: foraneo.php");
        break;    
	}
 ?>

<?php include "header.katze" ?>

<!--Barra de Navegacion-->
        <nav class="navbar navbar-inverse" role="navigation" id="barra">
            <div class="navbar-header">
                	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Cambiar Navegacion</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
					</button>
                    
                	
            </div>
            

            <div class="collapse navbar-collapse navbar-ex1-collapse">
            	<ul class="nav navbar-nav" >
                    
                    <li><a href="admin.php"><span class="glyphicon glyphicon-tasks"></span> Servicios</a></li>
                    <li><a href="pendientes_admin.php"><span class="glyphicon glyphicon-tasks"></span> Pendientes</a></li>
                    <li><a href="empleados.php"><span class="glyphicon glyphicon-user"></span> Empleados</a></li>
                    <li><a href="nuevo_empleado.php"><span class="glyphicon glyphicon-plus"></span>Nuevo empleado</a></li>
                    <li><a id="li_video" onclick="abrirVideo();"><span class="glyphicon glyphicon-film"></span> Video</a></li>
                    <li><a href="../control/cerrar_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión </a></li>
                </ul>
             </div>
        </nav>
     <!--End Barra de Navegacion-->
     <h3>SERVICIOS IZZI</h3>
     <center>
    <img src="../img/logo.png" id="logo_dot">
    </center>
     <center>
     <p ><label><span class="glyphicon glyphicon-calendar"></span> <?php echo " ".date('Y-m-d'); ?><br><span class="glyphicon glyphicon-user"></span><?php echo " ". $_SESSION['login'] ?></label></p>
     </center>
     <br><br><br>
     <!--BUSCADOR AQUI-->
     
        <br>
        <hr>
        <button class="btn btn-info" onclick="showNuevoPendienteAdmin();"><span class="glyphicon glyphicon-plus"></span> Agregar pendiente</button>
        <button class="btn btn-success" onclick="cargarPendientesTerminados();"><span class="glyphicon glyphicon-log-out"></span> Pendientes terminados</button>
        <hr>
        <?php include "../control/conexion.php" ?>
        <?php 
        date_default_timezone_set("Mexico/General");
        $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
        mysqli_set_charset($conexion, "utf8");

        $consulta_empleado="SELECT * FROM empleado ORDER BY nombre";
        $datos_empleado=mysqli_query($conexion,$consulta_empleado);
        while($fila_empleado=mysqli_fetch_array($datos_empleado))
        {
            echo "<a id='inicio' href='#lbl_".$fila_empleado['nombre']." ".$fila_empleado['apaterno']." ".$fila_empleado['amaterno']."'>".$fila_empleado['nombre']." ".$fila_empleado['apaterno']." ".$fila_empleado['amaterno']."</a><br>";
        }
         ?>
         <hr>
     <div id="contenedor_pendientes_admin">

     </div>
<?php include "modal_editar_pendiente.php" ?> 
<?php include "modal_detalle_pendiente.php" ?>  
<?php include "modal_nuevo_pendiente_admin.php" ?>  
<?php include "modal_reasignar_admin.php" ?>    
<?php include "footer.katze" ?>