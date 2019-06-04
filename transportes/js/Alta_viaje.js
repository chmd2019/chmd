function Alta_viaje()
{
    

 var fecha = document.getElementById('fecha').value;
 var idusuario = document.getElementById('idusuario').value;
 var nfamilia = document.getElementById('nfamilia').value;
  var talumnos = document.getElementById('talumnos').value;
  var calle = document.getElementById('calle').value;
  var colonia = document.getElementById('colonia').value;
  var cp = document.getElementById('cp').value;
  
 var responsable = document.getElementById('responsable').value;
  var parentesco = document.getElementById('parentesco').value;
  var celular = document.getElementById('celular').value;
  var telefono = document.getElementById('telefono').value;
  
  var fechaini = document.getElementById('fechaini').value;
  var fechater = document.getElementById('fechater').value;

 
   
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
alert('debe seleccionar alumnos.');
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
{
    var alumno2 = document.getElementById('alumno2').value;
}
else{
    var alumno2 =0;}

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
//alert("edwin");
}
//validacion por cantidad de alumnos




 //validar domicilio
 
 if(viaje.calle.value.length<=1) 
   { //¿Tiene 0 caracteres?
    viaje.calle.focus();    // Damos el foco al control
   alert('Ingresa calle y numero'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  
   if(viaje.colonia.value.length<=1) 
   { //¿Tiene 0 caracteres?
    viaje.colonia.focus();    // Damos el foco al control
   alert('Ingresa colonia'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  
   if(viaje.cp.value.length<=4) 
   { //¿Tiene 0 caracteres?
    viaje.cp.focus();    // Damos el foco al control
   alert('Ingresa cp'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  /************datos responsable**************/
  
  //validar datos de responsable

if(viaje.responsable.value.length<=4) 
   { //¿Tiene 0 caracteres?
    viaje.responsable.focus();    // Damos el foco al control
   alert('Ingresa responsable'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }


if(viaje.parentesco.value.length<=2) 
   { //¿Tiene 0 caracteres?
    viaje.parentesco.focus();    // Damos el foco al control
   alert('Ingresa parentesco'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  
  

  
  if(viaje.celular.value.length<=9) 
   { //¿Tiene 0 caracteres?
    viaje.celular.focus();    // Damos el foco al control
   alert('Ingresa Celuar'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  

  
    if(viaje.telefono.value.length<=7) 
   { //¿Tiene 0 caracteres?
    viaje.telefono.focus();    // Damos el foco al control
    alert('Ingresa telefono'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
 
 //validar seleccion de dia
   //validar ruta
 indice = document.getElementById("ruta").selectedIndex;
if( indice == null || indice == 0 )
 {
  alert('selecciona Ruta'); //Mostramos el mensaje
  viaje.ruta.focus();   
  return false;
}
var ruta =document.viaje.ruta.value;

var comentarios =document.viaje.comentarios.value;


              
		
		$.ajax({
			url: 'Alta_viaje.php',
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
        
			success: function(datos)
                        {
				alert(" Datos Guardados");
				
                                window.location = "/transportes/PViaje.php";
                                
			}
		});
                
                    
		return false;
   
  
   
    
}


function Cancelar()
{
     window.location.replace("/transportes/PViaje.php");
}

