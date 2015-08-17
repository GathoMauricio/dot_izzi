<?php session_start() ?>
<?php 
//echo $_SESSION['login']." ".$_SESSION['rol'];
if(!isset($_SESSION['login'])){ header("Location: ../index.php"); } ?>
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
     <?php 
        if(isset($_GET['r']))
        {
            echo'<p class="bg-success">'.$_GET['r'].'</p>';
        }
      ?>
     </center>
     <br><br><br>
     <div class="publicacion">
     <table class="table"> 
        <tr>
        <td><label for="expediente">Fecha</label> </td><td><input type="date" class="form-control" id="fecha_ike"></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarFecha('ike');"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
        </tr>
        <tr>
        <td><label for="expediente">N° Expediente</label></td><td><input type="text" class="form-control" id="expediente_ike" onkeypress="soloNumeros();" maxlength="10" placeholder="N° de Expediente"></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarExpediente('ike');"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
        </tr>
     </table>
    </div>
    <br>
     <div class="publicacion">

        <form class="form-horizontal" method="POST" action="../control/insertar_servicio_ike.php">
        
        <div class="form-group">
            <label for="expediente" class="col-sm-2 control-label">N°. de Expediente: <span class="glyphicon glyphicon-barcode"></span></label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="expediente" placeholder="N°. de Expediente" onkeypress="soloNumeros();" name="expediente" required>
            </div>
        </div>

        <div class="form-group">
             <label for="tipo" class="col-sm-2 control-label">Tipo de servicio: <span class="glyphicon glyphicon-globe"></span></label>
             <div class="col-sm-4">
                 <select id="tipo" name="tipo" class="form-control">
                    <option value="SERVICIO A DOMICILIO">SERVICIO A DOMICILIO</option>
                    <option value="SERVICIO REMOTO">SERVICIO REMOTO</option>
                 </select>
             </div>
         </div>

         <div class="form-group">
             <label for="locacion" class="col-sm-2 control-label">Locacion: <span class="glyphicon glyphicon-globe"></span></label>
             <div class="col-sm-4">
                 <select id="locacion" name="locacion" class="form-control" onchange="cargarTecnicos();" required>
                    <?php 
                    include "../control/conexion.php";
                    $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
                    mysqli_set_charset($conexion, "utf8");
                    $consulta="SELECT * FROM locacion";
                    $datos=mysqli_query($conexion,$consulta);
                    
                    while($fila=mysqli_fetch_array($datos))
                    {
                        echo "<option  value='".$fila['locacion']."'>".$fila['locacion']."</option>";
                    }
                    mysqli_close($conexion);
                    ?>
                 </select>
             </div>
         </div>
         <div class="form-group">
             <label for="fecha" class="col-sm-2 control-label">Fecha: <span class="glyphicon glyphicon-calendar"></span></label>
             <div class="col-sm-4">
                 <input type="date" class="form-control" id="fecha"  name="fecha"  onchange="cargarTecnicos();" required>
             </div>
         </div>
        <div class="form-group">
            <label for="capturista" class="col-sm-2 control-label">Capturista: <span class="glyphicon glyphicon-pencil"></span></label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="capturista" id="capturista" placeholder="Escribe tu nombre en esta parte..." required/>
            </div>
        </div>

        

         <div class="form-group">
             <label for="solucitud" class="col-sm-2 control-label">Solicitud: <span class="glyphicon glyphicon-lock"></span></label>
             <div class="col-sm-4">
                 <input type="text" class="form-control" id="solucitud"  name="solicitud" placeholder="¿Quién solicita el servicio?">
             </div>
         </div>

         

         <div class="form-group">
             <label for="costo" class="col-sm-2 control-label">Costo: <span class="glyphicon glyphicon-usd"></span></label>
             <div class="col-sm-4" id="div_costo">
                 <select class="form-control" id="costo" name="costo">
                    <option value="700">Costo normal $700</option>
                    <option value="350">Costo muerto $350</option>
                 </select>
             </div>
         </div>

         <div class="form-group">
             <label for="usuario" class="col-sm-2 control-label">Usuario: <span class="glyphicon glyphicon-user"></span></label>
             <div class="col-sm-8">
                 <input type="text" class="form-control" id="usuario"  name="usuario" placeholder="Nombre del usuario." required>
             </div>
         </div>

         <!--<div class="form-group">
             <label for="telefono" class="col-sm-2 control-label">Teléfono: <span class="glyphicon glyphicon-phone-alt"></span></label>
             <div class="col-sm-8">
                 <input type="text" class="form-control" id="telefono"  name="telefono" placeholder="Teléfono del usuario." onkeypress="soloNumeros();">
             </div>
         </div>-->

         <div class="form-group">
             <label for="direccion" class="col-sm-2 control-label">Dirección: <span class="glyphicon glyphicon-list-alt"></span></label>
             <div class="col-sm-8">
                 <textarea  class="form-control" id="direccion"  name="direccion" placeholder="Direccion del usuario." required></textarea>
             </div>
         </div>

         <div class="form-group">
             <label for="mapa" class="col-sm-2 control-label">Mapa: <span class="glyphicon glyphicon-map-marker"></span></label>
             <div class="col-sm-8">
                 <input type="text" class="form-control" id="mapa"  name="mapa" placeholder="Enlace de google maps." required>
             </div>
         </div>

         <div class="form-group">
             <label for="horario" class="col-sm-2 control-label">Hora de servicio: <span class="glyphicon glyphicon-time"></span></label>
             <div class="col-sm-4">
                <input type="radio" onclick="cambiarHorario(1)" name="select_horario" checked>Horario 1
                <input type="radio" onclick="cambiarHorario(2)" name="select_horario">Horario 2
                <input type="radio" onclick="cambiarHorario(3)" name="select_horario">Horario 3
                <input type="radio" onclick="cambiarHorario(4)" name="select_horario">Otro
                 <select type="text" class="form-control" id="horario1"  name="horario1" readonly="true" onchange="cargarTecnicos();"  required>
                    <?php for ($i=9; $i <= 17 ; $i++) { 
                      echo "<option value='".$i.":00'>".$i.":00</option>";
                       echo "<option value='".$i.":30'>".$i.":30</option>";
                    } ?>
                 </select>
                 <label>A</label>
                 <select type="text" class="form-control" id="horario2"  name="horario2" readonly="true" required>
                    <?php for ($i=9; $i <= 17 ; $i++) { 
                       if($i==10)
                       echo "<option value='".$i.":00' selected>".$i.":00</option>";
                        else
                       echo "<option value='".$i.":00'>".$i.":00</option>";
                       echo "<option value='".$i.":30'>".$i.":30</option>";
                    } ?>
                 </select>
             </div>
         </div>

         <div class="form-group">
             <label for="problema" class="col-sm-2 control-label">Descripción del problema: <span class="glyphicon glyphicon-info-sign"></span></label>
             <div class="col-sm-8">
                 <textarea  class="form-control" id="problema"  name="problema" placeholder="Descripcion del problema reportado." required></textarea>
             </div>
         </div>

 <div style="float:right;padding:20px"><input type="submit" value="Insertar servicio" class="btn btn-primary" ></div>
    <br><br><br>    


     </form>
     </div>
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