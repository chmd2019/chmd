function Alta_Rfc()
{
 
 var idusuario = document.getElementById('idusuario').value;
 var nfamilia = document.getElementById('nfamilia').value;
 var razonsocial = document.getElementById('razonsocial').value;
 var rfc = document.getElementById('rfc').value;
 var calle = document.getElementById('calle').value;
 var colonia = document.getElementById('colonia').value;
 var cp = document.getElementById('cp').value;
 var municipio = document.getElementById('municipio').value;
 
 var entidad = document.getElementById('entidad').value;
  var correo = document.getElementById('correo').value;
 
    
 
 
 
    if(RegisterUserForm.razonsocial.value.length==0) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.razonsocial.focus();    // Damos el foco al control
    // alertify.error("<b>Error:</b>No has escrito tu Razon social."); 
    RegisterUserForm.razonsocial.style.backgroundColor = "#FF4D4D";
  // alert('Error:No has escrito tu Razon social'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
     
    else if(RegisterUserForm.razonsocial.value.length<8) 
    { //¿Tiene 0 caracteres?
     
    RegisterUserForm.razonsocial.focus();    // Damos el foco al control
// alertify.error("<b>Error:</b>No es una Razon social valida."); 
 RegisterUserForm.razonsocial.style.backgroundColor = "#FF4D4D";
   alert('Error:razon social invalida'); //Mostramos el mensaje
    return false; //devolvemos el foco
    }
    else
    {
        RegisterUserForm.razonsocial.style.backgroundColor = "white";
    }
   
   
  
    if(RegisterUserForm.rfc.value.length==0) 
    { //¿Tiene 0 caracteres?
    RegisterUserForm.rfc.focus();    // Damos el foco al control
    
   RegisterUserForm.rfc.style.backgroundColor = "#FF4D4D";
   // alert('No has escrito tu RFC'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
   else if(RegisterUserForm.rfc.value.length <=11) 
   { //¿Tiene 0 caracteres?
     //alertify.error("<b>Error:</b>RFC incorrecto"); 
     alert("Error:RFC incorrecto"); 
    RegisterUserForm.rfc.style.backgroundColor = "#FF4D4D";
       ////////////////////////////
    RegisterUserForm.rfc.focus();    // Damos el foco al control
   
    return false; //devolvemos el foco
  }
//rfc
else if (/^[a-zA-Z]{3,4}(\d{6})((\D|\d){3})?$/.test(RegisterUserForm.rfc.value))
{

     RegisterUserForm.rfc.style.backgroundColor = "white";
} 
else 
{
  RegisterUserForm.rfc.focus();
  alert("Error:RFC incorrecto"); 
  //alertify.error("<b>Error:</b>RFC incorrecto"); 
  RegisterUserForm.rfc.style.backgroundColor = "#FF4D4D";
 return false;
 }

/////rfc
  

  if(RegisterUserForm.calle.value.length==0) 
  { //¿Tiene 0 caracteres?
    RegisterUserForm.calle.focus();    // Damos el foco al control
    //alertify.error("<b>Error:</b>No has escrito tu calle"); 
    alert("Error:Agrega calle");
    RegisterUserForm.calle.style.backgroundColor = "#FF4D4D";
    return false; //devolvemos el foco
  }
  else if(RegisterUserForm.calle.value.length<2) 
  { //¿Tiene 0 caracteres?
    RegisterUserForm.calle.focus();    // Damos el foco al control
    alert("Error:Nombre de calle no valido"); 
    RegisterUserForm.calle.style.backgroundColor = "#FF4D4D";
    return false; //devolvemos el foco
  }
  else
  {
      
      RegisterUserForm.calle.style.backgroundColor = "white";
  }

  
  
  
  
   if(RegisterUserForm.colonia.value.length==0) 
      { //¿Tiene 0 caracteres?
    RegisterUserForm.colonia.focus();    // Damos el foco al control
    alert("Error:Agrega colonia");
    //alertify.error("<b>Error:</b>No has escrito tu colonia"); 
    RegisterUserForm.colonia.style.backgroundColor = "#FF4D4D";
    return false; //devolvemos el foco
  }
  
    else if(RegisterUserForm.colonia.value.length<6) 
 { //¿Tiene 0 caracteres?
    RegisterUserForm.colonia.focus();    // Damos el foco al control
    
    alert("Error:Colonia no valida");
   // alertify.error("<b>Error:</b>Colonia no valida"); 
    RegisterUserForm.colonia.style.backgroundColor = "#FF4D4D";
    
    
    return false; //devolvemos el foco
  }
  else
  {
       RegisterUserForm.colonia.style.backgroundColor = "white";
     
  }
  
   
 
   if(RegisterUserForm.cp.value.length==0) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.cp.focus();    // Damos el foco al control
   
    
     alert("Error:No has escrito CP"); 
    RegisterUserForm.cp.style.backgroundColor = "#FF4D4D";
    return false; //devolvemos el foco
  }

  else if(RegisterUserForm.cp.value.length<=4) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.cp.focus();    // Damos el foco al control
    
     alert("Error:CP incorrecto"); 
    RegisterUserForm.cp.style.backgroundColor = "#FF4D4D";
  
    return false; //devolvemos el foco
  }
 
