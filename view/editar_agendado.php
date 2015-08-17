<?php session_start() ?>
<?php if(!isset($_SESSION['login'])){ header("Location: ../index.php"); } ?>
<?php 
switch ($_SESSION['rol']) {
	
	case 3:
		header("Location: tecnico.php");
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
                	<!--IMAGEN-->
                	
            </div>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
            	<ul class="nav navbar-nav" >
                    <li><a href="ike.php"><span class="glyphicon glyphicon-tasks"></span> Estatus de servicios</a></li>
                    <li><a href="nuevo_servicio_ike.php"><span class="glyphicon glyphicon-plus"></span> Agendar servicio</a></li>
                    <li><a href="agendados.php"><span class="glyphicon glyphicon-list"></span> Servicios agendados</a></li>
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
     <br>
     <h3>Actualización de servicio.</h3>
     <?php if(isset($_GET['act']))
     {
        echo "<p class='bg-success'>El expediente ".$_GET['expediente']." ha sido actualizado.</p>";
     } ?>
     </center>
     <br><br><br>
     <?php include "../control/conexion.php" ?>
     <?php
     $expediente="";
     $tipo="";
     $tecnico="";
     $fecha="";
     $solicitud="";
     $locacion="";
     $costo="";
     $usuario="";
     $direccion="";
     $mapa="";
     $horario1="";
     $horario2="";
     $descripcion="";
     date_default_timezone_set("Mexico/General");
     $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
     mysqli_set_charset($conexion, "utf8");
     $consulta="SELECT * FROM expediente_ike 
    WHERE id_expediente=".$_GET['expediente'];
    $datos=mysqli_query($conexion,$consulta);
    while($fila=mysqli_fetch_array($datos)){
        $expediente=$fila['id_expediente'];
         $tipo=$fila['tipo'];
         $fecha=$fila['fecha'];
         $capturista=$fila['capturista'];
         $solicitud=$fila['solicitud'];
         $locacion=$fila['locacion'];
         $costo=$fila['costo'];
         $usuario=$fila['usuario'];
         $direccion=$fila['direccion_u'];
         $mapa=$fila['mapa'];
         $horario1=$fila['horario1'];
         $horario2=$fila['horario2'];
         $descripcion=$fila['d_problema'];

    }

      ?>
     <form class="form-horizontal" method="POST" action="../control/actualizar_agendado.php">
        
        <div class="form-group">
            <label for="expediente" class="col-sm-2 control-label">N°. de Expediente: <span class="glyphicon glyphicon-barcode" ></span></label>
            <div class="col-sm-4">
                <input type="text" value="<?php echo $_GET['expediente']; ?>" class="form-control" id="expediente" placeholder="N°. de Expediente" onkeypress="soloNumeros();" name="expediente" readonly>
            </div>
        </div>

        <div class="form-group">
             <label for="tipo" class="col-sm-2 control-label">Tipo de servicio: <span class="glyphicon glyphicon-globe"></span></label>
             <div class="col-sm-4">
                 <select id="tipo" name="tipo" class="form-control">
                    <?php 
                    if($tipo=="SERVICIO A DOMICILIO")
                    {
                        echo '<option value="SERVICIO A DOMICILIO" selected>SERVICIO A DOMICILIO</option>';
                    } else
                    {
                        echo '<option value="SERVICIO A DOMICILIO" >SERVICIO A DOMICILIO</option>';
                    }
                    if($tipo=="SERVICIO REMOTO")
                    {
                        echo '<option value="SERVICIO REMOTO" selected>SERVICIO REMOTO</option>';
                    } else
                    {
                        echo '<option value="SERVICIO REMOTO">SERVICIO REMOTO</option>';
                    }

                    ?>
                 </select>
             </div>
         </div>
         <div class="form-group">
             <label for="locacion" class="col-sm-2 control-label">Locacion: <span class="glyphicon glyphicon-globe"></span></label>
             <div class="col-sm-4">
                 <select id="locacion" name="locacion" class="form-control" onchange="cargarTecnicos();" >
                    <?php 
                    include "../control/conexion.php";
                    $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
                    mysqli_set_charset($conexion, "utf8");
                    $consulta="SELECT * FROM locacion";
                    $datos=mysqli_query($conexion,$consulta);
                    
                    while($fila=mysqli_fetch_array($datos))
                    {
                        if($locacion==$fila['locacion'])
                        {
                            echo "<option  value='".$fila['locacion']."' selected>".$fila['locacion']."</option>";
                        }else
                        {
                           echo "<option  value='".$fila['locacion']."'>".$fila['locacion']."</option>"; 
                        }
                        
                    }
                    mysqli_close($conexion);
                    ?>
                 </select>
             </div>
         </div>
         <div class="form-group">
             <label for="fecha" class="col-sm-2 control-label">Fecha: <span class="glyphicon glyphicon-calendar"></span></label>
             <div class="col-sm-4">
                 <input type="date" value="<?php echo $fecha; ?>" class="form-control" id="fecha"  name="fecha" onchange="cargarTecnicos();"  required>
             </div>
         </div>
        <div class="form-group">
            <label for="capturista" class="col-sm-2 control-label">Capturista: <span class="glyphicon glyphicon-pencil"></span></label>
            <div class="col-sm-4" >
                <input class="form-control" value="<?php echo $capturista; ?>" name="capturista" id="capturista" required/>
            </div>
        </div>

        

         <div class="form-group">
             <label for="solucitud" class="col-sm-2 control-label">Solicitud: <span class="glyphicon glyphicon-lock"></span></label>
             <div class="col-sm-4">
                 <input type="text" value="<?php echo $solicitud; ?>" class="form-control" id="solucitud"  name="solicitud" placeholder="¿Quién solicita el servicio?">
             </div>
         </div>

         

         <div class="form-group">
             <label for="costo" class="col-sm-2 control-label">Costo: <span class="glyphicon glyphicon-usd"></span></label>
             <div class="col-sm-8" id="div_costo">
                <?php 
                    if($locacion=="DF")
                    {
                        if($costo==700)
                        {
                            echo'<select class="form-control" id="costo" name="costo"><option value="700" selected>Costo normal $700</option><option value="350">Costo muerto $350</option></select>';
                            
                        }else
                        {
                            echo'<select class="form-control" id="costo" name="costo"><option value="700">Costo normal $700</option><option value="350" selected>Costo muerto $350</option></select>';
                        }
                    }else
                    {
                        if($costo==300)
                        {
                            echo'<select class="form-control" id="costo" name="costo"><option value="300" selected>Costo normal $300</option><option value="150">Costo muerto $150</option></select>';
                            
                        }else
                        {
                            echo'<select class="form-control" id="costo" name="costo"><option value="300">Costo normal $300</option><option value="150" selected>Costo muerto $150</option></select>';
                        }
                    }

                 ?>
             </div>
         </div>

         <div class="form-group">
             <label for="usuario" class="col-sm-2 control-label">Usuario: <span class="glyphicon glyphicon-user"></span></label>
             <div class="col-sm-8">
                 <input type="text" value="<?php echo $usuario; ?>"  class="form-control" id="usuario"  name="usuario" placeholder="Nombre del usuario." required>
             </div>
         </div>


         <div class="form-group">
             <label for="direccion" class="col-sm-2 control-label">Dirección: <span class="glyphicon glyphicon-list-alt"></span></label>
             <div class="col-sm-8">
                 <textarea  class="form-control" id="direccion"  name="direccion" placeholder="Direccion del usuario." required><?php echo $direccion; ?></textarea>
             </div>
         </div>

         <div class="form-group">
             <label for="mapa" class="col-sm-2 control-label">Mapa: <span class="glyphicon glyphicon-map-marker"></span></label>
             <div class="col-sm-8">
                 <input type="text" value='<?php echo $mapa; ?>'  class="form-control" id="mapa"  name="mapa" placeholder="Enlace de google maps." required>
             </div>
         </div>

         <div class="form-group">
             <label for="horario" class="col-sm-2 control-label">Hora de servicio: <span class="glyphicon glyphicon-time"></span></label>
             <div class="col-sm-4">
                <?php 
                    switch($horario1[0].$horario1[1])
                    {
                        case '09':
                        echo'
                        <input type="radio" onclick="cambiarHorario(1)" name="select_horario" checked>Horario 1
                        <input type="radio" onclick="cambiarHorario(2)" name="select_horario">Horario 2
                        <input type="radio" onclick="cambiarHorario(3)" name="select_horario">Horario 3
                        <input type="radio" onclick="cambiarHorario(4)" name="select_horario">Otro
                        ';
                        break;
                        case '12':
                        echo'
                        <input type="radio" onclick="cambiarHorario(1)" name="select_horario" >Horario 1
                        <input type="radio" onclick="cambiarHorario(2)" name="select_horario" checked>Horario 2
                        <input type="radio" onclick="cambiarHorario(3)" name="select_horario">Horario 3
                        <input type="radio" onclick="cambiarHorario(4)" name="select_horario">Otro
                        ';
                        break;
                        case '15':
                        echo'
                        <input type="radio" onclick="cambiarHorario(1)" name="select_horario" >Horario 1
                        <input type="radio" onclick="cambiarHorario(2)" name="select_horario">Horario 2
                        <input type="radio" onclick="cambiarHorario(3)" name="select_horario" checked>Horario 3
                        <input type="radio" onclick="cambiarHorario(4)" name="select_horario">Otro
                        ';
                        break;
                        default:
                        echo'
                        <input type="radio" onclick="cambiarHorario(1)" name="select_horario" >Horario 1
                        <input type="radio" onclick="cambiarHorario(2)" name="select_horario">Horario 2
                        <input type="radio" onclick="cambiarHorario(3)" name="select_horario" >Horario 3
                        <input type="radio" onclick="cambiarHorario(4)" name="select_horario" checked>Otro
                        ';
                        break;

                    }
                 ?>
                

                 <select  class="form-control" id="horario1"  name="horario1" readonly="true"  required>
                    <?php for ($i=9; $i <= 17 ; $i++) {
                    if($horario1[0].$horario1[1]==$i)
                    {
                        echo "<option value='".$i.":00' selected>".$i.":00</option>";
                        echo "<option value='".$i.":30'>".$i.":30</option>";
                    } else
                    {
                        echo "<option value='".$i.":00' >".$i.":00</option>";
                        echo "<option value='".$i.":30'>".$i.":30</option>";
                    }
                      
                    } ?>
                 </select>
                 <label>A</label>
                 <select value="<?php echo $horario2; ?>" class="form-control" id="horario2"  name="horario2" readonly="true" required>
                    <?php for ($i=9; $i <= 17 ; $i++) {
                    if($horario2[0].$horario2[1]==$i)
                    {
                        echo "<option value='".$i.":00' selected>".$i.":00</option>";
                        echo "<option value='".$i.":30'>".$i.":30</option>";
                    } else
                    {
                        echo "<option value='".$i.":00' >".$i.":00</option>";
                        echo "<option value='".$i.":30'>".$i.":30</option>";
                    }
                      
                    } ?>
                 </select>
             </div>
         </div>

         <div class="form-group">
             <label for="problema"  class="col-sm-2 control-label">Descripción del problema: <span class="glyphicon glyphicon-info-sign"></span></label>
             <div class="col-sm-8">
                 <textarea  class="form-control" id="problema"  name="problema" placeholder="Descripcion del problema reportado." required><?php echo $descripcion; ?> </textarea>
             </div>
         </div>
<br><br>
        <input type="submit" value="Actualizar servicio" class="btn btn-primary">


     </form>
<?php include "footer.katze" ?>