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


function enviar_formulario(id_chofer,nautosT, nfamilia, existe_auto ){
  $("#btn_enviar_formulario").prop('disabled', true);
  $("#loading").hide();
  var isgood=true;
  var counter=0;
  var autos=''
  if(existe_auto){
    $.ajax({
      url: '../common/update_renovar_chofer.php',
      type:'POST',
      data: {id_chofer: id_chofer },
      success: function(data){
        //alert(data);
        if (data==true){
          M.toast({html: 'Renovación de chofer exitosa!', classes: 'green accent-4'});
          setInterval(() => {
            window.location = "../Choferes.php";
            return;
          }, 1500);

        }else{
          M.toast({html: 'Ha ocurrido un Error', classes: 'red accent-4'});
          $("#btn_enviar_formulario").prop('disabled', false);
          return;
        }
      }

    });
  }
  /********************** autos *****************************/

  $('.checks-autos input[type=checkbox]').each(function () {
      if (this.checked) {
          counter++;
          let value = $(this).val();
  //          alert(value);
          let marca = $("#marca" + value).val();
          let submarca = $("#submarca" + value).val();
          let modelo = $("#modelo" + value).val();
          let color = $("#color" + value).val();
          let placa = $("#placa" + value).val();
          //validar que no estan vacios
          if (marca=='' || marca == null){
            isgood=false;
          //  swal("Error en fecha del permiso", "Debe seleccionar una fecha válida", "error");
          //  alert("Falta agregar Marca");
            M.toast({
              html: 'Debe selecionar la Marca del Automóvil.',
              classes: 'deep-orange c-blanco'
            });
            $("#btn_enviar_formulario").prop('disabled', false);
            return false;
          }
          if (submarca==''){
            isgood=false;
            M.toast({
              html: 'Debe agregar la Submarca del Automóvil.',
              classes: 'deep-orange c-blanco'
            });
            $("#btn_enviar_formulario").prop('disabled', false);
            return false;
          }
          if (modelo==''){
            isgood=false;
            //alert("Falta agregar Modelo");
            M.toast({
              html: 'Debe agregar el Modelo del Automóvil.',
              classes: 'deep-orange c-blanco'
            });
            $("#btn_enviar_formulario").prop('disabled', false);
            return false;
          }
          if (color=='' || color == null){
            isgood=false;
            //alert("Falta agregar Color");
            M.toast({
              html: 'Debe seleccionar el Color del Automóvil.',
              classes: 'deep-orange c-blanco'
            });
            $("#btn_enviar_formulario").prop('disabled', false);
            return false;
          }
          if (placa==''){
            isgood=false;
            //alert("Falta agregar Placa");
            M.toast({
              html: 'Debe agregar la Placa del Automóvil.',
              classes: 'deep-orange c-blanco'
            });
            $("#btn_enviar_formulario").prop('disabled', false);
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
            $("#btn_enviar_formulario").prop('disabled', false);
            return false;
          }
        //almacenar en implote
        autos=autos + marca + '|'+ submarca + '|' + modelo +'|' + color + '|' + placa + ',';
      }
  });
  //Listo cn los autos
  var Nautos=counter;
//  alert(autos);
//hacer el llamado ajax
var ncheckbox_selected= Nautos;
if(isgood==true && ncheckbox_selected>0 ){
  $.ajax({
    url: '../common/post_auto_chofer.php',
    type: 'POST',
    data: {
      submit: true,
      nchoferes:0,
      choferes: '',
      nautos:Nautos,
      autos: autos,
      maxchoferes: 0,
      maxautos: nautosT,
      nfamilia: nfamilia
    },
    success: function(res){
      if (res == 1) {
        $.ajax({
          url: '../common/update_renovar_chofer.php',
          type:'POST',
          data: {id_chofer: id_chofer },
          success: function(data){
            //alert(data);
            if (data==true){
              M.toast({html: 'Renovación de chofer exitosa!', classes: 'green accent-4'});
              //swal("Información", "Registro exitoso!", "success");
              M.toast({html: 'Actualización de Automóvil(es) exitosa!', classes: 'green accent-4'});
              setInterval(() => {
                window.location = "../Choferes.php";
                return;
              }, 1500);
            }else{
              M.toast({html: 'Ha ocurrido un Error', classes: 'red accent-4'});
              $("#btn_enviar_formulario").prop('disabled', false);
            }
          }

        });
      } else {
      //swal("Información", res, "error");
        M.toast({html: 'Ha Ocurrido un Error: ' + res , classes: 'red accent-4'});
        $("#btn_enviar_formulario").prop('disabled', false);
        setInterval(() => {
          location.reload();
          return;
        }, 10000);
      }
    }


  }).always(function () {
              $("#btn_enviar_formulario").prop("disabled", false);
              setInterval(function () {
                  $("#loading").fadeOut("slow");
              }, 1000);
      });
}else if(ncheckbox_selected=='0' && existe_auto==false ){
  M.toast({html: 'Debe registrar al menos un Automóvil.' , classes: 'red accent-4'});
  return false;
}
return false;
}
