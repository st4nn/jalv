<?php 
function Conectar() { 
	// Parametros a configurar para la conexion de la base de datos 
	$host = "localhost";   
	$basededatos = "pa";   
	$usuariodb = "root";     
	$clavedb = "";    

	$link = new mysqli($host, $usuariodb, $clavedb, $basededatos);
	if ($link->connect_errno) {
		echo "Error: (" . $link->connect_errno . ") " . $link->connect_error;
		exit(); 
	}

   return $link; 
} 

?>
