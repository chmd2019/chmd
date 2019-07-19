function enviar_formulario(idauto){
  $("#loading").hide();
  var isgood=true;
/********************** autos *****************************/
  var marca = $("#marca").val();
  var modelo = $("#modelo").val();
  var color = $("#color").val();
  var placa = $("#placa").val();

  //validar que no estan vacios
    if (marca==''){
      isgood=false;
      alert("Falta agregar Marca");
      return false;
    }
    if (modelo==''){
      isgood=false;
      alert("Falta agregar Modelo");
      return false;
    }
    if (color==''){
      isgood=false;
      alert("Falta agregar Color");
      return false;
    }
    if (placa==''){
      isgood=false;
      alert("Falta agregar Placa");
      return false;
    }
  //almacenar en implote
//hacer el llamado ajax
if(isgood==true){
  $.ajax({
    url: '../common/post_update_auto.php',
    type: 'POST',
    data: {
      submit: true,
      idcarro: idauto,
      marca: marca,
      modelo:modelo,
      color:color,
      placa:placa
    },
    success: function(res){
      if (res == 1) {
          swal("Información", "Registro Actualizado exitosamente!", "success");
          setInterval(() => {
              window.location = "../Choferes.php";
          }, 1500);
      } else {
          swal("Información", res, "error");
          setInterval(() => {
              location.reload();
          }, 10000);
      }

    }
  }).always(function () {
              $("#btn_enviar_formulario").prop("disabled", false);
              setInterval(function () {
                  $("#loading").fadeOut("slow");
              }, 1000);
      });
}
return false;
}
