
function Detalle_evento()
{

     var idusuario = document.getElementById('idusuario').value;
     

             
                  
/*********************ajax***********************************/
	$.ajax({
			url: 'Detalle_evento.php',
			type: "POST",
			data: "submit=&idusuario="+idusuario,
success: function(datos)
{
				
				//$("#tabla").load(" #tabla");
                                //$("#formulario").hide();
				//$("#tabla").show();
                                //alertify.alert(datos);
                               alert(datos);
                               
				$("#formulario").hide();
				$("#tabla").show();
                                location.reload();
                                
                                
			}
		});
                 
 
     
      return false ;


                




}

            
function ConsultaDatos()
{
		$.ajax(
                        {
			url: 'Eventos.php',
			cache: false,
			type: "GET",
			success: function(datos)
                        {
				$("#tabla").html(datos);
			}
		});
	}


function Cancelar()
{
alertify.confirm("<h2><font color='#FF7373'>!ALERTA¡</font></h2><p>¿Deseas regresar sin cerrar el evento?.<br>Una vez concluido el evento se podrá cambiar información<br><b>ENTER</b> y <b>ESC</b> corresponden a <b>Aceptar</b> o <b>Cancelar</b></p>", function (e) {
            if (e) {
                  alertify.success("Has pulsado '" + alertify.labels.ok + "'");
                  $("#formulario").hide();
                   $("#tabla").show();
 
            } else { 
                        alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
            }
      }); 
      return false ;
		
}


function Acuerdos1(){var idusuario = $('#idusuario').val(); var valor=1; AgregaAcuerdos(idusuario,valor);}
function Acuerdos2(){var idusuario = $('#idusuario').val(); var valor=2; AgregaAcuerdos(idusuario,valor);}
function Acuerdos3(){var idusuario = $('#idusuario').val(); var valor=3; AgregaAcuerdos(idusuario,valor);}
function Acuerdos4(){var idusuario = $('#idusuario').val(); var valor=4; AgregaAcuerdos(idusuario,valor);}
function Acuerdos5(){var idusuario = $('#idusuario').val(); var valor=5; AgregaAcuerdos(idusuario,valor);}
function Acuerdos6(){var idusuario = $('#idusuario').val(); var valor=6; AgregaAcuerdos(idusuario,valor);}
function Acuerdos7(){var idusuario = $('#idusuario').val(); var valor=7; AgregaAcuerdos(idusuario,valor);}
function Acuerdos8(){var idusuario = $('#idusuario').val(); var valor=8; AgregaAcuerdos(idusuario,valor);}
function Acuerdos9(){var idusuario = $('#idusuario').val(); var valor=9; AgregaAcuerdos(idusuario,valor);}
function Acuerdos10(){var idusuario = $('#idusuario').val(); var valor=10; AgregaAcuerdos(idusuario,valor);}
function Acuerdos11(){var idusuario = $('#idusuario').val(); var valor=11; AgregaAcuerdos(idusuario,valor);}
function Acuerdos12(){var idusuario = $('#idusuario').val(); var valor=12; AgregaAcuerdos(idusuario,valor);}
function Acuerdos13(){var idusuario = $('#idusuario').val(); var valor=13; AgregaAcuerdos(idusuario,valor);}
function Acuerdos14(){var idusuario = $('#idusuario').val(); var valor=14; AgregaAcuerdos(idusuario,valor);}
function Acuerdos15(){var idusuario = $('#idusuario').val(); var valor=15; AgregaAcuerdos(idusuario,valor);}

function Acuerdos16(){var idusuario = $('#idusuario').val(); var valor=16; AgregaAcuerdos(idusuario,valor);}
function Acuerdos17(){var idusuario = $('#idusuario').val(); var valor=17; AgregaAcuerdos(idusuario,valor);}
function Acuerdos18(){var idusuario = $('#idusuario').val(); var valor=18; AgregaAcuerdos(idusuario,valor);}
function Acuerdos19(){var idusuario = $('#idusuario').val(); var valor=19; AgregaAcuerdos(idusuario,valor);}
function Acuerdos20(){var idusuario = $('#idusuario').val(); var valor=20; AgregaAcuerdos(idusuario,valor);}
function Acuerdos21(){var idusuario = $('#idusuario').val(); var valor=21; AgregaAcuerdos(idusuario,valor);}
function Acuerdos22(){var idusuario = $('#idusuario').val(); var valor=22; AgregaAcuerdos(idusuario,valor);}
function Acuerdos23(){var idusuario = $('#idusuario').val(); var valor=23; AgregaAcuerdos(idusuario,valor);}
function Acuerdos24(){var idusuario = $('#idusuario').val(); var valor=24; AgregaAcuerdos(idusuario,valor);}
function Acuerdos25(){var idusuario = $('#idusuario').val(); var valor=25; AgregaAcuerdos(idusuario,valor);}
function Acuerdos26(){var idusuario = $('#idusuario').val(); var valor=26; AgregaAcuerdos(idusuario,valor);}







function AgregaAcuerdos(idusuario,valor) 
{
  var acuerdos = $('#acuerdos'+valor).val(); 
   var id_tema = $('#id_tema'+valor).val();
    
$.ajax(
	{
		url : 'Validar_temas.php?acuerdos=true&idusuario='+idusuario+'&acuerdos='+acuerdos+'&id_tema='+id_tema,
					dataType : 'json',
				}).done(function(data) {
			if (data.id == '-1')
                        {
				 alertify.error("Error: ");  
			} 
                        else 
                        {
				
                              alertify.success("Correcto");  
			}
		});

}

 