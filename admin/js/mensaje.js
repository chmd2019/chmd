var gruposUsuario = [];

function eliminarMensaje(qwert, asunto) {
	var respuesta = confirm("Desea eliminar el mensaje con asunto: \n\n"
			+ asunto
			+ "\n\nEl mensaje se enviará a la lista de Mensajes Borrados");
	if (respuesta) {
		var contenido = "";
		$.ajax({
			url : "php/mensajes.php?delMensaje=true&qwert=" + qwert,
			dataType : 'json',
			success : function(data) {
				if (data) {
					$("#tmensaje_" + qwert).remove();
				}

			}/* Success */
		});
	}
}

function validarMensaje() {
	$("#loader").slideDown("show");
	if (!$('#todosPadres').is(':checked')) {
		if ($('#grupos_table tr').length <= 1) {
			$("#loader").hide();
			alert("Agrega al menos un Nivel o Grupo Personalizado por favor")
			return false;
		}
	}
}

function cambiaDetalle(qwert) {
	var paginaDetalle = "DetalleMensaje.php?qwerty=" + qwert;
	document.location.href = paginaDetalle;
}

function eliminarUsuario(qwert, nombre_usuario, correo_usuario) {
	var respuesta = confirm("Desea Eliminar el usuario " + nombre_usuario);
	if (respuesta) {
		var contenido = "";
		$.ajax({
			url : "php/usuarios.php?delUsuario=true&qwert=" + qwert,
			dataType : 'json',
			success : function(data) {
				if (data) {
					$("#tusuario_" + qwert).remove();
				}

			}/* Success */
		});
	}
}

