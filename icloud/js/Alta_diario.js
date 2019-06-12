function Alta_Diario()
{
    
    var fecha10 = new Date();
    var hora=fecha10.getHours();
    var minutos=fecha10.getMinutes();
    var dia=fecha10.getDay();

    
    
  /**
    var fecha1 = new Date();
    var hora=fecha1.getHours();
    var minutos=fecha1.getMinutes();
    
   if(hora==11 )
    {
        if(minutos>='30')
        {  
        
        alert('Fuera de horario. Favor de intentar despues de las 16:00 hrs.');
        return false;
        }
    }
    
 
    
    
    if(hora>='12')
    {
        
        alert('Fuera de horario. Favor de intentar despues de las 16:00 hrs2017.');
        return false;
   
    }
    if(hora>='13')
    {
        
        alert('Fuera de horario. Favor de intentar despues de las 16:00 hrs.');
        return false;
   
    }
      if(hora>='14')
    {
        
        alert('Fuera de horario. Favor de intentar despues de las 16:00 hrs.');
        return false;
   
    }
      if(hora>='15')
    {
        
        alert('Fuera de horario. Favor de intentar despues de las 16:00 hrs.');
        return false;
   
    }
    
    
    
    */
      
 
    

    
 
 var talumnos = document.getElementById('talumnos').value;
 var idusuario = document.getElementById('idusuario').value; 
 var nfamilia = document.getElementById('nfamilia').value;
 var calle = document.getElementById('calle').value;
 var colonia = document.getElementById('colonia').value;
 var cp = document.getElementById('cp').value;
 var fecha = document.getElementById('fecha').value;
 var fecha1 = document.getElementById('fecha1').value; 
 
 
/**************************************/

  function checkPassword(str)
  {                         
    var re = /^(?=.*\d)(?=.*[A-Za-z ]+[0-9 ]).{1,50}$/;
    return re.test(str);
  }
 
    
 /****************************************/
 
    
    if(fecha1.length <= 1  || fecha1 == null)
 {
      var fecha1=0
 }
///////
          if(hora==11 )
    {
        
       
        if(minutos>='30')
        {
            
            if(fecha1==0)
            {
                
              alertify.alert("Fuera de horario");  
              return false; //devolvemos el foco   
            }
          
           
           
          
           
        }
       
      else
        {
             
            
        }
        
    }
    
     if(hora>=12)
    {
         
        if(fecha1==0)
            {
              RegisterUserForm.fecha1.focus();    // Damos el foco al control
              RegisterUserForm.fecha1.style.backgroundColor = "#FF4D4D";
              alertify.alert("Selecciona la fecha para el permiso");  
              return false; //devolvemos el foco   
            }
            else
      {
           RegisterUserForm.colonia.style.backgroundColor = "white"; 
      }
  
        
    }
//////alumnos
 

 
   
 //validacion de alumnos
var suma = 0;
var los_cboxes = document.getElementsByName('alumno[]'); 
for (var i = 0, j = los_cboxes.length; i < j; i++)
{
    
    if(los_cboxes[i].checked == true)
    {
    suma++;
    }
}
 
if(suma == 0)
{
 alertify.alert("debe seleccionar alumnos."); 
return false;
}


if (talumnos == 1) 
{
var alum1 = document.getElementById('alumno1').checked; 
if (alum1==true)
{
    var alumno1 = document.getElementById('alumno1').value;
    var alumno2 =0;
    var alumno3 =0;
    var alumno4 =0;
    var alumno5 =0;
}
 
 

}
 if (talumnos == 2) 
{
  var alum1 = document.getElementById('alumno1').checked;
  var alum2 = document.getElementById('alumno2').checked;
  
  
  if (alum1==true)
{var alumno1 = document.getElementById('alumno1').value;}
else{var alumno1 =0;}
////////////////////
if (alum2==true)
{var alumno2 = document.getElementById('alumno2').value;}
else{var alumno2 =0;}

 var alumno3 =0;
 var alumno4 =0;
 var alumno5 =0;

    
}
///////////////
 if (talumnos == 3) 
{
  var alum1 = document.getElementById('alumno1').checked;
  var alum2 = document.getElementById('alumno2').checked;
  var alum3 = document.getElementById('alumno3').checked;
  
  if (alum1==true)
{var alumno1 = document.getElementById('alumno1').value;}
else{var alumno1 =0;}
////////////////////
if (alum2==true)
{var alumno2 = document.getElementById('alumno2').value;}
else{var alumno2 =0;}
////////////////////////
if (alum3==true)
{var alumno3 = document.getElementById('alumno3').value;}
else{var alumno3 =0;}

var alumno4 =0;
var alumno5 =0;
    
}
 if (talumnos == 4) 
{
  var alum1 = document.getElementById('alumno1').checked;
  var alum2 = document.getElementById('alumno2').checked;
  var alum3 = document.getElementById('alumno3').checked;
  var alum4 = document.getElementById('alumno4').checked;
  
  if (alum1==true)
{var alumno1 = document.getElementById('alumno1').value;}
else{var alumno1 =0;}
////////////////////
if (alum2==true)
{var alumno2 = document.getElementById('alumno2').value;}
else{var alumno2 =0;}
////////////////////////
if (alum3==true)
{var alumno3 = document.getElementById('alumno3').value;}
else{var alumno3 =0;}
/////////////////////////////////
if (alum4==true)
{var alumno4 = document.getElementById('alumno4').value;}
else{var alumno4 =0;}

var alumno5 =0;
    
}
///////////////////////
 if (talumnos == 5) 
{
  var alum1 = document.getElementById('alumno1').checked;
  var alum2 = document.getElementById('alumno2').checked;
  var alum3 = document.getElementById('alumno3').checked;
  var alum4 = document.getElementById('alumno4').checked;
  var alum5 = document.getElementById('alumno5').checked;
  
  
if (alum1==true)
{var alumno1 = document.getElementById('alumno1').value;}
else{var alumno1 =0;}
////////////////////
if (alum2==true)
{var alumno2 = document.getElementById('alumno2').value;}
else{var alumno2 =0;}
////////////////////////
if (alum3==true)
{var alumno3 = document.getElementById('alumno3').value;}
else{var alumno3 =0;}
/////////////////////////////////
if (alum4==true)
{var alumno4 = document.getElementById('alumno4').value;}
else{var alumno4 =0;}
//////////////////////////////////////
if (alum5==true)
{var alumno5 = document.getElementById('alumno5').value;}
else{var alumno5 =0;}
/////////////////////////////////////////////
    
}
else
{

}
//validacion por cantidad de alumnos


  

 //validar domicilio
 
 if(RegisterUserForm.calle.value.length<=5 ) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.calle.focus();    // Damos el foco al control
    RegisterUserForm.calle.style.backgroundColor = "#FF4D4D";
   alertify.alert("Ingresa calle y numero");  
    return false; //devolvemos el foco
  }
    else
  {
       RegisterUserForm.calle.style.backgroundColor = "white"; 
  }
  
  /*
  if(!checkPassword(RegisterUserForm.calle.value)) 
  {
         RegisterUserForm.calle.focus();    // Damos el foco al control
         RegisterUserForm.calle.style.backgroundColor = "#FF4D4D";
   alertify.alert("Agrega calle número");  
    return false; //devolvemos el foco
      }
    else
      {
           RegisterUserForm.calle.style.backgroundColor = "white"; 
      }
  
  */
  
   if(RegisterUserForm.colonia.value.length<=5) 
   { //¿Tiene 0 caracteres?
   RegisterUserForm.colonia.focus();    // Damos el foco al control
    RegisterUserForm.colonia.style.backgroundColor = "#FF4D4D";
     alertify.alert("Ingresa colonia");  
  
    return false; //devolvemos el foco
  }
  else
      {
           RegisterUserForm.colonia.style.backgroundColor = "white"; 
      }
      
      
   if(RegisterUserForm.cp.value.length<=4 || RegisterUserForm.cp.value.length>=6) 
   {
     
         cp="00000";
      
  }
  
