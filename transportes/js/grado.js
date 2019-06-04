function guardarGrado() {
	var id_nivel = $('#id_nivel').val();
	var n_nivel = $('#n_nivel').val();
	var nombre_grado = $('#nombre_grado').val();
	if (nombre_grado == "") {
		alert("Por favor escribe el Grado");
	} else {
		$.ajax(
				{
					url : "php/grados.php?insertGrado=true&id_nivel="
							+ id_nivel + "&nombre_grado=" + nombre_grado,
					dataType : 'json',
				}).done(function(data) {
			if (data.id == '-1') {
				muestraAlerta();
			} else {
				location.reload();
			}
		});
	}
}

function editarGrado(qwert) {
	var nombre = $('#span_grado_' + qwert).text();
	$('[data-edit=' + qwert + ']').show();
	$('[data-etiqueta=' + qwert + ']').hide();
}

function cancelarEdicion(qwert) {
	var nombre = $('#link_grado_ed_' + qwert).val();
	$('#span_grado_' + qwert).text(nombre);
	$('[data-edit=' + qwert + ']').hide();
	$('[data-etiqueta=' + qwert + ']').show();
}

function aceptarGrado(qwert) {
	var nombre = $('[data-row=' + qwert + '] input').val();
	console.log(nombre);
	$.ajax(
			{
				url : "php/grados.php?updateGrado=true&qwert=" + qwert
						+ "&nombre=" + nombre,
				dataType : 'json',
			}).done(function(data) {
		if (data.id == '-1') {
			muestraAlerta();
		} else {
			location.reload();
		}

	});
}

function eliminarGrado(qwert) {
	var nombre = $('[data-etiqueta=' + qwert + ']').text();
	var respuesta = confirm("Desea eliminar el grado "+nombre);
	if (respuesta) {
		var contenido = "";
		$.ajax({
			url : "php/grados.php?delGrado=true&qwert=" + qwert,
			dataType : 'json',
		}).done(function() {
			location.reload();
		});
	}
}

function muestraAlerta() {
	$('.grado-alert')
			.html(
					'<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>El nombre del grado ya esta registrado, por favor escribe otro</div>')
			.show();
	setTimeout(function() {
		$('.grado-alert').fadeOut();
	}, 3000);
}

$(document)
		.ready(
				function() {

					getNivelesGrados();

					$('#buscar_grado.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable_buscar_grado tr').hide();
						$('.searchable_buscar_grado tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});

					function getNivelesGrados() {
						var contenido = "";
						var contenido2 = "";
						$
								.ajax({
									url : "php/niveles.php?getNiveles=true",
									dataType : 'json',
									success : function(data) {
										contenido2 += '<option value="0" selected="selected">Niveles</option>';
										$
												.each(
														data,
														function(i, nivel) {
															var n = i + 1;
															contenido += '<tr id="tnivel_'
																	+ nivel.id
																	+ '">'
																	+ '<td style="width:50px;">'
																	+ n
																	+ '</td>'
																	+ '<td style="width:900px;">'
																	+ nivel.nombre
																	+ '</td>'
																	+ '<td align="center" style="width:300px;">'
																	+ '<center>'
																	+ '<button style="cursor:pointer;" onclick="verGrado('
																	+ nivel.id
																	+ ', \''
																	+ nivel.nombre
																	+ '\')" type="button" class="btn btn-info" data-toggle="modal" data-target="#verGrado">'
																	+ '<span class="glyphicon glyphicon-eye-open"></span> Ver Grados'
																	+ '</button>'
																	+ '</center>'
																	+ '</td>'
																	+ '</tr>';
															// contenido2 +=
															// '<option
															// value="'+nivel.id+'">'+nivel.nombre+'</option>';

														});

										$('#niveles_table > tbody').append(
												contenido);
										// $('#niveles_select').append(contenido2);
									}/* Success */
								});

					}

				});