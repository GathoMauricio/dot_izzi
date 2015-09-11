//Variables globales
//var host="ws://localhost:8000/websocket/server.php";
//var socket;


function soloNumeros() {
 if ((event.keyCode < 46) || (event.keyCode > 57)) 
  event.returnValue = false;
}

$(document).ready(init);
function init()
{
	
	$("#contenedor_pendientes_admin").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_pendientes_admin").load("cargar_pendientes_admin.php");

	$("#contenedor_pendiente_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_pendiente_gerente").load("cargar_pendientes_gerente.php");

	$("#contenedor_pendiente_tecnico").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_pendiente_tecnico").load("cargar_pendientes_tecnico.php");

	$("#contenedor_servicios_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_gerente").load("servicios_gerente.php");
	$("#div_notificacion").load("../control/cargar_notificacion.php");

	$("#contenedor_servicios_tecnico").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_tecnico").load("servicios_tecnico.php");
	$("#pendientes").load("cargar_pendientes.php");

	$("#contenedor_servicios_admin").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_admin").load("servicios_admin.php");

	$("#contenedor_empleados").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_empleados").load("cargar_empleados.php");

	$("#contenedor_servicios_ike").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_ike").load("servicios_ike.php");

	$("#contenedor_servicios_foraneo").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_foraneo").load("servicios_foraneo.php");


	$("#contenedor_validar_servicios").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_validar_servicios").load("servicios_validar.php");

	$("#contenedor_servicios_agendados").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_agendados").load("servicios_agendados.php");
	
	var pusher = new Pusher('6f728ab7f8ef55d211e3');
	var canal = pusher.subscribe('canal_notificacion');
	canal.bind('nueva_notificacion',function(data){
			$("#txt_notificacion").text(data.mensaje);
			$("#modal-notificacion").modal();
		});
	
		//cargarTecnicos();
		//cargarTecnicosEdit();
	geolocalizame();
		// itinerancia de geolocalización
		
		Concurrent.Thread.create(function (){
			var minuto=0;
			var second=0;
			while(1){
				second++;
				if(second>=60)
				{
					minuto++;
					second=0;

					if(minuto>=2)
					{
						minuto=0;
						second=0;
						geolocalizame();
						
					}
				}
				console.log(minuto+":"+second);
				Concurrent.Thread.sleep(1000);
			}
		});	
}

function eliminarNotificacion(id)
{
	$.post("../control/eliminar_notificacion.php",{id_notificacion:id},function(data){
		//$("#div_notificacion").html("<img src='../img/load_bar.gif' id='barra'>");
		$.post("../control/cargar_notificacion.php",{},function(data){ $("#div_notificacion").html(data); });
	});
}
function validar()
{
	var usuario = $("#usuario").prop("value");
	var contrasena = $("#contrasena").prop("value");

	$.post("control/validar_usuario.php",
		{usuario:usuario,contrasena:contrasena},
		function(data)
		{ 
			if(data=="true"){ 
				
				
				window.location=("view/ike.php");
			}else{
				$("#form-login").effect("shake"); 
				document.getElementById("usuario").value="";
				document.getElementById("contrasena").value="";
			} 
		});
}
//FUNCION ENVIAR NOTIFICACION
function notificar(expediente)
{
	$.post("../control/get_hora.php",{},function(data){
	var user = $("#sesion").text();
	var notificacion=user+" ha realizado contacto las "+data+" con el expediente: "+expediente;
	$.post("../control/insertar_notificacion.php",{notificacion:notificacion},function(data){
		//socket.send(notificacion);
	});	
});
	
}

function page_agregar_servicio()
{
	window.location="nuevo_servicio.php";
}


