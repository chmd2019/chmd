var gruposUsuario = [];

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

function editarUsuario(qwert, nombre_usuario, correo_usuario) {
	// var respuesta = confirm("Desea Eliminar el usuario "+nombre_usuario);
	var contenido = "";
	$.ajax({
		url : "php/usuarios.php?buscaUsuario=true&qwert=" + qwert,
		dataType : 'json',
		success : function(data) {
			getGruposUsuario(qwert);
			$.each(data, function(i, usuario_edicion) {
				var nombre_texto = document
						.getElementById("nombre_usuario_edit");
				var correo_texto = document.getElementById("correo_edit");
				var id_texto = document.getElementById("id_edit");
				nombre_texto.value = usuario_edicion.nombre;
				correo_texto.value = usuario_edicion.correo;
				id_texto.value = qwert;
			});
		}/* Success */
	});
}

function getUsuarios() {
	var contenido = "";
	$
			.ajax({
				url : "php/usuarios.php?getUsuarios=true",
				dataType : 'json',
				success : function(data) {

					$
							.each(
									data,
									function(i, usuario) {
										var n = i + 1;
										contenido += '<tr id="tusuario_'
												+ usuario.id
												+ '">'
												+ '<td style="width:600px;">'
												+ usuario.nombre
												+ '</td>'
												+ '<td style="width:300px;">'
												+ usuario.correo
												+ '</td>'
												+ '<td align="center" style="width:300px;">'
												+ '<center>'
												+ '<button style="cursor:pointer;" onclick="editarUsuario('
												+ usuario.id
												+ ', \''
												+ usuario.nombre
												+ '\',\''
												+ usuario.correo
												+ '\')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#actualiza_Usuario">'
												+ '<span class="glyphicon glyphicon-pencil"></span>'
												+ '</button>'
												+ '<button style="cursor:pointer;" onclick="eliminarUsuario('
												+ usuario.id
												+ ', \''
												+ usuario.nombre
												+ '\',\''
												+ usuario.correo
												+ '\')" type="button" class="btn btn-danger">'
												+ '<span class="glyphicon glyphicon-trash"></span>'
												+ '</button>' + '</center>'
												+ '</td>' + '</tr>';

									});
					$('#usuarios_table > tbody').html(contenido);
				}/* Success */
			});

}

function actualizarUsuario() {
	var nombre_usuario = $("#nombre_usuario_edit").val();
	var correo_usuario = $("#correo_edit").val();
	var id_usuario = $("#id_edit").val();
	var emailreg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

	if (nombre_usuario == "" || correo_usuario == ""
			|| !emailreg.test(correo_usuario)) {
		alert("Escriba el nombre del Padre y/o Correo electrónico válido");
		return false;
	} else if (nombre_usuario != "" && correo_usuario != ""
			&& emailreg.test(correo_usuario)) {
		var parametros = "&qwert=" + id_usuario + "&nombre_usuario="
				+ nombre_usuario + "&correo_usuario=" + correo_usuario;
		$.ajax({
			url : "php/usuarios.php?updateUsuario=true" + parametros,
			dataType : 'json',
			success : function(data) {
				$.each(gruposUsuario, function(i, grupousuario) {
					var param = "&id_nivel=" + grupousuario.id_nivel
							+ "&id_grado=" + grupousuario.id_grado
							+ "&id_grupo=" + grupousuario.id_grupo
							+ "&id_usuario=" + id_usuario + "&nombre_hijo="
							+ grupousuario.nombre_hijo;
					$.ajax({
						url : "php/usuarios.php?insertGrupoUsuario=true"
								+ param,
						dataType : 'json',
						success : function(data) {

						}/* Success */
					});

				});
				getUsuarios();
			}/* Success */
		});
	}
}

