$(function() {
   
	var funcion;

	$('.save-nivel')
			.submit(
					function(e) {
						var nombre_nivel = $('#nombre_nivel').val();
                                                var mensaje = $('#mensaje').val();
                                                var status = $('#status').val();
                                                 if(status==0)
                                                 {
                                                    alert("Seleciona el estatus"); 
                                                    return false;
                                                 }
                                                 
                                                  if(mensaje==null || mensaje.length<=5)
                                                 {
                                                    alert("Agrega Respuesta."); 
                                                    return false;
                                                 }
                                                
						e.preventDefault();
						$
								.ajax({
									type : 'POST',
									data : {
										funcion : funcion,
										nombre_nivel : nombre_nivel,
                                                                                mensaje : mensaje,
                                                                                status : status
									}
								})
								.done(
										function(data) {
											if (data.estatus == -1) {
												$('.alert-save')
														.html(
																'<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>  El nombre del nivel ya existe, por favor escribe otro</div>')
														.hide().show('fast');
											} else {
												location.reload();
											}

										});
					});
	$('input.filter').keyup(function() {
		var rex = new RegExp($(this).val(), 'i');
		$('.searchable tr').hide();
		$('.searchable tr').filter(function() {
			return rex.test($(this).text());
		}).show();
	});
        /**********************************************************************/
	$('.btn-editar').click(function() 
        {
		editarNivel($(this).attr('data-id'),
                            $(this).attr('data-nombre'),
                            $(this).attr('data-nombre1'),
                            $(this).attr('data-calle_numero'),
                            $(this).attr('data-colonia'),
                            $(this).attr('data-cp'),
                            $(this).attr('data-ruta'),
                            $(this).attr('data-comentarios'),
                            $(this).attr('data-calle_numero1'),
                            $(this).attr('data-colonia1'),
                            $(this).attr('data-alumno1'),
 $(this).attr('data-grado1'),
 $(this).attr('data-grupo1'),
 $(this).attr('data-alumno2'),
 $(this).attr('data-grado2'),
 $(this).attr('data-grupo2'),
 $(this).attr('data-alumno3'),
 $(this).attr('data-grado3'),
 $(this).attr('data-grupo3'),
 $(this).attr('data-alumno4'),
 $(this).attr('data-grado4'),
 $(this).attr('data-grupo4'),
 $(this).attr('data-alumno5'),
 $(this).attr('data-grado5'),
 $(this).attr('data-grupo5'),
 $(this).attr('data-mensaje'),
 $(this).attr('data-lunes'),
 $(this).attr('data-martes'), 
 $(this).attr('data-miercoles'),
 $(this).attr('data-jueves'),
 $(this).attr('data-viernes')        
          );
funcion = $(this).attr('data-id');
	});
        /*************************************************************/
	$('.btn-borrar').click(function() {
		eliminarNivel($(this).attr('data-id'), $(this).attr('data-nombre'));
	});
        
        $('.btn-autorizar').click(function() {
		Autorizar($(this).attr('data-id'), $(this).attr('data-nombre'));
	});
        
        
        
	$('.btn-nuevo').click(function() {
		$("#modalNivelTitulo").text("Agrega Solicitud");
		$("#nombre_nivel").val('');
                $("#nombre_nivel1").val('');
		funcion = 0;
	});
        /**********************************************************/
	function editarNivel(qwert,nombre,nombre1,calle_numero,colonia,cp,ruta,comentarios,calle_numero1,colonia1,alumno1,grado1,grupo1,alumno2,grado2,grupo2,alumno3,grado3,grupo3,alumno4,grado4,grupo4,alumno5,grado5,grupo5,mensaje,lunes,martes,miercoles,jueves,viernes)
        {
		$("#modalNivelTitulo").text("Editar Solicitud de Permanente");
                 
               
                $("#folio").val(qwert);
		$("#nombre_nivel").val(nombre);
                $("#nombre_nivel1").val(nombre1);
                $("#calle_numero").val(calle_numero);
                $("#colonia").val(colonia);
                $("#cp").val(cp);
                $("#ruta").val(ruta);
                $("#comentarios").val(comentarios);
                $("#calle_numero1").val(calle_numero1);
                $("#colonia1").val(colonia1);
                $("#alumno1").val(alumno1);
$("#grado1").val(grado1);
$("#grupo1").val(grupo1);
$("#alumno2").val(alumno2);
$("#grado2").val(grado2);
$("#grupo2").val(grupo2); 
$("#alumno3").val(alumno3);
$("#grado3").val(grado3);
$("#grupo3").val(grupo3);
$("#alumno4").val(alumno4);
$("#grado4").val(grado4);
$("#grupo4").val(grupo4);
$("#alumno5").val(alumno5);
$("#grado5").val(grado5);
$("#grupo5").val(grupo5);
$("#mensaje").val(mensaje);
$("#lunes").val(lunes);
$("#martes").val(martes);
$("#miercoles").val(miercoles);
$("#jueves").val(jueves);
$("#viernes").val(viernes);


		$("#funcion").val(qwert);
	}
       /**************************************************************/ 
        /*Cancelar permiso*/
	function eliminarNivel(qwert, nombre) {
		var respuesta = confirm("Desea archivar el permiso numero: " + qwert);
		if (respuesta) {
			var contenido = "";
			$.ajax({
				url : "php/niveles.php?CancelaP=true&qwert=" + qwert,
				dataType : 'json',
				success : function(data) {
					if (data) {
						location.reload();
					}

				}/* Success */
			});
		}
	}
        /*autorizar permiso*/
        
        function Autorizar(qwert, nombre) {
		var respuesta = confirm("Desea Autorizar el permiso numero: " + qwert);
		if (respuesta) {
			var contenido = "";
			$.ajax({
				url : "php/niveles.php?AutorizaP=true&qwert=" + qwert,
				dataType : 'json',
				success : function(data) {
					if (data) {
						location.reload();
					}

				}/* Success */
			});
		}
	}
});