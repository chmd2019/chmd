

function guardarGrado(){
	var id_nivel 	   = $('#id_nivel').val();
	var nombre_grado   = $('#nombre_grado').val();
	if(nombre_grado == ""){
		alert("Por favor escribe el Grado");
	}else{
		var contenido = "";
		$.ajax({
			url: "php/grados.php?insertGrado=true&id_nivel="+id_nivel+"&nombre_grado="+nombre_grado,
			dataType: 'json',
			success: function(data){
				contenido += '<tr id="tgrado_'+data.id+'">'+
								//'<td style="width:50px;">'+n+'</td>'+
								'<td style="width:900px;">'+
									'<div style="display:none" id="input_ed_'+data.id+'">'+
									'</div>'+
									'<div id="label_'+data.id+'">'+
										'<span id="span_grado_'+data.id+'">'+nombre_grado+'</span>'+
									'</div>'+
								
								'</td>'+
								'<td align="center" style="width:300px;">'+
								'<center>'+
								'<button style="cursor:pointer;" onclick="editarGrado('+data.id+', \''+nombre_grado+'\')" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#agregarNivel">'+
						          '<span class="glyphicon glyphicon-pencil"></span>'+
						        '</button>'+
								'<button style="cursor:pointer;" onclick="eliminarGrado('+data.id+')" type="button" class="btn btn-danger btn-sm">'+
						          '<span class="glyphicon glyphicon-trash"></span>'+
						        '</button>'+
						        '</center>'+
								'</td>'+
							   '</tr>';

				$('#grados_table > tbody').append(contenido);
				$("#nombre_grado").val("");
				$('.pop_over').popover('hide');
				
				
			}/*Success*/
		});	
	}
	
}


function verGrado(qwert,nivel){
	
	var contenido = "";
	$("#nombre_grado").val("");
	$('.pop_over').popover('hide');
	$("#modalGradoTitulo").text(nivel);
	$("#id_nivel").val(qwert);
	$.ajax({
		url: "php/grados.php?getGrados=true&qwert="+qwert,
		dataType: 'json',
		success: function(data){
			$.each( data, function(i, grado){
				var n = i+1;
				contenido += '<tr id="tgrado_'+grado.id+'">'+
								//'<td style="width:50px;">'+n+'</td>'+
								'<td style="width:900px;">'+
									'<div style="display:none" id="input_ed_'+grado.id+'">'+
									'</div>'+
									'<div id="label_'+grado.id+'">'+
										'<span id="span_grado_'+grado.id+'">'+grado.nombre+'</span>'+
									'</div>'+
								
								'</td>'+
								'<td align="center" style="width:300px;">'+
								'<center>'+
								'<button style="cursor:pointer;" onclick="editarGrado('+grado.id+')" type="button" class="btn btn-primary btn-sm">'+
						          '<span class="glyphicon glyphicon-pencil"></span>'+
						        '</button>'+
								'<button style="cursor:pointer;" onclick="eliminarGrado('+grado.id+')" type="button" class="btn btn-danger btn-sm">'+
						          '<span class="glyphicon glyphicon-trash"></span>'+
						        '</button>'+
						        '</center>'+
								'</td>'+
							   '</tr>';
				
			});
			$('#grados_table > tbody').html(contenido);	
		}/*Success*/
	});

}

function editarGrado(qwert){
	var nombre = $('#span_grado_'+qwert).text();
	var contenido 	= '<div class="form-group has-warning" style="margin-bottom: 2px;">'+
						  	'<input  type="text" class="form-control input-sm" id="link_grado_ed_'+qwert+'" value="'+nombre+'" required autofocus>'+
						  	'<button onclick="aceptarGrado('+qwert+')" type="button" class="btn btn-success btn-xs">Aceptar</button>'+
					  '</div>';

	$("#input_ed_"+qwert).show();
	$("#label_"+qwert).hide();
	$("#input_ed_"+qwert).html(contenido);
}

function aceptarGrado(qwert){
	var nombre = $('#link_grado_ed_'+qwert).val();
	$.ajax({
		url: "php/grados.php?updateGrado=true&qwert="+qwert+"&nombre="+nombre,
		dataType: 'json',
		success: function(data){
			
			$('#span_grado_'+qwert).text(nombre);
			$("#input_ed_"+qwert).hide();
			$("#label_"+qwert).show();
			
		}/*Success*/
	});
}

function eliminarGrado(qwert){
	var nombre = $('#span_grado_'+qwert).text();
	var respuesta = confirm("Desea Eliminar el "+nombre+" Grado ");
	if (respuesta){
		var contenido = "";
		$.ajax({
			url: "php/grados.php?delGrado=true&qwert="+qwert,
			dataType: 'json',
			success: function(data){
				if(data){
					$("#tgrado_"+qwert).remove();	
				}
				
			}/*Success*/
		});
	}
}

$(document).ready(function() {

	getNivelesGrados();

	
	$('#buscar_nivel.filter').keyup(function() {
		var rex = new RegExp($(this).val(), 'i');
		$('.searchable_buscar_nivel tr').hide();
		$('.searchable_buscar_nivel tr').filter(function() {
		  return rex.test($(this).text());
		}).show();
	});
	$('#buscar_grado.filter').keyup(function() {
		var rex = new RegExp($(this).val(), 'i');
		$('.searchable_buscar_grado tr').hide();
		$('.searchable_buscar_grado tr').filter(function() {
		  return rex.test($(this).text());
		}).show();
	});

	

	function getNivelesGrados(){
		var contenido  = "";
		var contenido2 = "";
		$.ajax({
			url: "php/niveles.php?getNiveles=true",
			dataType: 'json',
			success: function(data){
				contenido2 += '<option value="0" selected="selected">Niveles</option>';
				$.each( data, function(i, nivel){
					var n = i+1;
					contenido += '<tr id="tnivel_'+nivel.id+'">'+
									'<td style="width:50px;">'+n+'</td>'+
									'<td style="width:900px;">'+nivel.nombre+'</td>'+
									'<td align="center" style="width:300px;">'+
									'<center>'+
									'<button style="cursor:pointer;" onclick="verGrado('+nivel.id+', \''+nivel.nombre+'\')" type="button" class="btn btn-info" data-toggle="modal" data-target="#verGrado">'+
							          '<span class="glyphicon glyphicon-eye-open"></span> Ver Grados'+
							        '</button>'+
							        '</center>'+
									'</td>'+
								   '</tr>';
					//contenido2 += '<option value="'+nivel.id+'">'+nivel.nombre+'</option>';

				});

				$('#niveles_table > tbody').append(contenido);	
				//$('#niveles_select').append(contenido2);
			}/*Success*/
   		});
	
	}

	

});