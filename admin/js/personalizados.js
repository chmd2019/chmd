function agregarGrupoUsuario() {
	var id_nivel = $("#niveles_select").val();
	var id_grado = $("#grados_select").val();
	var id_grupo = $("#grupos_select").val();
	var padres = $("#padres_select").val();

	var id_grupo_personalizado = $("#id_grupo").val();

	if (padres == 0) {
		alert("Seleccione un Padre");

	} else if (padres > 0) {
		var contenido = "";
		var param = "&id_nivel=" + id_nivel + "&id_grado=" + id_grado
				+ "&id_grupo=" + id_grupo + "&id_usuario=" + padres
				+ "&id_grupo_personalizado=" + id_grupo_personalizado;
		$.ajax({
			url : "php/personalizados.php?insertGrupoUsuario=true" + param,
			dataType : 'json',
			success : function(data) {
				location.reload();
			}
		});

	}
}
function addUsuarioPersonalizado(id_u, qwert) {
	var contenido = "";
	$.ajax({
		url : "php/usuarios.php?insertGrupoUsuario=true&qwert=" + qwert
				+ "&id_usuario=" + id_u,
		dataType : 'json',
		success : function(data) {

			if (data) {
				alert("Exito");
			}
		}
	});
}

function editarGrupoPerso(qwert) {
	var nombre = $('#span_grado_' + qwert).text();
	var contenido = '<div class="form-group has-warning" style="margin-bottom: 2px;"> <input  type="text" class="form-control input-sm" id="link_grado_ed_'
			+ qwert
			+ '" value="'
			+ nombre
			+ '" required autofocus> <br><button onclick="aceptarGrupoPerso('
			+ qwert
			+ ')" type="button" class="btn btn-success btn-xs">Aceptar</button> <button onclick="cancelarEdicion('
			+ qwert
			+ ')" type="button" class="btn btn-default btn-xs">Cancelar</button> </div>';

	$("#input_ed_" + qwert).show();
	$("#label_" + qwert).hide();
	$("#input_ed_" + qwert).html(contenido);
}

function cancelarEdicion(qwert) {
	var nombre = $('#link_grado_ed_' + qwert).val();
	$('#span_grado_' + qwert).text(nombre);
	$("#input_ed_" + qwert).hide();
	$("#label_" + qwert).show();
}

function eliminarUsuario(id_grupo_per, qwert, nombre_usuario, nivel, grado,
		grupo) {
	var id_nivel = nivel;
	var id_grado = grado;
	var id_grupo = grupo;
	var respuesta = confirm("Desea Eliminar el usuario " + nombre_usuario);

	if (respuesta) {
		var contenido = "";
		$.ajax({
			url : "php/usuarios.php?delUsuarioGrupo=true&qwert=" + qwert
					+ "&id_nivel=" + id_nivel + "&id_grado=" + id_grado
					+ "&id_grupo=" + id_grupo + "&id_pers=" + id_grupo_per,
			dataType : 'json',
			success : function(data) {
				if (data) {
					location.reload();
				}

			}/* Success */
		});
	}
}
function eliminarUsuarioPers(id_grupo_per, qwert, nombre_usuario, nivel, grado,
		grupo) {
	var id_nivel = nivel;
	var id_grado = grado;
	var id_grupo = grupo;

	var respuesta = confirm("Desea Eliminar el usuario " + nombre_usuario);
	if (respuesta) {
		var contenido = "";
		$.ajax({
			url : "php/usuarios.php?delUsuarioGrupoPers=true&qwert=" + qwert
					+ "&id_nivel=" + id_nivel + "&id_grado=" + id_grado
					+ "&id_grupo=" + id_grupo + "&id_pers=" + id_grupo_per,
			dataType : 'json',
			success : function(data) {
				if (data) {
					location.reload();
				}

			}/* Success */
		});
	}
}

function aceptarGrupoPerso(qwert) {
	var nombre = $('#link_grado_ed_' + qwert).val();
	$
			.ajax(
					{
						url : "php/personalizados.php?updateGrupoPerso=true&qwert="
								+ qwert + "&nombre=" + nombre,
						dataType : 'json',

					})
			.done(
					function(data) {
						if (data.existe == '1') {
							$('.grado-alert')
									.hide()
									.html(
											'			<div role="alert" class="alert alert-danger alert-dismissible">				<button data-dismiss="alert" class="close" type="button">					<span aria-hidden="true">×</span><span class="sr-only">Close</span>				</button>				El nombre del grado ya esta registrado, por favor escribe otro			</div>')
									.fadeIn();
							setTimeout(function() {
								$('.grado-alert').fadeOut();
							}, 5000);
						} else {
							location.reload();
						}
					});
}

