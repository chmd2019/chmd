function Alta_Viaje()
{

var fecha = document.getElementById('fecha').value;
 var idusuario = document.getElementById('idusuario').value;
 
 var talumnos = document.getElementById('talumnos').value;
 
 var nfamilia = document.getElementById('nfamilia').value;
  var calle = document.getElementById('calle').value;
  var colonia = document.getElementById('colonia').value;
  var cp = document.getElementById('cp').value;
  
  var responsable = document.getElementById('responsable').value;
  var parentesco = document.getElementById('parentesco').value;
  var celular = document.getElementById('celular').value;
  var telefono = document.getElementById('telefono').value;
  
  var fechaini = document.getElementById('fechaini').value;
  var fechater = document.getElementById('fechater').value;
  
  

 
    function checkPassword(str)
  {
    var re = /^(?=.*\d)(?=.*[A-Za-z ]+[0-9 ]).{1,50}$/;
    return re.test(str);
  }
  
 
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

alertify.alert("Selecciona Alumnos");    
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
//alert("edwin"+suma);
}
//validacion por cantidad de alumnos




 //validar domicilio
 
 if(RegisterUserForm.calle.value.length<=8) 
   { //¿Tiene 0 caracteres?
   RegisterUserForm.calle.style.backgroundColor = "#FF4D4D";
    RegisterUserForm.calle.focus();    // Damos el foco al control
    alertify.alert("Ingresa calle y numero DD");
   
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
   alertify.alert("Agrega calle número 12");  
    return false; //devolvemos el foco
      }
          else
       {
           RegisterUserForm.calle.style.backgroundColor = "white"; 
      }
  */
   if(RegisterUserForm.colonia.value.length<=4) 
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
  else
  
   {
           RegisterUserForm.cp.style.backgroundColor = "white"; 
      }
 //validar datos de responsable

if(RegisterUserForm.responsable.value.length<=2) 
{ //¿Tiene 0 caracteres?
    RegisterUserForm.responsable.focus();    // Damos el foco al control
    RegisterUserForm.responsable.style.backgroundColor = "#FF4D4D";
    alertify.alert("Ingresa responsable");
    return false; //devolvemos el foco
}
  else
  
   {
           RegisterUserForm.responsable.style.backgroundColor = "white"; 
      }


if(RegisterUserForm.parentesco.value.length<=2) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.parentesco.focus();    // Damos el foco al control
     RegisterUserForm.parentesco.style.backgroundColor = "#FF4D4D";
    alertify.alert("Ingresa parentesco");
  
    return false; //devolvemos el foco
  }
  else
      {
           RegisterUserForm.parentesco.style.backgroundColor = "white"; 
      }
  
  
  
  

  
  if(RegisterUserForm.celular.value.length<=7 || RegisterUserForm.celular.value.length>=11 ) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.celular.style.backgroundColor = "#FF4D4D";
    RegisterUserForm.celular.focus();    // Damos el foco al control
    alertify.alert("Error en Celuar");
  
    return false; //devolvemos el foco
  }
  
  
  
     {
           RegisterUserForm.celular.style.backgroundColor = "white"; 
      }
  

  
    if(RegisterUserForm.telefono.value.length<=7 || RegisterUserForm.telefono.value.length>=9) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.telefono.focus();    // Damos el foco al control
    alertify.alert("Error en telefono");
   
    return false; //devolvemos el foco
  }
  else
   {
           RegisterUserForm.telefono.style.backgroundColor = "white"; 
      }
  
  

  // VAlidacion de fechas
  
  
  if(RegisterUserForm.fechaini.value.length<=0) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.fechaini.focus();    // Damos el foco al control
    RegisterUserForm.fechaini.style.backgroundColor = "#FF4D4D";
    alertify.alert("Ingresa Feha inicial");
        return false; //devolvemos el foco
  }
    else
   {
           RegisterUserForm.fechaini.style.backgroundColor = "white"; 
   }

   if(RegisterUserForm.fechater.value.length<=0) 
   { //¿Tiene 0 caracteres?
    RegisterUserForm.fechater.focus();    // Damos el foco al control
    RegisterUserForm.fechater.style.backgroundColor = "#FF4D4D";
    alertify.alert("Ingresa Feha final");
        return false; //devolvemos el foco
  }
    else
   {
           RegisterUserForm.fechater.style.backgroundColor = "white"; 
      }
  
 
 
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
			url: 'Temporal_Alta.php',
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
&responsable="+responsable+"\
&parentesco="+parentesco+"\
&celular="+celular+"\
&telefono="+telefono+"\
&fechaini="+fechaini+"\
&fechater="+fechater+"\
&ruta="+ruta+"\
&comentarios="+comentarios+"\
&suma="+suma+"\
&nfamilia="+nfamilia+"\
&fecha="+fecha,
			success: function(datos){
                            alert('ok');
		        alertify.alert(datos);
				//$("#tabla").load(" #tabla");
                                //$("#formulario").hide();
				//$("#tabla").show();
                              //window.location = window.location;
                                
			}
		});
                
                    
		return false;


}


            
function ConsultaDatos(){
		$.ajax({
			url: 'PTemporal.php',
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
    window.location = "PTemporal.php";
}


function Cancelado2() {

alertify.error("Acceso no disponible"); 
return false; 

}