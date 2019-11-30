function editar_inputs(id) {


  if ($("#nombre_ruta").val() === "") {
    alert('¡Debe agregar una Nueva Ruta!');
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

//verificar que es distinto al antiguo
var camion_new = camion;
var camion_old = $("#camion_old").val();
if (camion_old===camion){
  camion_new = -1;
}

//Existencia del camión.
var data = {
  "camion": camion_new,
  "tipo_ruta":tipo_ruta
  }
/**Fin de las validaciones*/
  $.ajax({
    url: 'common/post_ruta_existe.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      $("#button_editar").prop("disabled", true);
      //  $("#loading").fadeIn("slow");
    },
    success: function (res) {
      // alert(res);
      res = JSON.parse(res);
      if (res.estatus === true) {
        alert('El Camión ingresado ya existe, Elija otro Numero de Camión. ');
        $("#button_editar").prop("disabled", false);
        // window.location = "./Prutas.php";
      }else{
        // alert('El camion No existe!');
          //alert('ok');
          var data2 = {
            "id_ruta": id,
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
            url: 'common/post_update_ruta.php',
            type: 'POST',
            data: data2,
            beforeSend: function () {
              //$("#loading").fadeIn("slow");
            },
            success: function (res) {
              //alert(res);
              res = JSON.parse(res);
              if (res.estatus === true) {
                alert('Registro actualizado exitosamente');
                  // window.location = "./Prutas.php";
                  window.location = "Pcamiones.php";
              }else{
                alert('Ha ocurrido un error, Verifique los datos');
                $("#button_editar").prop("disabled", false);
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
  //verificar que es distinto al antiguo
  var camion_new = camion;
  var camion_old = $("#camion_old").val();
  if (camion_old===camion){
    camion_new = -1;
  }

  var data = {
    "camion": camion_new,
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