else  if (isNaN(RegisterUserForm.cp.value)) 
{
RegisterUserForm.cp.focus();

alert("Error:CP debe tener sólo números."); 
RegisterUserForm.cp.style.backgroundColor = "#FF4D4D";


return false;
}
 else
  {
       RegisterUserForm.cp.style.backgroundColor = "white";
  }


//municipio




  if(RegisterUserForm.municipio.value.length==0) 
  { //¿Tiene 0 caracteres?
    RegisterUserForm.municipio.focus();    // Damos el foco al control
    //alertify.error("<b>Error:</b>No has escrito tu calle"); 
    alert("Error:Agrega municipio");
    RegisterUserForm.municipio.style.backgroundColor = "#FF4D4D";
    return false; //devolvemos el foco
  }
  else if(RegisterUserForm.municipio.value.length<8) 
  { //¿Tiene 0 caracteres?
    RegisterUserForm.municipio.focus();    // Damos el foco al control
    alert("Error:Nombre de municipio no valido"); 
    RegisterUserForm.municipio.style.backgroundColor = "#FF4D4D";
    return false; //devolvemos el foco
  }
  else
  {
      
      RegisterUserForm.municipio.style.backgroundColor = "white";
  }

//fin de municipio

 if(RegisterUserForm.entidad.value==0) 
 { //¿Tiene 0 caracteres?
    RegisterUserForm.entidad.focus();    // Damos el foco al control
    alert("Error:Selecciona Entidad"); 
    RegisterUserForm.entidad.style.backgroundColor = "#FF4D4D";
    return false; //devolvemos el foco
  }
  else
  {
      RegisterUserForm.entidad.style.backgroundColor = "white";
     
  }
  
  

  //ajax

		$.ajax({
			url: 'Rfc_Alta.php',
			type: "POST",
			data: "submit=&idusuario="+idusuario+"\
&nfamilia="+nfamilia+"\
&razonsocial="+razonsocial+"\
&rfc="+rfc+"\
&calle="+calle+"\
&colonia="+colonia+"\
&cp="+cp+"\
&municipio="+municipio+"\
&entidad="+entidad+"\
&correo="+correo,

			success: function(datos)
                        {
				//alertify.success(datos);
                                alert(datos);
                               
                                $("#tabla").load(" #tabla");
                                $("#formulario").hide();
				$("#tabla").show();
				
                                
			}
		});
                
                 
		return false;

}



function ConsultaDatos()
{
		$.ajax({
			url: 'RFC.php',
			cache: false,
			type: "GET",
			success: function(datos)
                        {
				$("#tabla").html(datos);
                                
			}
		});
               
	}
        
        
        
        
        function actualizar()
        {
	 $(".contenedor").html(datos).fadeIn('fast');
	
}



function Cancelar()
{
    
		$("#formulario").hide();
		$("#tabla").show();
		
}