function guardarUsuario() {
	var nombre_usuario = $("#nombre_usuario").val();
	var correo_usuario = $("#correo").val();

	if (nombre_usuario == "" || correo_usuario == "") {
		alert("Escriba un nombre de usaurio y/o correo electrónico");
		return false;
	} else if (nombre_usuario != "" && correo_usuario != "") {
		var parametros = "&nombre_usuario=" + nombre_usuario
				+ "&correo_usuario=" + correo_usuario;
		$
				.ajax({
					url : "php/usuarios.php?insertUsuario=true" + parametros,
					dataType : 'json',
					success : function(data) {
						var id_usuario = data.id;
						var contenido = '';
						contenido += '<tr id="tusuario_'
								+ id_usuario
								+ '">'
								+ '<td style="width:600px;">'
								+ nombre_usuario
								+ '</td>'
								+ '<td style="width:300px;">'
								+ correo_usuario
								+ '</td>'
								+ '<td align="center" style="width:300px;">'
								+ '<center>'
								+ '<button style="cursor:pointer;" onclick="editarUsuario('
								+ id_usuario
								+ ', \''
								+ nombre_usuario
								+ '\',\''
								+ correo_usuario
								+ '\')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarNivel">'
								+ '<span class="glyphicon glyphicon-pencil"></span> Editar'
								+ '</button>'
								+ '<button style="cursor:pointer;" onclick="eliminarUsuario('
								+ id_usuario
								+ ', \''
								+ nombre_usuario
								+ '\',\''
								+ correo_usuario
								+ '\')" type="button" class="btn btn-danger">'
								+ '<span class="glyphicon glyphicon-trash"></span> Eliminar'
								+ '</button>' + '</center>' + '</td>' + '</tr>';

						$
								.each(
										gruposUsuario,
										function(i, grupousuario) {
											var param = "&id_nivel="
													+ grupousuario.id_nivel
													+ "&id_grado="
													+ grupousuario.id_grado
													+ "&id_grupo="
													+ grupousuario.id_grupo
													+ "&id_usuario="
													+ id_usuario;
											$
													.ajax({
														url : "php/usuarios.php?insertGrupoUsuario=true"
																+ param,
														dataType : 'json',
														success : function(data) {

														}/* Success */
													});

										});
						$('#usuarios_table > tbody').append(contenido);

					}/* Success */
				});
	}
}
var haygradosgrupos = true;
function agregarGrupoUsuario() {
	// console.log(gruposUsuario);
	var contenido = "";

	var id_nivel = $("#niveles_select option:selected").val();
	var id_grado = $("#grados_select option:selected").val();
	var id_grupo = $("#grupos_select option:selected").val();
	if (id_nivel != 0 && haygradosgrupos) {
		$('#destinatarios').show();
		var nombre_nivel = $("#niveles_select option:selected").text();
		var nombre_grado = $("#grados_select option:selected").text();
		var nombre_grupo = $("#grupos_select option:selected").text();
		var esta = false;
		$.each(gruposUsuario, function(i, grupoUsuario) {
			if (grupoUsuario.id_nivel == id_nivel
					&& grupoUsuario.id_grado == id_grado
					&& grupoUsuario.id_grupo == id_grupo) {
				esta = true;
			}

		});

		if (!esta) {
			if (id_grado == "0" || id_grado == undefined) {
				nombre_grado = "TODOS";
				id_grado = "0";
			}
			if (id_grupo == "0" || id_grupo == undefined) {
				nombre_grupo = "TODOS";
				id_grupo = "0";
			}
			contenido += '<tr id="tgrupousuario_'
					+ id_nivel
					+ "_"
					+ id_grado
					+ "_"
					+ id_grupo
					+ '">'
					+ '<td style="width:330px;">'
					+ '<input name="nivel[]" id="nivel[]" type="text" class="form-control" value="'
					+ id_nivel
					+ '" style="display:none;">'
					+ '<span>'
					+ nombre_nivel
					+ '</span>'
					+ '</td>'
					+ '<td style="width:330px;">'
					+ '<input name="grado[]" id="grado[]" type="text" class="form-control" value="'
					+ id_grado
					+ '" style="display:none;">'
					+ '<span>'
					+ nombre_grado
					+ '</span>'
					+ '</td>'
					+ '<td style="width:330px;">'
					+ '<input name="grupo[]" id="grupo[]" type="text" class="form-control" value="'
					+ id_grupo
					+ '" style="display:none;">'
					+ '<span>'
					+ nombre_grupo
					+ '</span>'
					+ '</td>'
					+ '<td align="center" style="width:150px;">'
					+ '<center>'
					+ '<button style="cursor:pointer;" onclick="eliminarGrupoUsuario('
					+ id_nivel + ',' + id_grado + ',' + id_grupo
					+ ')" type="button" class="btn btn-danger">'
					+ '<span class="glyphicon glyphicon-trash"></span>'
					+ '</button>' + '</center>' + '</td>' + '</tr>';
			$('#grupos_table > tbody').append(contenido);
			$("#niveles_select").val(0);
			$("#grados_select").val(0);
			$("#grupos_select").val(0);
			var divGradosControl = document.getElementById("grados_control");
			var divGruposControl = document.getElementById("grupos_control");
			divGradosControl.style.display = "none";
			divGruposControl.style.display = "none";
			gruposUsuario.push({
				"id_nivel" : id_nivel,
				"id_grado" : id_grado,
				"id_grupo" : id_grupo
			});
			// console.log(gruposUsuario);

		} else {
			alert("Ya añadiste este grupo, selecciona otro");
		}
	} else if (id_nivel == 0) {
		alert("Selecciona al menos un nivel");
	} else if (!haygradosgrupos) {
		alert("No podemos insertar este Destinatario. Selecciona otro por favor");
	}
}

