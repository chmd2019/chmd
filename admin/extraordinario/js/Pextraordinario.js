$(function() {

  var funcion;
  var idpermiso;

$('.fila_alumnos').each( function(){
  //necesito id_alumno, idcursar, id_permiso_alumno
  let id = this.id;
  let info= id.split('_');
  let id_alumno=info[1];
  let idcursar=info[2];
  let id_permiso_alumno= info[3];
  $.ajax({
    url: 'common/get_aviso_tercer_permiso.php',
    type: 'GET',
    data: {"id_alumno": id_alumno, "idcursar": idcursar},
    success: function (res) {
      res = JSON.parse(res);
    //  alert( 'Mas de tras' + res);
      if (res) {
        $("#fila_" + id_alumno + '_' + idcursar + '_' + id_permiso_alumno).css("background", "#ffffab");
        //el alumno ha supera el limite
      }
    }
  });
  //alert( 'Mas de tras' + id_alumno +',' +idcursar+',' + id_permiso_alumno);
  /*
  */
});

  $('.save-nivel')
  .submit(
    function(e) {
      var nombre_nivel = 1;
      var mensaje = $('#mensaje').val();
      var estatus = $('#estatus').val();
      var nombre = $('#nombre').val();

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
      //Identifica el mensaje
      mensaje= nombre + ': ' + mensaje + '. ';
    //  alert(mensaje);
    //  return false;
      e.preventDefault();
      $
      .ajax({
        url: 'common/post_estatus.php',
        type : 'POST',
        data : {
          nombre_nivel : nombre_nivel,
          funcion : funcion,
          idpermiso : idpermiso,
          mensaje : mensaje,
          estatus : estatus
        }
      })
      .done(
        function(data) {
          //alert(data.estatus + 'Pendentes: ' + data.pendientes);
          if (data.estatus == '-1') {
            alert('Ha ocurrido un error!');
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
          $(this).attr('data-idpermiso'),
          $(this).attr('data-nfamilia'),
          $(this).attr('data-fecha'),
          $(this).attr('data-correo'),
          $(this).attr('data-nombre'),
          $(this).attr('data-grado'),
          $(this).attr('data-grupo'),
          $(this).attr('data-nivel'),
          $(this).attr('data-fechap'),
          $(this).attr('data-regresa'),
          $(this).attr('data-horasalida'),
          $(this).attr('data-horaregreso'),
          $(this).attr('data-comentarios'),
          $(this).attr('data-mensaje'),
          $(this).attr('data-responsable'),
          $(this).attr('data-parentesco'),
          $(this).attr('data-fechacambio'),
          $(this).attr('data-frespuesta'));

          idpermiso = $(this).attr('data-idpermiso');
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

        function editarNivel(qwert,idpermiso,nfamilia,fecha,correo, nombre, grado, grupo, nivel, fechap, regresa, hora_salida,  hora_regreso, motivo, mensaje, responsable, parentesco, fecha_cambio, frespuesta)
        {
          $("#modalNivelTitulo").text("Solicitud de permiso Extraordinarios");
          $("#nfamilia").val(nfamilia);
          $("#fecha_s").val(fecha);
          $("#solicitante").val(correo);
          $("#nombre").val(nombre);
          $("#grado").val(grado);
          $("#grupo").val(grupo);
          $("#nivel").val(nivel);
          $("#fechacambio").val(fechap);
          if (regresa==0){
            $("#regresa").val('No');
            $("#hora_regreso").val('-');
          }else{
            $("#regresa").val('Si');
            $("#hora_regreso").val(hora_regreso);
          }
          $("#hora_salida").val(hora_salida);

          $("#responsable").val(responsable);
          $("#parentesco").val(parentesco);
          $("#comentarios").val(motivo);
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

          $("#idpermiso").val(idpermiso);
          $("#funcion").val(qwert);
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

function reset(nivel){
  var _nivel = '';
  switch (nivel) {
    case 1:
        _nivel = 'KINDER';
      break;
      case 2:
          _nivel = 'PRIMARIA';
        break;
        case 3:
            _nivel = 'BACHILLERATO';
          break;
    default:

  }
  alert('Prueba de Reset - Nivel: ' + _nivel);
  return;
}
