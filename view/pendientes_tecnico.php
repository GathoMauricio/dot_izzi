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

     <!--BUSCADOR AQUI-->

<div id="contenedor_pendiente_tecnico"></div>

<?php include "footer.katze" ?>