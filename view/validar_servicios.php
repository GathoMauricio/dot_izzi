<?php session_start() ?>
<?php if(!isset($_SESSION['login'])){ header("Location: ../index.php"); } ?>
<?php 
date_default_timezone_set("Mexico/General");
switch ($_SESSION['rol']) {
	case 1:
		header("Location: admin.php");
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
                    
                    <li><a href="gerente.php"><span class="glyphicon glyphicon-tasks"></span> Estatus de servicios</a></li>
                    <li><a href="nuevo_servicio.php"><span class="glyphicon glyphicon-plus"></span> Agregar nuevo servicio</a></li>
                    <li><a href="validar_servicios.php"><span class="glyphicon glyphicon-thumbs-up"></span>Validar servicios</a></li>
                    <li><a href="pendientes_gerente.php"><span class="glyphicon glyphicon-tasks"></span> Pendientes</a></li>
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
     <div class="publicacion">

     <center>
            <?php
            include "../control/conexion.php";
            $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
            $consulta_locacion="SELECT * FROM locacion";
            $datos_locacion=mysqli_query($conexion,$consulta_locacion);
            echo '<div id="inicio">';
            while($fila_locacion=mysqli_fetch_array($datos_locacion))
            {
                echo '/<a href="#lbl_'.$fila_locacion['locacion'].'"> '.$fila_locacion['locacion'].' </a>/';
            }
            echo '</div>';
            ?>
            </center>
     </div>      
    <br>

     <div id="contenedor_validar_servicios"></div>
    <!--Modal notificacion-->
<div class="modal fade" id="modal-notificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h3>Notificación!!!</h3>
                </div>
                <div class="modal-body">
                     <h4 id="txt_notificacion"></h4> 
                 </div>
                                    
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                     <!--<button class="btn btn-default" data-dismiss="modal">Cancelar</button><br>-->
                </div>
            </div>
        </div>
     </div>
<?php include "footer.katze" ?>