function guardarUsuario() {
	var nombre_usuario = $("#nombre_usuario").val();
	var nombre_hijo = $("#nombre_hijo").val();
	var correo_usuario = $("#correo").val();
	var funcion = $("#funcion").val(); // si es 1 ya existe el mail si es 0 no
	// existe
	var emailreg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

	if (nombre_usuario == "" || correo_usuario == ""
			|| !emailreg.test(correo_usuario) || funcion == "1") {
		alert("Escriba el nombre del Padre y/o Correo electrónico válido");
		return false;
	} else if (nombre_usuario != "" && correo_usuario != ""
			&& emailreg.test(correo_usuario) && funcion == "0") {
		var parametros = "&nombre_usuario=" + nombre_usuario
				+ "&correo_usuario=" + correo_usuario;
		$.ajax({
			url : "php/usuarios.php?insertUsuario=true" + parametros,
			dataType : 'json',
		}).done(
				function(data) {
					console.log(data);
					id_usuario = data.id;
					$.each(gruposUsuario, function(i, grupousuario) {
						var param = "&id_nivel=" + grupousuario.id_nivel
								+ "&id_grado=" + grupousuario.id_grado
								+ "&id_grupo=" + grupousuario.id_grupo
								+ "&id_usuario=" + id_usuario + "&nombre_hijo="
								+ grupousuario.nombre_hijo;
						$.ajax({
							url : "php/usuarios.php?insertGrupoUsuario=true"
									+ param,
							dataType : 'json',
						});

					});
					location.reload();
					// getUsuarios();

				});
	}
}

function cancelarUsuario() {
	var hasta = gruposUsuario.length;
	gruposUsuario.splice(0, hasta);
	$('#grupos_table_edit > tbody').html("");
}

function agregarGrupoUsuario() {
	// console.log(gruposUsuario);
	var contenido = "";
	$('#grupos_usuario').show();
	var id_nivel = $("#niveles_select option:selected").val();
	var id_grado = $("#grados_select option:selected").val();
	var id_grupo = $("#grupos_select option:selected").val();
	var nombre_nivel = $("#niveles_select option:selected").text();
	var nombre_grado = $("#grados_select option:selected").text();
	var nombre_grupo = $("#grupos_select option:selected").text();
	var nombre_hijo = $("#nombre_hijo").val();
	var esta = false;
	$.each(gruposUsuario, function(i, grupoUsuario) {
		if (grupoUsuario.id_nivel == id_nivel
				&& grupoUsuario.id_grado == id_grado
				&& grupoUsuario.id_grupo == id_grupo) {
			esta = true;
		}

	});

	if (!esta) {
		contenido += '<tr id="tgrupousuario_'
				+ id_grupo
				+ '">'
				+ '<td style="width:150px;">'
				+ nombre_hijo
				+ '</td>'
				+ '<td style="width:150px;">'
				+ nombre_nivel
				+ '</td>'
				+ '<td style="width:150px;">'
				+ nombre_grado
				+ '</td>'
				+ '<td style="width:150px;">'
				+ nombre_grupo
				+ '</td>'
				+ '<td align="center" style="width:150px;">'
				+ '<center>'
				+ '<button style="cursor:pointer;" onclick="eliminarGrupoUsuario('
				+ id_nivel + ',' + id_grado + ',' + id_grupo
				+ ')" type="button" class="btn btn-danger">'
				+ '<span class="glyphicon glyphicon-trash"></span>'
				+ '</button>' + '</center>' + '</td>' + '</tr>';
		$('#grupos_table > tbody').append(contenido);
		gruposUsuario.push({
			"id_nivel" : id_nivel,
			"id_grado" : id_grado,
			"id_grupo" : id_grupo,
			"nombre_hijo" : nombre_hijo
		});
		// console.log(gruposUsuario);

	} else {
		alert("Ya añadiste este grupo, selecciona otro");
	}

}

function eliminarGrupoUsuario(id_nivel, id_grado, id_grupo) {

	$.each(gruposUsuario, function(i, grupoUsuario) {
		if (grupoUsuario.id_nivel == id_nivel
				&& grupoUsuario.id_grado == id_grado
				&& grupoUsuario.id_grupo == id_grupo) {
			gruposUsuario.splice(i, 1);
			$("#tgrupousuario_" + id_grupo).remove();
			// console.log(gruposUsuario);
		}

	});

}