function agregarGrupoPerso() {
	// console.log(gruposUsuario);
	var contenido = "";

	var id_nivel = 0// $("#niveles_select option:selected").val();
	var id_grado = 0// $("#grados_select option:selected").val();
	// var id_grupo = 0//$("#grupos_select option:selected").val();
	var id_grupo_perso = $("#grupos_perso_select option:selected").val();
	if (id_grupo_perso != 0 && haygradosgrupos) {
		$('#destinatarios').show();
		var nombre_nivel = ""// $("#niveles_select option:selected").text();
		var nombre_grado = ""// $("#grados_select option:selected").text();
		var nombre_grupo = $("#grupos_perso_select option:selected").text();
		var esta = false;
		$.each(gruposUsuario, function(i, grupoUsuario) {
			if (grupoUsuario.id_nivel == id_nivel
					&& grupoUsuario.id_grado == id_grado
					&& grupoUsuario.id_grupo == id_grupo_perso) {
				esta = true;
			}
		});

		if (!esta) {
			if (id_nivel == "0" || id_nivel == undefined) {
				nombre_nivel = "Grupo Personalizado";
				id_nivel = "0";
			}
			if (id_grado == "0" || id_grado == undefined) {
				nombre_grado = "Grupo Personalizado";
				id_grado = "0";
			}
			if (id_grupo_perso == "0" || id_grupo_perso == undefined) {
				nombre_grupo = "Grupo Personalizado";
				id_grupo_perso = "0";
			}
			contenido += '<tr id="tgrupousuario_'
					+ id_nivel
					+ "_"
					+ id_grado
					+ "_"
					+ id_grupo_perso
					+ '">'
					+ '<td style="width:330px;">'
					+ '<input name="nivel[]" id="nivel[]" type="text" class="form-control" value="'
					+ id_nivel
					+ '" style="display:none;">'
					+ '<span>'
					+ nombre_nivel
					+ '</span>'
					+ '</td>'
					+ '<td style="width:330px;">'
					+ '<input name="grado[]" id="grado[]" type="text" class="form-control" value="'
					+ id_grado
					+ '" style="display:none;">'
					+ '<span>'
					+ nombre_grado
					+ '</span>'
					+ '</td>'
					+ '<td style="width:330px;">'
					+ '<input name="grupo[]" id="grupo[]" type="text" class="form-control" value="'
					+ id_grupo_perso
					+ '" style="display:none;">'
					+ '<span>'
					+ nombre_grupo
					+ '</span>'
					+ '</td>'
					+ '<td align="center" style="width:150px;">'
					+ '<center>'
					+ '<button style="cursor:pointer;" onclick="eliminarGrupoUsuario('
					+ id_nivel + ',' + id_grado + ',' + id_grupo_perso
					+ ')" type="button" class="btn btn-danger">'
					+ '<span class="glyphicon glyphicon-trash"></span>'
					+ '</button>' + '</center>' + '</td>' + '</tr>';
			$('#grupos_table > tbody').append(contenido);
			$("#grupos_perso_select").val(0);
			gruposUsuario.push({
				"id_nivel" : id_nivel,
				"id_grado" : id_grado,
				"id_grupo" : id_grupo_perso
			});
			// console.log(gruposUsuario);
		} else {
			alert("Ya añadiste este Grupo Personalizado, selecciona otro e intenta de nuevo");
		}
	} else if (id_grupo_perso == 0) {
		alert("Selecciona al menos un Grupo Personalizado");
	} else if (!haygradosgrupos) {
		alert("No podemos insertar este Destinatario. Selecciona otro por favor");
	}
}

