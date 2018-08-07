$(document).on('ready', miPrimeraFuncion);

function miPrimeraFuncion(){
	$("#contrato").autocomplete({
        source: "php/productos.php",
        minLength: 2,
        select: function(event, ui) {
			event.preventDefault();

			$('#contrato').val(ui.item.contrato);
			$('#id_contrato').val(ui.item.id_contrato);
			$('#jefe').val(ui.item.jefe);
			$('#grupo').val(ui.item.grupo);
			$('#equipo').val(ui.item.equipo);
			$('#dependencia').val(ui.item.dependencia);
			$('#nombre').val(ui.item.nombre);
		}
	});

	$('#frmCrearContrato').on('submit', function(event){
		event.preventDefault();

		var controles = $('#frmCrearContrato input');
		var datos = {};

		$.each(controles, function(index, valor) {
			 datos[$(valor).attr('id')] = $(valor).val();
		});
		
		$.post('php/guardarContrato.php', datos, function(data, textStatus, xhr) {
			if (isNaN(data)){
				alert(data);
			} else{
				alert('Se registró el contrato con el id: ' + data);
			}
		});
	});

	$('#btnLimpiar').on('click', function(event){
		event.preventDefault();
		$('#frmCrearContrato')[0].reset();
	});
}