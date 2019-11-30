$( function() {
  var funcion;
  $('.save-nivel')
  .submit(
    function(e) {
      var nombre_nivel = $('#nombre_nivel').val();
      var mensaje = $('#mensaje').val();
      var estatus = $('#estatus').val();
//validacion de mensaje
      if(mensaje==null || mensaje.length<=5)
      {
        alert("Agrega Respuesta.");
        return false;
      }
//validacion de camion/ruta
      //conseguir camion mañana-tarde
      var ruta = $("#ruta").val();
      var id_camion = '';
      ruta=ruta.toLowerCase();
      if (ruta==='mañana-tarde'){
          //si el checkbox es seleccionado
          if ($("#dos_rutas").prop('checked')){
            id_camion = $('select#id_camion').val() +  '/' + $('select#id_camion_s').val();
            id_camion_1 = $('select#id_camion').val();
            id_camion_2 = $('select#id_camion_s').val();
            if(!(id_camion_1>0) || !(id_camion_1>0))
            {
              alert("Selecciona las dos Rutas Validas.");
              return false;
            }

        }else{
          id_camion = $('select#id_camion').val() +  '/' + $('select#id_camion').val();
          id_camion_1 = $('select#id_camion').val();
          if(!(id_camion_1>0))
          {
            alert("Selecciona una Ruta Valida.");
            return false;
          }
        }

      } else{
          id_camion = $('select#id_camion').val();
          if(!(id_camion>0))
          {
            alert("Selecciona una Ruta Valida.");
            return false;
          }

      }
//validacion de estatus
      if(estatus==0)
      {
        alert("Seleciona el estatus");
        return false;
      }

      e.preventDefault();
      $
      .ajax({
        type : 'POST',
        data : {
          funcion : funcion,
          nombre_nivel : nombre_nivel,
          mensaje : mensaje,
          id_camion : id_camion,
          estatus : estatus,
          turno: ruta
        }
      })
      .done(
        function(data) {
          if (data.estatus == '-1') {
            $('.alert-save')
            .html(
              '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>  El nombre del nivel ya existe, por favor escribe otro</div>')
              .hide().show('fast');
            } else {
              location.reload();
            }

          });
        });
        $('input.filter').keyup(function() {
          var rex = new RegExp($(this).val(), 'i');
          $('.searchable tr').hide();
          $('.searchable tr').filter(function() {
            return rex.test($(this).text());
          }).show();
        });
        $('.btn-editar').click(function()
        {
          editarNivel($(this).attr('data-id'),
          $(this).attr('data-nombre'),
          $(this).attr('data-nombre1'),
          $(this).attr('data-calle_numero'),
          $(this).attr('data-colonia'),
          $(this).attr('data-cp'),
          $(this).attr('data-fecha_inicial'),
          $(this).attr('data-fecha_final'),
          $(this).attr('data-comentarios'),
          $(this).attr('data-calle_numero1'),
          $(this).attr('data-colonia1'),
          $(this).attr('data-ruta'), // añadido nuevo

          $(this).attr('data-mensaje'),
          $(this).attr('data-responsable'),
          $(this).attr('data-parentesco'),
          $(this).attr('data-celular'),
          $(this).attr('data-telefono'),
          $(this).attr('data-id_ruta'),
          $(this).attr('data-id_camion'),
          $(this).attr('data-estatus')
        );
        funcion = $(this).attr('data-id');
      });

      $('.btn-borrar').click(function() {
        eliminarNivel($(this).attr('data-id'), $(this).attr('data-nombre'));
      });

      $('.btn-autorizar').click(function() {
        Autorizar($(this).attr('data-id'), $(this).attr('data-nombre'));
      });



      $('.btn-nuevo').click(function() {
        $("#modalNivelTitulo").text("Agrega Solicitud");
        $("#nombre_nivel").val('');
        $("#nombre_nivel1").val('');
        funcion = 0;
      });


      function editarNivel(qwert,nombre,nombre1,calle_numero,colonia,cp,fecha_inicial,fecha_final,
        comentarios,calle_numero1,colonia1,ruta,mensaje,
        responsable,parentesco,celular,telefono,id_ruta,id_camion, estatus)
        {
          $("#modalNivelTitulo").text("Solicitud de Viaje");
          $("#folio").val(qwert);
          $("#nombre_nivel").val(nombre);
          $("#nombre_nivel1").val(nombre1);
          $("#calle_numero").val(calle_numero);
          $("#colonia").val(colonia);
          $("#cp").val(cp);
          $("#fecha_inicial").val(fecha_inicial);
          $("#fecha_final").val(fecha_final);
          $("#comentarios").val(comentarios);
          $("#calle_numero1").val(calle_numero1);
          $("#colonia1").val(colonia1);
          $("#ruta").val(ruta); //añadido ruta

          //Verifica la ruta/Turno
          ruta = ruta.toLowerCase();
          if (ruta==='mañana-tarde'){
            //mañana-tarde
            $("#vista_s").show();
            if (id_camion!==''){
              // alert('Camion Asignado');
              //el camion fue asignado
              var array_rutas = id_camion.split("/");
              var id_camion_1 = array_rutas[0];
              var id_camion_2 = array_rutas[1];
                if (id_camion_1===id_camion_2){
                  // alert('Camion Igual M-T');
                  //Se selecciono una unica ruta
                  $("#dos_rutas").attr('checked', false);
                  $(".rutas_s").hide();
                  $("#ruta_p").text('Rutas:');
                      //id_rutas
                      if(id_camion_1>0){
                        $('select#id_camion').val(id_camion_1);
                      }else{
                        $('select#id_camion').val('0');
                        $('select#id_camion').val('99999'); //FALTA estar en PRODUCCION
                        $("#id_camion").prop('disabled',true);
                      }

                }else{
                  // alert('Camion Distintos M-T');
                  //se seleccionaron dos rutas
                  $("#dos_rutas").attr('checked', true);
                    $(".rutas_s").show();
                    $("#ruta_p").text('Rutas(Mañana):');
                  //camion 1
                  if(id_camion_1>0){
                    $('select#id_camion').val(id_camion_1);
                  }else{
                    $('select#id_camion').val('0');
                  }
                  //camion 2
                  if(id_camion_2>0){
                    $('select#id_camion_s').val(id_camion_2);
                  }else{
                    $('select#id_camion_s').val('0');
                  }
                }

            }else{
              // alert('Camion NO Asignado');
                //No se ha Seleccionado camion
                $(".rutas_s").hide();
                $("#ruta_p").text('Rutas:');
                $("#dos_rutas").attr('checked', false);
                $('select#id_camion').val('0');
            }

          }else{
            //Mañana o Tarde
            $("#vista_s").hide();
            $("#ruta_p").text('Rutas:');
                //id_rutas
                if(id_camion>0){
                  $('select#id_camion').val(id_camion);
                }else{
                  $('select#id_camion').val('0');
                }
          }


          $("#mensaje").val(mensaje);
          $("#responsable").val(responsable);
          $("#parentesco").val(parentesco);
          $("#telefono").val(telefono);
          $("#celular").val(celular);
          $("#funcion").val(qwert);

          $("#ruta_cancelada").hide();
          $("#id_camion").prop('disabled',false);
          if (estatus==1 || estatus==4){
            if(estatus==4){
                $("#ruta_cancelada").show();
                $("#id_camion").val(999);
                $("#id_camion").prop('disabled',true);
                $("#vista_s").hide();
                $("#ruta_p").text('Rutas:');
              }
            $("#estatus").val(0);
          }else {

            if( estatus==2 || estatus==3){

              $("#estatus").val(estatus);

            }else{

              $("#estatus").val(0);

            }

          }
          //remover todos los alumnos de la lista
          $(".lista-alumnos").remove();
          //$("#tabla_alumnos").append("<h1 class='lista-alumnos'>Good</h1>");
          $.get("common/get_alumnos.php", {id:qwert}, verificar, 'text' );
          //Funcion del ajax
          function verificar(respuesta){
            var array_alumnos = respuesta.split('!');
            for (var i = 0; i< array_alumnos.length ; i++){
                var datos_alumno = array_alumnos[i].split('|');
                //$("#tabla_alumnos").append("<h1 class='lista-alumnos'>"+ datos_alumno[0]+","+datos_alumno[1]+","+datos_alumno[2]+"," +"</h1>");
                var nombre= datos_alumno[0];
                var grado=  datos_alumno[1];
                var grupo = datos_alumno[2];
                var text= "<tr class='lista-alumnos'><td><input name='alumno' id='alumno' type='text' class='form-control' value='" + nombre + "'  readonly> </td> <td><input name='grado' id='grado' type='text' class='form-control' value='" + grado + "' readonly></td> <td> <input name='grupo' id='grupo' type='text' class='form-control' value='"+ grupo + "' readonly></td></tr>";
              $("#tabla_alumnos").append(text);
            }
          }
        }

        /*Cancelar permiso*/
        function eliminarNivel(qwert, nombre) {
          var respuesta = confirm("Desea archivar el permiso numero: " + qwert);
          if (respuesta) {
            var contenido = "";
            $.ajax({
              url : "php/niveles.php?CancelaV=true&qwert=" + qwert,
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

function show_dos_rutas(){
  if($("#dos_rutas").prop("checked")){
    // alert('on');
    //2 ruta
    $(".rutas_s").show();
    $("#ruta_p").text('Rutas(Mañana):');
  }else{
    // alert('off');
    //1 ruta
    $(".rutas_s").hide();
    $("#ruta_p").text('Rutas:');

  }

}
