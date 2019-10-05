$(document).ready(function(){
  $('.collapsible').collapsible();
});

$(document).ready(function(){
  $('select').formSelect();
});
$(document).ready(function () {
  $("#loading").hide();
});

//funcion slo numeros
function solo_numeros(e){
  var key = window.Event ? e.which : e.keyCode
  return (key >= 48 && key <= 57)
}

function enviar_formulario(idauto){
  $("#loading").hide();
  var isgood=true;
/********************** autos *****************************/
  var marca = $("#marca").val();
  let submarca = $("#submarca").val();
  var modelo = $("#modelo").val();
  var color = $("#color").val();
  var placa = $("#placa").val();
  //validar que no estan vacios
    if (marca=='' || marca==null){
      isgood=false;
      //  alert("Falta agregar Marca");
      M.toast({
                  html: 'Debe selecionar la Marca del Automóvil.',
                classes: 'deep-orange c-blanco'
      });
      return false;
    }
    if (submarca==''){
      isgood=false;
      M.toast({
        html: 'Debe agregar el Modelo del Automóvil.',
        classes: 'deep-orange c-blanco'
      });
      return false;
    }
    if (modelo=='' || modelo ==null){
      isgood=false;
  //    alert("Falta agregar Modelo");
      M.toast({
                html: 'Debe agregar el Año del Automóvil.',
                classes: 'deep-orange c-blanco'
      });
      return false;
    }

    if (color=='' || color ==null){
      isgood=false;
    //  alert("Falta agregar Color");
      M.toast({
                  html: 'Debe seleccionar el Color del Automóvil.',
                classes: 'deep-orange c-blanco'
      });
      return false;
    }
    if (placa==''){
      isgood=false;
      alert("Falta agregar Placa");
      M.toast({
                html: 'Debe agregar la Placa del Automóvil.',
                classes: 'deep-orange c-blanco'
      });
      return false;
    }
    placa = placa.trim();
    //Validacion de mas de 5 Digitos la PLACA
    if (placa.length<5){
      isgood=false;
      //alert("Falta agregar Placa");
      M.toast({
        html: 'La Placa del Automóvil Debe tener mas de cinco (5) Caracteres.',
        classes: 'deep-orange c-blanco'
      });
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
      submarca: submarca,
      modelo:modelo,
      color:color,
      placa:placa
    },
    success: function(res){
      //alert(res);
      if (res == 1) {
        //swal("Información", "Registro Actualizado exitosamente!", "success");
        M.toast({html: 'Registro Actualizado exitosamente!', classes: 'green accent-4'});
          setInterval(() => {
              window.location = "../Choferes.php";
          }, 1500);
      } else {
          //swal("Información", res, "error");
          M.toast({html: 'Ha Ocurrido un Error!', classes: 'red accent-4'});
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
