function Prueba2()
{
  /************************************metodo dinamico*****************************************/  
  
    

/////////////////////////////////////////////////////////////
/***************************************************************************************/
     var idusuario = document.getElementById('idusuario').value;
     var titulo = document.getElementById('titulo').value;
     /**********************************************************************/
  

     
     
     /********************************************************/
     var fecha1 = document.getElementById('fecha1').value; 
     var hora = document.getElementById('hora').value;
     
     if(idusuario == null)
     {
        alertify.alert("Error de ID");  
  
          return false; 
     }
     


/////////////////////////////////////////////////////////////
/***************validar seleccion de comite***********************/
      //validar ruta
/*      
 indice = document.getElementById("comite").selectedIndex;
if( indice == null || indice == 0 )
{
   document.RegisterUserForm.comite.focus();
  alertify.alert("selecciona comite");  
  return false;
}
    */
var comite =document.RegisterUserForm.comite.value;

/*******************valida convocado*****************************/

 var convocado = document.getElementById('convocado').value;


/*************************************************************************/

 
 var invitado = document.getElementById('invitado').value;
 var director = document.getElementById('director').value;

//////////////////////////////////////////////////
  
    
    
  if(RegisterUserForm.director.value.length<=4 ) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.director.focus();    // Damos el foco al control
    RegisterUserForm.director.style.backgroundColor = "#FF4D4D";
   alertify.alert("Ingresa director");  
    return false; //devolvemos el foco
  }
    else
  {
       RegisterUserForm.director.style.backgroundColor = "white"; 
  }
    
    

 /****************************************/
 
    
    if(fecha1.length <= 1  || fecha1 == null)
 {
      RegisterUserForm.fecha1.focus();    // Damos el foco al control
    RegisterUserForm.fecha1.style.backgroundColor = "#FF4D4D";
   alertify.alert("Ingresa fecha1");  
    return false; //devolvemos el foco
 }
 else
 {
     RegisterUserForm.fecha1.style.backgroundColor = "white"; 
 }



/////////////////////////////////////////////////////////////////

     var a = document.querySelectorAll("input[type='text']"); //BUSCAMOS TODOS LOS INPUTS
        var iCnt = 0;
     for(var b in a)
     { //COMO RETORNA UN ARRAY ITERAMOS
             var c = a[b];
       if(typeof c == "object")   
       {
            console.log(c.name,c.value);
             if(c.id == "titulo" || c.id == "fecha1" || c.id == "hora" || c.id == "convocado" || c.id == "invitado" || c.id == "director" || c.id == "caja_busqueda")
             {
                 
             }
             else
{
    ////////////////////////////slolo los campos 
    
           console.log(c.name,c.value);
             iCnt = iCnt + 1;
           // SOLO PUROS OBJECTS
         // SOLO BUSCAMOS LOS PRODUCTOS Y CANTIDADES
         
         var z ="tema"; 
         //var b = iCnt;
         //var d=c.value;
         window[z+iCnt] = c.value; 
         // console.log(c.name,c.value); // NOMBRE DEL INPUT Y SU VALOR DE LA BUSQUEDA...
           window["cantidad"] = iCnt; 
           
           
        ////////////////agregar metodo de  validacion por tema////////////////////////////////
 
          
       
       
       ///////////////////////////////////////////
           
           
           
         
                 
 }
           
         
       
           
 
       }
    
     
    
    }

if(iCnt==0)
{
    alertify.alert("Agrega temas a tratar");
      return false;
}
   

  var cant=cantidad;
  

 
/*******************************validacion de temas****************************************/

/*****************************seleccion 2************************************************/


for ( var i = cant; i < 27; i++) 
{
    cant = cant + 1;
  var z1 ="tema"; 
         //var b = iCnt;
         //var d=c.value;
         window[z1+cant] = 0; 
         // console.log(c.name,c.value); // NOMBRE DEL INPUT Y SU VALOR DE LA BUSQUEDA...
        
}
 
///////////////////////////////////////////////////////////
 Asistencia_usuario(idusuario);
 

