$(function() {

  var funcion;

  $('.save-nivel')
  .submit(
    function(e) {
      var nombre_nivel = $('#nombre_nivel').val();
      var mensaje = $('#mensaje').val();
      var estatus = $('#estatus').val();
      if(estatus==0)
      {
        alert("Seleciona el estatus");
        return false;
      }

      if(mensaje==null || mensaje.length<=5)
      {
        alert("Agrega Respuesta.");
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
          estatus : estatus
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
        $('input.filter').keyup(function()
        {
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
          $(this).attr('data-correo'),
          $(this).attr('data-fechacambio'),
          $(this).attr('data-responsable'),
          $(this).attr('data-parentesco'),
          $(this).attr('data-comentarios'),
          $(this).attr('data-mensaje'),
          $(this).attr('data-frespuesta'),
          $(this).attr('data-estatus'));

          funcion = $(this).attr('data-id');
        });

        $('.btn-borrar').click(function()
        {
          eliminarNivel($(this).attr('data-id'), $(this).attr('data-nombre'));
        });

        $('.btn-autorizar').click(function()
        {
          Autorizar($(this).attr('data-id'), $(this).attr('data-nombre'));
        });

        $('.btn-nuevo').click(function()
        {
          $("#modalNivelTitulo").text("Agrega Solicitud");
          $("#nombre_nivel").val('');
          $("#solicitante").val('');
          funcion = 0;
        });

        function editarNivel(qwert,nombre,correo,fechacambio,responsable,parentesco,comentarios,mensaje,frespuesta,estatus)
        {
          $("#modalNivelTitulo").text("Permiso Extraordinarios");
          $("#folio").val(qwert);
          $("#nombre_nivel").val(nombre);
          $("#solicitante").val(correo);
          $("#fechacambio").val(fechacambio);

          $("#responsable").val(responsable);
          $("#parentesco").val(parentesco);
          $("#comentarios").val(comentarios);

          $("#mensaje").val(mensaje);
          $("#frespuesta").val(frespuesta);

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
          //remover todos los alumnos de la lista
          $(".lista-alumnos").remove();
          //$("#tabla_alumnos").append("<h1 class='lista-alumnos'>Good</h1>");
          $.get("common/get_alumnos_extraordinario.php", {id:qwert}, verificar, 'text' );
          //Funcion del ajax
          function verificar(respuesta){
            var array_alumnos = respuesta.split('!');
            for (var i = 0; i< array_alumnos.length ; i++){
                var datos_alumno = array_alumnos[i].split('|');
                //$("#tabla_alumnos").append("<h1 class='lista-alumnos'>"+ datos_alumno[0]+","+datos_alumno[1]+","+datos_alumno[2]+"," +"</h1>");
                var nombre= datos_alumno[0];
                var horasalida= datos_alumno[1];
                var horaregreso=datos_alumno[2];
                var regresa=datos_alumno[3];
                if(regresa=='1'){
                  regresa='Si';
                } else{
                  regresa='No';
                  horaregreso= '    -   ';
                }

                var estatus=datos_alumno[4];
                if(estatus==1){ staus1="Pendiente";}
                if(estatus==2){ staus1="Autorizado";}
                if(estatus==3){ staus1="Declinado";}
                if(estatus==4){ staus1="Cancelado por el usuario";}

                var nivel = datos_alumno[5];

                var text='<tr class="lista-alumnos"><td WIDTH="40%" colspan="4">' + nombre + '</td><td WIDTH="30%" colspan="3">' + nivel + '</td><td WIDTH="30%" colspan="3">' + staus1 + '</td></tr><tr class="lista-alumnos" style="border-bottom: 1px solid #eee;"><td colspan="4"><b>Hora de Salida: </b>' + horasalida +  '</td><td colspan="4"><b>Hora de Regreso: </b>'+horaregreso + '</td><td colspan="2"><b>Regresa: </b>'+regresa+'</td></tr>';
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
