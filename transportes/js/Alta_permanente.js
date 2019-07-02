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
 var alumnos = '';
 for (var i = 0, j = los_cboxes.length; i < j; i++){
   if(los_cboxes[i].checked == true)
   {
   suma++;}
 }
 //Validar que hay estudiantes seleccionados
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


    if( permanente.cp.value.length==0){
      cp= '00000';
    }else{
      if(permanente.cp.value.length>5 || permanente.cp.value.length<4 )
      { //¿Tiene 0 caracteres?
        permanente.cp.focus();    // Damos el foco al control
      alert('Ingresa un cp de 4 o 5 Digitos'); //Mostramos el mensaje
       return false; //devolvemos el foco
      }
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
      data: {
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
        lunes:lunes,
        martes: martes,
        miercoles: miercoles,
        jueves: jueves,
        viernes: viernes,
        alumnos:alumnos
      },
      success: function(datos)
      {
        alert("Guardado");

        window.location = "../transportes/PPermanente.php";

      }
    });
    return false;
  }


  function Cancelar()
  {
    window.location.replace("../transportes/PPermanente.php");
  }
