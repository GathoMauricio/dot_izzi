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
                    <li><a href="bitacora.php"><span class="glyphicon glyphicon-tasks"></span> Bitácora</a></li>
                    <li><a href="pendientes_admin.php"><span class="glyphicon glyphicon-tasks"></span> Pendientes</a></li>
                    <li><a href="empleados.php"><span class="glyphicon glyphicon-user"></span> Empleados</a></li>
                    <li><a href="nuevo_empleado.php"><span class="glyphicon glyphicon-plus"></span>Nuevo empleado</a></li>
                    <li><a id="li_video" onclick="abrirVideo();"><span class="glyphicon glyphicon-film"></span> Video</a></li>
                    <li><a href="../control/cerrar_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión </a></li>
                </ul>
             </div>
        </nav>
     <!--End Barra de Navegacion-->
     <h3>Empleados</h3>
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
        <td><label for="nombre">Nombre</label> </td><td>
        <input type="text" class="form-control" id="nombre_empleado" placeholder="Ingrese el nombre del empleado."></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarEmpleado();"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
        </tr>
        
     </table>
    </div>
    <br>
     <div id="contenedor_empleados"></div>


<div class="modal fade" id="modal-img">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Seleccione la imagen de perfil.</h4>
      </div>
      <div class="modal-body">
        <form class="form-inline" enctype="multipart/form-data" method="post" action="../control/actualizar_imagen.php">
            <input type="text" name="id" id="txtimagen" hidden>
            <div class="form-group">
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
            <input type="file" name="imagen" class="form-control" required>
            <input type="submit" class="form-control" value="Actualizar foto de perfil">
            </div>
        </form>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php include "footer.katze" ?>