function mostrarBoton() {
	var contenido = "";
	var id_grupo = $("#grupos_select").val();
	if (id_grupo == 0) {
		$('#btnagregar_control').hide();
	} else {
		contenido += '<br><input name="nombre_hijo" id="nombre_hijo"  type="text"     class="form-control" placeholder="Nombre Hijo"    required >'
		contenido += '<br><button type="button" class="btn btn-primary" name="agregar" onclick="agregarGrupoUsuario()" >Agregar</button>';
		$('#btnagregar_control').html(contenido);
		$('#btnagregar_control').show();
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
					contenido += '<select class="form-control" id="grupos_select" onchange="mostrarBoton();">';
					contenido += '<option value="0">::Seleccione Grupo</option>';
					$.each(data, function(i, grupo) {
						contenido += '<option value="' + grupo.id + '">'
								+ grupo.nombre + '</option>';

					});
					contenido += '</select>';
					$('#grupos_control').html(contenido);
					$("#grupos_control").show();
					$('#btnagregar_control').hide();
				}/* Success */
			});

}

function limpiarCampos() {
	$("#nombre_usuario").val("");
	$("#correo").val("");
	$("#aviso").hide();
	$("#aviso2").hide();
	$("#niveles_select").val(0);
	$("#grados_control").hide();
	$("#grupos_control").hide();
	$('#btnagregar_control').hide();
	$("#grupos_usuario").hide();
	$('#grupos_table > tbody').html("");

}

/*---------Aqui empezamos con las funciones para la edicion de Usuario---------*/
function mostrarBotonEdit() {
	var contenido = "";
	var id_grupo = $("#grupos_select_edit").val();
	if (id_grupo == 0) {
		$('#btnagregar_control_edit').hide();
	} else {
		contenido += '<br><input name="nombre_hijo_edit" id="nombre_hijo_edit"  type="text"     class="form-control" placeholder="Nombre Hijo"    required >'
		contenido += '<br><button type="button" class="btn btn-primary" name="agregar" onclick="agregarGrupoUsuarioEdit()" >Agregar</button>';
		$('#btnagregar_control_edit').html(contenido);
		$('#btnagregar_control_edit').show();
	}

}

function getGruposEdit() {
	var contenido = "";
	var id_nivel = $("#niveles_select_edit").val();
	var id_grado = $("#grados_select_edit").val();

	$
			.ajax({
				url : "php/grupos.php?getGrupos=true&qwert_nivel=" + id_nivel
						+ "&qwert_grado=" + id_grado,
				dataType : 'json',
				success : function(data) {
					contenido += '<select class="form-control" id="grupos_select_edit" onchange="mostrarBotonEdit();">';
					contenido += '<option value="0">::Seleccione Grupo</option>';
					$.each(data, function(i, grupo) {
						contenido += '<option value="' + grupo.id + '">'
								+ grupo.nombre + '</option>';

					});
					contenido += '</select>';
					$('#grupos_control_edit').html(contenido);
					$("#grupos_control_edit").show();
					$('#btnagregar_control_edit').hide();
				}/* Success */
			});

}

function limpiarCamposEdit() {
	$("#nombre_usuario_edit").val("");
	$("#correo_edit").val("");
	$("#aviso_edit").hide();
	$("#aviso2_edit").hide();
	$("#niveles_select_edit").val(0);
	$("#grados_control_edit").hide();
	$("#grupos_control_edit").hide();
	$('#btnagregar_control_edit').hide();
	$("#grupos_usuario_edit").hide();
	$('#grupos_table_edit > tbody').html("");

}

function limpiarSelectsEdit() {
	$("#niveles_select_edit").val(0);
	$("#grados_control_edit").hide();
	$("#grupos_control_edit").hide();
	$('#btnagregar_control_edit').hide();
}

