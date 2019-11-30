var ids = [];
var coleccion_ids = [];
var coleccion_checkbox_values = [];
var coleccion_data_alumnos = [];

function  archivar_alumno(id){
  let  nombre = $("td#nombret_"+id).text();
  let  grupo = $("td#grupot_"+id).text();
  let  grado = $("td#gradot_"+id).text();
//alert(nombre + grupo + grado + id);
  //agregar alumno al modal
  let text =
'<tr style="border-bottom: 1px solid #eee" id="tr_'+id+'">'+
'<td id="nombre_'+id+'">'+nombre+'</td>'+
'<td id="grado_'+id+'">'+grado+'</td>'+
'<td id="grupo_'+id+'">'+grupo+'</td>'+
'<td style="text-align:center">'+
'<button type="button" class="btn btn-primary" onclick="enlistar_alumno('+id+')" style ="font-family: \'Varela Round\'" >'+
'<span class="glyphicon glyphicon-plus"></span> AÑADIR'+
'</button>'+
'</td>'+
'</tr>';

//alert(text);

$("#lista_alumnos_new").append(text);
//Hay en lista
$("#selected_" + id ).remove();

}

function enlistar_alumno(id){
  //cambiar a ver
    //hay enlistados
    if ($("#selected_" + id ).length){
      //Hay en lista
      $("#selected_" + id ).remove();
//      $("#imagen_"+ id).css("background","white");
//      $("#imagen_"+ id).css("background","white");
    }else{
      //no existe en lista
      let nombre = $("#nombre_"+id).text();
      let grado = $("#grado_"+id).text();
      let grupo = $("#grupo_"+id).text();
      //$("#imagen_"+ id).css("background","#8aff8e");
      // $("#imagen_"+ id).css("background","#8aff8e");
      var text_button_archivar = '<a class="" id="btn_'+id+'" type="button" onclick = "archivar_alumno('+ id +')"></a>';
      var text = "<tr class='enlistado' id='selected_"+id+"' style='border-bottom: 1px solid #ddd;'><td class='id_selected' colspan='1' id='idt_"+id+"'>"+id+"</td><td colspan='4' id ='nombret_"+id+"'>"+nombre+"</td><td colspan='3' id ='gradot_"+id+"'' >"+grado+"</td><td colspan='1' id ='grupot_"+id+"'>"+grupo+"</td> <td colspan='1'>"+text_button_archivar+"</td></tr>";
      $("#lista_alumnos").append(text);
      }
      $.get('componentes/btn_cancelar.php', function (html){
        $("a#btn_"+id).html(html);

      });

//Eliminar de la Lista de adicion.
$('#tr_'+id).remove();
}

function cancelar() {
  //alert('ok');
   window.location = "../eventosInternos/PeventosInternos.php";
}


