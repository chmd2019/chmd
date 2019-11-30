var ids = [];
var coleccion_ids = [];
var coleccion_checkbox_values = [];
var coleccion_data_alumnos = [];

function Cancelar() {
     window.location.replace("../eventos/Peventos.php");
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



/******************* Enviar el Fomulario**********************/
function enviar_formulario(codigo_evento, familia, id_permiso) {

  validar_alumnos();
  coleccion_ids = [... new Set(coleccion_ids)];
  coleccion_checkbox_values = [... new Set(coleccion_checkbox_values)];

  if (coleccion_ids.length === 0) {
    alert('Debe seleccionar al menos un alumno para continuar!');
    return;
  }
/**Fin de las validaciones*/

//alert(coleccion_checkbox_values);
//return;
  var data = {
    "id_permiso": id_permiso,
    "codigo_evento": codigo_evento,
    "nfamilia": familia,
    "alumnos": coleccion_checkbox_values
  };

  $.ajax({
    //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
    url: 'common/post_inscripcion_evento.php',
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
        alert('Inscripción exitosa');
        $("#btn_enviar_formulario").prop("disabled", false);
        window.location = "./Peventos.php";
      }else{
        alert('Ha ocurrido un error, Verifique los datos');
      }
    }
  });
}

function cancelar_inscripcion(id_permiso, id_alumno){
  var data = {
    "id_permiso": id_permiso,
    "id_alumno": id_alumno
  };

  $.ajax({
    //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
    url: 'common/post_cancelar_inscripcion_alumno.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      $("button").prop("disabled", true);
      //  $("#loading").fadeIn("slow");
    },
    success: function (res) {
      //alert(res);
      res = JSON.parse(res);
      if (res.estatus === true) {
        //alert('Ha c exitosa');
        location.reload();
      }else{
        $("button").prop("disabled", false);
        alert('Ha ocurrido un error, Verifique los datos');
      }
    }
  });
}