function eliminarGrupoPerso(qwert, nombre) {
	var respuesta = confirm("Desea Eliminar el Grupo Personalizado: " + nombre);
	if (respuesta) {
		var contenido = "";
		$.ajax({
			url : "php/personalizados.php?EliminarGrupoPerso=true&qwert="
					+ qwert,
			dataType : 'json',
			success : function(data) {
				if (data) {
					$("#tperso_" + qwert).remove();
				}

			}/* Success */
		});
	}
}

function getGrupos() {
	var contenido = "";
	var id_nivel = $("#niveles_select").val();
	var id_grado = $("#grados_select").val();

	$
			.ajax({
				url : "php/grupos.php?getGrupos=true&qwert_nivel=" + id_nivel
						+ "&qwert_grado=" + id_grado,
				dataType : 'json',
				success : function(data) {
					if (data.length == 0) {
						haygradosgrupos = false;
						contenido += '<div class="alert alert-warning alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4>¡Verificar!</h4> No existen grupos registrados'
								+ '</div>';

					} else if (data.length > 0) {
						haygradosgrupos = true;
						contenido += '<select class="form-control" id="grupos_select" name="grupos_select" onchange="getPadres();"> <option value="0">::Seleccione Grupo</option>';
						$.each(data, function(i, grupo) {
							contenido += '<option value="' + grupo.id + '">'
									+ grupo.nombre + '</option>';

						});
						contenido += '</select>';

					}
					$('#grupos_control').html(contenido).show();
				}/* Success */
			});

}

function getPadres() {
	var contenido = "";
	var id_nivel = $("#niveles_select").val();
	var id_grado = $("#grados_select").val();
	var id_grupo = $("#grupos_select").val();

	$
			.ajax({
				url : "php/usuarios.php?getPadresGrupos=true&qwert_nivel="
						+ id_nivel + "&qwert_grado=" + id_grado
						+ "&qwert_grupo=" + id_grupo,
				dataType : 'json',
				success : function(data) {
					if (data.length == 0) {
						haygradosgrupos = false;
						contenido += '<div class="alert alert-warning alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4>¡Verificar!</h4> No existen padres asignados </div>';
					} else if (data.length > 0) {
						haygradosgrupos = true;
						contenido += '<select class="form-control" id="padres_select" name="padres_select" onchange="btn_agregarPadres();"><option value="0">::Seleccione Padres</option>';
						$.each(data, function(i, padre) {
							contenido += '<option value="' + padre.id + '">'
									+ padre.nombre + '</option>';

						});
						contenido += '</select>';

					}
					$('#padres_control').html(contenido).show();
					// $('#btnagregar_control').show();

				}/* Success */
			});

}

function btn_agregarPadres() {
	// body...
	var contenido = "";
	var id_padre = $("#padres_select").val();
	if (id_padre <= 0) {
		contenido += '<div class="alert alert-warning alert-dismissable">'
				+ '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
				+ '<h4>¡Verificar!</h4>' + 'Seleccione un padre por favor'
				+ '</div>';
		$('#btnagregar_control').html(contenido);
	} else if (id_padre > 0) {
		contenido += '<br><button type="button" class="btn btn-primary" name="agregar" onclick="agregarGrupoUsuario()" >Agregar</button>'
		$('#btnagregar_control').html(contenido);
		$('#btnagregar_control').show();
	}

}

function limpiarCampos() {
	$("#niveles_select").val(0);
	$("#grados_select").val(0);
	$('#grados_control').hide();
	$("#grupos_select").val(0);
	$('#grupos_control').hide();
	$("#padres_select").val(0);
	$('#padres_control').hide();
	$('#btnagregar_control').hide();
}

