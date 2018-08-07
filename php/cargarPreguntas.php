<?php
	include "conectar.php";

	$sql = "SELECT 
				preguntas_categoria.id_pre_cat AS 'idCat', 
				preguntas_categoria.codigo_orden AS 'catOrden', 
				preguntas_categoria.descripcion_corta AS 'catDesCor', 
				preguntas_categoria.descripcion_larga AS 'catDesLar',
				preguntas.id_preguntas AS 'idPre', 
				preguntas.codigo_orden AS 'preCod', 
				preguntas.descripcion_corta AS 'preDesCor', 
				preguntas.descripcion_larga AS 'preDescLar', 
				preguntas.estado AS 'preEst'
			FROM 
				preguntas
				INNER JOIN preguntas_categoria
					ON preguntas_categoria.id_pre_cat = preguntas.PREGUNTAS_CATEGORIA_id;";

	$con = Conectar();
	$resultado = $con->query($sql);

	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	$idx = 0;

	$Resultados = array();
	while ($row = mysqli_fetch_assoc($resultado)) {
		$Resultados[$idx] = array();
		$Resultados[$idx]['idCat']		= utf8_encode($row['idCat']);
		$Resultados[$idx]['catOrden']	= utf8_encode($row['catOrden']);
		$Resultados[$idx]['catDesCor']	= utf8_encode($row['catDesCor']);
		$Resultados[$idx]['catDesLar']	= utf8_encode($row['catDesLar']);
		$Resultados[$idx]['idPre']		= utf8_encode($row['idPre']);
		$Resultados[$idx]['preCod']		= utf8_encode($row['preCod']);
		$Resultados[$idx]['preDesCor']	= utf8_encode($row['preDesCor']);
		$Resultados[$idx]['preDescLar']	= utf8_encode($row['preDescLar']);
		$Resultados[$idx]['preEst']		= utf8_encode($row['preEst']);

		$idx++;
	}

	mysqli_free_result($resultado);  
    echo json_encode($Resultados);
?>