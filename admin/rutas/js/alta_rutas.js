function cancelar() {
  //alert('ok');
   window.location = "../rutas/Prutas.php";
}
/******************* Enviar el Fomulario**********************/
function enviar_formulario() {


  if ($("#nombre_ruta").val() === "") {
    alert('¡Debe agregar una Nueva Ruta!');
    return;
  }
  if ($("#prefecta").val() === "") {
    alert('¡Debe agregar una Prefecta!');
    return;
  }
  if ($("#camion").val() === "") {
    alert('Debe seleccionar un numero para el camion!');
    return;
  }
  if ($("#cupos").val() === "") {
    alert('Debe seleccionar el Número de Cupos del Camión!');
    return;
  }
  var nombre_ruta= $("#nombre_ruta").val();
  var prefecta = $("#prefecta").val();
  var camion = $("#camion").val();
  var cupos = $("#cupos").val();
//Existencia del camión.
var data = {
  "camion": camion
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
            "prefecta": prefecta,
            "camion": camion,
            "cupos": cupos,
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
                  window.location = "./Prutas.php";
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