function agregarGrupoUsuarioEdit() {
	// console.log(gruposUsuario);
	var contenido = "";
	$('#grupos_usuario_edit').show();
	var id_nivel = $("#niveles_select_edit option:selected").val();
	var id_grado = $("#grados_select_edit option:selected").val();
	var id_grupo = $("#grupos_select_edit option:selected").val();
	var nombre_nivel = $("#niveles_select_edit option:selected").text();
	var nombre_grado = $("#grados_select_edit option:selected").text();
	var nombre_grupo = $("#grupos_select_edit option:selected").text();
	var nombre_hijo = $("#nombre_hijo_edit").val();
	var esta = false;
	$.each(gruposUsuario, function(i, grupoUsuario) {
		if (grupoUsuario.id_nivel == id_nivel
				&& grupoUsuario.id_grado == id_grado
				&& grupoUsuario.id_grupo == id_grupo) {
			esta = true;
		}
	});

	if (!esta) {
		contenido += '<tr id="tgrupousuario_edit_'
				+ id_grupo
				+ '">'
				+ '<td style="width:150px;">'
				+ nombre_hijo
				+ '</td>'
				+ '<td style="width:150px;">'
				+ nombre_nivel
				+ '</td>'
				+ '<td style="width:150px;">'
				+ nombre_grado
				+ '</td>'
				+ '<td style="width:150px;">'
				+ nombre_grupo
				+ '</td>'
				+ '<td align="center" style="width:150px;">'
				+ '<center>'
				+ '<button style="cursor:pointer;" onclick="eliminarGrupoUsuarioEdit('
				+ id_nivel + ',' + id_grado + ',' + id_grupo
				+ ')" type="button" class="btn btn-danger">'
				+ '<span class="glyphicon glyphicon-trash"></span>'
				+ '</button>' + '</center>' + '</td>' + '</tr>';
		$('#grupos_table_edit > tbody').append(contenido);
		limpiarSelectsEdit();
		gruposUsuario.push({
			"id_nivel" : id_nivel,
			"id_grado" : id_grado,
			"id_grupo" : id_grupo,
			"nombre_hijo" : nombre_hijo
		});
		// console.log(gruposUsuario);

	} else {
		alert("Ya añadiste este grupo, selecciona otro");
	}

}
var Nombre_Niveles = new Array();
var Nombre_Grupos = new Array();
var Nombre_Grados = new Array();

function getGruposUsuario(qwert) {
	var id_usuario = qwert;
	var contenido = "";
	$('#grupos_table_edit > tbody').html('');
	$
			.ajax({
				url : "php/usuarios.php?getGrupoUsuario=true&qwert="
						+ id_usuario,
				dataType : 'json',
				success : function(data) {
					$
							.each(
									data,
									function(i, grupo_usuario) {

										$
												.ajax({
													url : "php/grados.php?getGrados=true&qwert="
															+ grupo_usuario.id_nivel,
													dataType : 'json',
													success : function(data) {
														$
																.each(
																		data,
																		function(
																				i,
																				grado) {
																			Nombre_Grados[grado.id] = grado.nombre;
																		});
														$
																.ajax({
																	url : "php/grupos.php?getGrupos=true&qwert_nivel="
																			+ grupo_usuario.id_nivel
																			+ "&qwert_grado="
																			+ grupo_usuario.id_grado,
																	dataType : 'json',
																	success : function(
																			data) {
																		$
																				.each(
																						data,
																						function(
																								i,
																								grupo) {
																							Nombre_Grupos[grupo.id] = grupo.nombre;
																						});
																		contenido += '<tr id="tgrupousuario_edit_'
																				+ grupo_usuario.id_grupo
																				+ '">'
																				+ '<td style="width:150px;">'
																				+ grupo_usuario.nombre_hijo
																				+ '</td>'
																				+ '<td style="width:150px;">'
																				+ Nombre_Niveles[grupo_usuario.id_nivel]
																				+ '</td>'
																				+ '<td style="width:150px;">'
																				+ Nombre_Grados[grupo_usuario.id_grado]
																				+ '</td>'
																				+ '<td style="width:150px;">'
																				+ Nombre_Grupos[grupo_usuario.id_grupo]
																				+ '</td>'
																				+ '<td align="center" style="width:150px;">'
																				+ '<center>'
																				+ '<button style="cursor:pointer;" onclick="eliminarGrupoUsuarioEdit('
																				+ grupo_usuario.id_nivel
																				+ ','
																				+ grupo_usuario.id_grado
																				+ ','
																				+ grupo_usuario.id_grupo
																				+ ')" type="button" class="btn btn-danger">'
																				+ '<span class="glyphicon glyphicon-trash"></span>'
																				+ '</button>'
																				+ '</center>'
																				+ '</td>'
																				+ '</tr>';
																		$(
																				'#grupos_table_edit > tbody')
																				.html(
																						contenido);
																		gruposUsuario
																				.push({
																					"id_nivel" : grupo_usuario.id_nivel,
																					"id_grado" : grupo_usuario.id_grado,
																					"id_grupo" : grupo_usuario.id_grupo,
																					"nombre_hijo" : grupo_usuario.nombre_hijo
																				});
																	}/* Success */
																});
													}/* Success */
												});
									});
				}/* Success */
			});
}

