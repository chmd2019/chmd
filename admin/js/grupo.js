function guardarGrupo() {
	var id_nivel = $('#id_nivel').val();
	var id_grado = $('#id_grado').val();

	var n_nivel = $('#n_nivel').val();
	var n_grado = $('#n_grado').val();

	var nombre_grupo = $('#nombre_grupo').val();
	if (nombre_grupo == "") {
		alert("Por favor escribe el Grupo");
	} else {
		var contenido = "";
		$.ajax(
				{
					url : "php/grupos.php?insertGrupo=true&id_nivel="
							+ id_nivel + "&id_grado=" + id_grado
							+ "&nombre_grupo=" + nombre_grupo,
					dataType : 'json',

				}).done(function(data) {
			if (data.id == '-1') {
				muestraAlerta('.alerta');
			} else {
				location.reload();
			}
		});
	}

}
function verGrupo(qwert_nivel, qwert_grado, nivel, grado) {
	var contenido = "";
	$("#nombre_grupo").val("");
	$('.pop_over').popover('hide');
	$("#modalNivelGradoTitulo").text(nivel + " - " + grado);
	$("#id_nivel").val(qwert_nivel);
	$("#id_grado").val(qwert_grado);
	$
			.ajax(
					{
						url : "php/grupos.php?getGrupos=true&qwert_nivel="
								+ qwert_nivel + "&qwert_grado=" + qwert_grado,
						dataType : 'json'
					})
			.done(
					function(data) {
						$
								.each(
										data,
										function(i, grupo) {
											var n = i + 1;
											contenido += '<tr id="tgrupo_'
													+ grupo.id
													+ '"><td style="width:900px;"><div style="display:none" id="input_ed_'
													+ grupo.id
													+ '"></div><div id="label_'
													+ grupo.id
													+ '"><span id="span_grupo_'
													+ grupo.id
													+ '">'
													+ grupo.nombre
													+ '</span></div></td><td align="center" style="width:300px;"><center><button style="cursor:pointer;" onclick="editarGrupo('
													+ grupo.id
													+ ')" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#agregarNivel"><span class="glyphicon glyphicon-pencil"></span></button><button style="cursor:pointer;" onclick="eliminarGrupo('
													+ grupo.id
													+ ')" type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button></center></td></tr>';

										});
						$('#grupos_table > tbody').html(contenido);
					});
}

function editarGrupo(qwert) {
	var nombre = $('#span_grupo_' + qwert).text();
	var contenido = '<div class="form-group has-warning" style="margin-bottom: 2px;"><input  type="text" class="form-control input-sm" id="link_grupo_ed_'
			+ qwert
			+ '" value="'
			+ nombre
			+ '" required autofocus><br><button onclick="aceptarGrupo('
			+ qwert
			+ ')" type="button" class="btn btn-success btn-xs">Aceptar</button>&nbsp<button onclick="cancelarEdicion('
			+ qwert
			+ ')" type="button" class="btn btn-default btn-xs">Cancelar</button></div>';

	$("#input_ed_" + qwert).show();
	$("#label_" + qwert).hide();
	$("#input_ed_" + qwert).html(contenido);
}

function cancelarEdicion(qwert) {
	var nombre = $('#link_grado_ed_' + qwert).val();
	$('#span_grupo_' + qwert).text(nombre);
	$("#input_ed_" + qwert).hide();
	$("#label_" + qwert).show();
}

function aceptarGrupo(qwert) {
	var nombre = $('#link_grupo_ed_' + qwert).val();
	$.ajax(
			{
				url : "php/grupos.php?updateGrupo=true&qwert=" + qwert
						+ "&nombre=" + nombre,
				dataType : 'json',

			}).done(function(data) {
		if (data.id == '-1') {
			muestraAlerta('.alerta');
		} else {
			location.reload();
		}
	});
}

function eliminarGrupo(qwert) {
	var nombre = $('#span_grupo_' + qwert).text();
	var respuesta = confirm("Desea Eliminar el Grupo " + nombre);
	if (respuesta) {
		var contenido = "";
		$.ajax({
			url : "php/grupos.php?delGrupo=true&qwert=" + qwert,
			dataType : 'json',

		}).done(function(data) {
			if (data) {
				$("#tgrupo_" + qwert).remove();
			}
		});
	}
}
function muestraAlerta(capa) {
	$(capa)
			.html(
					'<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>El nombre del grupo ya esta registrado, por favor escribe otro</div>')
			.show();
	setTimeout(function() {
		$(capa).fadeOut();
	}, 3000);
}
$(document)
		.ready(
				function() {

					getNivelesGrados();

					$('#buscar_grupo.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable_buscar_grupo tr').hide();
						$('.searchable_buscar_grupo tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});

					function getNivelesGrados() {
						var contenido = "";

								$
										.ajax({
											url : "php/niveles.php?getNivelesGrados=true",
											dataType : 'json',
										}),
								done(function(data) {

									$
											.each(
													data,
													function(i, nivelgrado) {
														var n = i + 1;
														contenido += '<tr id="tnivelgrado_'
																+ nivelgrado.id_nivel
																+ '-'
																+ nivelgrado.id_grado
																+ '"><td style="width:600px;">'
																+ nivelgrado.nombre_nivel
																+ '</td><td style="width:300px;">'
																+ nivelgrado.nombre_grado
																+ '</td><td align="center" style="width:300px;"><center><button style="cursor:pointer;" onclick="verGrupo('
																+ nivelgrado.id_nivel
																+ ', '
																+ nivelgrado.id_grado
																+ ',\''
																+ nivelgrado.nombre_nivel
																+ '\' ,\''
																+ nivelgrado.nombre_grado
																+ '\')" type="button" class="btn btn-info" data-toggle="modal" data-target="#verGrupo"><span class="glyphicon glyphicon-eye-open"></span> Ver Grupos </button></center></td></tr>';

													});

									$('#niveles_table > tbody').append(
											contenido);

								});

					}

				});