////////////////////////////////

/*********************ajax***********************************/
	$.ajax({
			url: 'Evento_Alta.php',
			type: "POST",
			data: "submit=&idusuario="+idusuario+"\
&titulo="+titulo+"\
&fecha1="+fecha1+"\
&hora="+hora+"\
&convocado="+convocado+"\
&director="+director+"\
&invitado="+invitado+"\\n\
&comite="+comite+"\
&cantidad="+cantidad+"\
&tema1="+tema1+"\
&tema2="+tema2+"\
&tema3="+tema3+"\
&tema4="+tema4+"\
&tema5="+tema5+"\
&tema6="+tema6+"\
&tema7="+tema7+"\
&tema8="+tema8+"\
&tema9="+tema9+"\
&tema10="+tema10+"\
&tema11="+tema11+"\
&tema12="+tema12+"\
&tema13="+tema13+"\
&tema14="+tema14+"\
&tema15="+tema15+"\
&tema16="+tema16+"\
&tema17="+tema17+"\
&tema18="+tema18+"\
&tema19="+tema19+"\
&tema20="+tema20+"\
&tema21="+tema21+"\
&tema22="+tema22+"\
&tema23="+tema23+"\
&tema24="+tema24+"\
&tema25="+tema25+"\
&tema26="+tema26,                
success: function(datos)
{
				
				//$("#tabla").load(" #tabla");
                                //$("#formulario").hide();
				//$("#tabla").show();
                                //alertify.alert(datos);
                               alert(datos);
                               // ConsultaDatos();
				$("#formulario").hide();
				$("#tabla").show();
                                location.reload();
                                
                                
			}
		});
                
                    
		return false;



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
    
 alertify.confirm("<h2><font color='#FF7373'>!ALERTA¡</font></h2><p>¿Deseas regresar sin guardar el evento?.<br><br><b>ENTER</b> y <b>ESC</b> corresponden a <b>Aceptar</b> o <b>Cancelar</b></p>", function (e) {
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


function comprobarTitulo() 
{

var titulo = $('#titulo').val();

$.ajax(
	{
		url : 'Validar_temas.php?ValidaTutulo=true&titulo='+titulo,
					dataType : 'json',
				}).done(function(data) {
			if (data.id == '-1')
                        {
RegisterUserForm.titulo.focus();    // Damos el foco al control
    RegisterUserForm.titulo.style.backgroundColor = "#FF4D4D";
   alertify.error("Error: nombre del tema ya existe");  
    return false; //devolvemos el foco
			} 
                        else 
                        {
				// alert("No existe");
			}
		});
}



/////////////////////////////////

  function comprobarTema() 
{
    var temavalida = $('#temavalida').val();
     $.ajax(
	{
		url : 'Validar_temas.php?ValidaTema=true&temavalida='+temavalida,
					dataType : 'json',
				}).done(function(data) {
			if (data.id == '-1')
                        {
                  // nomcampo.focus();    // Damos el foco al control
                  // nomcampo.style.backgroundColor = "#FF4D4D";
                   alertify.alert("Error: nombre del tema ya existe"+temavalida);  
               
                   return false; //devolvemos el foco
			} 
                        else 
                        {
				//alert("temavalida"+temavalida);
			}
		});
    
}


////////////////////////////////////////////////agregar asistencia usuarios

function Asistencia_usuario(idusuario) 
{

var id_evento = idusuario;
var id_comite = $('#comite').val();

$.ajax(
	{
		url : 'Validar_temas.php?AsistenciaUsuario=true&id_evento='+id_evento+'&id_comite='+id_comite,
					dataType : 'json',
				}).done(function(data) {
			if (data.id == '-1')
                        {
       RegisterUserForm.titulo.focus();    // Damos el foco al control
    RegisterUserForm.titulo.style.backgroundColor = "#FF4D4D";
   alertify.error("Error: nombre del tema ya existe");  
    return false; //devolvemos el foco
			} 
                        else 
                        {
				// alert("No existe");
			}
		});
}