function eliminarGrupoUsuario(id_nivel, id_grado, id_grupo) {

	$.each(gruposUsuario, function(i, grupoUsuario) {
		console.log(grupoUsuario);
		if (grupoUsuario.id_nivel == id_nivel
				&& grupoUsuario.id_grado == id_grado
				&& grupoUsuario.id_grupo == id_grupo) {
			console.log("IF: ");
			console.log(grupoUsuario);
			gruposUsuario.splice(i, 1);
			$("#tgrupousuario_" + id_nivel + "_" + id_grado + "_" + id_grupo)
					.remove();
			// console.log(gruposUsuario);
		}

	});

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
						contenido += '<div class="alert alert-warning alert-dismissable">'
								+ '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
								+ '<h4>¡Verificar!</h4>'
								+ 'No existen grupos registrados' + '</div>';

					} else if (data.length > 0) {
						haygradosgrupos = true;
						contenido += '<select class="form-control" id="grupos_select" name="grupos_select" >';
						contenido += '<option value="0">::Seleccione Grupo</option>';
						$.each(data, function(i, grupo) {
							contenido += '<option value="' + grupo.id + '">'
									+ grupo.nombre + '</option>';

						});
						contenido += '</select>';

					}
					$('#grupos_control').html(contenido);
					$("#grupos_control").show();

				}/* Success */
			});

}

