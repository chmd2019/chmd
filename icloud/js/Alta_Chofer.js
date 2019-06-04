function Alta_Chofer()
{
 
var idusuario = document.getElementById('idusuario').value;
var nfamilia = document.getElementById('nfamilia').value;
var chofer = document.getElementById('chofer').value;
var correo = document.getElementById('correo').value;

 var paterno = document.getElementById('paterno').value;
 var materno = document.getElementById('materno').value;

var marca = document.getElementById('marca').value;
var modelo = document.getElementById('modelo').value;
var color = document.getElementById('color').value;
var placas = document.getElementById('placas').value;

//var completo = str1.concat(paterno, materno);


    
 
    if(RegisterUserForm.chofer.value.length==0) 
    { //¿Tiene 0 caracteres?
     alertify.alert("Error:Agrega Nombre");
    RegisterUserForm.chofer.focus();    // Damos el foco al control
    // alertify.error("<b>Error:</b>No has escrito tu Razon social."); 
    RegisterUserForm.chofer.style.backgroundColor = "#FF4D4D";
  // alert('Error:No has escrito tu Razon social'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
     
    else if(RegisterUserForm.chofer.value.length<2) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.chofer.focus();    // Damos el foco al control

 RegisterUserForm.chofer.style.backgroundColor = "#FF4D4D";
   alertify.alert('Error:Nombre no valido'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
    else
    {
        RegisterUserForm.chofer.style.backgroundColor = "white";
    }
   
 /////////////////////////////////  paterno
 
 
 if(RegisterUserForm.paterno.value.length==0) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.paterno.focus();    // Damos el foco al control
   alertify.alert("<b>Error:</b>No has escrito apellido paterno."); 
    RegisterUserForm.paterno.style.backgroundColor = "#FF4D4D";
  // alert('Error:No has escrito tu Razon social'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
     
    else if(RegisterUserForm.paterno.value.length<2) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.paterno.focus();    // Damos el foco al control
// alertify.error("<b>Error:</b>No es una Razon social valida."); 
    RegisterUserForm.paterno.style.backgroundColor = "#FF4D4D";
   alertify.alert('Error:Agrega apellido completo'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
    else
    {
        RegisterUserForm.paterno.style.backgroundColor = "white";
    }
  
  /////////////// materno
  if(RegisterUserForm.materno.value.length==0) 
    { //¿Tiene 0 caracteres?
     
   RegisterUserForm.materno.focus();    // Damos el foco al control
   alertify.alert("<b>Error:</b>No has escrito tu apellido materno."); 
   RegisterUserForm.materno.style.backgroundColor = "#FF4D4D";
  // alert('Error:No has escrito tu Razon social'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
     
    else if(RegisterUserForm.materno.value.length<2) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.materno.focus();    // Damos el foco al control
// alertify.error("<b>Error:</b>No es una Razon social valida."); 
 RegisterUserForm.materno.style.backgroundColor = "#FF4D4D";
   alertify.alert('Error:Agrega nombre completo'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
    else
    {
        RegisterUserForm.materno.style.backgroundColor = "white";
    }

  
//
  //ajax
  
  

		$.ajax({
			url: 'Choferes_alta.php',
			type: "POST",
			data: "submit=&idusuario="+idusuario+"\
&nfamilia="+nfamilia+"\
&chofer="+chofer+"\
&correo="+correo+"\
&paterno="+paterno+"\
&materno="+materno+"\
&marca="+marca+"\
&modelo="+modelo+"\
&color="+color+"\
&placas="+placas,

success: function(datos)
  {
                            var str =datos;
                            var st = str.trim();     
                            
      if(st==1)
      {
              alertify.confirm("<p>Datos guardados.<br><br><b>ENTER</b> y <b>ESC</b>  <b>Aceptar</b> o <b>Cancelar</b></p>", function (e) {
            if (e)
            {
                ConsultaDatos();
				$("#formulario").hide();
				$("#tabla").show();
                  
            } else 
            {
                ConsultaDatos();
				$("#formulario").hide();
				$("#tabla").show();
                
                     
            }
      });
          
      }
      else
      {
          alert("alert");
          $("#formulario").hide();
	$("#tabla").show();
      }
                            
                            
				//alertify.success(datos);
                                //alertify.alert(datos);
                               //window.location.reload();
                                //$("#tabla").load(" #tabla");
                               // $("#formulario").hide();
				//$("#tabla").show();
				
                                
}
		});
                
                 
		return false;

}


function ConsultaDatos(){
		$.ajax({
			url: 'Choferes/Choferes.php',
			cache: false,
			type: "GET",
			success: function(datos){
				$("#tabla").html(datos);
                                 
			}
		});
	}

        
        
    
        
function  CancelarChofer(idchofer,nombre)
        {
            
      
         
		var msg = confirm("Esta seguro de cancelar al chofer:"+nombre+" \n Una vez confirmado no podra hacer cambios." );
                
                
		if ( msg ) 
                {
			$.ajax({
				url: 'Cancelar_chofer.php',
				type: "GET",
				data: "idchofer="+idchofer,
				success: function(datos){
		                alert(datos);
			        $("#tabla").load(" #tabla");
                                $("#formulario").hide();
				$("#tabla").show();
				
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