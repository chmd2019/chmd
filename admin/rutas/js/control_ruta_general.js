var camion_old;
var cupos_old;
$(function(){
    //Tomar valores de las inputs
  camion_old = $("#camion").val();
  cupos_old = $("#cupos").val();
});


function  archivar_alumno(id){
  var data = {
     "summit" : 1 ,
     "id_alumno": id
  }
  $.ajax({
     url: 'common/post_dar_baja_alumno_ruta_general.php',
     type: 'POST',
     data: data,
     beforeSend: function () {
       // $("#btn_enviar_formulario").prop("disabled", true);
       //  $("#loading").fadeIn("slow");
     },
     success: function (res) {
      // alert(res);
       res = JSON.parse(res);
       if (res.estatus === true) {
         // alert('El alumno ha sido desvinculado de la ruta exitosamente.');
         // location.reload();
       }else{
         alert('Ha ocurrido un Error.');
         // $("#btn_enviar_formulario").prop("disabled", false);
       }
     }
   });

  let  nombre = $("td#nombre_m"+id).text();
  let  domicilio = $("td#domicilio_m"+id).text();
  let  grupo = $("td#grupo_m"+id).text();
  let  grado  = $("td#grado_m"+id).text();
//alert(nombre + grupo + grado + id);
  //agregar alumno al modal
  let text =
'<tr style="border-bottom: 1px solid #eee" id="tr_modal_m'+id+'">'+
'<td id="nombre_modal_m'+id+'">'+nombre+'</td>'+
'<td id="domicilio_modal_m'+id+'">'+domicilio+'</td>'+
'<td id="grado_modal_m'+id+'">'+grado+'</td>'+
'<td id="grupo_modal_m'+id+'">'+grupo+'</td>'+
'<td style="text-align:center">'+
'<button type="button" class="btn btn-primary" onclick="enlistar_alumno_m'+'('+id+')" style ="font-family: \'Varela Round\'" >'+
'<span class="glyphicon glyphicon-plus"></span> AÑADIR'+
'</button>'+
'</td>'+
'</tr>';
//alert(text);
$("#lista_alumnos_new_m").append(text);
//Hay en lista
$("#selected_m" + id ).remove();
//Disminuye el numero de alumnos y mostrarlo
let n_alumnos=parseInt($("#n_alumnos_m").text());
n_alumnos--;
$("#n_alumnos_m").text(n_alumnos);
//ordenar
ordenar_m(1);
}


// function  archivar_alumno(id){
//   let  nombre = $("td#nombret_"+id).text();
//   let  domicilio = $("td#domiciliot_"+id).text();
//   let  grupo = $("td#grupot_"+id).text();
//   let  grado = $("td#gradot_"+id).text();
// //alert(nombre + grupo + grado + id);
//   //agregar alumno al modal
//   let text =
// '<tr style="border-bottom: 1px solid #eee" id="tr_'+id+'">'+
// '<td id="nombre_'+id+'">'+nombre+'</td>'+
// '<td id="domicilio_'+id+'">'+domicilio+'</td>'+
// '<td id="grado_'+id+'">'+grado+'</td>'+
// '<td id="grupo_'+id+'">'+grupo+'</td>'+
// '<td style="text-align:center">'+
// '<button type="button" class="btn btn-primary" onclick="enlistar_alumno('+id+')" style ="font-family: \'Varela Round\'" >'+
// '<span class="glyphicon glyphicon-plus"></span> AÑADIR'+
// '</button>'+
// '</td>'+
// '</tr>';
// //alert(text);
// $("#lista_alumnos_new").append(text);
// //Hay en lista
// $("#selected_" + id ).remove();
// //Disminuye el numero de alumnos y mostrarlo
// let n_alumnos=parseInt($("#n_alumnos").text());
// n_alumnos--;
// $("#n_alumnos").text(n_alumnos);
// //ordenar
// ordenar(1);
// }

