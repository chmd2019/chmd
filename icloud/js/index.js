

function alerta23(){
				//un alert
				alertify.alert("<b></b><p align='justify'>AVISO DE PRIVACIDAD VIGENTE A PARTIR DEL 1º DE DICIEMBRE DEL 2011 En Colegio Hebreo Maguen David  A.C., con domicilio en Antiguo Camino a Tecamachalco No.370 Col. Vista Hermosa  Delegación Cuajimalpa, Ciudad de México, Distrito Federal, la información de la comunidad estudiantil así como de los Padres de Familia y Tutores es tratada de forma estrictamente confidencial por lo que al proporcionar sus datos personales a esta Institución, consiente su tratamiento con las siguientes finalidades: 1.- La realización de los expedientes de todos y cada uno de los alumnos inscritos en este Colegio; 2.- La realización de encuestas, así como la creación e implementación de procesos analíticos y estadísticos necesarios o convenientes, relacionados con el mejoramiento del sistema educativo implementado en este Colegio; 3.- La promoción de servicios, beneficios adicionales, becas, bonificaciones, concursos, todo esto ofrecido por o relacionado con las Responsables o Terceros nacionales o extranjeros con quienes este Colegio mantenga alianzas educativas; 4.- La atención de requerimientos de cualquier autoridad competente; 5.- La realización de cualquier actividad complementaria o auxiliar necesaria para la realización de los fines anteriores; 6.- La realización de consultas, investigaciones y revisiones en relación a cualquier queja o reclamación; y 7.- Ponernos en contacto con Usted para tratar cualquier tema relacionado con las labores de sus hijos en su calidad de alumnos de este Colegio; 8.- Mantener actualizados nuestros registros. Para conocer el texto completo del aviso de privacidad para la comunidad del Colegio Hebreo Maguen David A.C. favor de consultar nuestra página en Internet www.chmd.edu.mx</p> ", function () {
					//aqui introducimos lo que haremos tras cerrar la alerta.
					//por ejemplo -->  location.href = 'http://www.google.es/';  <-- Redireccionamos a GOOGLE.
				});
			}
			
			function confirmar()
                        {
				//un confirm
				alertify.confirm("<p>Aquí confirmamos algo.<br><br><b>ENTER</b> y <b>ESC</b> corresponden a <b>Aceptar</b> o <b>Cancelar</b></p>", function (e) {
					if (e) {
						alertify.success("Has pulsado '" + alertify.labels.ok + "'");
					} else { alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
					}
				}); 
				return false
			}
			
			function datos(){
				//un prompt
				alertify.prompt("Esto es un <b>prompt</b>, introduce un valor:", function (e, str) { 
					if (e){
						alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + str);
					}else{
						alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
					}
				});
				return false;
			}
			
			function notificacion(){
				alertify.log("Esto es una notificación cualquiera."); 
				return false;
			}
			
			function ok(){
				alertify.success("Visita nuestro <a href=\"http://blog.reaccionestudio.com/\" style=\"color:white;\" target=\"_blank\"><b>BLOG.</b></a>"); 
				return false;
			}
			
			function Cancelado2(){
				alertify.error("Servicio no  disponible."); 
				return false; 
			}
		

