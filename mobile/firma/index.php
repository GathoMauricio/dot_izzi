﻿﻿<?php header('Access-Control-Allow-Origin: *'); ?> 
<!DOCTYE html>
<html>
<head>
	<title>Touch Paint</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<link rel="shortcut icon" href="favicon.ico" />
	<!-- iPhone & Android 2.2+ -->
	<link rel="apple-touch-icon" href="icons/RnCIcon57x57.png">
	<!- - iPhone 4 retina display -->
	<link rel="apple-touch-icon" sizes="114x114" href="icons/RnCIcon114x114.png">
	<!-- iPad & iPad 2 -->
	<link rel="apple-touch-icon" sizes="72x72" href="icons/RnCIcon72x72.png" />
	<!-- iPad retina display -->
	<link rel="apple-touch-icon" sizes="144x144" href="icons/RnCIcon144x144.png" />
	<!-- iPhone -->
	<link rel="apple-touch-startup-image" media="(device-width: 320px)" href="icons/RnCSplash320x460.png">
	<!-- iPhone (Retina) -->
	<link rel="apple-touch-startup-image"
	      media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)"
	      href="icons/RnCSplash640x920.png">
	<link href="content/jquery.mobile-1.1.1.min.css" rel="stylesheet" type="text/css" />
	<link href="content/style.css" rel="stylesheet" type="text/css" />
	<link href="alert/sweetalert.css" rel="stylesheet" type="text/css" />
	<script src="scripts/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="alert/sweetalert.min.js" type="text/javascript"></script>
	<script src="scripts/jquery.mobile-1.1.1.min.js" type="text/javascript"></script>
</head>
<body>
	
	<div id="page1" data-role="page" data-rnc-jspage="paintPage">
		<section id="content" data-role="content">
			<!-- the size of the canvas will be dynamically changed -->
			<canvas id="flexBox" width="100" height="100"></canvas>
			<table style="width:100%">
		<tr>
			<td><button onclick="guardar();">Guardar</button></td>
			<td><button onclick="cancelar();">Cancelar</button></td>
		</tr>
	</table>
		</section>
	</div>
	<script type="text/javascript">
		
		function cancelar(){
			window.close();
		}
		function guardar()
		{
			swal({
				html:true,
				title:'¿Guardar firma?',
				text:'<img src="" id="img_firma" width="30%">',
				showCancelButton: true
			},function(){
				var expediente='<?php echo $_GET["exp"]; ?>';
				$.post("img_firmas/crear_firma.php",{
					imagen:document.getElementById('img_firma').src,
					expediente:expediente
				},function(data){
					alert("La firma se almacenó con éxito "+data);
					window.close();
				});
			});
			var datos = document.getElementById('flexBox').toDataURL();
			document.getElementById('img_firma').src=datos;
		}
	</script>
	<script src="scripts/app.js" type="text/javascript"></script>
	<script src="scripts/paintPage.js" type="text/javascript"></script>
</body>
</html>