$(document)
		.ready(
				function() {
					getGruposPersonalizados();
					getTodosUsuariosPersonalizados();
					$('input.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable tr').hide();
						$('.searchable tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});
					$('.alert-add').hide();
					$('.form-add')
							.submit(
									function(e) {
										e.preventDefault();
										var datos;
										datos = $('.form-add').serializeArray();
										datos.push({
											name : 'guardar',
											value : 'TRUE'
										});
										console.log(datos);
										$
												.ajax({
													type : 'POST',
													data : datos
												})
												.done(
														function(data) {
															if (data.existe == '1') {
																$('.alert-add')
																		.html(
																				'<div class="alert alert-warning alert-dismissible"					role="alert">					<button type="button" class="close" data-dismiss="alert">						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>					</button>					El nombre del grupo ya esta registrado, por favor escribe otro				</div>')
																		.fadeIn();
															} else {
																location
																		.reload();
															}
														});
									})

					function getGruposPersonalizados() {
						var contenido = "";
						$
								.ajax({
									url : "php/personalizados.php?getGruposPersonalizados=true",
									dataType : 'json',
									success : function(data) {
										$
												.each(
														data,
														function(i, perso) {
															var n = i + 1;
															contenido += '<tr id="tperso_'
																	+ perso.id
																	+ '"> <td style="width:800px;"><div style="display:none" id="input_ed_'
																	+ perso.id
																	+ '"> </div> <div id="label_'
																	+ perso.id
																	+ '"> <span id="span_grado_'
																	+ perso.id
																	+ '">'
																	+ perso.nombre
																	+ '</span> </div></td> <td align="center" style="width:400px;"> <center> <button style="cursor:pointer;" onclick="editarGrupoPerso('
																	+ perso.id
																	+ ')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarNivel"> <span class="glyphicon glyphicon-pencil"></span> </button> <button style="cursor:pointer;" onclick="eliminarGrupoPerso('
																	+ perso.id
																	+ ', \''
																	+ perso.nombre
																	+ '\')" type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> </button> <a style="cursor:pointer;" href="usuarios_grupos_personalizados.php?qwert='
																	+ perso.id
																	+ '&nombre='
																	+ perso.nombre
																	+ '" type="button" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Ver o Agregar Padres </a></center></td></tr>';

														});
										$('#grupos_table > tbody').append(
												contenido);
									}/* Success */
								});

					}

					function getTodosUsuariosPersonalizados() {
						var contenido = "";

						var id_grupo_personalizado = $("#id_grupo").val();

						$
								.ajax({
									url : "php/personalizados.php?getTodosUsuarios=true",
									dataType : 'json',
									success : function(data) {
										$
												.each(
														data,
														function(i, perso) {
															var n = i + 1;
															contenido += '<tr id="tperso_'
																	+ perso.id
																	+ '"> <td style="width:800px;"><div style="display:none" id="input_ed_'
																	+ perso.id
																	+ '"> </div> <div id="label_'
																	+ perso.id
																	+ '"> <span id="span_grado_'
																	+ perso.id
																	+ '">'
																	+ perso.nombre
																	+ '</span> </div></td> <td align="center" style="width:400px;"> <center> <button style="cursor:pointer;" onclick="addUsuarioPersonalizado('
																	+ perso.id
																	+ ', '
																	+ id_grupo_personalizado
																	+ ')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarNivel"> <span class="glyphicon glyphicon-plus"></span> </button> </center> </td> </tr>';

														});
										$('#usuarios-table > tbody').append(
												contenido);
									}/* Success */
								});

					}

					$('#niveles_select')
							.on(
									'change',
									function() {
										var contenido = "";
										var id_nivel = this.value;
										if (id_nivel == 0) {
											$("#grados_control").hide();
											$("#grupos_control").hide();
										} else {
											$
													.ajax({
														url : "php/grados.php?getGrados=true&qwert="
																+ id_nivel,
														dataType : 'json',
														success : function(data) {
															if (data.length == 0) {
																haygradosgrupos = false;
																contenido += '<div class="alert alert-warning alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4>¡Verificar!</h4> No existen grados registrados </div>';
															} else if (data.length > 0) {
																haygradosgrupos = true;
																contenido += '<select class="form-control" id="grados_select" name="grados_select" onchange="getGrupos();"> <option value="0">::Seleccione Grado</option>';
																$
																		.each(
																				data,
																				function(
																						i,
																						grado) {
																					contenido += '<option value="'
																							+ grado.id
																							+ '">'
																							+ grado.nombre
																							+ '</option>';

																				});
																contenido += '</select>';
															}

															$('#grados_control')
																	.html(
																			contenido)
																	.show()
																	.hide();
															$("#grupos_select")
																	.val(0);
														}/* Success */
													});
										}

									});

				});