<?php date_default_timezone_set("Mexico/General"); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Hilo de validaciín</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="../js/Concurrent.Thread.js"></script>
	<script type="text/javascript" src="../js/jquery.js" charset="utf-8"></script>
	<script type="text/javascript">
		Concurrent.Thread.create(function (){
			while(true){
				$("#reloj").load("get_hora_mail.php");
				var hora=$("#reloj").text();
				//console.log(hora);
				if(hora=="18:00:00")
				{
					validarPendientes();
				}
				Concurrent.Thread.sleep(1000);
			
			}
		});
		function validarPendientes()
		{
			$("#reloj").text("Enviando notificaciones....");
			$.post("validar_caducidad.php",{},function(data){
				
				$("#reloj").text("Hora: <?php echo date('H:i:s'); ?>");
				$("#caducados").html(data);
			});
		}
	</script>
</head>
<body>
<center>
<h1>Hilo de validación de pendientes</h1>
<h4>Este proceso se debe ejecutar todo el tiempo y al dar las 6 PM (18:00:00 Hrs) valida que pendientes han caducado 
</h4>
<h3>Hoy es: <?php 

echo date('Y-d-m'); 
echo "<br>";
?></h3>

<br><br>
<h2 style="color:red">NO CERRAR</h2>
<h2>Son las: <p id="reloj">00:00:00</p> Hrs</h2>

<br><br>

<div id="caducados"></div>
</center>
</body>
</html>