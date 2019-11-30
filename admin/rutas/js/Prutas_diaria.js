$(function() {

  var funcion;

  $('.save-nivel')
  .submit(
    function(e) {
      var nombre_nivel = 1;
      //var mensaje = $('#mensaje').val();
      var estatus = $('#estatus').val();

      if(estatus==0)
      {
        alert("Seleciona el estatus");
        return false;
      }
/*
      if(mensaje==null || mensaje.length<=5)
      {
        alert("Agrega Respuesta.");
        return false;
      }
*/
      e.preventDefault();
      $
      .ajax({
        url: 'common/post_estatus_permiso.php',
        type : 'POST',
        data : {
          nombre_nivel : nombre_nivel,
          funcion : funcion,
          estatus : estatus
        },
        success: function (res) {
          data = JSON.parse(res);
        //  alert(data.estatus + 'Pendentes: ' + data.pendientes);
          if (data.estatus == '0') {
                location.reload();
            } else {
            alert('Ha ocurrido un error, Vuelva a intentarlo.');
            }
        }
      });
   });

        $('input.filter').keyup(function()
        {
          //alert('hola');
          var rex = new RegExp($(this).val(), 'i');
          $('.searchable tr').hide();
          $('.searchable tr').filter(function() {
            return rex.test($(this).text());
          }).show();
        });

        $('.btn-editar').click(function()
        {
          redirect_ver_ruta($(this).attr('data-id'),$(this).attr('data-fecha') );
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
          $("#nombre_nivel1").val('');
          funcion = 0;
        });

        function redirect_ver_ruta(qwert,fecha)
        {
          var url = '../rutas/control_ruta_diaria.php';
          var form = $('<form action="' + url + '" method="post">' +
          '<input type="text" name="id_ruta" value="' + qwert + '" />' +
          '<input type="text" name="fecha" value="' + fecha + '" />' +
          '</form>');
          $('body').append(form);
          form.submit();
        }



        /*Cancelar permiso*/
        function eliminarNivel(qwert, nombre) {
          var respuesta = confirm("Desea archivar el permiso numero: " + qwert);
          if (respuesta) {
            var contenido = "";
            $.ajax({
              url : "common/niveles.php?delNivel=true&qwert=" + qwert,
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

      function set_estatus(estatus, id_permiso_alumno){
      //  alert('ok: ' + estatus + ' ' + id_permiso_alumno);
        $.ajax({
          url : "common/post_estatus_alumno.php",
          type : 'POST',
          data : {
            id_permiso_alumno: id_permiso_alumno,
             estatus: estatus
          },
          success : function(data) {
            if (data) {
            //  alert('Modificado exitosamente.');
              if(estatus=='2'){
              //  $('#acciones_' + id_permiso_alumno).hide();
              $('#acciones_' + id_permiso_alumno).html("<p class = 'text-success glyphicon glyphicon-ok'  onmouseover='change_icon_ok("+ id_permiso_alumno+")'   > </p>");
              }else{
              //  $('#acciones_' + id_permiso_alumno).hide();
              $('#acciones_' + id_permiso_alumno).html("<p class = 'text-danger glyphicon glyphicon-remove' onmouseover='change_icon_remove("+ id_permiso_alumno+")' > </p>");
              }

            }

          }/* Success */
        });

      }

      function change_icon_ok(id){
        $('#acciones_' + id).html("<p class = 'text-primary glyphicon glyphicon-refresh'  onmouseout='back_change_icon_ok("+ id+")' onclick='rollback("+id+")'> </p>");
      }

      function change_icon_remove(id){
        $('#acciones_' + id).html("<p class = 'text-primary glyphicon glyphicon-refresh'  onmouseout='back_change_icon_remove("+ id+")' onclick='rollback("+id+")'> </p>");
      }

      function back_change_icon_ok(id){
        //  alert('hola');
        $('#acciones_' + id).html("<p class = 'text-success glyphicon glyphicon-ok' onmouseover='change_icon_ok("+ id +")' > </p>");
      }
      function back_change_icon_remove(id){
      //  alert('hola');
        $('#acciones_' + id).html("<p class = 'text-danger glyphicon glyphicon-remove' onmouseover='change_icon_remove("+ id +")' > </p>");
      }

      function rollback(id){
        $('#acciones_' + id).html("<button  type='button' class = 'btn btn-success glyphicon glyphicon-ok' onclick='set_estatus(2, " + id + ")' > </button> <button  type='button' class='btn btn-danger glyphicon glyphicon-remove' onclick= 'set_estatus(3, " + id + ")'> </button>");
      }


      function accion_todos( estatus){
        var qwert = $("#funcion").val();
          $.get("common/get_alumnos.php", {id:qwert}, verificar, 'text' );
          //funcion ajax
          function verificar(respuesta){
            //alert('ok:'+ respuesta );
            var array_alumnos = respuesta.split('!');
            for (var i = 0; i< array_alumnos.length ; i++){
                var datos_alumno = array_alumnos[i].split('|');
                //$("#tabla_alumnos").append("<h1 class='lista-alumnos'>"+ datos_alumno[0]+","+datos_alumno[1]+","+datos_alumno[2]+"," +"</h1>");
                let nombre= datos_alumno[0];
                let id_permiso_alumno = datos_alumno[3];
                if (nombre !==''){
                  //id del permiso
                  $.ajax({
                    url : "common/post_estatus_alumno.php",
                    type : 'POST',
                    data : {
                      id_permiso_alumno: id_permiso_alumno,
                      estatus: estatus
                    },
                    success : function(data) {
                      if (data) {
                      //  alert('Modificado exitosamente.');
                        if(estatus=='2'){
                        //  $('#acciones_' + id_permiso_alumno).hide();
                        $('#acciones_' + id_permiso_alumno).html("<p class = 'text-success glyphicon glyphicon-ok'  onmouseover='change_icon_ok("+ id_permiso_alumno +")'   > </p>");
                        }else{
                        //  $('#acciones_' + id_permiso_alumno).hide();
                          $('#acciones_' + id_permiso_alumno).html("<p class = 'text-danger glyphicon glyphicon-remove' onmouseover='change_icon_remove("+ id_permiso_alumno +")' > </p>");
                        }

                      }

                    }/* Success */
                  });

                }else{
                  alert('No existen alumnos enlistados.');
                }
            }
          }
      }

function  remove_alumno(i,id_p){
          //remover de la lista de alumnos
          var remove = 1;
          var id_permiso_alumno = id_p;
          $.ajax({
                url: 'common/post_remove_alumno.php',
                type : 'POST',
                data : {
                  remove : remove,
                  id_permiso_alumno : id_permiso_alumno
                },
                success: function (res) {
               //   alert(res);
                  data = JSON.parse(res);
                //alert(data.estatus + 'Pendentes: ' + data.pendientes);
                  if (data.estatus == '0') {
                      //colocar una x del lado der
                      let text_salida = "<p class='text-danger glyphicon glyphicon-remove'> </p>"
                      $("#salida_"+i).html (text_salida);
                      //eliminar boton del lado izq
                      $("#cancelar_"+i).html('');
                    } else {
                    alert('Ha ocurrido un error, Vuelva a intentarlo.');
                    }
                }
              });
        }

function deamon_rutas(){
  // ejecutar demonio de rutas del dia
    $.ajax({
                url: 'common/deamon_rutas.php',
                type : 'GET',
                success: function (res) {
              //  alert(res);
                data = JSON.parse(res);
                //alert(data.estatus + 'Pendentes: ' + data.pendientes);
                  if (!data.error) {
                    alert('Se ha actualizado la lista del día de Hoy');
                    location.reload();
                      // //colocar una x del lado der
                      // let text_salida = "<p class='text-danger glyphicon glyphicon-remove'></p>"
                      // $("#salida_"+i).html (text_salida);
                      // //eliminar boton del lado izq
                      // $("#cancelar_"+i).html('');
                    } else {
                      alert('Ha ocurrido un error, Vuelva a intentarlo.');
                    }
                }
              });
}
