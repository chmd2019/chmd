function enviar_formulario(nchoferesT,nautosT, nfamilia){
  $("#loading").hide();
  var isgood=true;
  var choferes=''
  var counter=0;
  $('.checks-choferes input[type=checkbox]').each(function () {
      if (this.checked) {
          counter++;
          let value = $(this).val();
//          alert(value);
          let nombre = $("#Chofer" + value).val();
          let celular = $("#celular" + value).val();
          //validar que no estan vacios
          if (nombre==''){
            isgood=false;
            alert("Falta agregar Nombre");
            return false;
          }
          if (celular==''){
            isgood=false;
            alert("Falta agregar celular");
            return false;
          }
        //almacenar en implote
        choferes=choferes + nombre + '|' + celular +',';
      }
  });
  //Listo cn los choferes
  var Nchoferes=counter;
  //alert(choferes);

/********************** autos *****************************/
  var autos=''
  counter=0;
  $('.checks-autos input[type=checkbox]').each(function () {
      if (this.checked) {
          counter++;
          let value = $(this).val();
  //          alert(value);
          let marca = $("#marca" + value).val();
          let modelo = $("#modelo" + value).val();
          let color = $("#color" + value).val();
          let placa = $("#placa" + value).val();

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
        autos=autos + marca + '|' + modelo +'|'+color +'|'+ placa + ',';
      }
  });
  //Listo cn los autos
  var Nautos=counter;
//  alert(autos);
//hacer el llamado ajax
  var ncheckbox_selected= Nautos+Nchoferes;
if(isgood==true && ncheckbox_selected>0 ){
  $.ajax({
    url: '../common/post_auto_chofer.php',
    type: 'POST',
    data: {
      submit: true,
      nchoferes:Nchoferes,
      choferes: choferes,
      nautos:Nautos,
      autos: autos,
      maxchoferes:nchoferesT ,
      maxautos: nautosT,
      nfamilia: nfamilia
    },
    success: function(res){
      if (res == 1) {
          swal("Información", "Registro exitoso!", "success");
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
