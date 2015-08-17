
<?php include "fpdf/fpdf.php"; 
$nombre_archivo=$_GET['expediente']."_izzi.pdf";
?>
<?php 

class generarpdf extends FPDF{
		
		function Header(){
		
 		include "conexion.php";
		$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
		mysqli_set_charset($conexion, "utf8");
		$consulta="SELECT * FROM expediente 
		LEFT JOIN empleado ON expediente.id_tecnico=empleado.id_empleado 
		LEFT JOIN estatus ON expediente.id_estatus=estatus.id_estatus 
		WHERE id_expediente=".$_GET['expediente'];

		$datos=mysqli_query($conexion,$consulta);

		while($fila=mysqli_fetch_array($datos))
		{
			$expediente=$fila['id_expediente'];
			$usuario = utf8_decode($fila['usuario']);
			$problema = utf8_decode($fila['d_problema']);
			$tecnico = utf8_decode($fila['apaterno']." ".$fila['amaterno']." ".$fila['nombre']);
			$direccion=utf8_decode($fila['direccion_u']);
			$solucion=utf8_decode($fila['d_solucion']);
		}

 		$this->Image("../img/izzi_logo.png",1,20,60);

 		$this->SetFont("Arial","B",10);
 		$this->Cell(80);
 		$this->SetTextColor(0,0,0);
 		$this->SetFillColor(255,255,255);
 		$this->Cell(80,10,"ORDEN DE SERVICIO:  ".$expediente,0,0,"C",true);
 		$this->Ln(10);

 		$this->SetFont("Arial","B",10);
 		$this->Cell(80);
 		$this->SetTextColor(0,0,0);
 		$this->SetFillColor(255,255,255);
 		$this->Cell(80,5,"CONTRATO: ",0,0,"C",true);
 		$this->Ln(10);
 		//10 width position
 		// heigth position
 		//180 length
 		$this->Image("../img/izzi_bar.png",1,40,200);
 		//bajar linea
 		$this->Ln(15);
 		//color de fondo de celda
 		$this->SetFillColor(155,141,158);

 		$this->Cell(180,3,"Datos Cliente",0,0,"C",true);
 		$this->Ln(12);

 		$this->SetFillColor(255,255,255);

 		$this->Cell(120,2,"Nombre:  ".$usuario,0,0,"L",true);
 		$this->Cell(140,2,"Email: ",0,0,"L",true);
 		$this->Ln(12);

 		$this->Cell(30,2,"Razon social:",0,0,"C",true);
 		$this->Cell(170,2,"Tel. Oficina: ",0,0,"C",true);
 		$this->Ln(12);

 		$this->Cell(30,2,"Telefono Casa:",0,0,"C",true);
 		$this->Cell(175,2,"Celular: ",0,0,"C",true);
 		$this->Ln(12);

 		//$this->Cell(30,2,"Direccion: ".$direccion,0,0,"L",true);
 		$this->MultiCell(190,6,utf8_decode("Dirección: ".$direccion),0,1,'L',0);
 		$this->Ln(12);

 		$this->SetFillColor(155,141,158);

 		$this->Cell(180,3,"Datos Orden de Servicio",0,0,"C",true);
 		$this->Ln(5);
		$this->SetFillColor(255,255,255);

 		//$this->Cell(100,3,"Reporte: ".$problema,0,0,"C",true);
 		$this->MultiCell(190,6,utf8_decode("Reporte: ".$problema),0,1,'L',0);
 		$this->Ln(5);

 		$this->SetFillColor(155,141,158);

 		$this->Cell(180,3,"",0,0,"C",true);
 		$this->Ln(5);
		$this->SetFillColor(255,255,255);
 		
 		$this->Cell(30,2,"Equipo: ",0,0,"C",true);
 		$this->Cell(160,2,"No de Orden: ".$expediente,0,0,"C",true);
 		$this->Ln(5);

 		$this->Cell(230,2,"Tecnico: ".$tecnico,0,0,"C",true);
 		$this->Ln(5);

 		$this->Cell(230,2,"Status: ",0,0,"C",true);
 		$this->Ln(5);
 		$this->Cell(220,2,"Fecha de alta: ",0,0,"C",true);
 		$this->Ln(5);

 		$this->Cell(30,2,"Marca: ",0,0,"C",true);
 		$this->Cell(145,2,"Fecha de diagnostico: ",0,0,"C",true);
 		$this->Ln(5);

 		$this->Cell(35,2,"RT: ",0,0,"C",true);
 		$this->Cell(145,2,"Fecha estimada: ",0,0,"C",true);
 		$this->Ln(12);

 		$this->Cell(30,2,"Modelo: ",0,0,"C",true);
 		$this->Cell(150,2,"Fecha de entrega: ",0,0,"C",true);
 		$this->Ln(12);

 		$this->Cell(35,2,"Serie: ",0,0,"C",true);
 		$this->Cell(150,2,"Quien recive: ",0,0,"C",true);
 		$this->Ln(12);


 		$this->Cell(30,2,"Accesorios: ",0,0,"C",true);
 		$this->Cell(155,2,"Quien entrega: ",0,0,"C",true);
 		$this->Ln(12);

 		$this->Cell(30,2,"Observaciones: ",0,0,"C",true);
 		$this->Cell(155,2,"Quien recolecta: ",0,0,"C",true);
 		$this->Ln(12);

 		$this->SetFillColor(155,141,158);

 		$this->Cell(180,3,"Presupuesto",0,0,"C",true);
 		$this->Ln(12);

 		$this->SetFillColor(155,141,158);

 		$this->Cell(180,3,"Notas y comentarios",0,0,"C",true);
 		$this->Ln(5);

 		$this->SetFillColor(255,255,255);
 		//$this->Cell(30,2,$solucion,0,0,"L",true);
 		$this->MultiCell(190,6,utf8_decode($solucion),0,1,'L',0);
 		$this->Ln(20);

 		

 	}
 	function Footer(){
 		$this->SetFillColor(255,255,255);
 		$this->SetFont("Arial","B",5);
 		$this->MultiCell(190,-5,utf8_decode("QUALQUIER DUDA FAVOR DE LLAMAR A izzi 01 800 120 5000. LA FIRMA DEL PRESENTE DOCUMENTO ES EL RECONOCIMIENTO DE QUE EL SERVICIO SE REALIZO A SU ENTERA SATISFACCION Y CONFORMIDAD"),0,1,'L',0);
 		
 	}
 }


 $pdf=new generarpdf();
 $pdf->OutPut($nombre_archivo,"I");

 ?>