<?php
	include "conectar.php";

	$InspectorId 		= addslashes($_POST['InspectorId']);
	$ContratoId 		= addslashes($_POST['ContratoId']);
	$Fecha 				= addslashes($_POST['Fecha']);
	$Cedula 			= addslashes($_POST['Cedula']);
	$InspectorEmpresa 	= addslashes($_POST['InspectorEmpresa']);
	$NumFactura 		= addslashes($_POST['NumFactura']);
	$InspectorNombre 	= addslashes($_POST['InspectorNombre']);
	$Contrato 			= addslashes($_POST['Contrato']);
	$JefeCuadrilla 		= addslashes($_POST['JefeCuadrilla']);
	$Empresa 			= addslashes($_POST['Empresa']);
	$Direccion 			= addslashes($_POST['Direccion']);
	$Trabajo 			= addslashes($_POST['Trabajo']);
	$Zona 				= addslashes($_POST['Zona']);
	$Equipo 			= addslashes($_POST['Equipo']);
	$Dependencia 		= addslashes($_POST['Dependencia']);
	$Odt 				= addslashes($_POST['Odt']);
	$ContratoNombre 	= addslashes($_POST['ContratoNombre']);
	$Celular 			= addslashes($_POST['Celular']);
	$VehiculoTipo 		= addslashes($_POST['VehiculoTipo']);
	$VehiculoPlaca 		= addslashes($_POST['VehiculoPlaca']);
	$VehiculoGrua 		= addslashes($_POST['VehiculoGrua']);
	$VehiculoCanasta 	= addslashes($_POST['VehiculoCanasta']);
	$VehiculoMoto 		= addslashes($_POST['VehiculoMoto']);
	$HoraInicial 		= addslashes($_POST['HoraInicial']);
	$HoraFinal 			= addslashes($_POST['HoraFinal']);
	$Observaciones 		= addslashes($_POST['Observaciones']);
	$Conformidad 		= addslashes($_POST['Conformidad']);
	$preguntas 			= $_POST['preguntas'];

	$sql = "INSERT INTO inspeccion(fecha, Direccion, trabajo_realizar, consignacion_odt, cel_avantel, tip_vehiculo, placa_vehiculo, placa_grua, placa_canasta, placa_moto, hora_inicial, hora_final, Conformidad, observaciones, INSPECTORES_id, CONTRATO_ID)
			VALUES(
				'" . $Fecha . "',
				'" . $Direccion . "',
				'" . $Trabajo . "',
				'" . $Odt . "',
				'" . $Celular . "',
				'" . $VehiculoTipo . "',
				'" . $VehiculoPlaca . "',
				'" . $VehiculoGrua . "',
				'" . $VehiculoCanasta . "',
				'" . $VehiculoMoto . "',
				'" . $Fecha . ' ' . $HoraInicial . "',
				'" . $Fecha . ' ' . $HoraFinal . "',
				'" . $Conformidad . "',
				'" . $Observaciones . "',
				'" . $InspectorId . "',
				'" . $ContratoId . "'
			) ON DUPLICATE KEY UPDATE
				fecha = VALUES(fecha),
				Direccion = VALUES(Direccion),
				trabajo_realizar = VALUES(trabajo_realizar),
				consignacion_odt = VALUES(consignacion_odt),
				cel_avantel = VALUES(cel_avantel),
				tip_vehiculo = VALUES(tip_vehiculo),
				placa_vehiculo = VALUES(placa_vehiculo),
				placa_grua = VALUES(placa_grua),
				placa_canasta = VALUES(placa_canasta),
				placa_moto = VALUES(placa_moto),
				hora_inicial = VALUES(hora_inicial),
				hora_final = VALUES(hora_final),
				Conformidad = VALUES(Conformidad),
				observaciones = VALUES(observaciones),
				INSPECTORES_id = VALUES(INSPECTORES_id),
				CONTRATO_ID = VALUES(CONTRATO_ID);";

	$con = Conectar();

	$con->query(utf8_decode($sql));

	if ( $con->affected_rows > 0){
            $nuevoId = $con->insert_id;
            foreach ($preguntas as $key => $value) {

            	$sql = "INSERT INTO inspeccion_pregunta (cumple, categoria, observacion, INSPECCION_id, PREGUNTAS_id, TECNICOS_id) VALUES(
						'" . $value['valor'] . "',
						'" . $value['categoria'] . "',
						'" . $value['observacion'] . "',
						'" . $nuevoId  . "',
						'" . $value['id'] . "',
						'" . $InspectorId . "'
            	);";

            	$con->query(utf8_decode($sql));
            }
    } else{
    	echo "Hubo un error desconocido " . $con->error;
    }
?>