var gruposUsuario = [];

function eliminarUsuario(qwert,nombre_usuario,correo_usuario) {
	var respuesta = confirm("Desea Eliminar el usuario "+nombre_usuario);
	if (respuesta){
		var contenido = "";
		$.ajax({
			url: "php/usuarios.php?delUsuario=true&qwert="+qwert,
			dataType: 'json',
			success: function(data){
				if(data){
					$("#tusuario_"+qwert).remove();	
				}
				
			}/*Success*/
		});
	}
}

function guardarUsuario() {
	var nombre_usuario = $("#nombre_usuario").val();
	var correo_usuario = $("#correo").val();

	if(nombre_usuario == "" || correo_usuario == ""){
		alert("Escriba un nombre de usaurio y/o correo electrónico");
		return false;
	}else if(nombre_usuario != "" && correo_usuario != ""){
		var parametros = "&nombre_usuario="+nombre_usuario+"&correo_usuario="+correo_usuario;
		$.ajax({
			url: "php/usuarios.php?insertUsuario=true"+parametros,
			dataType: 'json',
			success: function(data){
				var id_usuario = data.id;
				var contenido = '';
				contenido += '<tr id="tusuario_'+id_usuario+'">'+
								'<td style="width:600px;">'+nombre_usuario+'</td>'+
								'<td style="width:300px;">'+correo_usuario+'</td>'+
								'<td align="center" style="width:300px;">'+
								'<center>'+
								'<button style="cursor:pointer;" onclick="editarUsuario('+id_usuario+', \''+nombre_usuario+'\',\''+correo_usuario+'\')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarNivel">'+
						          '<span class="glyphicon glyphicon-pencil"></span> Editar'+
						        '</button>'+
								'<button style="cursor:pointer;" onclick="eliminarUsuario('+id_usuario+', \''+nombre_usuario+'\',\''+correo_usuario+'\')" type="button" class="btn btn-danger">'+
						          '<span class="glyphicon glyphicon-trash"></span> Eliminar'+
						        '</button>'+
						        '</center>'+
								'</td>'+
							   '</tr>';

				$.each(gruposUsuario, function(i, grupousuario){
					var param = "&id_nivel="+grupousuario.id_nivel+"&id_grado="+grupousuario.id_grado+"&id_grupo="+grupousuario.id_grupo+"&id_usuario="+id_usuario;
					$.ajax({
						url: "php/usuarios.php?insertGrupoUsuario=true"+param,
						dataType: 'json',
						success: function(data){
							
							
						}/*Success*/
					});	

				});
				$('#usuarios_table > tbody').append(contenido);
				
			}/*Success*/
		});	
	}
}

function agregarGrupoUsuario() {
	//console.log(gruposUsuario);
	var contenido = "";
	$('#grupos_usuario').show();
	var id_nivel     = $("#niveles_select option:selected").val();
	var id_grado     = $("#grados_select option:selected").val();
	var id_grupo     = $("#grupos_select option:selected").val();
	var nombre_nivel = $("#niveles_select option:selected").text();
	var nombre_grado = $("#grados_select option:selected").text();
	var nombre_grupo = $("#grupos_select option:selected").text();
	var esta = false;
	$.each( gruposUsuario, function(i, grupoUsuario){
		if(grupoUsuario.id_nivel == id_nivel && grupoUsuario.id_grado == id_grado && grupoUsuario.id_grupo == id_grupo){
			esta = true;
		}
				
	});

	if(!esta){
		contenido += '<tr id="tgrupousuario_'+id_grupo+'">'+
						'<td style="width:150px;">'+nombre_nivel+'</td>'+
						'<td style="width:150px;">'+nombre_grado+'</td>'+
						'<td style="width:150px;">'+nombre_grupo+'</td>'+
						'<td align="center" style="width:150px;">'+
						'<center>'+
						'<button style="cursor:pointer;" onclick="eliminarGrupoUsuario('+id_nivel+','+id_grado+','+id_grupo+')" type="button" class="btn btn-danger">'+
				          '<span class="glyphicon glyphicon-trash"></span> Eliminar'+
				        '</button>'+
				        '</center>'+
						'</td>'+
					   '</tr>';
		$('#grupos_table > tbody').append(contenido);	
		gruposUsuario.push({"id_nivel": id_nivel,"id_grado": id_grado,"id_grupo": id_grupo});
		//console.log(gruposUsuario);

	}else{
		alert("Ya añadiste este grupo, selecciona otro");
	}
	

}