function enlistar_alumno_m(id){
  //Tomar cupos
  var n_alumnos = parseInt($("#n_alumnos_m").text());
  var cupos = $("#cupos").val();
  if (n_alumnos>=cupos){
    alert('No existen cupos disponible para esta ruta.')
    return;
  }
  //aumentar el numero de alumnos y mostrarlo
n_alumnos++;
$("#n_alumnos_m").text(n_alumnos);
//hay enlistados
  if ($("#selected_m" + id ).length){
      //Hay en lista
      // $("#selected_" + id ).remove();
//      $("#imagen_"+ id).css("background","white");
//      $("#imagen_"+ id).css("background","white");
    }else{
      //no existe en lista
      let nombre = $("#nombre_modal_m"+id).text();
      let domicilio = $("#domicilio_modal_m"+id).text();
      let grado = $("#grado_modal_m"+id).text();
      let grupo = $("#grupo_modal_m"+id).text();
      //$("#imagen_"+ id).css("background","#8aff8e");
      // $("#imagen_"+ id).css("background","#8aff8e");
      var text_button_archivar = "<a class='' id='btn_"+id+"' type='button' onclick='archivar_alumno("+ id +", \"m\")'></a>";
      var text = "<tr class='enlistado  enlistado_m view_m' id='selected_m"+id+"' data-id='"+id+"' data-orden='"+n_alumnos+"' style='border-bottom: 1px solid #ddd;'>"+
      "<td  id='orden_in"+id+"'>"+n_alumnos+"</td>"+
      "<td hidden class='id_selected_m'  id='id_m"+id+"'>"+id+"</td>"+
      "<td colspan='2' id ='nombre_m"+id+"'>"+nombre+"</td>"+
      "<td colspan='3' id ='domicilio_m"+id+"'>"+ domicilio +"</td>"+
      "<td colspan='2' id ='grado_m"+id+"'' >"+ grado +"</td>"+
      "<td colspan='2' id ='grupo_m"+id+"'>"+ grupo +"</td>"+
      "<td colspan='2' id ='hora_manana_m"+id+"'>"+
      "<input id='hora_m"+id+"' type='text' class='form-control timepicker hora_m' data-id='"+id+
      "' data-orden_in='"+n_alumnos+"' placeholder='Mañana' onclick='mostrar_timepicker_ma(this,"+id+
      ")' onKeyPress='return solo_select(event)' onchange='ordenar_m("+id+")'  maxlength='5' value=''>"+
      "</td>"+
      "<td colspan='1'>"+text_button_archivar+"</td>"+
      "</tr>";
      $("#lista_alumnos_m").append(text);
      }
      $.get('componentes/btn_cancelar.php', function (html){
        $("a#btn_"+id).html(html);
      });
      //Eliminar de la Lista de adicion.
      $('#tr_modal_m'+id).remove();

}



function cancelar() {
  //alert('ok');
   window.location = "../rutas/PrutasGenerales.php";
}


function mostrar_new() {
  if($('#chbox1').prop('checked') ) {
    $('#old_responsable').hide();
    $('#new_responsable').show();
    $("#responsable").prop('disabled', false);
    $("#parentesco_responsable").prop('disabled', false);
}else{
    $('#old_responsable').show();
  //  $('#new_responsable').hide();
    $("#responsable").prop('disabled', true);
    $("#parentesco_responsable").prop('disabled', true);
  }
}


/******************* Enviar el Fomulario**********************/
function enviar_formulario(id_ruta) {

//validar alumnos
if ($(".enlistado").length){
  //hay en lista, agregarlos a un array / Crear coleccion de alumnos
  //conseguir ids de alumnos registrados
  var ids_m ='';
  var coleccion_ids_m = [];
  var coleccion_data_alumnos_m = [];

  //mañana
  $(".id_selected_m").each(
    function(){
      ids_m += $(this).text() + ',';
    });
    var values = ids_m.split(",");
    for (var item in values) {
        if (values[item] !== "") {
            coleccion_ids_m.push(values[item]);
        }
    }

}else{
  //no hay alumno
  alert('Debe agregar al menos un alumno en la lista para continuar.');
  return;
}
//Validar que todos los horarios fueron rellenados
$vacio=false;
$(".timepicker").each(function(){
  //distinto de void
  if($(this).val()===''){
    $vacio=true;
  }
});
if ($vacio){
  alert('Debe Seleccionar las horas de todos los alumnos enlistados.');
  return;
}

/**Fin de las validaciones*/

//armar data

  //armar data - mañana
 for (var item in coleccion_ids_m) {
   var counter_alumno = coleccion_ids_m[item];
   var data_alumnos_m = {
      "id_alumno": $("td#id_m" + counter_alumno).text(),
      "id_ruta": id_ruta,
      "domicilio": $("td#domicilio_m" + counter_alumno).text(),
      "hora_manana": $("input#hora_m" + counter_alumno).val(),
      "orden_in": $("td#orden_in"+ counter_alumno).text()
    }
    coleccion_data_alumnos_m.push(data_alumnos_m);
  }

var data = {
    "id_ruta": id_ruta,
    "alumnos_m": coleccion_data_alumnos_m
  };

 $.ajax({
    url: 'common/post_rutas_general.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      $("#btn_enviar_formulario").prop("disabled", true);
      //  $("#loading").fadeIn("slow");
    },
    success: function (res) {
     // alert(res);
      res = JSON.parse(res);
      if (res.estatus === true) {
        alert('Almacenamiento exitoso.');
        location.reload();
      }else{
        alert('Ha ocurrido un Error.');
        $("#btn_enviar_formulario").prop("disabled", false);
      }
    }
  });
}

