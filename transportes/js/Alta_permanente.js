function Alta_permanente()
{
   var fecha = document.getElementById('fecha').value;
 var idusuario = document.getElementById('idusuario').value;
 var nfamilia = document.getElementById('nfamilia').value;
  var talumnos = document.getElementById('talumnos').value;
 
 
  var calle = document.getElementById('calle').value;
  var colonia = document.getElementById('colonia').value;
  var cp = document.getElementById('cp').value;
  
 

 
   
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
 
 if(permanente.calle.value.length<=1) 
   { //¿Tiene 0 caracteres?
    permanente.calle.focus();    // Damos el foco al control
   alert('Ingresa calle y numero'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  
   if(permanente.colonia.value.length<=1) 
   { //¿Tiene 0 caracteres?
    permanente.colonia.focus();    // Damos el foco al control
   alert('Ingresa colonia'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  
   if(permanente.cp.value.length<=4) 
   { //¿Tiene 0 caracteres?
    permanente.cp.focus();    // Damos el foco al control
   alert('Ingresa cp'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
 
 //validar seleccion de dia
 
 var suma1 = 0;
var los_cboxes = document.getElementsByName('dia[]'); 
for (var i = 0, j = los_cboxes.length; i < j; i++) {
    
    if(los_cboxes[i].checked == true){
    suma1++;
    }
}
 
if(suma1 == 0)
{
alert('debe seleccionar los dia.');

return false;
}

////////////////
else
{
var dia1 = document.getElementById('lunes').checked; 
var dia2 = document.getElementById('martes').checked; 
var dia3 = document.getElementById('miercoles').checked; 
var dia4 = document.getElementById('jueves').checked; 
var dia5 = document.getElementById('viernes').checked; 

if (dia1==true){var lunes = document.getElementById('lunes').value;}else{var lunes =0;}
if (dia2==true){var martes = document.getElementById('martes').value;}else{var martes =0;}
if (dia3==true){var miercoles = document.getElementById('miercoles').value;}else{var miercoles =0;}
if (dia4==true){var jueves = document.getElementById('jueves').value;}else{var jueves =0;}
if (dia5==true){var viernes = document.getElementById('viernes').value;}else{var viernes =0;}


}
 

 
     //validar ruta
 indice = document.getElementById("ruta").selectedIndex;
if( indice == null || indice == 0 )
 {
 alert('selecciona Ruta'); //Mostramos el mensaje
  permanente.ruta.focus();   
  return false;
}
var ruta =document.permanente.ruta.value;

var comentarios =document.permanente.comentarios.value;


              
		
		$.ajax({
			url: 'Alta_permanente.php',
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
&lunes="+lunes+"\
&martes="+martes+"\
&miercoles="+miercoles+"\
&jueves="+jueves+"\
&viernes="+viernes+"\
&ruta="+ruta+"\
&comentarios="+comentarios+"\
&suma="+suma+"\
&nfamilia="+nfamilia+"\
&fecha="+fecha,
        
			success: function(datos)
                        {
				alert("Guardado");
				
                                window.location = "/transportes/PPermanente.php";
                                
			}
		});
                
                    
		return false;
   
    
}


function Cancelar()
{
     window.location.replace("/transportes/PPermanente.php");
}