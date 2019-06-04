function Alta_Auto()
{
 
 var idauto = document.getElementById('idauto').value;
//var idusuario = document.getElementById('idusuario').value;
var nfamilia = document.getElementById('nfamilia').value;
var correo = document.getElementById('correo').value;


var marca = document.getElementById('marca').value;
var modelo = document.getElementById('modelo').value;
var color = document.getElementById('color').value;
var placas = document.getElementById('placas').value;

//var completo = str1.concat(paterno, materno);

   
 /////////////////////////////////  paterno

  
  /////////////// marca
  if(RegisterUserForm.marca.value.length==0) 
    { //¿Tiene 0 caracteres?
     
   RegisterUserForm.marca.focus();    // Damos el foco al control
   alertify.alert("<b>Error:</b>No has escrito la marca."); 
   RegisterUserForm.marca.style.backgroundColor = "#FF4D4D";
  // alert('Error:No marca escrito tu Razon social'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
     
    else if(RegisterUserForm.marca.value.length<2) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.marca.focus();    // Damos el foco al control
// alertify.error("<b>Error:</b>No es una Razon social valida."); 
 RegisterUserForm.marca.style.backgroundColor = "#FF4D4D";
   alertify.alert('Error:Agrega marca completo'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
    else
    {
        RegisterUserForm.marca.style.backgroundColor = "white";
    }
    
    
    ////////////////////////////
    /////////////// modelo
  if(RegisterUserForm.modelo.value.length==0) 
    { //¿Tiene 0 caracteres?
     
   RegisterUserForm.modelo.focus();    // Damos el foco al control
   alertify.alert("<b>Error:</b>No has escrito la modelo."); 
   RegisterUserForm.modelo.style.backgroundColor = "#FF4D4D";
  // alert('Error:No marca escrito tu Razon social'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
     
    else if(RegisterUserForm.modelo.value.length<2) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.modelo.focus();    // Damos el foco al control
// alertify.error("<b>Error:</b>No es una Razon social valida."); 
 RegisterUserForm.modelo.style.backgroundColor = "#FF4D4D";
   alertify.alert('Error:Agrega modelo'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
    else
    {
        RegisterUserForm.modelo.style.backgroundColor = "white";
    }


   /////////////// color
  if(RegisterUserForm.color.value.length==0) 
    { //¿Tiene 0 caracteres?
     
   RegisterUserForm.color.focus();    // Damos el foco al control
   alertify.alert("<b>Error:</b>No has escrito el color."); 
   RegisterUserForm.color.style.backgroundColor = "#FF4D4D";
  // alert('Error:No marca escrito tu Razon social'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
     
    else if(RegisterUserForm.color.value.length<2) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.color.focus();    // Damos el foco al control
// alertify.error("<b>Error:</b>No es una Razon social valida."); 
 RegisterUserForm.color.style.backgroundColor = "#FF4D4D";
   alertify.alert('Error:Agrega color'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
    else
    {
        RegisterUserForm.modelo.style.backgroundColor = "white";
    }

  
//
  //ajax
  
  

		$.ajax({
			url: 'Autos_alta.php',
			type: "POST",
			data: "submit=&idauto="+idauto+"\
&nfamilia="+nfamilia+"\
&correo="+correo+"\
&marca="+marca+"\
&modelo="+modelo+"\
&color="+color+"\
&placas="+placas,

			success: function(datos)
                        {
				//alertify.success(datos);
                                alertify.alert(datos);
                               
                              //  $("#tabla").load(" #tabla");
                              //  $("#formulario").hide();
			//	$("#tabla").show();
                        
                        
                               // ConsultaDatos();
				$("#formulario").hide();
				$("#tabla").show();
                                 location.reload();
				
                                
			}
		});
                
                 
		return false;

}




function ConsultaDatos(){
		$.ajax({
			url: 'Choferes.php',
			cache: false,
			type: "GET",
			success: function(datos){
				$("#tabla").html(datos);
                                 location.reload();
                               
			}
		});
	}
        
        
    
        
function  CancelarChofer(idchofer,nombre,$correo)
        {
            
      
         
		var msg = confirm("Esta seguro de cancelar al chofer:"+nombre+" \n Una vez confirmado no podra hacer cambios." );
                
                
		if ( msg ) 
                {
			$.ajax({
				url: 'Cancelar_chofer.php',
				type: "GET",
				data: "idchofer="+idchofer+"\&correo="+$correo,
				success: function(datos){
		                 alertify.alert(datos);
			       $("#formulario").hide();
				$("#tabla").show();
                                 location.reload();
				
				}
			});
		}
		return false;
               
	}






function Cancelar()
{
$("#formulario").hide();
$("#tabla").show();
		
}