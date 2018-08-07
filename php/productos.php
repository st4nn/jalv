<?php
	include "conectar.php";

	$parametro = addslashes($_GET['term']);

	$sql = "SELECT 	
				* 
			FROM 
				contrato 
			WHERE 
				contrato.contrato LIKE '%$parametro%'";

	$con = Conectar();
	$resultado = $con->query($sql);

	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	$idx = 0;

	$Resultados = array();
	while ($row = mysqli_fetch_assoc($resultado)) {
		$Resultados[$idx] = array();
		$Resultados[$idx]['id_contrato']	= $row['id_contrato'];
		$Resultados[$idx]['value'] 			= $row['contrato'] . '|' . $row['nombre'];
		$Resultados[$idx]['contrato']		= $row['contrato'];
		$Resultados[$idx]['jefe']			= $row['jefe'];
		$Resultados[$idx]['grupo']			= $row['grupo'];
		$Resultados[$idx]['equipo']			= $row['equipo'];
		$Resultados[$idx]['dependencia']	= $row['dependencia'];
		$Resultados[$idx]['nombre']			= $row['nombre'];

		$idx++;
	}

	mysqli_free_result($resultado);  
    echo json_encode($Resultados);
?>