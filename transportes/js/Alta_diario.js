function Alta_diario()
{

var fecha = document.getElementById('fecha').value;
if(document.querySelector('input[name="idusuario"]:checked')){
  var idusuario = document.querySelector('input[name="idusuario"]:checked').value;
}else{
  alert("Seleccione un familiar como Solicitante");
  return false;
}
var nfamilia = document.getElementById('nfamilia').value;
var talumnos = document.getElementById('talumnos').value;
var calle = document.getElementById('calle').value;
var colonia = document.getElementById('colonia').value;
var cp = document.getElementById('cp').value;
var fecha_permiso = document.getElementById('fecha_permiso').value;

 //validacion de alumnos
var suma = 0;
var los_cboxes = document.getElementsByName('alumno[]');
var alumnos = '';
for (var i = 0, j = los_cboxes.length; i < j; i++){
  if(los_cboxes[i].checked == true)
{
  suma++;}
}

if(suma == 0)
{
alert('debe seleccionar alumnos.');
return false;
}

var _cierre =0;
for (var i = 0, j = los_cboxes.length; i < j; i++)
{
    if(los_cboxes[i].checked == true)
    {
    _cierre++;
    alumnos= alumnos + los_cboxes[i].value;
    if ( _cierre < suma){
      alumnos= alumnos + '|';
    }
    }
}
//alert(alumnos);
//Validar que hay estudiantes seleccionados.

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

  if( diario.cp.value.length==0){
    cp= '00000';
  }else{
    if(diario.cp.value.length>5 || diario.cp.value.length<4 )
    { //¿Tiene 0 caracteres?
     diario.cp.focus();    // Damos el foco al control
    alert('Ingresa un cp de 4 o 5 Digitos'); //Mostramos el mensaje
     return false; //devolvemos el foco
    }
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
var ruta = document.diario.ruta.value;
var comentarios =document.diario.comentarios.value;

$.ajax({
		url: 'Alta_diario.php',
		type: "POST",
    data : {
      submit: 0,
      idusuario : idusuario,
      calle:calle,
      colonia:colonia,
      cp:cp,
      ruta: ruta,
      comentarios: comentarios,
      suma:suma,
      nfamilia: nfamilia,
      fecha: fecha,
      fecha_permiso: fecha_permiso,
      alumnos:alumnos
    },
		success: function(datos)
     {
  			alert("Guardado");
        window.location = "../transportes/PDiario.php";
			}
		});
		return false;
}


function Cancelar()
{
     window.location.replace("../transportes/PDiario.php");
}
