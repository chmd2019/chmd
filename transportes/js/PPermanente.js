$(function() {
  var funcion;
  $('.save-nivel')
  .submit(
    function(e) {
      var nombre_nivel = $('#nombre_nivel').val();
      var mensaje = $('#mensaje').val();
      var status = $('#status').val();
      if(status==0)
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
          status : status
        }
      })
      .done(
        function(data) {
          if (data.estatus == -1) {
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
        /**********************************************************************/
        $('.btn-editar').click(function()
        {
          editarNivel($(this).attr('data-id'),
          $(this).attr('data-nombre'),
          $(this).attr('data-nombre1'),
          $(this).attr('data-calle_numero'),
          $(this).attr('data-colonia'),
          $(this).attr('data-cp'),
          $(this).attr('data-ruta'),
          $(this).attr('data-comentarios'),
          $(this).attr('data-calle_numero1'),
          $(this).attr('data-colonia1'),

          $(this).attr('data-mensaje'),
          $(this).attr('data-lunes'),
          $(this).attr('data-martes'),
          $(this).attr('data-miercoles'),
          $(this).attr('data-jueves'),
          $(this).attr('data-viernes')
        );
        funcion = $(this).attr('data-id');
      });
      /*************************************************************/
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
      /**********************************************************/
      function editarNivel(qwert,nombre,nombre1,calle_numero,colonia,cp,ruta,comentarios,calle_numero1,colonia1,mensaje,lunes,martes,miercoles,jueves,viernes)
      {
        $("#modalNivelTitulo").text("Editar Solicitud de Permanente");

        $("#folio").val(qwert);
        $("#nombre_nivel").val(nombre);
        $("#nombre_nivel1").val(nombre1);
        $("#calle_numero").val(calle_numero);
        $("#colonia").val(colonia);
        $("#cp").val(cp);
        $("#ruta").val(ruta);
        $("#comentarios").val(comentarios);
        $("#calle_numero1").val(calle_numero1);
        $("#colonia1").val(colonia1);

        $("#mensaje").val(mensaje);
        $("#lunes").val(lunes);
        $("#martes").val(martes);
        $("#miercoles").val(miercoles);
        $("#jueves").val(jueves);
        $("#viernes").val(viernes);
        if (status==1 || status==4){
          $("#status").val(0);
        }else {
          if( status==2 || status==3){
            $("#status").val(status);
          }else{
            $("#status").val(0);
          }
        }
        //funcion
        $("#funcion").val(qwert);
        //remover todos los alumnos de la lista
        $(".lista-alumnos").remove();
        //$("#tabla_alumnos").append("<h1 class='lista-alumnos'>Good</h1>");
        $.get("get_alumnos.php", {id:qwert}, verificar, 'text' );
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

      /**************************************************************/
      /*Cancelar permiso*/
      function eliminarNivel(qwert, nombre) {
        var respuesta = confirm("Desea archivar el permiso numero: " + qwert);
        if (respuesta) {
          var contenido = "";
          $.ajax({
            url : "php/niveles.php?CancelaP=true&qwert=" + qwert,
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
            url : "php/niveles.php?AutorizaP=true&qwert=" + qwert,
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
