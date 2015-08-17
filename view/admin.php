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
     <div class="publicacion">
     <table class="table"> 
        <tr>
        <td><label for="expediente">Fecha</label> </td><td><input type="date" class="form-control" id="fecha_admin"></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarFecha('admin');"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
        </tr>
        <tr>
        <td><label for="expediente">N° Expediente</label></td><td><input type="text" class="form-control" id="expediente_admin" onkeypress="soloNumeros();" maxlength="10" placeholder="N° de Expediente"></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarExpediente('admin');"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
        </tr>
        <tr>
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
            echo '<button class="btn btn-info" title="Ver ultimo registro de geolocalización" onclick="showGeolocalizacionAll(this.id)"  style="float:right"><span class="glyphicon glyphicon-globe"></span>Geolocalización</button>';
            echo '</div>';
            ?>
            </center>
        </tr>
     </table>
    </div>
        
        <br>
        <hr>
        <label>REPORTES</label>
        <?php include "../control/conexion.php" ?>
            <?php 
                $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
                mysqli_set_charset($conexion, "utf8");
                $consulta="SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=3";
                $datos=mysqli_query($conexion,$consulta);
             ?>

            <div class="form-inline">
                <input style="width:12%" type="date"   id="fecha_inicio" class="input_reporte" required> A
                <input style="width:12%" type="date"  id="fecha_final" class="input_reporte" required>
                <select style="width:10%"  id="cb_tecnico" class="input_reporte">
                    <option value="">TECNICO</option>
                    <?php 
                        while($fila=mysqli_fetch_array($datos))
                        echo '<option value="'.$fila['id_empleado'].'">'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'</option>';
                     ?>
                </select>
                <?php 
                    $consulta="SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=2";
                    $datos=mysqli_query($conexion,$consulta);
                 ?>
                <select style="width:8%" id="cb_capturo" class="input_reporte" >
                    <option value="" >CAPTURO</option>
                    <?php 
                        while($fila=mysqli_fetch_array($datos))
                        echo '<option value="'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'">'.$fila['nombre'].' '.$fila['apaterno'].' '.$fila['amaterno'].'</option>';
                     ?>
                </select>
                <?php 
                    $consulta="SELECT * FROM estatus_ike";
                    $datos=mysqli_query($conexion,$consulta);
                 ?>
                <select style="width:10%"  id="cb_estatus_ike" class="input_reporte">
                    <option value="">ESTATUS IKE</option>
                    <?php 
                        while($fila=mysqli_fetch_array($datos))
                        echo '<option value="'.$fila['id_estatus_ike'].'">'.$fila['estatus'].'</option>';
                     ?>
                </select>
                <?php 
                    $consulta="SELECT * FROM estatus";
                    $datos=mysqli_query($conexion,$consulta);
                 ?>
                <select style="width:10%"  id="cb_estatus_tecnico" class="input_reporte">
                    <option value="">ESTATUS TECNICO</option>
                    <?php 
                        while($fila=mysqli_fetch_array($datos))
                        echo '<option value="'.$fila['id_estatus'].'">'.$fila['estatus'].'</option>';
                     ?>
                </select>
                <select style="width:10%"  id="cb_estatus_pago" class="input_reporte">
                    <option value="">ESTATUS PAGO</option>
                    <option value="SI">Si</option>
                    <option value="NO">No</option>
                </select>
                <select style="width:10%"  id="cb_tipo_servicio" class="input_reporte">
                    <option value="">TIPO DE SERVICIO</option>
                    <option value="SERVICIO A DOMICILIO"> A Domicilio</option>
                    <option value="SERVICIO REMOTO">Remoto</option>
                </select>
                <?php 
                    $consulta="SELECT * FROM locacion";
                    $datos=mysqli_query($conexion,$consulta);
                 ?>
                <select style="width:9%"  id="cb_locacion" class="input_reporte">
                    <option value="">LOCACION</option>
                    <?php 
                    while($fila=mysqli_fetch_array($datos))
                    {
                        echo "<option  value='".$fila['locacion']."'>".$fila['locacion']."</option>";
                    }
                    mysqli_close($conexion);
                    ?>
                 </select>
                <button style="width:10%; background-color:red" class="input_reporte"  onclick="crearReporte();"><span class="glyphicon glyphicon-print"></span>
                    Generar PDF
                </button>
                <button style="width:10%; background-color:green" class="input_reporte"  onclick="crearExcel();"><span class="glyphicon glyphicon-print"></span>
                    Generar Excel
                </button>
            </div>
        
    
    <br>

     <div id="contenedor_servicios_admin"></div>
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
<?php include "modal-ver-encuesta.php" ?> 
<?php include "footer.katze" ?>