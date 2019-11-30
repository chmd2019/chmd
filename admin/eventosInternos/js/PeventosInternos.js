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
          editarNivel($(this).attr('data-id'),
          $(this).attr('data-solicitante'),
      //    $(this).attr('data-nfamilia'),
          $(this).attr('data-fecha'),
      //    $(this).attr('data-correo'),
      //    $(this).attr('data-codigo'),
      //    $(this).attr('data-familia'),
          $(this).attr('data-fechaevento'),
          $(this).attr('data-tipoevento'),
    //      $(this).attr('data-empresa'),
          $(this).attr('data-comentarios'),
          $(this).attr('data-mensaje'),
          $(this).attr('data-responsable'),
          $(this).attr('data-parentesco'),
          $(this).attr('data-horasalida'),
          $(this).attr('data-horaregreso'),
          $(this).attr('data-regresa'),
          $(this).attr('data-fechacambio'),
          $(this).attr('data-frespuesta'),
          $(this).attr('data-estatus')
          );

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
          $("#nombre_nivel1").val('');
          funcion = 0;
        });

        function editarNivel(qwert,solicitante,fecha, fecha_evento, tipo_evento,  motivo, mensaje, responsable, parentesco,hora_salida, hora_regreso, regresa, fecha_cambio, frespuesta, estatus)
        {
          $("#modalNivelTitulo").text("Solicitud de Permiso Interno");
          $("#folio").val(qwert);
          $("#solicitante").val(solicitante);
          //$("#nfamilia").val(nfamilia);
          $("#fecha_s").val(fecha);
        //  $("#solicitante").val(correo);
        //  $("#codigo").val(codigo);
        //  $("#familia").val(familia);
          $("#fechaevento").val(fecha_evento);
          $("#tipoevento").val(tipo_evento);
        //  $("#empresa").val(empresa);
          $("#responsable").val(responsable);
          $("#parentesco").val(parentesco);
          $("#comentarios").val(motivo);
          $("#frespuesta").val(frespuesta);

          $("#hora_salida").val(hora_salida);
          if (regresa === '1'){
          $("#hora_regreso").val(hora_regreso);
          }else{
            $("#hora_regreso").val('  -  ');
          }



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
                if (nombre !==''){
                  var grado_grupo=  datos_alumno[1] + ' - '+  datos_alumno[2];
                  var id_permiso_alumno = datos_alumno[3];
                  var estatus = datos_alumno[4];
                  var estatus_seguridad = datos_alumno[6];
                  /*
                  if (estatus=='2'){
                    var text_botones ="<p class = 'text-success glyphicon glyphicon-ok'  onmouseover='change_icon_ok("+ id_permiso_alumno+")'   > </p>";
                  }else if (estatus=='3'){
                    var text_botones = "<p class = 'text-danger glyphicon glyphicon-remove' onmouseover='change_icon_remove("+ id_permiso_alumno+")' > </p>";
                  }else{
                    var text_botones = "<button  type='button' class = 'btn btn-success glyphicon glyphicon-ok' onclick='set_estatus(2, " + id_permiso_alumno + ")' > </button> <button  type='button' class='btn btn-danger glyphicon glyphicon-remove' onclick= 'set_estatus(3, " + id_permiso_alumno + ")'> </button>";
                  }
                  */
                  var text_salida = '';
                  var text_cancelar = '';

                  if (estatus_seguridad == '0' || estatus_seguridad == '1'   ){
                    text_salida = "<p class='text-primary glyphicon glyphicon-time'> </p>"
                    text_cancelar = "<button  type='button' class='btn btn-danger glyphicon glyphicon-remove' onclick= 'remove_alumno("+i+"," + id_permiso_alumno + ")'> </button>";
                  }else if (estatus_seguridad == '2'){
                    text_salida = "<p class='text-success glyphicon glyphicon-ok-sign'> </p>";
                    text_cancelar = '';
                  }
                  if (estatus=='3'){
                    text_salida = "<p class='text-danger glyphicon glyphicon-remove'> </p>";
                    text_cancelar = '';
                  }


                  var text = "<tr class='lista-alumnos'><td id='salida_"+i+"' WIDTH='5%' colspan='1'>"+text_salida+"</td><td WIDTH='50%' colspan='5' ><input name='alumno' id='alumno' type='text' class='form-control' placeholder='nombre' value='" + nombre + "'  readonly></td><td  WIDTH='40%' colspan='4'>  <input name='grado_grupo' id='grado_grupo' type='text' class='form-control' placeholder='grado' value='" + grado_grupo + "'  readonly></td><td id ='cancelar_"+i+"' WIDTH='5%' colspan='1'>" + text_cancelar + "</td></tr>'";

                }else{
                  var text="<tr class='lista-alumnos'><td>Sin alumnos enlistados</td></tr>";
                }
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