function eliminarGrupoUsuarioEdit(id_nivel, id_grado, id_grupo) {
	/*
	 * $.ajax({ url:
	 * "php/usuarios.php?delUsuarioGrupo=true&qwert="+qwert+"&id_nivel="+id_nivel+"&id_grado="+id_grado+"&id_grupo="+id_grupo,
	 * dataType: 'json', success: function(data){
	 */
	$.each(gruposUsuario, function(i, grupoUsuario) {
		if (grupoUsuario.id_nivel == id_nivel
				&& grupoUsuario.id_grado == id_grado
				&& grupoUsuario.id_grupo == id_grupo) {
			gruposUsuario.splice(i, 1);
			$("#tgrupousuario_edit_" + id_grupo).remove();
			// console.log(gruposUsuario);
		}
	});
	// }/*Success*/
}// );
// }

/*---------Aqui terminamos con las funciones para la edicion de Usuario---------*/

$(document)
		.ready(
				function() {
					getUsuarios();
					getNivel();
					getNivelEdit();
					getArrayNivel();

					$("#correo")
							.keyup(
									function(event) {
										var emailreg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
										var correo = $("#correo").val();
										var contenido = "";
										$
												.ajax({
													url : "php/usuarios.php?getCorreo=true&correo="
															+ correo,
													dataType : 'json',
													success : function(data) {

														if (data[0] == "true") {
															contenido += '<div class="alert alert-warning alert-dismissable">'
																	+ '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
																	+ '<h4>¡Verificar!</h4>'
																	+ 'Este usuario ya existe'
																	+ '</div>';
															$('#aviso').html(
																	contenido);
															$("#aviso").show();
															$("#funcion").val(
																	"1");
														} else if (data[0] == "false") {
															contenido = '';
															$("#aviso").hide();
															$("#funcion").val(
																	"0");
														}
														$('#aviso').html(
																contenido);
														$("#aviso").show();

													}/* Success */
												});
										if (!emailreg.test(correo)) {
											contenido += '<div class="alert alert-warning alert-dismissable">'
													+ '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
													+ '<h4>¡Verificar!</h4>'
													+ 'Escriba un correo electrónico válido'
													+ '</div>';
											$('#aviso2').html(contenido);
											$("#aviso2").show();
										} else {
											$("#aviso2").hide();
										}
									});

					$("#correo_edit")
							.keyup(
									function(event) {
										var emailreg_edit = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
										var correo_edit = $("#correo_edit")
												.val();
										var contenido_edit = "";
										$
												.ajax({
													url : "php/usuarios.php?getCorreo=true&correo="
															+ correo_edit,
													dataType : 'json',
													success : function(data) {

														if (data[0] == "true") {
															contenido_edit += '<div class="alert alert-warning alert-dismissable">'
																	+ '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
																	+ '<h4>¡Verificar!</h4>'
																	+ 'Este usuario ya existe'
																	+ '</div>';
															$('#aviso_edit')
																	.html(
																			contenido_edit);
															$("#aviso_edit")
																	.show();
															$("#funcion_edit")
																	.val("1");
														} else if (data[0] == "false") {
															contenido_edit = '';
															$("#aviso_edit")
																	.hide();
															$("#funcion_edit")
																	.val("0");
														}
														$('#aviso_edit').html(
																contenido_edit);
														$("#aviso_edit").show();

													}/* Success */
												});

										if (!emailreg_edit.test(correo_edit)) {
											contenido_edit += '<div class="alert alert-warning alert-dismissable">'
													+ '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
													+ '<h4>¡Verificar!</h4>'
													+ 'Escriba un correo electrónico válido'
													+ '</div>';
											$('#aviso2_edit').html(
													contenido_edit);
											$("#aviso2_edit").show();
										} else {
											$("#aviso2_edit").hide();
										}

									});

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
															contenido += '<select class="form-control" id="grados_select" onchange="getGrupos();">';
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
															$('#grados_control')
																	.html(
																			contenido);
															$("#grados_control")
																	.show();
															$("#grupos_control")
																	.hide();
															$(
																	'#btnagregar_control')
																	.hide();
														}/* Success */
													});
										}

									});

					$('#niveles_select_edit')
							.on(
									'change',
									function() {
										var contenido_edit = "";
										var id_nivel_edit = this.value;
										if (id_nivel_edit == 0) {
											$("#grados_control_edit").hide();
											$("#grupos_control_edit").hide();
										} else {
											$
													.ajax({
														url : "php/grados.php?getGrados=true&qwert="
																+ id_nivel_edit,
														dataType : 'json',
														success : function(data) {
															contenido_edit += '<select class="form-control" id="grados_select_edit" onchange="getGruposEdit();">';
															contenido_edit += '<option value="0">::Seleccione Grado</option>';
															$
																	.each(
																			data,
																			function(
																					i,
																					grado) {
																				contenido_edit += '<option value="'
																						+ grado.id
																						+ '">'
																						+ grado.nombre
																						+ '</option>';

																			});
															contenido_edit += '</select>';
															$(
																	'#grados_control_edit')
																	.html(
																			contenido_edit);
															$(
																	"#grados_control_edit")
																	.show();
															$(
																	"#grupos_control_edit")
																	.hide();
															$(
																	'#btnagregar_control_edit')
																	.hide();
														}/* Success */
													});
										}

									});

					$('#buscar_usuario.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable tr').hide();
						$('.searchable tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});
					$('#buscar_grupo.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable_grupo tr').hide();
						$('.searchable_grupo tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});

					$('#buscar_usuario_edit.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable tr').hide();
						$('.searchable tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});
					$('#buscar_grupo_edit.filter').keyup(function() {
						var rex = new RegExp($(this).val(), 'i');
						$('.searchable_grupo tr').hide();
						$('.searchable_grupo tr').filter(function() {
							return rex.test($(this).text());
						}).show();
					});

					function getUsuarios() {
						var contenido = "";
						$
								.ajax({
									url : "php/usuarios.php?getUsuarios=true",
									dataType : 'json',
									success : function(data) {

										$
												.each(
														data,
														function(i, usuario) {
															var n = i + 1;
															contenido += '<tr id="tusuario_'
																	+ usuario.id
																	+ '">'
																	+ '<td style="width:600px;">'
																	+ usuario.nombre
																	+ '</td>'
																	+ '<td style="width:300px;">'
																	+ usuario.correo
																	+ '</td>'
																	+ '<td align="center" style="width:300px;">'
																	+ '<center>'
																	+ '<button style="cursor:pointer;" onclick="editarUsuario('
																	+ usuario.id
																	+ ', \''
																	+ usuario.nombre
																	+ '\',\''
																	+ usuario.correo
																	+ '\')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#actualiza_Usuario">'
																	+ '<span class="glyphicon glyphicon-pencil"></span>'
																	+ '</button>'
																	+ '<button style="cursor:pointer;" onclick="eliminarUsuario('
																	+ usuario.id
																	+ ', \''
																	+ usuario.nombre
																	+ '\',\''
																	+ usuario.correo
																	+ '\')" type="button" class="btn btn-danger">'
																	+ '<span class="glyphicon glyphicon-trash"></span>'
																	+ '</button>'
																	+ '</center>'
																	+ '</td>'
																	+ '</tr>';

														});
										$('#usuarios_table > tbody').append(
												contenido);
									}/* Success */
								});

					}

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

					function getNivelEdit() {
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
										$('#niveles_select_edit').append(
												contenido);
									}/* Success */
								});

					}

					function getArrayNivel() {
						$.ajax({
							url : "php/niveles.php?getNiveles=true",
							dataType : 'json',
							success : function(data) {
								$.each(data, function(i, nivel) {

									Nombre_Niveles[nivel.id] = nivel.nombre;

								});
								// $('#niveles_select_edit').append(contenido);
							}/* Success */
						});
					}

				});