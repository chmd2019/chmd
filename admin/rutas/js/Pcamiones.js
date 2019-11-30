function cancelar() {
  //alert('ok');
   window.location = "../rutas/Prutas.php";
}
/******************* Enviar el Fomulario**********************/
function enviar_formulario() {


  if ($("#nombre_ruta").val() === "") {
    // alert('¡Debe agregar una Nueva Ruta!');
    $('.toast').toast('show');
    return;
  }
  var auxiliar = $("select#auxiliar :selected").val();
  if (auxiliar === "" || auxiliar === "0") {
    alert('¡Debe seleccionar un Auxiliar!');
    return;
  }
  if ($("#camion").val() === "") {
    alert('Debe seleccionar un número para el camion!');
    return;
  }
  if ($("#cupos").val() === "") {
    alert('Debe seleccionar el Número de Cupos del Camión!');
    return;
  }
  var cupos = $("#cupos").val();
  if (cupos < 10 || cupos >60  ) {
    alert('El Cupos del Camión debe estar entre: 10  y 60 alumnos !');
    return;
  }

  var tipo_ruta = $("select#tipo_ruta :selected").val();
  if (tipo_ruta === "" || tipo_ruta === "0") {
    alert('¡Debe seleccionar un tipo de Ruta!');
    return;
  }

  //validar camiones prohibido or Limitar de 1 - 99 LOs camiiones
  var n_camiones = $("#camion").val();
  if (n_camiones<1 || n_camiones>99) {
    alert('Debe seleccionar un número para el camion entre 01 - 99 !');
    return;
  }


  var nombre_ruta= $("#nombre_ruta").val();
  var auxiliar = $("#auxiliar").val();
  var camion = $("#camion").val();
  var cupos = $("#cupos").val();

//Existencia del camión.
var data = {
  "camion": camion,
  "tipo_ruta":tipo_ruta
}
/**Fin de las validaciones*/
  $.ajax({
    url: 'common/post_ruta_existe.php',
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
        alert('El Camión ingresado ya existe, Elija otro Numero de Camión. ');
        $("#btn_enviar_formulario").prop("disabled", false);
        // window.location = "./Prutas.php";
      }else{
        // alert('El camion No existe!');
          //alert('ok');
          var data2 = {
            "nombre_ruta": nombre_ruta,
            "auxiliar": auxiliar,
            "camion": camion,
            "cupos": cupos,
            "tipo_ruta": tipo_ruta,
            "summit": 1
          };

          //alert();
          //return;
          $.ajax({
            //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
            url: 'common/post_nueva_ruta.php',
            type: 'POST',
            data: data2,
            beforeSend: function () {
              //  $("#loading").fadeIn("slow");
            },
            success: function (res) {
              //alert(res);
              res = JSON.parse(res);
              if (res.estatus === true) {
                alert('Registro exitoso');
                  // window.location = "./Prutas.php";
                  window.location.reload();
              }else{
                alert('Ha ocurrido un error, Verifique los datos');
                $("#btn_enviar_formulario").prop("disabled", false);
              }
            }
          });
        // $("#btn_enviar_formulario").prop("disabled", false);
      }
    }
  });
}

function existe_camion(){
  var tipo_ruta = $("select#tipo_ruta :selected").val();
  if (tipo_ruta === "" || tipo_ruta === "0") {
    $("#camion").val('');
    alert('¡Debe seleccionar un tipo de Ruta!');
    return;
  }
  if($("#camion").val()===''){
    return;
  }
  var camion = $("#camion").val();
  var data = {
    "camion": camion,
    "tipo_ruta":tipo_ruta
  }
    $.ajax({
      url: 'common/post_ruta_existe.php',
      type: 'POST',
      data: data,
      success: function (res) {
        // alert(res);
        res = JSON.parse(res);
          if (res.estatus === true) {
            //existe
            $("#existe_camion").show();
          }else{
            //no existe
            $("#existe_camion").hide();
          }
      }
    });

}

function eliminar_ruta(){
  var id_ruta = $("#modal_id_ruta").val();
  var data = { "id_ruta": id_ruta};
  $.ajax({
    url: 'common/post_eliminar_ruta.php',
    type: 'POST',
    data: data,
    success: function (res) {
      // alert(res);
      res = JSON.parse(res);
        if (res.estatus === true) {
          //Ruta eliminada
          alert('Se ha eliminado la ruta exitosamente!');
          $("#fila_"+id_ruta).remove();

        }else{
          //Ruta No eliminada
          alert('No se ha logrado eliminar la ruta!');
        }
    }
  });
}

function mod_eliminar(id_ruta, nombre_ruta){
  //cambio los valores en el modal.
  $("#modal_nombre_ruta").text(nombre_ruta);
  $("#modal_id_ruta").val(id_ruta);
}
