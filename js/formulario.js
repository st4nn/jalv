$(document).on('ready', funFormulario);

function funFormulario(){
	cargarPreguntas();

	var miVariableDefecha = new Date();
	$('#txtFormulario_Fecha').val(obtenerFecha().substring(0, 10));

	$('#txtFormulario_Cedula').on('change', function(){
		$.post('php/cargarInspector.php', {cedula : $('#txtFormulario_Cedula').val()}, function(datos, textStatus, xhr) {
			if (datos.length > 0){
				$('#txtFormulario_InspectorId').val(datos[0].id_inspectores);
				$('#txtFormulario_InspectorNombre').val(datos[0].nombre);
				$('#txtFormulario_InspectorEmpresa').val(datos[0].empre_inspec);
			} else{
				alert('No se encontró ningún usuario con la cedula: ' + $('#txtFormulario_Cedula').val());
				$('#txtFormulario_InspectorId').val(0);
				$('#txtFormulario_InspectorNombre').val('');
				$('#txtFormulario_InspectorEmpresa').val('');
			}
		}, 'json');
	});

	$('#txtFormulario_Contrato').autocomplete({
        source: "php/productos.php",
        minLength: 2,
        select: function(event, ui) {
			event.preventDefault();
			
			$('#txtFormulario_ContratoId').val(ui.item.id_contrato);
			$('#txtFormulario_JefeCuadrilla').val(ui.item.jefe);
			$('#txtFormulario_Empresa').val(ui.item.grupo);
		}
	});

	$(document).delegate('.txtFormulario_Pregunta', 'change', function(event) {
		var valor = $(this).val();
		var idPre = $(this).attr('id').replace('txtFormulario_Pregunta_', '');
		
		if (valor === 'NO'){
			if ($('#txtFormulario_Pregunta_Observacion_' + idPre).length === 0){
				var tds = '<textarea class="form-control" rows="3" placeholder="OBSERVACIÓN:" id="txtFormulario_Pregunta_Observacion_' + idPre + '"></textarea>';
				$(this).parent('div').parent('div').append(tds);
				$('#txtFormulario_Conformidad').val('No');
			} else{
				$('#txtFormulario_Pregunta_Observacion_' + idPre).remove();
			}
		}
	});

	$('#frmFormulario').on('submit', function(evento){
		evento.preventDefault();

		var datos = {
			InspectorId 		: $('#txtFormulario_InspectorId').val(),
			ContratoId 			: $('#txtFormulario_ContratoId').val(),
			Fecha 				: $('#txtFormulario_Fecha').val(),
			Cedula 				: $('#txtFormulario_Cedula').val(),
			InspectorEmpresa 	: $('#txtFormulario_InspectorEmpresa').val(),
			NumFactura 			: $('#txtFormulario_NumFactura').val(),
			InspectorNombre 	: $('#txtFormulario_InspectorNombre').val(),
			Contrato 			: $('#txtFormulario_Contrato').val(),
			JefeCuadrilla 		: $('#txtFormulario_JefeCuadrilla').val(),
			Empresa 			: $('#txtFormulario_Empresa').val(),
			Direccion 			: $('#txtFormulario_Direccion').val(),
			Trabajo 			: $('#txtFormulario_Trabajo').val(),
			Zona 				: $('#txtFormulario_Zona').val(),
			Equipo 				: $('#txtFormulario_Equipo').val(),
			Dependencia 		: $('#txtFormulario_Dependencia').val(),
			Odt 				: $('#txtFormulario_Odt').val(),
			ContratoNombre 		: $('#txtFormulario_ContratoNombre').val(),
			Celular 			: $('#txtFormulario_Celular').val(),
			VehiculoTipo 		: $('#txtFormulario_VehiculoTipo').val(),
			VehiculoPlaca 		: $('#txtFormulario_VehiculoPlaca').val(),
			VehiculoGrua 		: $('#txtFormulario_VehiculoGrua').val(),
			VehiculoCanasta 	: $('#txtFormulario_VehiculoCanasta').val(),
			VehiculoMoto 		: $('#txtFormulario_VehiculoMoto').val(),
			HoraInicial 		: $('#txtFormulario_HoraInicial').val(),
			HoraFinal 			: $('#txtFormulario_HoraFinal').val(),
			Observaciones 		: $('#txtFormulario_Observaciones').val(),
			Conformidad 		: $('#txtFormulario_Conformidad').val(),
			preguntas 			: []
		}

		var objPreguntas = $('.txtFormulario_Pregunta');

		$.each(objPreguntas, function(index, val) {
			var idPre = $(val).attr('id').replace('txtFormulario_Pregunta_', '');
			var objPre = {
				id 				: idPre,
				valor 			: $(val).val(),
				categoria 		: $('#txtFormulario_PreguntaCategoria_' + idPre).val(),
				observacion 	: ($('#txtFormulario_Pregunta_Observacion_' + idPre).length > 0 ? $('#txtFormulario_Pregunta_Observacion_' + idPre).val() : '')
			};
			datos.preguntas.push(objPre);

		});

		$.post('php/crearInspeccion.php', datos, function(data, textStatus, xhr) {
			alert('El registro ha sido ingresado');
		});

	});
}





function obtenerFecha(){
  var f = new Date();
  return f.getFullYear() + "-" + CompletarConCero(f.getMonth() +1, 2) + "-" + CompletarConCero(f.getDate(), 2) + " " + CompletarConCero(f.getHours(), 2) + ":" + CompletarConCero(f.getMinutes(), 2) + ":" + CompletarConCero(f.getSeconds(), 2);
}

function CompletarConCero(n, length){
   n = n.toString();
   while(n.length < length) n = "0" + n;
   return n;
}


function cargarPreguntas(){
	$.post('php/cargarPreguntas.php', {}, function(datos, textStatus, xhr) {

		var tmpIdx 	= 0;
		var tds 	= '';
		$.each(datos, function(indice, val) {
			if (tmpIdx !== val.idCat){
				if (tmpIdx !== 0){
					tds += '</div>'	
				}
				tmpIdx = val.idCat;
				tds += '<h3 title="' + val.catDesLar + '">' + val.catDesCor + '</h3>';
				tds += '<div>';
			}
			tds += '<div class="row">';
				tds += '<div class="col-sm-2">';
					tds += '<h3>' + val.idCat + '.' + val.idPre + '</h3>';
				tds += '</div>';
				tds += '<div class="col-sm-6">';
					tds += '<h4 title="' + val.preDescLar + '">' + val.preDesCor + '</h4>';
				tds += '</div>';
				tds += '<div class="col-sm-2">';
					tds += '<select class="txtFormulario_Pregunta" id="txtFormulario_Pregunta_' + val.idPre + '">';
	                    tds += '<option value="SI">SI</option>';
	                    tds += '<option value="NO">NO</option>';
	                    tds += '<option value="NA">N.A</option>';
	                tds += '</select>';
	            tds += '</div>';
	            tds += '<div class="col-sm-2">';
					tds += '<select class="txtFormulario_PreguntaCategoria" id="txtFormulario_PreguntaCategoria_' + val.idPre + '">';
	                    tds += '<option value="F">F</option>';
	                    tds += '<option value="C">C</option>';
	                    tds += '<option value="E">E</option>';
	                    tds += '<option value="O">O</option>';
	                tds += '</select>';
	            tds += '</div>';
	        tds += '</div>';
		});
		tds += '</div>';

		$('#accordion').append(tds);

		$( "#accordion" ).accordion();


	}, 'json');	
}