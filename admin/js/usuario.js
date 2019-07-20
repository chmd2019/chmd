function limpiarCampos() {
	$("#padres_select").val(0);
	$('#btnagregar_control').hide();
}

$(document)
		.ready(
				function() {

					getNivel();

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
					$('[data-borrar]').click(function() {
						eliminarUsuario($(this).attr('data-borrar'));
						location.reload();
					});
					$('.btn-guardar').click(function() {
						guardarUsuario();
						location.reload();
					});
					function eliminarUsuario(id) {
						var respuesta = confirm("Desea Eliminar el usuario");
						if (respuesta) {
							var contenido = "";
							$
									.ajax({
										url : "php/usuarios.php?delUsuarioGrupo=true&qwert="
												+ id,
										dataType : 'json',
									})
						}
					}

					function guardarUsuario() {
						var padres = $("#padres_select").val();
						var id_nivel = $("#id_nivel").val();
						var id_grado = $("#id_grado").val();
						var id_grupo = $("#id_grupo").val();
						var nombre_hijo = $("#nombre_hijo").val();
						if (padres == 0) {
							alert("Seleccione un Padre");
						} else if (nombre_hijo == "") {
							alert("Escriba el nombre del hijo");
						} else if (padres > 0 && nombre_hijo != "") {
							var contenido = "";
							var param = "&id_nivel=" + id_nivel + "&id_grado="
									+ id_grado + "&id_grupo=" + id_grupo
									+ "&id_usuario=" + padres + "&nombre_hijo="
									+ nombre_hijo;
							$
									.ajax({
										url : "php/usuarios.php?insertGrupoUsuario=true"
												+ param,
										dataType : 'json'
									});
						}
					}

				});