$('input.filter').keyup(function()
{
  //alert('hola');
  var rex = new RegExp($(this).val(), 'i');
  $('.searchable tr').hide();
  $('.searchable tr').filter(function() {
    return rex.test($(this).text());
  }).show();
});



function mostrar_timepicker_ma(el, id) {
  // mañana
    hora_maxima_del_dia = '19:00';
    $('#hora_m' + id).timepicker({
      'step': 1,
      'minTime': '07:40',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_m' + id).timepicker('show');
  // ids.push(el.id);
}

  function solo_select(e){
   var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
  }



function ordenar_m(id){

var id_edit = id;
//Encuentra tabla
var $table = $("#lista_alumnos_m");
var $rows = $table.children('tr');
//organizar tabla
var sortList = Array.prototype.sort.bind($rows);
sortList(function (a,b){
   let id_a = $(a).data('id');
   let id_b = $(b).data('id');
   //coseguir la Hora
   var hora_a = $('#hora_m'+id_a).val();
   var hora_b = $('#hora_m'+id_b).val();
   //analizo la hora y obtengo hora y minutos
   let elements_a = hora_a.split(':');
   let elements_b = hora_b.split(':');
   //Llevo a minutos las horas y obtengo los minutos totales
   let min_a= parseInt(elements_a[1]) + parseInt(elements_a[0])*60;
   let min_b= parseInt(elements_b[1]) + parseInt(elements_b[0])*60;
   //obtengo la difeencia de los minutos
   let value = min_a - min_b;
   //Verfico que no sea NaN
   return  isNaN(value) ? 1 : value;
     });

$table.append($rows);

//Ordena orden_in
//cambiar las posiciones
var array_orden = [];

$(".hora_m").each(function(){
     let hora = $(this).val();
     let id = $(this).data('id');
     let orden = $(this).data('orden_in');
     // alert("hora-"+hora+" id-"+id);
     //agregar a un array
     let data = {"id" : id, "hora" : hora, "orden": orden };
     array_orden.push(data);
});
array_orden.sort(function (a,b){
  let element_a = a.hora.split(':');
  let element_b = b.hora.split(':');
  let hora_a = element_a[0];
  let hora_b = element_b[0];
  let min_a= parseInt(element_a[1]) + parseInt(hora_a)*60;
  let min_b= parseInt(element_b[1]) + parseInt(hora_b)*60;
  let value = min_a - min_b;
  return isNaN(value) ? 1 : value;
});

// ordenar las posiciones
var pos =0;
 for (var item in array_orden) {
       //cambiar las posiciones
      pos++;
      let id = array_orden[item].id;
      let orden = array_orden[item].orden;
      // if (orden<900 || id===id_edit){
          $("#hora_m" + id ).attr('data-orden_in', pos);
          $("#orden_in" + id).text( pos );
      // }
  }
}


function cambiar_ruta(id_ruta_new, id_ruta_old){
  //conseguir id_alumno a cambiar
  var id_alumno = $("#id_alumno").val();

  // Solicitar cambio mediante ajax
 var data = {
    "id_ruta": id_ruta_new,
    "id_alumno": id_alumno,
    "summit": 1
  };

 $.ajax({
    url: 'common/post_cambio_ruta_general.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      // $("#btn_enviar_formulario").prop("disabled", true);
      //  $("#loading").fadeIn("slow");
    },
    success: function (res) {
      // alert(res);
      res = JSON.parse(res);
      if (res.estatus === true) {
        alert('El cambio ha sido exitoso.');
        // CERRAR MODAL
        $('#modal_cambio_ruta').modal('hide');

        //Hay en lista
        $("#selected_m" + id_alumno ).remove();
        //Disminuye el numero de alumnos y mostrarlo
        let n_alumnos=parseInt($("#n_alumnos_m").text());
        n_alumnos--;
        $("#n_alumnos_m").text(n_alumnos);
        //incrementar cupos en
        let cupos_d = parseInt($("#cupos_disponibles_m"+id_ruta_new).text());
        cupos_d++;
        $("#cupos_disponibles_m"+ id_ruta_new).text(cupos_d);
        //ordenar - mañana
        ordenar_m(0);

        //Almacenar Cambios de orden y ocupacion de espacios.
        enviar_formulario(id_ruta_old)
        // location.reload();
      }else{
        alert('Ha ocurrido un Error.');
      }
    }
  });
}

$(".cambio_ruta").click(function (){
  //tomar la data
   var id_alumno =  $(this).attr('data-id');
   var nombre_alumno   =  $(this).attr('data-nombre_alumno');
   var domicilio   =  $(this).attr('data-domicilio');
  //enviarla al modal
  $("#id_alumno").val(id_alumno );
  $("#nombre_alumno").text(nombre_alumno);
  $("#domicilio_alumno").text(domicilio );

});
