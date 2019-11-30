var ids = [];
var coleccion_ids = [];
var coleccion_checkbox_values = [];
var coleccion_data_alumnos = [];



function enlistar_alumno(id){
  //cambiar a ver
    //hay enlistados
    if ($("#selected_" + id ).length){
      //Hay en lista
      $("#selected_" + id ).remove();
//      $("#imagen_"+ id).css("background","white");
      $("#imagen_"+ id).css("background","white");
    }else{
      //no existe en lista
      let nombre = $("#nombre_"+id).text();
      let grado = $("#grado_"+id).text();
      let grupo = $("#grupo_"+id).text();
      //$("#imagen_"+ id).css("background","#8aff8e");
      $("#imagen_"+ id).css("background","#8aff8e");
    var text = "<tr class='enlistado' id='selected_"+id+"' style='border-bottom: 1px solid #ddd;'><td colspan='1'>"+id+"</td><td colspan='4'>"+nombre+"</td><td colspan='3'>"+grado+"</td><td colspan='3'>"+grupo+"</td></tr>";
      $("#lista_alumnos").append(text);
    }

}

function cancelar() {
  //alert('ok');
  window.location = "../eventos/PeventosBachillerato.php";
}

function mostrar_transporte() {
  if( $('#chbox2').prop('checked') ) {
    $('#new_transporte').show();
  }else{
    $('#new_transporte').hide();
  }
}

function mostrar_new() {
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

function validar_empresa() {
    var empresa = $("#empresa").val();
    if (empresa === "") {
        alert('Debe ingresar una empresa válida!');
        return false;
    }
    return true;
}

function cambia_responsable() {
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
  if ($("#tipo_evento").val() === "") {
    alert('Debe seleccionar una tipo de evento válida!');
    return;
  }
  if ($("#hora_salida").val() === "") {
    alert('Debe seleccionar una Hora válida!');
    return;
  }
  if ($("#hora_regreso").val() === "") {
    alert('Debe seleccionar una hora válida!');
    return;
  }
  if ($("#responsable").val() === "") {
    alert('Debe seleccionar una responsable válido!');
    return;
  }
  if ($("#parentesco_responsable").val() === "") {
      alert('Debe seleccionar un parentesco válido!');
      return;
    }
    if( $('#chbox2').prop('checked') ) {
    //nuevo
      if (!validar_empresa()) {
        return;
      }
    }

    if ($("#motivos").val() === "") {
      alert('Debe ingresar un motivo válido!');
      return;
    }

//validar alumnos
if ($(".enlistado").length){
  //hay en lista, agregarlos a un array

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
  let array1= fecha_cambio.split(',');
  let dia_letra=array1[0];
  let fecha_more= array1[1];
  let array2 = fecha_more.split(' ');
  let dia=array2[1];
  let mes=array2[2];
  let anio=array2[3];
  var fecha_cambio = dia_letra + ", "  + dia + " de " + mes + " de " + anio;
  var empresa='';
  if( $('#chbox2').prop('checked') ) {
    empresa= $("#empresa").val();
  }
//alert(coleccion_checkbox_values);
//return;
  var data = {
    "idusuario": idusuario,
    "motivos": motivos,
    "nfamilia": familia,
    "responsable": responsable,
    "parentesco": parentesco,
    "fecha_creacion": fecha_solicitud,
    "fecha_cambio": fecha_cambio,
    "estatus": 1,
    "empresa" : empresa,
    "tipo_evento" : tipo_evento,
    "alumnos": coleccion_checkbox_values
  };

  $.ajax({
    //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
    url: 'common/post_nuevo_permiso_eventos.php',
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
        alert('Registro exitoso, Su Codigo de Invitacion es :' + res.codigo_invitacion);
        $("#btn_enviar_formulario").prop("disabled", false);
        window.location = "./Peventos.php";
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
