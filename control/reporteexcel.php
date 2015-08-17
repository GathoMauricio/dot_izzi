<?php
    $conexion = new mysqli('localhost','root','','dot',3306);
    mysqli_set_charset($conexion, "utf8");
	if (mysqli_connect_errno()) {
    	printf("La conexión con el servidor de base de datos falló: %s\n", mysqli_connect_error());
    	exit();
	}

	//____________________________AREA DE LA CONSULTA______________________________________________


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






	//_____________________________________________________________________________________________
	//$consulta = "SELECT nombre AS empleado,telefono,email FROM empleado ";
	$resultado = $conexion->query($consulta);
	if($resultado->num_rows > 0 ){
						
		date_default_timezone_set('America/Mexico_City');

		if (PHP_SAPI == 'cli')
			die('Este archivo solo se puede ver desde un navegador web');

		/** Se agrega la libreria PHPExcel */
		require_once 'lib/PHPExcel/PHPExcel.php';

		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Katze Systems") //Autor
							 ->setLastModifiedBy("Katze Systems") //Ultimo usuario que lo modificó
							 ->setTitle("Reporte Excel")
							 ->setSubject("Reporte")
							 ->setDescription("Reporte de servicios")
							 ->setKeywords("reporte servicios izzi")
							 ->setCategory("Reporte excel");

	
		$titulosColumnas = array('FECHA', 'EXPEDIENTE', 'CAPTURO','TECNICO','ESTATUS IKE','ESTATUS TECNICO','ESTATUS DE PAGO','LOCACION');
		
						
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',  $titulosColumnas[0])
		            ->setCellValue('B1',  $titulosColumnas[1])
        		    ->setCellValue('C1',  $titulosColumnas[2])
        		    ->setCellValue('D1',  $titulosColumnas[3])
        		    ->setCellValue('E1',  $titulosColumnas[4])
        		    ->setCellValue('F1',  $titulosColumnas[5])
        		    ->setCellValue('G1',  $titulosColumnas[6])
        		    ->setCellValue('H1',  $titulosColumnas[7]);
		
		//Se agregan los datos de los alumnos
		$i = 2;
		while ($fila = $resultado->fetch_array()) {
			$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  $fila['fecha'])
		            ->setCellValue('B'.$i,  $fila['id_expediente'])
        		    ->setCellValue('C'.$i,  $fila['capturista'])
        		    ->setCellValue('D'.$i,  $fila['nombre']." ".$fila['apaterno']." ".$fila['amaterno'])
        		    ->setCellValue('E'.$i,  $fila['esi'])
        		    ->setCellValue('F'.$i,  $fila['estatus'])
        		    ->setCellValue('G'.$i,  $fila['pagado'])
        		    ->setCellValue('H'.$i,  $fila['locacion']);
					$i++;
		}
		
		

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Reporte_izzi_'.date('Y-m-d').'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
		
	}
	else{
		echo $consulta;
		print_r('No hay resultados para mostrar');
	}
?>