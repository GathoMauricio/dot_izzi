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
	case 3:
		header("Location: tecnico.php");
		break;
}
 ?>