function eliminarGrupoUsuario(id_nivel,id_grado,id_grupo){
	
	$.each( gruposUsuario, function(i, grupoUsuario){
		if(grupoUsuario.id_nivel == id_nivel && grupoUsuario.id_grado == id_grado && grupoUsuario.id_grupo == id_grupo){
			gruposUsuario.splice(i,1);
			$("#tgrupousuario_"+id_grupo).remove();	
			//console.log(gruposUsuario);
		}
				
	});
	
}

function mostrarBoton(){
	var contenido = "";
	var id_grupo = $("#grupos_select").val();
	if(id_grupo == 0){
		$('#btnagregar_control').hide();	
	}else{
		contenido += '<br><button type="button" class="btn btn-primary" name="agregar" onclick="agregarGrupoUsuario()" >Agregar</button>';
		$('#btnagregar_control').html(contenido);	
		$('#btnagregar_control').show();
	}
	
}

function getGrupos() {
	var contenido = "";
	var id_nivel = $("#niveles_select").val();
	var id_grado = $("#grados_select").val();
	
	$.ajax({
		url: "php/grupos.php?getGrupos=true&qwert_nivel="+id_nivel+"&qwert_grado="+id_grado,
		dataType: 'json',
		success: function(data){
			contenido += '<select class="form-control" id="grupos_select" onchange="mostrarBoton();">';
			contenido += '<option value="0">::Seleccione Grupo</option>';
			$.each( data, function(i, grupo){
				contenido += '<option value="'+grupo.id+'">'+grupo.nombre+'</option>';
				
			});
			contenido += '</select>';
			$('#grupos_control').html(contenido);	
			$("#grupos_control").show();
			$('#btnagregar_control').hide();	
		}/*Success*/
	});
  	
}

function limpiarCampos(){
	$("#nombre_usuario").val("");
	$("#correo").val("");

	$("#niveles_select").val(0);
	$("#grados_control").hide();
	$("#grupos_control").hide();
	$('#btnagregar_control').hide();
	$("#grupos_usuario").hide();
	$('#grupos_table > tbody').html("");	

}

$(document).ready(function() {
	getUsuarios();
	getNivel();

	$('#niveles_select').on('change', function() {
		var contenido = "";
		var id_nivel = this.value;
		if(id_nivel == 0){
			$("#grados_control").hide();
			$("#grupos_control").hide();	
		}else {
			$.ajax({
				url: "php/grados.php?getGrados=true&qwert="+id_nivel,
				dataType: 'json',
				success: function(data){
					contenido += '<select class="form-control" id="grados_select" onchange="getGrupos();">';
					contenido += '<option value="0">::Seleccione Grado</option>';
					$.each( data, function(i, grado){
						contenido += '<option value="'+grado.id+'">'+grado.nombre+'</option>';
						
					});
					contenido += '</select>';
					$('#grados_control').html(contenido);
					$("#grados_control").show();
					$("#grupos_control").hide();
					$('#btnagregar_control').hide();	
				}/*Success*/
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

	function getUsuarios(){
		var contenido = "";
		$.ajax({
			url: "php/usuarios.php?getUsuarios=true",
			dataType: 'json',
			success: function(data){
				
				$.each( data, function(i, usuario){
					var n = i+1;
					contenido += '<tr id="tusuario_'+usuario.id+'">'+
									'<td style="width:600px;">'+usuario.nombre+'</td>'+
									'<td style="width:300px;">'+usuario.correo+'</td>'+
									'<td align="center" style="width:300px;">'+
									'<center>'+
									'<button style="cursor:pointer;" onclick="editarUsuario('+usuario.id+', \''+usuario.nombre+'\',\''+usuario.correo+'\')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarNivel">'+
							          '<span class="glyphicon glyphicon-pencil"></span> Editar'+
							        '</button>'+
									'<button style="cursor:pointer;" onclick="eliminarUsuario('+usuario.id+', \''+usuario.nombre+'\',\''+usuario.correo+'\')" type="button" class="btn btn-danger">'+
							          '<span class="glyphicon glyphicon-trash"></span> Eliminar'+
							        '</button>'+
							        '</center>'+
									'</td>'+
								   '</tr>';

				});
				$('#usuarios_table > tbody').append(contenido);	
			}/*Success*/
   		});
	
	}

	function getNivel(){
		var contenido = "";
		$.ajax({
			url: "php/niveles.php?getNiveles=true",
			dataType: 'json',
			success: function(data){
				contenido += '<option value="0">::Seleccione Nivel</option>';
				$.each( data, function(i, nivel){
					
					contenido += '<option value="'+nivel.id+'">'+nivel.nombre+'</option>';

				});
				$('#niveles_select').append(contenido);	
			}/*Success*/
   		});
	
	}

	

	

});