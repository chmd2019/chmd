function mostrar_familia(id){
  window.location = 'PseguridadFamilia.php?nfamilia=' + id;
}

function registrar_salida(id_alumno,id_responsable ){
  //alert('Ok:' + id);
  //cambiar estatus
  $.ajax({
    url: 'common/post_registro_salida.php',
    type: "POST",
    data:{
      submit:0,
      id_alumno : id_alumno,
      $id_responsable: id_responsable
    },
      success: function(datos)
    {
      //alert(datos);
      data = JSON.parse(datos);
    if (data.registro===true){
      //alert("Estatus cambiado a: " + data.estatus_seguridad );
      $("#img_"+ id_alumno).css("background", "#8aff8e");
    }else if (data.registro===false){
      $("#img_"+ id_alumno).css("background", "white");
    }
    }
  });
}

function no_mostrar(id){
  $("#fila_"+ id).hide();
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

    //poner en verde los alumnos donde se registro la Salidas_alumnos
$(".fila_alumnos").each(function(){
  let id = this.id;

  $.get('common/get_registro_alumno.php?id_alumno=' + id  , function(datos){
   //alert(datos);
    datos=JSON.parse(datos);
    if (datos.registro==true){
      $("#img_"+ id).css("background", "#8aff8e");
    }else {
      $("#img_"+ id).css("background", "white");
    }

  });
});





  /*  $.ajax({
      url: 'common/get_registro_alumno.php',
      type: "POST",
      data:{
        submit:0,
        id_alumno : id_alumno,
        $id_responsable: id_responsable
      },
        success: function(datos)
      {
        alert(datos);
        data = JSON.parse(datos);
      if (data.estatus===true){
        //alert("Estatus cambiado a: " + data.estatus_seguridad );
        $("#img_"+ id_alumno).css("background", "green");
      }else if (data.estatus===false){
        $("#img_"+ id_alumno).css("background", "white");
      }
      }
    });*/


});
