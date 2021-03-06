$(function() {
  var funcion;

  $('.save-nivel').submit(function(e) {
      //var nombre_nivel = $('#nombre_nivel').val();//fecha de solicitud
      //var mensaje = $('#mensaje').val();
      var estatus = $('#estatus').val();
      if(estatus==0){
        alert("Seleciona el estatus");
        return false;
      }
      /*if(mensaje==null || mensaje.length<=5){
        alert("Agrega Respuesta.");
        return false;
      }*/
      e.preventDefault();
      $.ajax({
        type : 'POST',
        data : {
          funcion : funcion,//id del usuario
          //nombre_nivel : nombre_nivel,
          //mensaje : mensaje,
          estatus : estatus
        }
      })
      .done(
        function(data) {
          if (data.estatus == '-1') {
            $('.alert-save').html(
              '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>  El nombre del nivel ya existe, por favor escribe otro</div>')
              .hide().show('fast');
          } else {
            location.reload();
          }
        }
      );
    });
        $('input.filter').keyup(function(){
          var rex = new RegExp($(this).val(), 'i');
          $('.searchable tr').hide();
          $('.searchable tr').filter(function() {
            return rex.test($(this).text());
          }).show();
        });

        $('.btn-editar').click(function(){
          editarNivel(
            $(this).attr('data-id'),
            $(this).attr('data-fecha_solicitud'),//era data-nombre
            $(this).attr('data-correo'), //era data-nombre1
            $(this).attr('data-nfamilia'),
            $(this).attr('data-estatus'),
            $(this).attr('data-nombre'),
          );
          funcion = $(this).attr('data-id');
        });

        $('.btn-borrar').click(function(){
          eliminarNivel($(this).attr('data-id'), $(this).attr('data-nombre'));
        });

        $('.btn-autorizar').click(function(){
          Autorizar($(this).attr('data-id'), $(this).attr('data-nombre'));
        });

        $('.btn-nuevo').click(function(){
          $("#modalNivelTitulo").text("Agrega Solicitud");
          $("#nombre_nivel").val('');
          $("#nombre_nivel1").val('');
          funcion = 0;
        });

        function editarNivel(qwert,fecha_solicitud,correo,nfamilia,estatus,nombre){
          $("#modalNivelTitulo").text("Solicitud de Chofer");
          $("#id").val(qwert);
          $("#fecha_solicitud").val(fecha_solicitud);
          $("#correo").val(correo);
          $("#familia").val(nfamilia);
          $("#nombre_chofer").val(nombre);
          if (estatus==1 || estatus==4){
            $("#estatus").val(0);
          }else {
            if( estatus==2 || estatus==3){
              $("#estatus").val(estatus);
            }else{
              $("#estatus").val(0);
            }
          }
          $("#funcion").val(qwert);
          $(".lista-padres").remove();
          $.get("get_padres.php",{nfamilia:nfamilia},verificar,'text');

          $(".lista-autos").remove();
          $.get("get_autos.php",{nfamilia:nfamilia},verificar_autos,'text');

          //Funcion del ajax padres
          function verificar(respuesta){
            var array_padres = respuesta.split('!');
            for (var i = 0; i< array_padres.length ; i++){
              var padre='';
              var datos_padres = array_padres[i].split('|');
              var nombre= datos_padres[0];
              var correo=  datos_padres[1];
              var tipo = datos_padres[2];
              if (tipo=='3') {
                padre='Papá';
              }else if (tipo=='4') {
                padre='Mamá';
              }
              var text= "<tr class='lista-padres m-5'><td><input type='text' class='form-control' value='"+nombre+"' readonly></td><td><input type='text' class='form-control' value='"+padre+"' readonly></td></tr>";
              $("#tabla_solicitantes").append(text);
            }
          }

          //Funcion del ajax autos
          function verificar_autos(respuesta){
            var array_autos = respuesta.split('!');
            if (array_autos.length ==1 && array_autos[0]==''){
              //imprime que no tiene carros asignados.

              var text= "<tr  class = 'lista-autos'><td  class='text-center'>Sin autos asignados</td></tr>";
              $("#tabla_autos").append(text);
            }else{
              for (var i = 0; i< array_autos.length ; i++){
                var datos_autos = array_autos[i].split('|');
                var marca =  datos_autos[0];
                var modelo=  datos_autos[1];
                var color = datos_autos[2];
                var placa = datos_autos[3];
                var tarjeton = datos_autos[4];
                var submarca = datos_autos[5];

                var text= "<tr class = 'lista-autos'><td WIDTH= '20%''><input id='marca' type='text' class='form-control' value='" + marca + "'  readonly></td><td WIDTH= '20%''><input id='submarca' type='text' class='form-control' value='" + submarca + "'  readonly></td><td WIDTH= '10%'><input id='modelo' type='text' class='form-control' value='"+ modelo+"' readonly></td><td WIDTH= '20%'><input id='color' type='text' class='form-control' value='"+color+ "' readonly></td><td WIDTH= '20%'><input id='placa' type='text' class='form-control' value='"+ placa+"' readonly></td><td WIDTH= '10%'><input id='tarjeton' type='text' class='form-control' value='"+ tarjeton+"' readonly></td></tr>";

                $("#tabla_autos").append(text);
              }
            }

          }


        }
        /*Cancelar permiso*/
        function eliminarNivel(qwert, nombre) {
          var respuesta = confirm("Desea archivar la solicitud del chofer con ID: " + qwert);
          if (respuesta) {
            var contenido = "";
            $.ajax({
              url : "php/niveles.php?delNivel=true&qwert=" + qwert,
              dataType : 'json',
              success : function(data) {
                if (data) {
                  location.reload();
                }
              }/* Success */
            });
          }
        }
        /*autorizar permiso*/
        function Autorizar(qwert, nombre) {
          var respuesta = confirm("Desea Autorizar el permiso numero: " + qwert);
          if (respuesta) {
            var contenido = "";
            $.ajax({
              url : "php/niveles.php?AutorizaV=true&qwert=" + qwert,
              dataType : 'json',
              success : function(data) {
                if (data) {
                  location.reload();
                }

              }/* Success */
            });
          }
        }
      });
