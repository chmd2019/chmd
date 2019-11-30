function editarNivel(qwert,nombre){
	$("#modalNivelTitulo").text("Editar Solicitud");
	$("#nombre_nivel").val(nombre);
	$("#funcion").val(qwert);
}
function eliminarNivel(qwert, nombre){
	var respuesta = confirm("Desea Eliminar el nivel "+nombre);
	if (respuesta){
		var contenido = "";
		$.ajax({
			url: "php/niveles.php?delNivel=true&qwert="+qwert,
			dataType: 'json',
			success: function(data){
				if(data){
					$("#tnivel_"+qwert).remove();	
				}
				
			}/*Success*/
		});
	}
}

$(document).ready(function() {
	getNiveles();


	$('input.filter').keyup(function() {
	var rex = new RegExp($(this).val(), 'i');
	$('.searchable tr').hide();
	  $('.searchable tr').filter(function() {
	      return rex.test($(this).text());
	  }).show();
	});

	function getNiveles(){
		var contenido = "";
		$.ajax({
			url: "php/niveles.php?getNiveles=true",
			dataType: 'json',
			success: function(data){
				
				$.each( data, function(i, nivel){
					var n = i+1;
					contenido += '<tr id="tnivel_'+nivel.id+'">'+
									'<td style="width:50px;">'+n+'</td>'+
									'<td style="width:900px;">'+nivel.nombre+'</td>'+
									'<td align="center" style="width:300px;">'+
									'<center>'+
									'<button style="cursor:pointer;" onclick="editarNivel('+nivel.id+', \''+nivel.nombre+'\')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarNivel">'+
							          '<span class="glyphicon glyphicon-pencil"></span> Editar'+
							        '</button>'+
									'<button style="cursor:pointer;" onclick="eliminarNivel('+nivel.id+', \''+nivel.nombre+'\')" type="button" class="btn btn-danger">'+
							          '<span class="glyphicon glyphicon-trash"></span> Eliminar'+
							        '</button>'+
							        '</center>'+
									'</td>'+
								   '</tr>';

				});
				$('#niveles_table > tbody').append(contenido);	
			}/*Success*/
   		});
	
	}

	

	

});