function buscarExpediente(tipo)
{

	$("#contenedor_servicios_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_tecnico").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_admin").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_ike").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_foraneo").html("<img src='../img/load_bar.gif' id='barra'>");
	switch(tipo)
	{
		case 'gerente':
			var criterio = $("#expediente_gerente").prop("value");
			$.post("servicios_gerente.php",{criterio:criterio},function(data){
				if(/mysqli_fetch_array()/.test(data))
				{
					$("#contenedor_servicios_gerente").html("<h3>No has ingresado los valores necesarios. <br>Por favor verifica que la información es correcta.</h3>");
				}else{
					$("#contenedor_servicios_gerente").html(data);
				}
			});
		break;
		case 'tecnico':
			var criterio = $("#expediente_tecnico").prop("value");
			$.post("servicios_tecnico.php",{criterio:criterio},function(data){
			if(/mysqli_fetch_array()/.test(data))
				{
					$("#contenedor_servicios_tecnico").html("<h3>No has ingresado los valores necesarios. <br>Por favor verifica que la información es correcta.</h3>");
				}else{
					$("#contenedor_servicios_tecnico").html(data);
				}	
			
			});
		break;
		case 'admin':
			var criterio = $("#expediente_admin").prop("value");
			$.post("servicios_admin.php",{criterio:criterio},function(data){
				if(/mysqli_fetch_array()/.test(data))
				{
					$("#contenedor_servicios_admin").html("<h3>No has ingresado los valores necesarios. <br>Por favor verifica que la información es correcta.</h3>");
				}else{
					$("#contenedor_servicios_admin").html(data);
				}
			
			});
		break;
		case 'ike':
			var criterio = $("#expediente_ike").prop("value");
			$.post("servicios_ike.php",{criterio:criterio},function(data){
			if(/mysqli_fetch_array()/.test(data))
				{
					$("#contenedor_servicios_ike").html("<h3>No has ingresado los valores necesarios. <br>Por favor verifica que la información es correcta.</h3>");
				}else{
					$("#contenedor_servicios_ike").html(data);
				}	
			
			});
		break;
		case 'foraneo':
			var criterio = $("#expediente_foraneo").prop("value");
			$.post("servicios_foraneo.php",{criterio:criterio},function(data){
			if(/mysqli_fetch_array()/.test(data))
				{
					$("#contenedor_servicios_foraneo").html("<h3>No has ingresado los valores necesarios. <br>Por favor verifica que la información es correcta.</h3>");
				}else{
					$("#contenedor_servicios_foraneo").html(data);
				}	
			
			});
		break;
	}	
}
function buscarFecha(tipo)
{
	$("#contenedor_servicios_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_tecnico").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_admin").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_ike").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_foraneo").html("<img src='../img/load_bar.gif' id='barra'>");
	switch(tipo)
	{
		case 'gerente':
			var fecha = $("#fecha_gerente").prop("value");
			$.post("servicios_gerente.php",{fecha:fecha},function(data){
			$("#contenedor_servicios_gerente").html(data);
			});
		break;
		case 'tecnico':
			var fecha = $("#fecha_tecnico").prop("value");
			$.post("servicios_tecnico.php",{fecha:fecha},function(data){
			$("#contenedor_servicios_tecnico").html(data);
			});
		break;
		case 'admin':
			var fecha = $("#fecha_admin").prop("value");
			$.post("servicios_admin.php",{fecha:fecha},function(data){
			$("#contenedor_servicios_admin").html(data);
			});
		break;
		case 'ike':
			var fecha = $("#fecha_ike").prop("value");
			$.post("servicios_ike.php",{fecha:fecha},function(data){
			$("#contenedor_servicios_ike").html(data);
			});
		break;
		case 'foraneo':
			var fecha = $("#fecha_foraneo").prop("value");
			$.post("servicios_foraneo.php",{fecha:fecha},function(data){
			$("#contenedor_servicios_foraneo").html(data);
			});
		break;
	}	
}
function agregarComentario(id_expediente)
{
	var comentario = $("#comentario_"+id_expediente).prop("value");
	$("#contenedor_servicios_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_servicios_tecnico").html("<img src='../img/load_bar.gif' id='barra'>");
	$.post("../control/agregar_comentario.php",{id_expediente:id_expediente,comentario:comentario},function(data){
		var user ="";
		$.post("../control/get_user.php",{},function(data){user=data;
		$.post("../control/enviar_mail.php",{tipo:"Agregado un comentario",expediente:id_expediente,comentario:comentario,user:user},function(data){
			$.post('../control/notificar.php',{tipo:"Agregado un comentario",expediente:id_expediente,comentario:comentario,user:user},function(data){

				$("#txt_notificacion").text(data.mensaje);
				$("#modal-notificacion").modal();
			},'json');

		  });
		});
		
		
		$("#contenedor_servicios_gerente").load("servicios.php");
		$("#contenedor_servicios_tecnico").load("servicios_tecnico.php");
		$("#contenedor_servicios_admin").load("servicios.php");
		$("#contenedor_servicios_ike").load("servicios_ike.php");
		$("#contenedor_servicios_foraneo").load("servicios_foraneo.php");

		window.location = "#pub_"+id_expediente; 
	});
}
function cambiar_estatus(id_expediente,id_estatus)
{
var confirmacion=confirm("¿Realmente desea cambiar el estatus?");
if(confirmacion)
{
	var solucion = $("#txtsolucion_"+id_expediente).prop("value");
	$.post("../control/cambiar_estatus.php",{ expediente:id_expediente,estatus:id_estatus,solucion:solucion},function(data){
		$("#pendientes").load("cargar_pendientes.php");
		$("#contenedor_servicios_gerente").load("servicios.php");
		$("#contenedor_servicios_tecnico").load("servicios_tecnico.php");
		$("#contenedor_servicios_admin").load("servicios_admin.php");
		window.location = "#pub_"+id_expediente; 
	});
	
		switch(id_estatus)
		{
			case 2:
			//notificar(id_expediente);
			var user ="";
			$.post("../control/get_user.php",{},function(data){user=data;
			$.post("../control/enviar_mail.php",{tipo:"Hecho contacto",expediente:id_expediente,user:user},function(data){  });
			});
			$.post('../control/notificar.php',{tipo:"Hecho contacto",expediente:id_expediente,user:user},function(data){
				$("#txt_notificacion").text(data.mensaje);
				$("#modal-notificacion").modal();
			},'json');
		
			break;
			case 3:
			//notificar(id_expediente);
			$.post("../control/get_user.php",{},function(data){user=data;
			$.post("../control/enviar_mail.php",{tipo:"Finalizado",expediente:id_expediente,solucion:solucion,user:user},function(data){  });
			});
			$.post('../control/notificar.php',{tipo:"Finalizado",expediente:id_expediente,solucion:solucion,user:user},function(data){
				$("#txt_notificacion").text(data.mensaje);
				$("#modal-notificacion").modal();
			},'json');
			break;
		}
}
}
function editarServicio(id_expediente)
{
	window.location = "../view/editar_servicio.php?expediente="+id_expediente;
}
function eliminarExpediente(id)
{
	var confirmacion=confirm("¿Realmente desea eliminar el expediente "+id+"? ");
	if (confirmacion){
		$.post("../control/eliminar_servicio.php",{expediente:id},function(data){
			$("#contenedor_servicios_admin").html("<img src='../img/load_bar.gif' id='barra'>");
			$("#contenedor_servicios_admin").load("servicios_admin.php");
			alert(data);
		});
	}

}
function buscarEmpleado()
{
	$("#contenedor_empleados").html("<img src='../img/load_bar.gif' id='barra'>");
	var info=$("#nombre_empleado").prop("value");
	$.post("../view/cargar_empleados.php",{nombre:info},function(data){
	$("#contenedor_empleados").html(data);	
	});
}
function eliminarEmpleado(id)
{
	var confirmacion=confirm("¿Realmente desea eliminar a este empleado "+id+"? ");
	if (confirmacion){
		$.post("../control/eliminar_empleado.php",{empleado:id},function(data){
			$("#contenedor_empleados").html("<img src='../img/load_bar.gif' id='barra'>");
			$("#contenedor_empleados").load("cargar_empleados.php");
			alert(data);
		});
	}

}
function editarImagen(id)
{
	document.getElementById("txtimagen").value=id;
	$("#modal-img").modal("show");
}
function detalleExpediente(id)
{
	$("#contenedor_servicios_admin").html("<img src='../img/load_bar.gif' id='barra'>");
	$.post("servicios.php",{criterio:id},function(data){
	$("#contenedor_servicios_admin").html(data);
	});

	$("#contenedor_servicios_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
	$.post("servicios.php",{criterio:id},function(data){
	$("#contenedor_servicios_gerente").html(data);
	});

	$.post("detalle_servicios_validar.php",{criterio:id},function(data){
	$("#contenedor_validar_servicios").html(data);
	});
}

function estatus_ike(id,estatus)
{

	$.post("../control/actualizar_estatus_ike.php",{expediente:id,estatus:estatus},function(data){
	$("#contenedor_servicios_ike").load("servicios_ike.php"); 
	window.location = "#pub_"+id;
	
	});
	
}
function editarEmpleado(id_empleado)
{
	window.location = "../view/editar_empleado.php?id="+id_empleado;
}

function detalleIke(id)
{
	$("#contenedor_servicios_ike").html("<img src='../img/load_bar.gif' id='barra'>");
	$.post("detalle_ike.php",{id:id},function(data){
	$("#contenedor_servicios_ike").html(data);
	});
}
function detalleForaneo(id)
{
	$("#contenedor_servicios_foraneo").html("<img src='../img/load_bar.gif' id='barra'>");
	$.post("detalle_foraneo.php",{id:id},function(data){
	$("#contenedor_servicios_foraneo").html(data);
	});
}
function estatusPago(id,estatus)
{
	var resp="";
	if(estatus==2){
		resp="SI";
	}else{
		resp="NO";
	}
	$.post("../control/actualizar_estatus_pago.php",{expediente:id,estatus:resp},function(data){
	/*$("#contenedor_servicios_admin").load("servicios_admin.php");
	$("#contenedor_servicios_gerente").load("servicios.php");
	window.location = "#pub_"+id;*/
	alert("El estatus de pago para el servicio "+id+" ha sido actualizado a "+resp+" pagado");
	});
}
function abrirVideo()
{
	$("#modal-video").modal();
}

function subirImagen(id)
{
	document.getElementById("txt_expediente_imagen").value=id;
	$("#modal-imagen").modal();
}
function guardarImagen()
{
	var imagen=document.getElementById("file_imagen");
	var expediente=document.getElementById("txt_expediente_imagen");
	if(imagen.value.length<=0)
	{
		alert("Por favor selecciona una imagen válida");
	}else{
		$.post("../control/guardar_imagen.php",{expediente:expediente,imagen:imagen},function(data){ alert(data); });
	}
	
}
function verImagen(id)
{
	$.post("../control/get_imagen.php",{expediente:id},function(data){  
	$("#imagen_servicio").html(data);
	$("#modal-ver-imagen").modal();
	});
	
}
function verFirma(id)
{
	$.post("../control/get_firma.php",{expediente:id},function(data){  
	$("#imagen_firma").html(data);
	$("#modal-ver-firma").modal();
	});
	
}
function crearPDF(expediente)
{
	window.open("../control/crear_pdf.php?expediente="+expediente,"IZZI TELECOM", "width=500 , height = 700");
}
function eliminarComentario(comentario,expediente)
{
	$.post("../control/eliminar_comentario.php",{comentario:comentario},function(data){
		$("#contenedor_servicios_gerente").load("servicios.php");
		$("#contenedor_servicios_tecnico").load("servicios_tecnico.php");
		$("#contenedor_servicios_admin").load("servicios_admin.php");
	});
}
function cancelarServicio(expediente,tipo)
{
	if(confirm("Confirmar cambio en el expediente "+expediente))
	{
		var causa="";
		if(tipo>1)
		{
			causa=prompt("Ingrese la causa de la cancelación para este servicio");
		}
		
		$.post("../control/cancelar_servicio.php",{expediente:expediente,tipo:tipo,causa:causa},function(data){
		/*$("#contenedor_servicios_gerente").load("servicios.php");
		$("#contenedor_servicios_tecnico").load("servicios_tecnico.php");
		$("#contenedor_servicios_admin").load("servicios_admin.php");*/
		alert("El servicio "+expediente+" ha cambiado de estatus");
		});
	}
	
}
function crearReporte()
{
	var fecha_inicio=$("#fecha_inicio").prop("value");
	var fecha_final=$("#fecha_final").prop("value");
	var tecnico=$("#cb_tecnico").prop("value");
	var capturo=$("#cb_capturo").prop("value");
	var eike=$("#cb_estatus_ike").prop("value");
	if(eike==undefined)
	{
		eike=1;
	}
	var etecnico=$("#cb_estatus_tecnico").prop("value");
	var epago=$("#cb_estatus_pago").prop("value");
	var tipo=$("#cb_tipo_servicio").prop("value");
	var locacion=$("#cb_locacion").prop("value");
	if(fecha_inicio.length>0 && fecha_final.length>0)
	{
		window.open("../control/crear_reporte.php?fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&tecnico="+tecnico+"&capturo="+capturo+"&eike="+eike+"&etecnico="+etecnico+"&epago="+epago+"&tipo="+tipo+"&locacion="+locacion,"DOT REDES", "width=500 , height = 700");
		
	}else{
		alert("Los campos de fecha son obligatorios para generar el reporte.");
	}
	
}
function crearExcel()
{
	var fecha_inicio=$("#fecha_inicio").prop("value");
	var fecha_final=$("#fecha_final").prop("value");
	var tecnico=$("#cb_tecnico").prop("value");
	var capturo=$("#cb_capturo").prop("value");
	var eike=$("#cb_estatus_ike").prop("value");
	if(eike==undefined)
	{
		eike=1;
	}
	var etecnico=$("#cb_estatus_tecnico").prop("value");
	var epago=$("#cb_estatus_pago").prop("value");
	var tipo=$("#cb_tipo_servicio").prop("value");
	var locacion=$("#cb_locacion").prop("value");
	if(fecha_inicio.length>0 && fecha_final.length>0)
	{
		window.location="../control/reporteexcel.php?fecha_inicio="+fecha_inicio+"&fecha_final="+fecha_final+"&tecnico="+tecnico+"&capturo="+capturo+"&eike="+eike+"&etecnico="+etecnico+"&epago="+epago+"&tipo="+tipo+"&locacion="+locacion,"DOT REDES", "width=500 , height = 700";

		
	}else{
		alert("Los campos de fecha son obligatorios para generar el reporte.");
	}
}
function abrirEncuesta(expediente)
{
	document.getElementById("encuesta_expediente").value=expediente;
	$("#modal-encuesta").modal();
}
function guardarEncuesta()
{
	var expediente=$("#encuesta_expediente").prop("value");
	var r1=$("#r1").prop("value");
	var r2=$("#r2").prop("value");
	var r3=$("#r3").prop("value");
	var r4=$("#r4").prop("value");
	var r5=$("#r5").prop("value");
	var r6=$("#r6").prop("value");
	var r7=$("#r7").prop("value");
	var r8=$("#r8").prop("value");
	$.post("../control/guardar_encuesta.php",{
		expediente:expediente,
		r1:r1,
		r2:r2,
		r3:r3,
		r4:r4,
		r5:r5,
		r6:r6,
		r7:r7,
		r8:r8
	},function(data){
		cambiar_estatus(expediente,3);
		$("#modal-encuesta").modal("hide");
	});
	

}
function verEncuesta(expediente)
{
	$.post("../control/ver_encuesta.php",{expediente:expediente},function(data){
		$("#contiene_encuesta").html(data);
		$("#modal-ver-encuesta").modal();
	});
	
}

function cambiarHorario(num)
{

	switch(num)
	{
		case 1:
			document.getElementById('horario1').value="9:00";
			document.getElementById('horario2').value="10:00";
			$("#horario1").attr('readOnly',true);
			$("#horario2").attr('readOnly',true);

		break;
		case 2:
			document.getElementById('horario1').value="12:00";
			document.getElementById('horario2').value="13:00";
			$("#horario1").attr('readOnly',true);
			$("#horario2").attr('readOnly',true);

		break;
		case 3:
			document.getElementById('horario1').value="15:00";
			document.getElementById('horario2').value="16:00";
			$("#horario1").attr('readOnly',true);
			$("#horario2").attr('readOnly',true);

		break;
		case 4:
			$("#horario1").removeAttr('readonly');
			$("#horario2").removeAttr('readonly');
		break;
	}
	cargarTecnicos();
	cargarCostos();
}

function cargarTecnicos()
{
	var locacion=$("#locacion").prop("value");
	var fecha=$("#fecha").prop("value");
	var horario=$("#horario1").prop("value");
	$.post("select_tecnico.php",{locacion:locacion,fecha:fecha,horario:horario},function(data){
		//alert(data);
		$("#select_tecnico").html(data);
	});

	if(locacion=="DF")
	{
		$("#div_costo").html('<select class="form-control" id="costo" name="costo"><option value="700">Costo normal $700</option><option value="350">Costo muerto $350</option></select>');
	}else{
		$("#div_costo").html('<select class="form-control" id="costo" name="costo"><option value="300">Costo normal $300</option><option value="150">Costo muerto $150</option></select>');
	}
	cargarCostos();
}
function cargarTecnicosEdit()
{
	var locacion=$("#locacion").prop("value");
	var fecha=$("#fecha").prop("value");
	var horario=$("#horario1").prop("value");
	$.post("select_tecnico_edit.php",{locacion:locacion,fecha:fecha,horario:horario},function(data){
		//alert(data);
		$("#select_tecnico").html(data);
	});

	if(locacion=="DF")
	{
		$("#div_costo").html('<select class="form-control" id="costo" name="costo"><option value="700">Costo normal $700</option><option value="350">Costo muerto $350</option></select>');
	}else{
		$("#div_costo").html('<select class="form-control" id="costo" name="costo"><option value="300">Costo normal $300</option><option value="150">Costo muerto $150</option></select>');
	}
	cargarCostos();
}
function cargarCostos()
{
	var tipo=$("#tipo").prop("value");
	if(tipo=="SERVICIO REMOTO")
	{
		$("#div_costo").html('<select class="form-control" id="costo" name="costo"><option value="300">Costo normal $300</option></select>');
	}
}
function validarServicio(id)
{
	$.post("../control/validar_servicio.php",{id:id},function(data){
		window.location="../view/editar_servicio.php?expediente="+id;
	});
}
function noValidarServicio(id)
{
	$.post("../control/no_validar_servicio.php",{id:id},function(data){
		window.location="validar_servicios.php";
	});

}
function editarAgendado(id_expediente)
{
	window.location = "../view/editar_agendado.php?expediente="+id_expediente;
}
//_____________________Pendientes_________________________________
function agregarComentarioPendiente(id_pendiente)
{
	var comentario = $("#comentario_pendiente_"+id_pendiente).prop("value");
	$.post("../control/agregar_comentario_pendiente.php",{id_pendiente:id_pendiente,comentario:comentario},function(data){
		$("#contenedor_pendientes_admin").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendientes_admin").load("cargar_pendientes_admin.php");

		$("#contenedor_pendiente_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendiente_gerente").load("cargar_pendientes_admin.php");

		$("#contenedor_pendiente_tecnico").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendiente_tecnico").load("cargar_pendientes_tecnico.php");

		$("#modal-detalle-pendiente").modal('hide');

		alert("Comentario almacenado");
	});
}
function showNuevoPendienteAdmin()
{
	$("#modal-nuevo-pendiente-admin").modal();
}
function guardarNuevoPendienteAdmin()
{
	$("#load_pendiente").html('<img src="../img/load.gif" width="50" height="50">');
	var titulo=$("#txt_titulo_pendiente").prop("value");
	var fecha=$("#txt_fecha_pendiente").prop("value");
	var hora=$("#txt_hora_pendiente").prop("value");
	var empleado=$("#txt_empleado_pendiente").prop("value");
	var descripcion=$("#txt_descripcion_pendiente").prop("value");
	$.post("../control/guardar_pendiente.php",{
		titulo:titulo,
		fecha:fecha,
		hora:hora,
		empleado:empleado,
		descripcion:descripcion
	},function(data){
		alert(data);
		$("#load_pendiente").html('');
		$("#contenedor_pendientes_admin").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendientes_admin").load("cargar_pendientes_admin.php");
		$("#contenedor_pendientes_gerente").load("cargar_pendientes_gerente.php");
		$("#modal-nuevo-pendiente-admin").modal("hide");
		document.getElementById("txt_titulo_pendiente").value="";
		document.getElementById("txt_fecha_pendiente").value="";
		document.getElementById("txt_empleado_pendiente").value="";
		document.getElementById("txt_descripcion_pendiente").value="";
	});
}
function showReasignarAdmin(id)
{
	document.getElementById("txt_reasignar_admin").value=id;
	$("#modal-reasignar-admin").modal();
}
function reasignarPendienteAdmin()
{
	var id = $("#txt_reasignar_admin").prop("value");
	var empleado=$("#txt_reasignar_empleado_pendiente").prop("value");
	$.post("../control/reasignar_admin.php",{id:id,empleado:empleado},function(data){
		alert(data);
		$("#contenedor_pendientes_admin").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendientes_admin").load("cargar_pendientes_admin.php");
		$("#modal-reasignar-admin").modal("hide");
	});
}

function eliminarPendiente(id)
{
	if(confirm("¿Seguro que desea eliminar este registro?")){

	$.post("../control/eliminar_pendiente.php",{id:id},function(data){
		alert(data);
		$("#contenedor_pendientes_admin").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendientes_admin").load("cargar_pendientes_admin.php");
	});
	
	}
}

function showReasignarGerente(id)
{
	document.getElementById("txt_reasignar_gerente").value=id;
	$("#modal-reasignar-gerente").modal();
}
function reasignarPendienteGerente()
{
	var id = $("#txt_reasignar_gerente").prop("value");
	var empleado=$("#txt_reasignar_empleado_pendiente").prop("value");
	$.post("../control/reasignar_Gerente.php",{id:id,empleado:empleado},function(data){
		alert(data);
		$("#contenedor_pendiente_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendiente_gerente").load("cargar_pendientes_gerente.php");
		$("#modal-reasignar-gerente").modal("hide");
	});
}
function showDetallePendiente(id)
{
	$.post("cargar_detalle_admin.php",{id:id},function(data){
		$("#body_detalle_pendiente").html(data);
		$("#modal-detalle-pendiente").modal();
	});
}
function showEditarPendiente(id)
{
	document.getElementById("txt_editar_id").value=id;
	$.post("editar_pendiente.php",{id:id},function(data){
		$("#body_editar_pendiente").html(data);
		$("#modal-editar-pendiente-admin").modal();
	});
}
function editarPendiente()
{
	$("#load_pendiente").html('<img src="../img/load.gif" width="50" height="50">');
	var id=$("#txt_editar_id").prop("value");
	var titulo=$("#txt_titulo_pendiente_edit").prop("value");
	var fecha=$("#txt_fecha_pendiente_edit").prop("value");
	var hora=$("#txt_hora_pendiente_edit").prop("value");
	var empleado=$("#txt_empleado_pendiente_edit").prop("value");
	var descripcion=$("#txt_descripcion_pendiente_edit").prop("value");
	$.post("../control/editar_pendiente.php",{
		id:id,
		titulo:titulo,
		fecha:fecha,
		hora:hora,
		empleado:empleado,
		descripcion:descripcion
	},function(data){
		alert(data);
		$("#load_pendiente").html('');
		$("#contenedor_pendientes_admin").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendientes_admin").load("cargar_pendientes_admin.php");
		$("#contenedor_pendiente_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendiente_gerente").load("cargar_pendientes_gerente.php");
		$("#modal-editar-pendiente-admin").modal("hide");
		document.getElementById("txt_titulo_pendiente").value="";
		document.getElementById("txt_fecha_pendiente").value="";
		document.getElementById("txt_hora_pendiente").value="";
		document.getElementById("txt_empleado_pendiente").value="";
		document.getElementById("txt_descripcion_pendiente").value="";
	});
}

function showGeolocalizacion(id)
{
	$.post("get_geolocalizacion.php",{id:id},function(data){
		//$("#body_geolocalizacion").html(data);
		//$("#modal-geolocalizacion").modal();
		//window.open("localizacion.php"+data);
		window.open("localizacion.php"+data, "localizacion",  "width="+screen.width+", height="+screen.height);
	});
}

 function pedirPosicion(pos) {
   //var centro = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
   //map.setCenter(centro); //pedimos que centre el mapa..
   //map.setMapTypeId(google.maps.MapTypeId.ROADMAP); //y lo volvemos un mapa callejero
	$.post("../control/actualizar_posicion.php",{
  	lat:pos.coords.latitude,
  	lon:pos.coords.longitude,
  	aprox:pos.coords.accuracy
  },function(data){ 
  	//alert("Pos : "+pos.coords.latitude+ ","+pos.coords.longitude+" Rango de localización de +/- "+pos.coords.accuracy+" metros");
  });
}
 //se manda a llamar a esta funcion
function geolocalizame(){
navigator.geolocation.getCurrentPosition(pedirPosicion);
 }

 function showGeolocalizacionAll()
{
	window.open("localizacion_all.php","localizacion", "width="+screen.width+", height="+screen.height);

}
function terminarPendiente(id)
{
	var comentario = prompt("Agregar comentario a cerca de esta actividad!!!");
	$.post("../control/terminar_pendiente.php",{id:id,comentario:comentario},function(data){
		$("#contenedor_pendientes_admin").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendientes_admin").load("cargar_pendientes_admin.php");

		$("#contenedor_pendiente_gerente").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendiente_gerente").load("cargar_pendientes_gerente.php");

		$("#contenedor_pendiente_tecnico").html("<img src='../img/load_bar.gif' id='barra'>");
		$("#contenedor_pendiente_tecnico").load("cargar_pendientes_tecnico.php");

		alert("Actividad terminada");
	});
}
function cargarPendientesTerminados()
{
	$("#contenedor_pendientes_admin").html("<img src='../img/load_bar.gif' id='barra'>");
	$("#contenedor_pendientes_admin").load("cargar_pendientes_admin2.php");
}
function cambiarTecnico(tecnico,expediente)
{
	$.post("../control/cambiar_tecnico.php",{
		id_tecnico:tecnico,
		id_expediente:expediente
	},function(data){
		alert(data);
	});
}