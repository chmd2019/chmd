var responsables = [];
var flag_no_sale_solo = '<?php echo "$flag_no_sale_solo" ?>';
flag_no_sale_solo = flag_no_sale_solo === "1" ? true : false;
var ids = [];
var coleccion_ids = [];
var coleccion_checkbox_values = [];
var coleccion_alumnos = [];
var coleccion_data_alumnos = [];

function validar_fecha_vacia() {
  var fecha_permiso = $("#fecha_permiso").val();
  if (fecha_permiso === "") {
    alert( 'Debe seleccionar una fecha válida antes de tomar un horario!');
    return false;
  }
  return true;
}

function mostrar_timepicker_salida(el, counter, horario_permitido) {
  $(document.activeElement).filter(':input:focus').blur();
  if (!validar_fecha_vacia())
  return;
  var hora_maxima_del_dia = '';
  var fecha_permiso = $("#fecha_permiso").val();
  //BACHILLERATO Y KINDER
  fecha_permiso = fecha_permiso.split(",");
  //BACHILLERATO Y KINDER
  // de lunes a jueves
  if (fecha_permiso[0] !== "Viernes" && horario_permitido === "1") {
    hora_maxima_del_dia = '14:50';
    $('#hora_salida_' + counter).timepicker({
      'step': 5,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_salida_' + counter).timepicker('show');
  }
  // los viernes
  else if (fecha_permiso[0] === "Viernes" && horario_permitido === "1") {
    hora_maxima_del_dia = '14:00';
    $('#hora_salida_' + counter).timepicker({
      'step': 5,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_salida_' + counter).timepicker('show');
  }
  //PRIMARIA BAJA (1 y 2)
  //de lunes a jueves
  if (fecha_permiso[0] !== "Viernes" && horario_permitido === "2") {
    hora_maxima_del_dia = '13:15';
    $('#hora_salida_' + counter).timepicker({
      'step': 5,
      'minTime': '10:50',
      'maxTime': hora_maxima_del_dia,
      'disableTimeRanges': [
        ['11:20', '12:50']
      ],
      'timeFormat': 'H:i'
    });
    $('#hora_salida_' + counter).timepicker('show');
  }
  // viernes
  else if (fecha_permiso[0] === "Viernes" && horario_permitido === "2") {
    hora_maxima_del_dia = '12:35';
    $('#hora_salida_' + counter).timepicker({
      'step': 5,
      'minTime': '10:35',
      'maxTime': hora_maxima_del_dia,
      'disableTimeRanges': [
        ['11:00', '12:20']
      ],
      'timeFormat': 'H:i'
    });
    $('#hora_salida_' + counter).timepicker('show');
  }
  //PRIMARIA ALTA (3, 4, 5 y 6)
  //de lunes a jueves
  if (fecha_permiso[0] !== "Viernes" && horario_permitido === "3") {
    hora_maxima_del_dia = '13:15';
    $('#hora_salida_' + counter).timepicker({
      'step': 5,
      'minTime': '10:05',
      'maxTime': hora_maxima_del_dia,
      'disableTimeRanges': [
        ['10:45', '12:55']
      ],
      'timeFormat': 'H:i'
    });
    $('#hora_salida_' + counter).timepicker('show');
  }
  // viernes
  else if (fecha_permiso[0] === "Viernes" && horario_permitido === "3") {
    hora_maxima_del_dia = '12:35';
    $('#hora_salida_' + counter).timepicker({
      'step': 5,
      'minTime': '09:55',
      'maxTime': hora_maxima_del_dia,
      'disableTimeRanges': [
        ['10:20', '12:20']
      ],
      'timeFormat': 'H:i'
    });
    $('#hora_salida_' + counter).timepicker('show');
  }
  ids.push(el.id);
}

function mostrar_timepicker_regreso(el, counter, horario_permitido) {
  $(document.activeElement).filter(':input:focus').blur();
  if (!validar_fecha_vacia())
  return;

  if ($("#hora_salida_" + counter).val() === "") {
    alert('Debe seleccionar un horario de salida antes de tomar un horario de entrada!');
    $('.timepicker_' + counter).timepicker('remove');
    $('.timepicker_' + counter).val("");
    return;
  }

  var hora_maxima_del_dia = '';
  var fecha_permiso = $("#fecha_permiso").val();
  //BACHILLERATO Y KINDER
  fecha_permiso = fecha_permiso.split(",");
  //BACHILLERATO Y KINDER
  // de lunes a jueves
  if (fecha_permiso[0] !== "Viernes" && horario_permitido === "1") {
    hora_maxima_del_dia = '14:50';
    $('#hora_regreso_' + counter).timepicker({
      'step': 5,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_regreso_' + counter).timepicker('show');
  }
  // los viernes
  else if (fecha_permiso[0] === "Viernes" && horario_permitido === "1") {
    hora_maxima_del_dia = '14:00';
    $('#hora_regreso_' + counter).timepicker({
      'step': 5,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_regreso_' + counter).timepicker('show');
  }
  ids.push(el.id);
}

function remover_timepicker() {
  $(".timepicker").timepicker('remove');
  $(".timepicker").val('');
  $(".horas").hide();
  $('.micheckbox:checked').each(
    function() {
      $(".micheckbox").attr("checked", false);
    }
  );
}

function aviso_tercer_permiso(id_alumno, idcursar) {
  $.ajax({
    url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/get_aviso_tercer_permiso.php',
    type: 'GET',
    data: {"id_alumno": id_alumno, "idcursar": idcursar},
    success: function (res) {
      res = JSON.parse(res);
      if (res) {
        alert('El alumno seleccionado ha superado el límte de tres permisos extraordinarios permitidos para su grado escolar, es posible que se decline el permiso solicitado. \n \nNOTA: Todas las solicitudes están sujetas a disponibilidad.');
      }
    }
  });
}

function mostrar_new(){
  if( $('#chbox1').prop('checked') ) {
    $('#old_responsable').hide();
    $('#new_responsable').show();
    $("#responsable").prop('disabled', false);
    $("#parentesco_responsable").prop('disabled', false);

  }else{
    $('#old_responsable').show();
  //  $('#new_responsable').hide();
    $("#responsable").prop('disabled', true);
    $("#parentesco_responsable").prop('disabled', true);
  }
}

function mostrar_horas(id,id_alumno,idcursar){
  if( $('#alumno_' + id).prop('checked') ) {
    $('#horas_'+id).show();
    aviso_tercer_permiso(id_alumno, idcursar);
  }else{
    $('#horas_'+id).hide();
  }
}

function validar_alumnos() {
    var selected = '';
    var id = '';
    coleccion_ids=[];
    coleccion_checkbox_values=[];
    $('.checks-alumnos input[type=checkbox]').each(function () {
        if (this.checked) {
            selected += $(this).val() + ',';
            id += $(this)[0].id + ',';
        }
    });
    var values = selected.split(",");
    for (var item in values) {
        if (values[item] !== "") {
            coleccion_checkbox_values.push(values[item]);
        }
    }
    var ids = id.split(",");
    for (var item in ids) {
        if (ids[item] !== "") {
            coleccion_ids.push(ids[item]);
        }
    }


}

function validar_responsable() {
    var responsable = $("#responsable").val();
    var parentesco_responsable = $("#parentesco_responsable").val();

    if (responsable === "") {
        alert('Debe ingresar un responsable válido!');
        return false;
    }
    if (parentesco_responsable === "") {
      alert('Debe ingresar un parentesco válido!');
      return false;
    }
    return true;
}

function cambia_responsable(){
  var sel = $('#seleccion_responsable').val();
  //solicitud get
  $.get("common/get_usuario.php?id_usuario="+ sel, function(data, status){
  usuario = JSON.parse(data);
    $('#responsable').val(usuario.nombre);
    if(usuario.tipo==='3'){
      parentesco='Papa';
    }else if (usuario.tipo==='4'){
      parentesco='Mama';
    }else if (usuario.tipo==='7'){
      parentesco='Chofer';
    }
    $('#parentesco_responsable').val(parentesco);
   //alert("Data: " + usuario.nombre + "\nStatus: " + status);
 });
}

/******************* Enviar el Fomulario**********************/
function enviar_formulario(id, familia, tipo_permiso) {
  if ($("#fecha_permiso").val() === "") {
    alert('Debe seleccionar una fecha válida!');
    return;
  }
  if (!validar_fecha_vacia())
  return;
  coleccion_data_alumnos = [];
  validar_alumnos();
  coleccion_ids = [... new Set(coleccion_ids)];
  coleccion_checkbox_values = [... new Set(coleccion_checkbox_values)];

  if (coleccion_ids.length === 0) {
    alert('Debe seleccionar al menos un alumno para continuar!');
    return;
  }

  for (var item in coleccion_ids) {
    var counter_alumno = coleccion_ids[item].split("_")[1];
    var hora_salida = $(".salida_" + counter_alumno).val();
    if (hora_salida === "") {
      alert('Debe seleccionar un horario de salida!');
      return;
    }
    var hora_regreso = $(".regreso_" + counter_alumno).val();
    var data_alumnos = {
      "id_alumno": $("#alumno_" + counter_alumno).val(),
      "hora_salida": $(".salida_" + counter_alumno).val(),
      "hora_regreso": hora_regreso !== undefined ? hora_regreso : "0",
      "regresa": $(".regreso_" + counter_alumno).val() !== ""
      && $(".regreso_" + counter_alumno).val() !== undefined ? 1 : 0,
      "estatus": 1,
      "idcursar": $("#idcursar_alumno_" + counter_alumno).val()
    }
    coleccion_data_alumnos.push(data_alumnos);
  }

  //alert(coleccion_ids);
  //alert(coleccion_checkbox_values);
  if( $('#chbox1').prop('checked') ) {
  //nuevo
    if (!validar_responsable()) {
      return;
    }
  }

  if ($("#motivos").val() === "") {
    alert('Debe ingresar un motivo válido!');
    return;
  }
  var fecha_solicitud = $("#fecha_solicitud").val();

  var fecha_cambio = $("#fecha_permiso").val();

  let array1= fecha_cambio.split(',');
  let dia_letra=array1[0];
  let fecha_more= array1[1];
  let array2 = fecha_more.split(' ');
  let dia=array2[1];
  let mes=array2[2];
  let anio=array2[3];
  var fecha_cambio = dia_letra + ", "  + dia + " de " + mes + " de " + anio;

  var idusuario= $("#solicitante").val();
  var responsable = $("#responsable").val();
  var parentesco = $("#parentesco_responsable").val();
  var motivos = $("#motivos").val();
  var data = {
    "nfamilia": familia,
    "fecha_creacion": fecha_solicitud,
    "fecha_cambio": fecha_cambio,
    "motivos": motivos,
    "responsable": responsable,
    "parentesco": parentesco,
    "idusuario": idusuario,
    "estatus": 1,
    "alumnos": coleccion_data_alumnos,
  };
  $.ajax({
    //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
    url: 'common/post_nuevo_permiso_especial.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      $("#btn_enviar_formulario").prop("disabled", true);
      //  $("#loading").fadeIn("slow");
    },
    success: function (res) {
      res = JSON.parse(res);
      if (res === 1) {
        alert('Registro exitoso');
        $("#btn_enviar_formulario").prop("disabled", false);
        window.location = "./PextraordinarioKinder.php";
      }
    }
  });
}
