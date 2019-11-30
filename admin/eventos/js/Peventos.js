$(function() {
  var funcion;
  var nivel = $("#nivel_perfil").val();

  $('.save-nivel')
  .submit(
    function(e) {
      var nombre_nivel = 1;
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
        url: 'common/post_estatus_permiso.php',
        type : 'POST',
        data : {
          nombre_nivel : nombre_nivel,
          funcion : funcion,
          mensaje : mensaje,
          estatus : estatus
        },
        success: function (res) {
        //  alert(res);
          data = JSON.parse(res);
        //  alert(data.estatus + 'Pendentes: ' + data.pendientes);
          if (data.estatus == '-1') {
            alert('Ha ocurrido un error, Debe autorizar o declinar a todos los alumnos enlistados.');
            } else {
              if (data.pendientes=='0'){
                location.reload();
              }
            }
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
          $(this).attr('data-nfamilia'),
          $(this).attr('data-fecha'),
          $(this).attr('data-correo'),
          $(this).attr('data-codigo'),
          $(this).attr('data-familia'),
          $(this).attr('data-fechaevento'),
          $(this).attr('data-tipoevento'),
          $(this).attr('data-empresa'),
          $(this).attr('data-comentarios'),
          $(this).attr('data-mensaje'),
          $(this).attr('data-responsable'),
          $(this).attr('data-parentesco'),
          $(this).attr('data-fechacambio'),
          $(this).attr('data-frespuesta'),
          $(this).attr('data-nivelpermiso'));
          funcion = $(this).attr('data-id');
        });
        /*NivelPermoso
         0 - General
         1 - kinder
         2 - primaria
         3 - bachillerato
         */
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

        function editarNivel(qwert,nfamilia,fecha,correo, codigo, familia, fecha_evento, tipo_evento, empresa,  motivo, mensaje, responsable, parentesco, fecha_cambio, frespuesta, nivel_perfil )
        {
          var _nivel = nivel_perfil;
          $("#modalNivelTitulo").text("Solicitud de Evento");
          $("#nfamilia").val(nfamilia);
          $("#fecha_s").val(fecha);
          $("#solicitante").val(correo);
          $("#codigo").val(codigo);
          $("#familia").val(familia);
          $("#fechaevento").val(fecha_evento);
          $("#tipoevento").val(tipo_evento);
          $("#empresa").val(empresa);
          $("#responsable").val(responsable);
          $("#parentesco").val(parentesco);
          $("#comentarios").val(motivo);
          $("#frespuesta").val(frespuesta);

        /* Estatus No APlica
         if (estatus==1 || estatus==4){
            $("#estatus").val(0);
          }else {
            if( estatus==2 || estatus==3){
              $("#estatus").val(estatus);
            }else{
              $("#estatus").val(0);
            }
          }
          */
          $("#funcion").val(qwert);

          $(".lista-alumnos").remove();
          //$("#tabla_alumnos").append("<h1 class='lista-alumnos'>Good</h1>");
          $.get("common/get_alumnos.php", {id:qwert}, verificar, 'text' );
          //Funcion del ajax
          function verificar(respuesta){
            var c = 0;
            var array_alumnos = respuesta.split('!');
            for (var i = 0; i< array_alumnos.length ; i++){
                var datos_alumno = array_alumnos[i].split('|');
                //$("#tabla_alumnos").append("<h1 class='lista-alumnos'>"+ datos_alumno[0]+","+datos_alumno[1]+","+datos_alumno[2]+"," +"</h1>");
                var nombre= datos_alumno[0];
                if (nombre !==''){
                  var grado_grupo=  datos_alumno[1] + ' - '+  datos_alumno[2];
                  var id_permiso_alumno = datos_alumno[3];
                  var estatus = datos_alumno[4];
                  var nivel = datos_alumno[5];
                  if (estatus=='2'){
                    var text_botones ="<p class = 'text-success glyphicon glyphicon-ok'  onmouseover='change_icon_ok("+ id_permiso_alumno+")'   > </p>";
                  }else if (estatus=='3'){
                    var text_botones = "<p class = 'text-danger glyphicon glyphicon-remove' onmouseover='change_icon_remove("+ id_permiso_alumno+")' > </p>";
                  }else{
                    var text_botones = "<button  type='button' class = 'btn btn-success glyphicon glyphicon-ok' onclick='set_estatus(2, " + id_permiso_alumno + ")' > </button> <button  type='button' class='btn btn-danger glyphicon glyphicon-remove' onclick= 'set_estatus(3, " + id_permiso_alumno + ")'> </button>";
                  }
                  var estatus_padre = datos_alumno[6];
                  if (estatus_padre=='1'){
                    //pendiente
                    var text_mail ="<p  style='margin:2px' class = 'text-info glyphicon glyphicon-time'> </p>";
                  }else if (estatus_padre=='2'){
                    //autorizado
                    var text_mail = "<p style='margin:2px' class = 'text-success glyphicon glyphicon-ok'> </p>";
                  }else if (estatus_padre=='4'){
                    //cancelado
                    var text_mail = "<p style='margin:2px' class = 'text-danger glyphicon glyphicon-remove'> </p>";
                  }else {
                    // declinado por administrador
                    var text_mail = "<p style='margin:2px' class = 'text-danger glyphicon glyphicon-remove'> </p>";
                  }

                  //Considerar el area o nivel
                  if (_nivel=== nivel || _nivel =='0'){
                    c++;
                    var text= "<tr  class='lista-alumnos'><td WIDTH='5%'>"+text_mail+"</td> <td  WIDTH='45%' colspan='3' ><input name='alumno' id='alumno' type='text' class='form-control' placeholder='nombre' value='" + nombre + "'  readonly></td><td  WIDTH='35%' colspan='4'>  <input name='grado_grupo' id='grado_grupo' type='text' class='form-control' placeholder='grado' value='" + grado_grupo + "'  readonly></td><td  id='acciones_"+ id_permiso_alumno +"' WIDTH='15s%' colspan='1' >"+text_botones+"</td></tr>'";
                  }else{
                    var text = '';
                  }

                }else{
                  var text="<tr class='lista-alumnos'><td>Sin alumnos enlistados</td></tr>";
                }
                $("#tabla_alumnos").append(text);
            }
            if (c=='0'){
              var text="<tr class='lista-alumnos'><td>Sin alumnos enlistados</td></tr>";
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

      function declinar_todos(){

      }
