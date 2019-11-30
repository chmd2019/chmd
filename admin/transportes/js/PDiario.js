$(function() {

  var funcion;

  $('.save-nivel')
  .submit(
    function(e) {
      var nombre_nivel = $('#nombre_nivel').val();
      var mensaje = $('#mensaje').val();
      var estatus = $('#estatus').val();
      var id_camion = $('select#id_camion').val();
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
          id_camion : id_camion,
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
          $(this).attr('data-nombre1'),
          $(this).attr('data-calle_numero'),
          $(this).attr('data-colonia'),
          $(this).attr('data-cp'),
          $(this).attr('data-ruta'),
          $(this).attr('data-comentarios'),
          $(this).attr('data-calle_numero1'),
          $(this).attr('data-colonia1'),
          //alunmnos
          $(this).attr('data-mensaje'),
          $(this).attr('data-fechacambio'),
          $(this).attr('data-frespuesta'),
          $(this).attr('data-celular'),
          $(this).attr('data-telefono'),
          $(this).attr('data-id_ruta'),
          $(this).attr('data-id_camion'),    
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
          $("#nombre_nivel1").val('');
          funcion = 0;
        });

        function editarNivel(qwert,nombre,nombre1,calle_numero,colonia,cp,ruta,comentarios,calle_numero1,colonia1,mensaje,fechacambio,frespuesta,celular, telefono,id_ruta ,id_camion , estatus)
        {
          $("#modalNivelTitulo").text("Solicitud de Diario");
          $("#folio").val(qwert);
          $("#nombre_nivel").val(nombre);
          $("#nombre_nivel1").val(nombre1);
          $("#calle_numero").val(calle_numero);
          $("#colonia").val(colonia);
          $("#cp").val(cp);
          // $("#ruta").val(ruta);
          //Color de Ruta 
          // if (ruta === 'Taller 4:30 PM') {
          //   $("#ruta").css("background","mistyrose");
          // }else{
          //   $("#ruta").css("background","#eee");
          // }
         //id_rutas
          if(id_ruta==1){
            // $('select#id_ruta').val(id_ruta);
             $("#ruta").val('[General 2:50 PM]');
          }else{
            // $('select#id_ruta').val('0');
             $("#ruta").val('[Taller 4:30 PM]');
          }
          //id_camion
        if(id_camion>0){
          $('select#id_camion').val(id_camion);
        }else{
          $('select#id_camion').val('0');
        }

          $("#comentarios").val(comentarios);
          $("#calle_numero1").val(calle_numero1);
          $("#colonia1").val(colonia1);
          $("#mensaje").val(mensaje);
          $("#fechacambio").val(fechacambio);
          $("#frespuesta").val(frespuesta);
          $("#telefono").val(telefono);
          $("#celular").val(celular);


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
