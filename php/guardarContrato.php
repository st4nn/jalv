<?php
	include "conectar.php";

	$contrato 		= addslashes($_POST['contrato']);
	$dependencia 	= addslashes($_POST['dependencia']);
	$equipo 		= addslashes($_POST['equipo']);
	$grupo 			= addslashes($_POST['grupo']);
	$jefe 			= addslashes($_POST['jefe']);
	$nombre 		= addslashes($_POST['nombre']);

	$sql = "INSERT INTO contrato ( contrato, jefe, grupo, equipo, dependencia, nombre)
			VALUES(
				'" . $contrato . "',
				'" . $jefe . "',
				'" . $grupo . "',
				'" . $equipo . "',
				'" . $dependencia . "',
				'" . $nombre . "'
			) ON DUPLICATE KEY UPDATE
				jefe = VALUES(jefe),
				grupo = VALUES(grupo),
				equipo = VALUES(equipo),
				dependencia = VALUES(dependencia),
				nombre = VALUES(nombre);";

	$con = Conectar();

	$con->query(utf8_decode($sql));

	if ( $con->affected_rows > 0){
            echo $con->insert_id;
    } else{
    	echo "Hubo un error desconocido " . $con->error;
    }
?>