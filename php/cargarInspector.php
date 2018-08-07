<?php
	include "conectar.php";

	$Cedula = addslashes($_POST['cedula']);

	$sql = "SELECT 
				inspectores.id_inspectores, 
				inspectores.cedula, 
				inspectores.usuario, 
				inspectores.nombre, 
				inspectores.rol, 
				inspectores.empre_inspec
			FROM 
				inspectores
			WHERE
				inspectores.cedula = '$Cedula';";

	$con = Conectar();
	$resultado = $con->query($sql);

	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	$idx = 0;

	$Resultados = array();
	
	while ($row = mysqli_fetch_assoc($resultado)) {
		$Resultados[$idx] = array();
		$Resultados[$idx]['id_inspectores']	= utf8_encode($row['id_inspectores']);
		$Resultados[$idx]['cedula']			= utf8_encode($row['cedula']);
		$Resultados[$idx]['usuario']		= utf8_encode($row['usuario']);
		$Resultados[$idx]['nombre']			= utf8_encode($row['nombre']);
		$Resultados[$idx]['rol']			= utf8_encode($row['rol']);
		$Resultados[$idx]['empre_inspec']	= utf8_encode($row['empre_inspec']);

		$idx++;
	}

	mysqli_free_result($resultado);  
    echo json_encode($Resultados);
?>