function mostrar_new() {
  if($('#chbox1').prop('checked') ) {
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

function cambia_responsable() {
  var sel = $('#seleccion_responsable').val();
  //solicitud get
  $.get("common/get_usuario.php?id_usuario="+ sel, function(data, status){
  usuario = JSON.parse(data);
    $('#responsable').val(usuario.nombre);
    // if(usuario.tipo==='3'){
    //   parentesco='Papa';
    // }else if (usuario.tipo==='4'){
    //   parentesco='Mama';
    // }else if (usuario.tipo==='7'){
    //   parentesco='Chofer';
    // }
    $('#parentesco_responsable').val(usuario.responsable);
   //alert("Data: " + usuario.nombre + "\nStatus: " + status);
 });
}

function validar_fecha_vacia() {
  var fecha_permiso = $("#fecha_permiso").val();
  if (fecha_permiso === "") {
    alert( 'Debe seleccionar una fecha válida antes de tomar un horario!');
    return false;
  }
  return true;
}

/******************* Enviar el Fomulario**********************/
function enviar_formulario(id , tipo_permiso, area) {
  // EL area queda definida en bbdd como nfamilia en la tabla Ventana_permisos 
  // Kinder = 1
  // Primaria = 2
  // BACHILLERATO = 3

  if ($("#fecha_permiso").val() === "") {
    alert('Debe seleccionar una fecha válida!');
    return;
  }
  if ($("#tipo_evento").val() === "") {
    alert('Debe seleccionar una tipo de evento válida!');
    return;
  }
  if ($("#hora_salida").val() === "") {
    alert('Debe seleccionar una hora de salida válida!');
    return;
  }

  if ($("#regresan_check").prop("checked")){
    if ($("#hora_regreso").val() === "") {
      alert('Debe seleccionar una hora de regreso válida!');
      return;
    }
  }
  if ($("#responsable").val() === "") {
    alert('Debe seleccionar una Responsable válido!');
    return;
  }
  if ($("#parentesco_responsable").val() === "") {
      alert('Debe seleccionar un Cargo válido!');
      return;
    }

    if ($("#motivos").val() === "") {
      alert('Debe ingresar un motivo válido!');
      return;
    }

//validar alumnos
if ($(".enlistado").length){
  //hay en lista, agregarlos a un array / Crear coleccion de alumnos
  //conseguir ids de alumnos registrados
  var selected ='';
  $(".id_selected").each(
    function(){
      selected += $(this).text() + ',';
    });
    var values = selected.split(",");
    for (var item in values) {
        if (values[item] !== "") {
            coleccion_checkbox_values.push(values[item]);
        }
    }

}else{
  //no hay alumno
  alert('Debe agregar al menos un alumno en la lista para continuar.');
}
/**Fin de las validaciones*/

  var idusuario= $("#solicitante").val();
  var motivos = $("#motivos").val();
  var responsable = $("#responsable").val();
  var parentesco = $("#parentesco_responsable").val();
  var tipo_evento= $("#tipo_evento").val();
  var fecha_solicitud = $("#fecha_solicitud").val();
  var fecha_cambio = $("#fecha_permiso").val();
  var hora_salida = $("#hora_salida").val();
  var hora_regreso = '';
  var regresa = '';

  if ($("#regresan_check").prop("checked")){
    hora_regreso = $("#hora_regreso").val();
    regresa = "1";
  }else{
    hora_regreso= "0";
    regresa = "0";
  }

  let array1= fecha_cambio.split(',');
  let dia_letra=array1[0];
  let fecha_more= array1[1];
  let array2 = fecha_more.split(' ');
  let dia=array2[1];
  let mes=array2[2];
  let anio=array2[3];
  fecha_cambio = dia_letra + ", "  + dia + " de " + mes + " de " + anio;

//alert('ok');
//return;
//  "nfamilia": familia,
  var data = {
    "idusuario": idusuario,
    "motivos": motivos,
    "responsable": responsable,
    "parentesco": parentesco,
    "fecha_creacion": fecha_solicitud,
    "fecha_cambio": fecha_cambio,
    "hora_salida": hora_salida,
    "hora_regreso": hora_regreso,
    "regresa": regresa,
    "estatus": '1',
    "area": area,
    "tipo_evento": tipo_evento,
    "alumnos": coleccion_checkbox_values,
  };

  //alert();
  //return;
  $.ajax({
    //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
    url: 'common/post_nuevo_permiso_interno.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      $("#btn_enviar_formulario").prop("disabled", true);
      //  $("#loading").fadeIn("slow");
    },
    success: function (res) {
      //alert(res);
      res = JSON.parse(res);
      if (res.estatus === true) {
        alert('Registro exitoso');
        $("#btn_enviar_formulario").prop("disabled", false);
        if (area =='1'){
          window.location = "./PeventosInternosKin.php";
        }else if (area == '2'){
          window.location = "./PeventosInternosPri.php";
        }else{
          window.location = "./PeventosInternosBa.php";
        }


      }else{
        alert('Ha ocurrido un error, Verifique los datos');
      }
    }
  });
}

$('input.filter').keyup(function()
{
  //alert('hola');
  var rex = new RegExp($(this).val(), 'i');
  $('.searchable tr').hide();
  $('.searchable tr').filter(function() {
    return rex.test($(this).text());
  }).show();
});

function mostrar_timepicker_salida(el,  horario_permitido) {
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
    $('#hora_salida').timepicker({
      'step': 5,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_salida').timepicker('show');
  }
  // los viernes
  else if (fecha_permiso[0] === "Viernes" && horario_permitido === "1") {
    hora_maxima_del_dia = '14:00';
    $('#hora_salida').timepicker({
      'step': 5,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_salida').timepicker('show');
  }
  //PRIMARIA BAJA (1 y 2)
  //de lunes a jueves
  if (fecha_permiso[0] !== "Viernes" && horario_permitido === "2") {
    hora_maxima_del_dia = '13:15';
    $('#hora_salida').timepicker({
      'step': 5,
      'minTime': '10:50',
      'maxTime': hora_maxima_del_dia,
      'disableTimeRanges': [
        ['11:20', '12:50']
      ],
      'timeFormat': 'H:i'
    });
    $('#hora_salida').timepicker('show');
  }
  // viernes
  else if (fecha_permiso[0] === "Viernes" && horario_permitido === "2") {
    hora_maxima_del_dia = '12:35';
    $('#hora_salida').timepicker({
      'step': 5,
      'minTime': '10:35',
      'maxTime': hora_maxima_del_dia,
      'disableTimeRanges': [
        ['11:00', '12:20']
      ],
      'timeFormat': 'H:i'
    });
    $('#hora_salida').timepicker('show');
  }
  //PRIMARIA ALTA (3, 4, 5 y 6)
  //de lunes a jueves
  if (fecha_permiso[0] !== "Viernes" && horario_permitido === "3") {
    hora_maxima_del_dia = '13:15';
    $('#hora_salida').timepicker({
      'step': 5,
      'minTime': '10:05',
      'maxTime': hora_maxima_del_dia,
      'disableTimeRanges': [
        ['10:45', '12:55']
      ],
      'timeFormat': 'H:i'
    });
    $('#hora_salida').timepicker('show');
  }
  // viernes
  else if (fecha_permiso[0] === "Viernes" && horario_permitido === "3") {
    hora_maxima_del_dia = '12:35';
    $('#hora_salida').timepicker({
      'step': 5,
      'minTime': '09:55',
      'maxTime': hora_maxima_del_dia,
      'disableTimeRanges': [
        ['10:20', '12:20']
      ],
      'timeFormat': 'H:i'
    });
    $('#hora_salida').timepicker('show');
  }
  ids.push(el.id);
}

function valida_hora_mayor(){
  var hora_s =  $("#hora_salida").val();
  var hora_r =  $("#hora_regreso").val();
  // Date and time method
  if (hora_s >= hora_r){
    alert('Debe seleccionar un horario de regreso mayor que el horario de entrada!');
     $('#hora_regreso').timepicker('remove');
     $('#hora_regreso').val("");
  }
}

function reinicia_hora_regreso() {
   $('#hora_regreso').val("");
}

function mostrar_timepicker_regreso(el,  horario_permitido) {
  $(document.activeElement).filter(':input:focus').blur();
  if (!validar_fecha_vacia())
  return;

  if ($("#hora_salida").val() === "") {
    alert('Debe seleccionar un horario de salida antes de tomar un horario de entrada!');
    $('.timepicker').timepicker('remove');
    $('.timepicker').val("");
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
    $('#hora_regreso').timepicker({
      'step': 5,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_regreso').timepicker('show');
  }
  // los viernes
  else if (fecha_permiso[0] === "Viernes" && horario_permitido === "1") {
    hora_maxima_del_dia = '14:00';
    $('#hora_regreso').timepicker({
      'step': 5,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_regreso').timepicker('show');
  }
  ids.push(el.id);
}

function remover_timepicker() {
  $(".timepicker").timepicker('remove');
  $(".timepicker").val('');
//  $(".horas").hide();
/*
  $('.micheckbox:checked').each(
    function() {
      $(".micheckbox").attr("checked", false);
    }
  );
  */
}
function mostrar_regreso(){
  if($("#regresan_check").prop("checked")){
    $("#tr_regreso").show();
  }else{
    $("#tr_regreso").hide();
  }
}
