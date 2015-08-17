<?php session_start() ?>
<?php if(!isset($_SESSION['login'])){ header("Location: ../index.php"); } ?>
<?php 
switch ($_SESSION['rol']) {
	case 1:
		header("Location: admin.php");
		break;
	case 2:
		header("Location: gerente.php");
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
                    
                    <li><a href="tecnico.php"><span class="glyphicon glyphicon-tasks"></span>Servicios</a></li>
                    <li><a href="pendientes_tecnico.php"><span class="glyphicon glyphicon-tasks"></span>Pendientes</a></li>
                    <li><a id="li_video" onclick="abrirVideo();"><span class="glyphicon glyphicon-film"></span> Video</a></li>
                    <li><a href="../control/cerrar_sesion.php"><span class="glyphicon glyphicon-log-out"></span>Cerrar Sesión </a></li>
                </ul>
             </div>
        </nav>
     <!--End Barra de Navegacion-->

     <h3>SERVICIOS IZZI</h3>
     <center>
    <img src="../img/logo.png" id="logo_dot">
    </center>
     <p style="float: right;padding:20px;"><label id="sesion"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['login'] ?></label></p>
     <br><br><br>

     <div class="publicacion">
        <form>
     <table class="table"> 
        <tr>
        <td><label for="expediente">Fecha</label> </td><td><input type="date" class="form-control" id="fecha_tecnico"></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarFecha('tecnico');"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
        </tr>
        <tr>
        <form>
        <td><label for="expediente">N° Expediente</label></td><td><input type="text" class="form-control" id="expediente_tecnico" onkeypress="soloNumeros();" maxlength="10" placeholder="N° de Expediente" required></td><td><button class="btn btn-default" id="btn_buscar" onclick="buscarExpediente('tecnico');"><span class="glyphicon glyphicon-search"></span> Buscar </button></td>
        </form>
        </tr>
     </table>
 </form>
    </div>
    <br>
    <div id="pendientes"></div>


   


     <div id="contenedor_servicios_tecnico"></div>
     



<?php include "modal_encuesta.php" ?>
<?php include "footer.katze" ?>