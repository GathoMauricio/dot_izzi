<?php include "fpdf/fpdf.php"; ?>
<?php include "conexion.php" ?>
<?php 
class reporte extends FPDF{
	//private $datos=null;
	function Header(){
		
		

		$this->Image("../img/logo_dot.jpg",10,10,30);

 		$this->SetFont("Arial","B",16);
 		$this->Cell(100);
 		$this->SetTextColor(0,0,0);
 		$this->SetFillColor(255,255,255);
 		$this->Cell(80,20,"REPORTE",0,0,"L",true);
 		$this->Ln(20);
 		$this->SetFont("Arial","B",10);
 		$this->Cell(90);
 		$this->Cell(80,5,"DEL ".$_GET['fecha_inicio']." AL ".$_GET['fecha_final'],0,0,"L",true);
 		$this->Ln(20);

 		$this->SetTextColor(255,255,255);
 		$this->SetFillColor(0,0,0);
 		$this->SetFont("Arial","B",8);
 		$this->SetFont('');
 		$this->Cell(1);
 		$this->Cell(20,5,"FECHA",0,0,"C",true);
 		$this->Cell(1);
 		$this->Cell(20,5,"EXPEDIENTE",0,0,"C",true);
 		$this->Cell(1);
 		$this->Cell(30,5,"CAPTURO",0,0,"C",true);
 		$this->Cell(1);
 		$this->Cell(30,5,"TECNICO",0,0,"C",true);
 		$this->Cell(1);
 		if($_GET['eike']!=1)
 		{
 			$this->Cell(30,5,"ESTATUS IKE",0,0,"C",true);
 			$this->Cell(1);
 		}
 		$this->Cell(30,5,"ESTATUS TECNICO",0,0,"C",true);
 		$this->Cell(1);
 		$this->Cell(30,5,"ESTATUS DE PAGO",0,0,"C",true);
 		$this->Cell(1);
 		$this->Cell(30,5,"LOCACION",0,0,"C",true);
 		$this->Cell(1);
 		$this->Ln(5);
 		

	}
	
	function Footer(){
	// Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print centered page number
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
 		
 	}
}
 		$conexion=mysqli_connect($host_bd,$usuario_bd,$contrasena_bd,$base_datos);
		mysqli_set_charset($conexion, "utf8");
		/*$consulta="SELECT exp.fecha,
		exp.id_expediente,
		exp.capturista,
		emp.nombre,
		emp.apaterno,
		emp.amaterno,
		es.estatus ,
		esi.estatus as esi,
		exp.pagado
		FROM expediente exp
		LEFT JOIN estatus es
		ON exp.id_estatus=es.id_estatus
		LEFT JOIN estatus_ike esi
		ON exp.id_estatus_ike=esi.id_estatus_ike
		LEFT JOIN empleado emp
		ON
		exp.id_tecnico=emp.id_empleado
		WHERE exp.fecha >= '".$_GET['fecha_inicio']."' AND exp.fecha <= '".$_GET['fecha_final']."' 
		ORDER BY fecha";*/
		$locacionConsulta="AND exp.locacion LIKE '%".$_GET['locacion']."%' " ;
		if($_GET['eike']==1 )
		{
			
			$locacionConsulta="AND exp.locacion LIKE '%".$_GET['locacion']."%' AND exp.locacion != 'DF' ";
		}
		$consulta="SELECT exp.fecha,
		exp.id_expediente,
		exp.capturista,
		exp.locacion,
		emp.nombre,
		emp.apaterno,
		emp.amaterno,
		es.estatus ,
		esi.estatus as esi,
		exp.pagado
		FROM expediente exp
		LEFT JOIN estatus es
		ON exp.id_estatus=es.id_estatus
		LEFT JOIN estatus_ike esi
		ON exp.id_estatus_ike=esi.id_estatus_ike
		LEFT JOIN empleado emp
		ON
		exp.id_tecnico=emp.id_empleado
		WHERE exp.fecha >= '".$_GET['fecha_inicio']."' AND exp.fecha <= '".$_GET['fecha_final']."'
		AND exp.id_tecnico LIKE '%".$_GET['tecnico']."%' 
		AND exp.capturista LIKE '%".$_GET['capturo']."%' 
		AND exp.id_estatus_ike LIKE '%".$_GET['eike']."%' 
		AND exp.id_estatus LIKE '%".$_GET['etecnico']."%' 
		AND exp.pagado LIKE '%".$_GET['epago']."%' 
		AND exp.tipo LIKE '%".$_GET['tipo']."%' 
		".$locacionConsulta."
		ORDER BY fecha";
		$datos=mysqli_query($conexion,$consulta);

		$reporte=new reporte('L','mm','Letter');
		$reporte->addPage();
		$reporte->SetTextColor(0,0,0);
 		$reporte->SetFillColor(255,255,255);
 		while($fila=mysqli_fetch_array($datos)) { 
 			$reporte->Cell(1);
 			$reporte->Cell(10,5,$fila['fecha'],0,0,"L",true);
 			$reporte->Cell(10);
 			$reporte->Cell(10,5,$fila['id_expediente'],0,0,"L",true);
 			$reporte->Cell(11);
 			$reporte->Cell(30,5,utf8_decode($fila['capturista']),0,0,"L",true);
 			$reporte->Cell(2);
 			$reporte->Cell(30,5,utf8_decode($fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno']),0,0,"L",true);
 			$reporte->Cell(2);
 			if($_GET['eike']!=1){
 			$reporte->Cell(30,5,$fila['esi'],0,0,"C",true);
 			$reporte->Cell(2);	
 			}
			$reporte->Cell(30,5,$fila['estatus'],0,0,"C",true);
 			$reporte->Cell(2);
 			$reporte->Cell(30,5,$fila['pagado'],0,0,"C",true);
 			$reporte->Cell(2);
 			$reporte->Cell(30,5,$fila['locacion'],0,0,"C",true);
 			$reporte->Cell(2);
 			$reporte->Ln(5);
 		}

 $reporte->OutPut();
 ?>