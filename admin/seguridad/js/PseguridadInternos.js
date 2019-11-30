function mostrar_familia(id){
  window.location = 'PseguridadFamilia.php?nfamilia=' + id;
}

function set_estatus(id){
  //alert('Ok:' + id);
  //cambiar estatus
  $.ajax({
    url: 'common/post_estatus_seguridad.php',
    type: "POST",
    data:{
      submit:0,
      id_permiso_alumno : id
    },
      success: function(datos)
    {
      data = JSON.parse(datos);
    //  alert(datos);
    if (data.estatus_seguridad==='2'){
      //alert("Estatus cambiado a: " + data.estatus_seguridad );
      $("#img_"+ id).css("background", "#8aff8e");
    }else if (data.estatus_seguridad==='1'){
      $("#img_"+ id).css("background", "white");
    }
    }
  });
}

function get_estatus(id){
  //alert('Ok:' + id);
  //cambiar estatus
  $.ajax({
    url: 'common/get_estatus_seguridad.php',
    type: "POST",
    data:{
      submit:0,
      id_permiso_alumno : id
    },
      success: function(datos)
    {
      data = JSON.parse(datos);
    //  alert(datos);
    if (data.estatus_seguridad==='2'){
      //alert("Estatus cambiado a: " + data.estatus_seguridad );
      $("#img_"+ id).css("background", "#8aff8e");
    }else if (data.estatus_seguridad==='1'){
      $("#img_"+ id).css("background", "white");
    }
    }
  });
}

$(function() {

  var funcion;


        $('input.filter').keyup(function()
        {
          var rex = new RegExp($(this).val(), 'i');
          $('.searchable tr').hide();
          $('.searchable tr').filter(function() {
            return rex.test($(this).text());
          }).show();
        });

        $(".fila_alumnos").each(function(){
          let id = this.id;
        //  alert(id);
           get_estatus(id);
        });

      });
