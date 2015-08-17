<?php session_start() ?>
<?php include "../control/conexion.php" ?>
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
                    <li><a href="pendientes_admin.php"><span class="glyphicon glyphicon-tasks"></span> Pendientes</a></li>
                    <li><a href="empleados.php"><span class="glyphicon glyphicon-user"></span> Empleados</a></li>
                    <li><a href="nuevo_empleado.php"><span class="glyphicon glyphicon-plus"></span>Nuevo empleado</a></li>
                    <li><a id="li_video" onclick="abrirVideo();"><span class="glyphicon glyphicon-film"></span> Video</a></li>
                    <li><a href="../control/cerrar_sesion.php"><span class="glyphicon glyphicon-log-out"></span> Cerrar Sesión </a></li>
                </ul>
             </div>
        </nav>
     <!--End Barra de Navegacion-->
     <h3>Editar empleado</h3>
     <center>
    <img src="../img/logo.png" id="logo_dot">
    </center>
     <center>
     <p ><label><span class="glyphicon glyphicon-calendar"></span> <?php echo " ".date('Y-m-d'); ?><br><span class="glyphicon glyphicon-user"></span><?php echo " ". $_SESSION['login'] ?></label></p>
     </center>
     <br><br><br>
     <div class="publicacion">
     <?php 
     $id_empleado=$_GET['id'];
     $nombre="";
     $apaterno="";
     $amaterno="";
     $telefono="";
     $email="";
     $direccion="";
     $disponibilidad=0;
     $rol=0;

     $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
     mysqli_set_charset($conexion, "utf8");
     $consulta="SELECT * FROM empleado e 
     LEFT JOIN usuario u ON e.id_usuario=u.id_usuario 
     LEFT JOIN rol r ON u.id_rol=r.id_rol 
     WHERE id_empleado=".$id_empleado;
    $datos=mysqli_query($conexion,$consulta);
    while($fila=mysqli_fetch_array($datos))
    {
         $nombre=$fila['nombre'];
         $apaterno=$fila['apaterno'];
         $amaterno=$fila['amaterno'];
         $telefono=$fila['telefono'];
         $email=$fila['email'];
         $direccion=$fila['direccion'];
         $disponibilidad=$fila['disponibilidad'];
         $localidad=$fila['localidad'];
         $rol=$fila['id_rol'];
    }
      ?>
     <form class="form-horizontal" method="POST" action="../control/actualizar_empleado.php">

        <div class="form-group">
            <label for="expediente" class="col-sm-2 control-label">N°. de Empleado: <span class="glyphicon glyphicon-barcode" ></span></label>
            <div class="col-sm-4">
                <input type="text" value="<?php echo $_GET['id'] ?>" class="form-control" id="empleado" name="empleado" readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="nombre" class="col-sm-2 control-label">Nombre: </label>
            <div class="col-sm-4">
                <input type="text" value="<?php echo $nombre; ?>" class="form-control" id="nombre" placeholder="Nombre..."  name="nombre" required>
            </div>
        </div>

        <div class="form-group">
            <label for="apaterno" class="col-sm-2 control-label">Apellido paterno: </label>
            <div class="col-sm-4">
                <input type="text" value="<?php echo $apaterno; ?>" class="form-control" id="apaterno" placeholder="Apellido Paterno"  name="apaterno" required>
            </div>
        </div>

        <div class="form-group">
            <label for="amaterno" class="col-sm-2 control-label">Apellido materno: </label>
            <div class="col-sm-4">
                <input type="text" value="<?php echo $amaterno; ?>" class="form-control" id="amaterno" placeholder="Apellido Materno..."  name="amaterno" required>
            </div>
        </div>
        <div class="form-group">
             <label for="rol" class="col-sm-2 control-label">Rol: <span class="glyphicon glyphicon-cog"></span></label>
             <div class="col-sm-4">
                 <select id="rol" name="rol" class="form-control">
                    <?php 
                    include "../control/conexion.php";
                    $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
                    mysqli_set_charset($conexion, "utf8");
                    $consulta="SELECT * FROM rol";
                    $datos=mysqli_query($conexion,$consulta);
                    
                    while($fila=mysqli_fetch_array($datos))
                    {
                        if($rol==$fila['id_rol'])
                        {
                            echo "<option  value='".$fila['id_rol']."' selected>".$fila['tipo']."</option>";
                        }else
                        {
                           echo "<option  value='".$fila['id_rol']."'>".$fila['tipo']."</option>"; 
                        }
                        
                    }
                    mysqli_close($conexion);
                    ?>
                 </select>
             </div>
         </div>
        <div class="form-group">
             <label for="locacion" class="col-sm-2 control-label">Locacion: <span class="glyphicon glyphicon-globe"></span></label>
             <div class="col-sm-4">
                 <select id="locacion" name="locacion" class="form-control">
                    <?php 
                    include "../control/conexion.php";
                    $conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
                    mysqli_set_charset($conexion, "utf8");
                    $consulta="SELECT * FROM locacion";
                    $datos=mysqli_query($conexion,$consulta);
                    
                    while($fila=mysqli_fetch_array($datos))
                    {
                        if($localidad==$fila['locacion'])
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
            <label for="telefono" class="col-sm-2 control-label">Teléfono: <span class="glyphicon glyphicon-phone"></span></label>
            <div class="col-sm-8">
                <input type="text" value="<?php echo $telefono; ?>" class="form-control" id="teléfono" placeholder="Telefono..."  name="telefono" onkeypress="soloNumeros();" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail: <span class="glyphicon glyphicon-envelope"></span></label>
            <div class="col-sm-8">
                <input type="email" value="<?php echo $email; ?>" class="form-control" id="email" placeholder="Email..."  name="email" required>
            </div>
        </div>

        <div class="form-group">
            <label for="direccion" class="col-sm-2 control-label">Dirección: <span class="glyphicon glyphicon-globe"></span></label>
            <div class="col-sm-8">
                <textarea class="form-control" id="direccion" placeholder="Dirección..."  name="direccion" required><?php echo $direccion; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="disponibilidad" class="col-sm-2 control-label">Disponibilidad: </label>
            <?php if($disponibilidad<2){
                echo'
                <input type="radio" name="disponibilidad" value="1" checked> Tiempo completo 
                <input type="radio" name="disponibilidad" value="2"> Fin de semana 
                ';
            } else{
                echo'
                <input type="radio" name="disponibilidad" value="1" > Tiempo completo 
                <input type="radio" name="disponibilidad" value="2" checked> Fin de semana 
                ';
            }
            ?>
            
        </div>
        <div style="float:right;padding:20px">
            <input type="submit" value="Actualizar empleado" class="btn btn-primary" >
            
        </div>
        
        <br><br><br>

    </form>    

    </div>
    <br>
     
<?php include "footer.katze" ?>