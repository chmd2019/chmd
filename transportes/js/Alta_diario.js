function Alta_diario()
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
 
 if(diario.calle.value.length<=1) 
   { //¿Tiene 0 caracteres?
    diario.calle.focus();    // Damos el foco al control
   alert('Ingresa calle y numero'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  
   if(diario.colonia.value.length<=1) 
   { //¿Tiene 0 caracteres?
    diario.colonia.focus();    // Damos el foco al control
   alert('Ingresa colonia'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
  
  
   if(diario.cp.value.length<=4) 
   { //¿Tiene 0 caracteres?
    diario.cp.focus();    // Damos el foco al control
   alert('Ingresa cp'); //Mostramos el mensaje
    return false; //devolvemos el foco
  }
 
 //validar seleccion de dia
   //validar ruta
 indice = document.getElementById("ruta").selectedIndex;
if( indice == null || indice == 0 )
 {
 alert('selecciona Ruta'); //Mostramos el mensaje
  diario.ruta.focus();   
  return false;
}
var ruta =document.diario.ruta.value;

var comentarios =document.diario.comentarios.value;


              
		
		$.ajax({
			url: 'Alta_diario.php',
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
&fecha="+fecha,
        
			success: function(datos)
                        {
				alert("Guardado");
				
                                window.location = "/transportes/PDiario.php";
                                
			}
		});
                
                    
		return false;
   
  
   
    
}


function Cancelar()
{
     window.location.replace("/transportes/PDiario.php");
}