/*  
   if(RegisterUserForm.cp.value.length<=4 || RegisterUserForm.cp.value.length>=6) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.cp.focus();    // Damos el foco al control
     alertify.error("CP Incorrecto");  
  
    return false; //devolvemos el foco
  }
 */
 //validar seleccion de dia
 
     //validar ruta
 indice = document.getElementById("ruta").selectedIndex;
if( indice == null || indice == 0 )
 {
  alertify.alert("selecciona Ruta");  
  RegisterUserForm.ruta.focus();   
  return false;
}
var ruta =document.RegisterUserForm.ruta.value;

var comentarios =document.RegisterUserForm.comentarios.value;


//ajax

              
		
		$.ajax({
			url: 'Diario_Alta.php',
			type: "POST",
			data: "submit=&idusuario="+idusuario+"\
&alumno1="+alumno1+"\
&alumno2="+alumno2+"\
&alumno3="+alumno3+"\
&alumno4="+alumno4+"\
&alumno5="+alumno5+"\
&calle="+calle+"\
&colonia="+colonia+"\
&cp="+cp+"\
&ruta="+ruta+"\
&comentarios="+comentarios+"\
&suma="+suma+"\
&nfamilia="+nfamilia+"\
&fecha="+fecha+"\
&fecha1="+fecha1,
			success: function(datos)
                        {
				
				//$("#tabla").load(" #tabla");
                                //$("#formulario").hide();
				//$("#tabla").show();
                                alertify.alert(datos);
                                window.location = window.location;
                                
			}
		});
                
                    
		return false;


}
            
function ConsultaDatos(){
		$.ajax({
			url: 'PDiario.php',
			cache: false,
			type: "GET",
			success: function(datos){
				$("#tabla").html(datos);
			}
		});
	}


function Cancelar()
{
    $("#formulario").hide();
    $("#tabla").show();
    window.location = "PDiario.php";
}

