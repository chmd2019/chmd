function Alta_viaje()
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

  var responsable = document.getElementById('responsable').value;
  var parentesco = document.getElementById('parentesco').value;
  var celular = document.getElementById('celular').value;
  var telefono = document.getElementById('telefono').value;
  var fechaini = document.getElementById('fechaini').value;
  var fechater = document.getElementById('fechater').value;

  if (fechaini==''){
    alert('Seleccione la fecha Inicial del permiso.');
    return false;
  }else{
    let array1= fechaini.split(',');
    let dia_letra=array1[0];
    let fecha_more= array1[1];
    let array2 = fecha_more.split(' ');
    let dia= array2[1];
    let mes= array2[2];
    let anio=array2[3];
    //procesar mes
    let _mes = get_mes(mes);
    //procesar año
    let _anio= anio % 100;
    fechaini=  _mes +"/"+ dia  + "/" + _anio;
    //alert(fechaini);
    var format_fechaini = dia_letra + ", "  + dia + " De " + mes + " De " + anio;
  }

  if (fechater==''){
    alert('Seleccione la Fecha Final del permiso.');
    return false;
  }else{
    let array1= fechater.split(',');
    let dia_letra=array1[0];
    let fecha_more= array1[1];
    let array2 = fecha_more.split(' ');
    let dia= array2[1];
    let mes=array2[2];
    let anio=array2[3];
    //procesar mes
    let _mes = get_mes(mes);
    //procesar año
    let _anio= anio % 100;

    fechater=_mes +"/"+ dia  + "/" + _anio;
    //alert(fechater);
    var format_fechater = dia_letra + ", "  + dia + " De " + mes + " De " + anio;
  }
  //fecha final > fecha inicial
  var fechai = new Date (fechaini);
  var fechaf = new Date (fechater);
  //alert(fechai.getDate() +" & " + (fechai.getMonth()+1) +" & " + fechai.getYear() +'&'+ fechai.getTime());
  //return false;
  if (fechaf.getTime() <= fechai.getTime()){
    alert('La Fecha Final debe ser mayor a la Fecha Inicial.');
    return false;
  }
  //validacion de alumnos
 var suma = 0;
 var los_cboxes = document.getElementsByName('alumno[]');
 var alumnos = '';

 for (var i = 0, j = los_cboxes.length; i < j; i++){
   if(los_cboxes[i].checked == true)
   {
   suma++; }
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

    // agregar los alumnos

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


    if( viaje.cp.value.length==0){
      cp= '00000';
    }else{
      if(viaje.cp.value.length>5 || viaje.cp.value.length<4 )
      { //¿Tiene 0 caracteres?
        viaje.cp.focus();   // Damos el foco al control
      alert('Ingresa un cp de 4 o 5 Digitos'); //Mostramos el mensaje
       return false; //devolvemos el foco
      }
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
      alert('Ingresa Celular'); //Mostramos el mensaje
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
      data:{
        submit:0,
        idusuario : idusuario,
        calle:calle,
        colonia:colonia,
        cp:cp,
        ruta: ruta,
        responsable:responsable,
        parentesco: parentesco,
        celular: celular,
        telefono: telefono,
        fechaini: format_fechaini,
        fechater:format_fechater,
        comentarios:comentarios,
        suma:suma,
        nfamilia:nfamilia,
        fecha: fecha,
        alumnos:alumnos
      },
        success: function(datos)
      {
        alert("Guardados");

        window.location = "../transportes/PTemporal.php";

      }
    });
    return false;
  }

  function Cancelar()
  {
    window.location.replace("../transportes/PTemporal.php");
  }

  function get_mes(mes){
      switch (mes) {
      case "Enero":
      return 1;
      break;
      case "Febrero":
      return 2;
      break;
      case "Marzo":
      return 3;
      break;
      case "Abril":
      return 4;
      break;
      case "Mayo":
      return 5;
      break;
      case "Junio":
      return 6;
      break;
      case "Julio":
      return 7;
      return ;
      break;
      case "Agosto":
      return 8;
      break;
      case "Septiembre":
      return 9;
      break;
      case "Octubre":
      return 10;
      break;
      case "Noviembre":
      return 11;
      break;
      case "Diciembre":
      return 12;
      break;

    }
  }