$(document)
		.ready(
				function() {
					getMensajes();
					getMensajesBorrados();
					getNivel();
					getGrupoSelect();

					// $('#todosPadres').change(function() {
					// if ($(this).is(":checked")) {
					// $("#niveles_select").val(0);
					// $("#grupos_perso_select").val(0);
					// $("#niveles_control").hide();
					// $("#grados_control").hide();
					// $("#grupos_control").hide();
					// $("#grupos_perso_control").hide();
					// $("#btnagregar_control").hide();
					// $("#btnagregar_control_perso").hide();
					// $("#destinatarios").hide();
					//
					// } else {
					// $("#niveles_select").val(0);
					// $("#niveles_control").show();
					// $("#btnagregar_control").show();
					// $("#grupos_perso_select").val(0);
					// $("#grupos_perso_control").show();
					// $("#btnagregar_control_perso").show();
					// }
					//
					// });

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
																contenido += '<div class="alert alert-warning alert-dismissable">'
																		+ '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
																		+ '<h4>¡Verificar!</h4>'
																		+ 'No existen grados registrados'
																		+ '</div>';
															} else if (data.length > 0) {
																haygradosgrupos = true;
																contenido += '<select class="form-control" id="grados_select" name="grados_select" onchange="getGrupos();">';
																contenido += '<option value="0">::Seleccione Grado</option>';
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
																			contenido);
															$("#grados_control")
																	.show();
															$("#grupos_select")
																	.val(0);
															$("#grupos_control")
																	.hide();

														}/* Success */
													});
										}

									});

					$('#buscar_mensaje.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable tr').hide();
						$('.searchable tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});
					$('#buscar_mensaje_borrado.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable tr').hide();
						$('.searchable tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});

					$('#buscar_dest.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable_dest tr').hide();
						$('.searchable_dest tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});

					function getNivel() {
						var contenido = "";
						$
								.ajax({
									url : "php/niveles.php?getNiveles=true",
									dataType : 'json',
									success : function(data) {
										contenido += '<option value="0">::Seleccione Nivel</option>';
										$.each(data, function(i, nivel) {

											contenido += '<option value="'
													+ nivel.id + '">'
													+ nivel.nombre
													+ '</option>';

										});
										$('#niveles_select').append(contenido);
									}/* Success */
								});

					}

					function getGrupoSelect() {
						var contenido = "";
						$
								.ajax({
									url : "php/niveles.php?getGruposPersonalizados=true",
									dataType : 'json',
									success : function(data) {
										contenido += '<option value="0">::Seleccione Grupo Personalizado</option>';
										$.each(data, function(i, grupo_perso) {

											contenido += '<option value="'
													+ grupo_perso.id + '">'
													+ grupo_perso.nombre
													+ '</option>';

										});
										$('#grupos_perso_select').append(
												contenido);
									}/* Success */
								});

					}

					function getMensajes() {
						var contenido = "";
						$
								.ajax({
									url : "php/mensajes.php?getMensajes=true",
									dataType : 'json',
									success : function(data) {
										contenido += '';
										$
												.each(
														data,
														function(i, mensaje) {
															if (mensaje.urgente == '1') {
																contenido += '<tr class="danger" id="tmensaje_'
																		+ mensaje.id
																		+ '"> <td style="width:600px;">'
																		+ mensaje.asunto
																		+ '</td> <td style="width:300px;">URGENTE</td> <td style="width:300px;">'
																		+ mensaje.fecha
																		+ '</td> <td align="center" style="width:300px;"> <center> <button onclick="cambiaDetalle('
																		+ mensaje.id
																		+ ')" style="cursor:pointer;" type="button" class="btn btn-info" data-toggle="modal" data-target="#verMensaje"> <span class="glyphicon glyphicon-eye-open"></span> Ver Mensaje </button> <button style="cursor:pointer;" onclick="eliminarMensaje('
																		+ mensaje.id
																		+ ', \''
																		+ mensaje.asunto
																		+ '\')" type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> </button> </center> </td> </tr>';
															} else {
																contenido += '<tr id="tmensaje_'
																		+ mensaje.id
																		+ '"> <td style="width:600px;">'
																		+ mensaje.asunto
																		+ '</td> <td style="width:300px;">NO-URGENTE</td> <td style="width:300px;">'
																		+ mensaje.fecha
																		+ '</td> <td align="center" style="width:300px;"> <center> <button onclick="cambiaDetalle('
																		+ mensaje.id
																		+ ')" style="cursor:pointer;" type="button" class="btn btn-info" data-toggle="modal" data-target="#verMensaje"> <span class="glyphicon glyphicon-eye-open"></span> Ver Mensaje </button> <button style="cursor:pointer;" onclick="eliminarMensaje('
																		+ mensaje.id
																		+ ', \''
																		+ mensaje.asunto
																		+ '\')" type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span> </button> </center> </td> </tr>';
															}

														});
										$('#mensajes_table').append(contenido);
									}/* Success */
								});

					}

					function getMensajesBorrados() {
						var contenido = "";
						$
								.ajax({
									url : "php/mensajes.php?getMensajesBorrados=true",
									dataType : 'json',
									success : function(data) {
										contenido += '';
										$
												.each(
														data,
														function(i, mensaje) {
															if (mensaje.urgente == '1') {
																contenido += '<tr class="danger" id="tmensaje_'
																		+ mensaje.id
																		+ '">'
																		+ '<td style="width:600px;">'
																		+ mensaje.asunto
																		+ '</td>'
																		+ '<td style="width:300px;">URGENTE</td>'
																		+ '<td style="width:300px;">'
																		+ mensaje.fecha
																		+ '</td>'
																		+ '<td align="center" style="width:300px;">'
																		+ '<center>'
																		+

																		'<button style="cursor:pointer;" onclick="eliminarMensaje('
																		+ mensaje.id
																		+ ', \''
																		+ mensaje.asunto
																		+ '\')" type="button" class="btn btn-danger">'
																		+ '<span class="glyphicon glyphicon-trash"></span>'
																		+ '</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
																		+ '</center>'
																		+ '</td>'
																		+ '</tr>';
															} else {
																contenido += '<tr id="tmensaje_'
																		+ mensaje.id
																		+ '">'
																		+ '<td style="width:600px;">'
																		+ mensaje.asunto
																		+ '</td>'
																		+ '<td style="width:300px;">NO-URGENTE</td>'
																		+ '<td style="width:300px;">'
																		+ mensaje.fecha
																		+ '</td>'
																		+ '<td align="center" style="width:300px;">'
																		+ '<center>'
																		+ '<button style="cursor:pointer;" onclick="eliminarMensaje('
																		+ mensaje.id
																		+ ', \''
																		+ mensaje.asunto
																		+ '\')" type="button" class="btn btn-danger">'
																		+ '<span class="glyphicon glyphicon-trash"></span>'
																		+ '</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
																		+ '</center>'
																		+ '</td>'
																		+ '</tr>';
															}

														});
										$('#mensajes_borrados_table').append(
												contenido);
									}/* Success */
								});

					}

				});