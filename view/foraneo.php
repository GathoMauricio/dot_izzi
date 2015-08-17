<?php session_start() ?>
<?php if(!isset($_SESSION['login'])){ header("Location: ../index.php"); } ?>
<?php 
date_default_timezone_set("Mexico/General");
switch ($_SESSION['rol']) {
	case 1:
		header("Location: admin.php");
		break;
    case 2:
        header("Location: gerente.php");
        break;
	case 3:
		header("Location: tecnico.php");
		break;
    case 4:
        header("Location: ike.php");
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
                    
                    <li><a href="ike.php"><span class="glyphicon glyphicon-tasks"></span> Estatus de servicios</a></li>
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
        <td><label for="expediente">Fecha</label> </td><td><input type="date" class="form-control" id="fecha_foraneo"></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarFecha('foraneo');"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
        </tr>
        <tr>
        <td><label for="expediente">N° Expediente</label></td><td><input type="text" class="form-control" id="expediente_foraneo" onkeypress="soloNumeros();" maxlength="10" placeholder="N° de Expediente"></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarExpediente('foraneo');"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
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
                $consulta="SELECT * FROM empleado e LEFT JOIN usuario u ON e.id_usuario=u.id_usuario WHERE u.id_rol=3 AND e.localidad != 'DF'";
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
                    $consulta="SELECT * FROM locacion WHERE locacion != 'DF'";
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
                <button style="width:10%" class="input_reporte"  onclick="crearReporte();"><span class="glyphicon glyphicon-print"></span>
                    Generar
                </button>
            </div>

    <br>
     <div id="contenedor_servicios_foraneo"></div>
<?php include "footer.katze" ?>