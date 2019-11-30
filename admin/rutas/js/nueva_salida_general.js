function cancelar() {
  //alert('ok');
   window.location = "../rutas/PrutasGenerales.php";
}

/******************* Enviar el Fomulario**********************/
function enviar_formulario() {
//Validar que cupos disponibles no sea mayor al nuemero de aalumnos registrados
var fecha_salida_general = $("#fecha_salida_general").val();
if (fecha_salida_general ==='') {
  alert('Debe seleccionar una Fecha de Salida General para continuar.');
  return;
}

var hora_salida_general = $("#hora_salida_general").val();
if (hora_salida_general ==='') {
  alert('Debe seleccionar una Hora de Salida General para continuar.');
  return;
}


/**Fin de las validaciones*/

var data = {
    "fecha_salida_general" : fecha_salida_general,
    "hora_salida_general" : hora_salida_general
  };

 $.ajax({
    url: 'common/post_nueva_salida_general.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      $("#btn_enviar_formulario").prop("disabled", true);
      //  $("#loading").fadeIn("slow");
    },
    success: function (res) {
     // alert(res);
      res = JSON.parse(res);
      if (res.estatus === true) {
        alert('Generación exitosa.');
        window.location="./PrutasGenerales.php";
      }else{
        alert('Ha ocurrido un Error.');
        $("#btn_enviar_formulario").prop("disabled", false);
      }
    }
  });
}

function mostrar_timepicker_sg(el) {
  // mañana
    hora_maxima_del_dia = '17:00';
    $('#hora_salida_general').timepicker({
      'step': 1,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_salida_general').timepicker('show');
  // ids.push(el.id);
}
function solo_select(e){
 var key = window.Event ? e.which : e.keyCode
  return (key >= 48 && key <= 57)
}
