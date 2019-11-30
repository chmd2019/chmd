var camion_old;
var cupos_old;
$(function(){
    //Tomar valores de las inputs
  camion_old = $("#camion").val();
  cupos_old = $("#cupos").val();
  // let alumnos_registrados = $("#n_alumnos").text();
  // if (alumnos_registrados>cupos_old ){
  //   $("#n_alumnos").addClass('text-danger');
  // }else{
  //   $("#n_alumnos").addClass('text-danger');
  //   $("#n_alumnos").removeClass('text-danger');
  // }
   //mañana
    $('.view_m').show();
    $('.view_r').hide();
});

function  archivar_alumno(id){
  let  nombre = $("td#nombret_"+id).text();
  let  domicilio = $("td#domiciliot_"+id).text();
  let  grupo = $("td#grupot_"+id).text();
  let  grado = $("td#gradot_"+id).text();
//alert(nombre + grupo + grado + id);
  //agregar alumno al modal
  let text =
'<tr style="border-bottom: 1px solid #eee" id="tr_'+id+'">'+
'<td id="nombre_'+id+'">'+nombre+'</td>'+
'<td id="domicilio_'+id+'">'+domicilio+'</td>'+
'<td id="grado_'+id+'">'+grado+'</td>'+
'<td id="grupo_'+id+'">'+grupo+'</td>'+
'<td style="text-align:center">'+
'<button type="button" class="btn btn-primary" onclick="enlistar_alumno('+id+')" style ="font-family: \'Varela Round\'" >'+
'<span class="glyphicon glyphicon-plus"></span> AÑADIR'+
'</button>'+
'</td>'+
'</tr>';
//alert(text);
$("#lista_alumnos_new").append(text);
//Hay en lista
$("#selected_" + id ).remove();
//Disminuye el numero de alumnos y mostrarlo
let n_alumnos=parseInt($("#n_alumnos").text());
n_alumnos--;
// $("#n_alumnos").text(n_alumnos);
//   if (alumnos_registrados>cupos_old ){
//     $("#n_alumnos").addClass('text-danger');
//   }else{
//     $("#n_alumnos").addClass('text-danger');
//     $("#n_alumnos").removeClass('text-danger');
//   }
//ordenar
ordenar(1);
}

function enlistar_alumno(id){
  //Tomar cupos
  var n_alumnos = parseInt($("#n_alumnos").text());
  var cupos = $("#cupos").val();
  if (n_alumnos>=cupos){
    alert('No existen cupos disponible para esta ruta.')
    return;
  }
  //aumentar el numero de alumnos y mostrarlo
n_alumnos++;
// $("#n_alumnos").text(n_alumnos);
//   if (alumnos_registrados>cupos_old ){
//     $("#n_alumnos").addClass('text-danger');
//   }else{
//     $("#n_alumnos").addClass('text-danger');
//     $("#n_alumnos").removeClass('text-danger');
//   }
//hay enlistados
    if ($("#selected_" + id ).length){
      //Hay en lista
      $("#selected_" + id ).remove();
//      $("#imagen_"+ id).css("background","white");
//      $("#imagen_"+ id).css("background","white");
    }else{
      //no existe en lista
      let nombre = $("#nombre_"+id).text();
      let domicilio = $("#domicilio_"+id).text();
      let grado = $("#grado_"+id).text();
      let grupo = $("#grupo_"+id).text();
      //$("#imagen_"+ id).css("background","#8aff8e");
      // $("#imagen_"+ id).css("background","#8aff8e");
      var text_button_archivar = '<a class="" id="btn_'+id+'" type="button" onclick="archivar_alumno('+ id +')"></a>';
      var text = "<tr class='enlistado' id='selected_"+id+"' data-id='"+id+"' data-orden='"+n_alumnos+"' style='border-bottom: 1px solid #ddd;'>"+
      "<td  id='orden_"+id+"'>"+n_alumnos+"</td>"+
      "<td class='id_selected' hidden id='idt_"+id+"'>"+id+"</td>"+
      "<td colspan='2' id ='nombret_"+id+"'>"+nombre+"</td>"+
      "<td colspan='3' id ='domiciliot_"+id+"'>"+ domicilio +"</td>"+
      "<td colspan='2' id ='gradot_"+id+"'' >"+ grado +"</td>"+
      "<td colspan='2' id ='grupot_"+id+"'>"+ grupo +"</td>"+
      "<td colspan='2' id ='hora_mananat_"+id+"'>"+
      "<input id='hora_m"+id+"' type='text' class='form-control timepicker hora_m' data-id='"+id+"' data-orden='"+n_alumnos+"' placeholder='Mañana' onclick='mostrar_timepicker_ma(this,"+id+")' onKeyPress='return solo_select(event)' onchange='ordenar("+id+")'  maxlength='5' value=''>"+
      "</td>"+
      "<td colspan='2' id ='hora_lu_jut_"+id+"'>"+
      "<input id='hora_lu_ju"+id+"' type='text' class='form-control timepicker'  placeholder='Lunes-Jueves' onclick='mostrar_timepicker_lu_ju(this,"+id+")'   onKeyPress='return solo_select(event)'  maxlength='5' value=''>"+
      "</td>"+
      "<td colspan='2' id ='hora_viet_"+id+"'>"+
      "<input id='hora_vie"+id+"' type='text' class='form-control timepicker'   placeholder='Viernes' onclick='mostrar_timepicker_vi(this,"+id+")'  onKeyPress='return solo_select(event)'  maxlength='5' value=''>"+
      "</td>"+
      "<td colspan='1'>"+text_button_archivar+"</td>"+
      "</tr>";
      $("#lista_alumnos").append(text);
      }
      $.get('componentes/btn_cancelar.php', function (html){
        $("a#btn_"+id).html(html);
      });

//Eliminar de la Lista de adicion.
$('#tr_'+id).remove();

}

function cancelar() {
  //alert('ok');
   window.location = "../rutas/Prutas_diaria.php";
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
function enviar_formulario(id_ruta,fecha) {

//validar alumnos
if ($(".enlistado").length){
  //hay en lista, agregarlos a un array / Crear coleccion de alumnos
  //conseguir ids de alumnos registrados
  var ids_m ='';
  var ids_t ='';
  var coleccion_ids_m = [];
  var coleccion_ids_t = [];
  var coleccion_data_alumnos_m = [];
  var coleccion_data_alumnos_t = [];
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
    //Tarde
  $(".id_selected_t").each(
    function(){
      ids_t += $(this).text() + ',';
    });
    var values = ids_t.split(",");
    for (var item in values) {
        if (values[item] !== "") {
            coleccion_ids_t.push(values[item]);
        }
    }

}else{
  //no hay alumno
  alert('Debe agregar al menos un alumno en la lista para Guardar.');
  return;
}
//Validar que los alumnos cambiados fueron revisado y ordenados.
var error=false;
  $(".enlistado").each(function(){
       let id = $(this).data('id');
       let turno = $(this).data('turno');
  if(turno==='m'){
       let orden = $('td#orden_in' + id).text();
       if (orden >900){
          error=true;
       }
  }else if (turno==='t'){
       let orden = $('td#orden_in' + id).text();
       if (orden >900){
          error=true;
       }
  }
});
if(error){
    alert('Debe revisar todos los alumnos Cambiados por los Permisos.');
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
//armar data - Tarde
 for (var item in coleccion_ids_t) {
   var counter_alumno = coleccion_ids_t[item];
   var data_alumnos_t = {
      "id_alumno": $("td#id_t" + counter_alumno).text(),
      "id_ruta": id_ruta,
      "domicilio": $("td#domicilio_t" + counter_alumno).text(),
      "hora_regreso": $("input#hora_re" + counter_alumno).val(),
      "orden_out": $("td#orden_out"+ counter_alumno).text()
    }
    coleccion_data_alumnos_t.push(data_alumnos_t);
  }

var data = {
    "fecha": fecha,
    "id_ruta": id_ruta,
    "alumnos_m": coleccion_data_alumnos_m,
    "alumnos_t": coleccion_data_alumnos_t
  };

 $.ajax({
    url: 'common/post_update_ruta_alumnos.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      $("#btn_enviar_formulario").prop("disabled", true);
      //$("#loading").fadeIn("slow");
    },
    success: function (res) {
      // alert(res);
      // alert(res.error_doc);
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

function desabilitar_inputs (){
    if ($("#prefecta").prop("disabled")){
      // $("#nombre_ruta").prop("disabled", false);
      $("#prefecta").prop('disabled', false);
      // $("#camion").prop('disabled', false);
      $("#cupos").prop('disabled', false);
      $("#button_editar").show();
    }else{
      // $("#nombre_ruta").prop("disabled", true);
      $("#prefecta").prop('disabled', true);
      // $("#camion").prop('disabled', true);
      $("#cupos").prop('disabled', true);
      $("#button_editar").hide();
    }
}

function editar_inputs(id,fecha){

  if ($("#nombre_ruta").val() === "") {
    alert('¡Debe agregar una Nueva Ruta!');
    return;
  }
  if ($("#prefecta").val() === "") {
    alert('¡Debe agregar una Prefecta!');
    return;
  }
  if ($("#camion").val() === "") {
    alert('Debe seleccionar un numero para el camion!');
    return;
  }
  if ($("#cupos").val() === "") {
    alert('Debe seleccionar el Número de Cupos del Camión!');
    return;
  }

  //Tomar valores de las inputs
  var nombre_ruta = $("#nombre_ruta").val();
  var prefecta = $("#prefecta").val();
  var camion = $("#camion").val();
  var cupos = $("#cupos").val();
  var n_alumnos = parseInt($("#n_alumnos").text());
  if (cupos<n_alumnos){
      alert('El Número de Cupos debe ser mayor al numero de alumnos registrados actualmente!');
      return;
  }

//Existencia del camión.
var data = {
  "camion": camion
}
/**Fin de las validaciones*/
  $.ajax({
    url: 'common/post_ruta_existe.php',
    type: 'POST',
    data: data,
    beforeSend: function () {
      $("#btn_enviar_formulario").prop("disabled", true);
      //  $("#loading").fadeIn("slow");
    },
    success: function (res) {
      // alert(res);
      res = JSON.parse(res);
      if (res.estatus === true && camion_old!=camion) {
        alert('El Camión ingresado ya existe, Elija otro Numero de Camión. ');
        $("#btn_enviar_formulario").prop("disabled", false);
        // window.location = "./Prutas.php";
      }else{
        // alert('El camion No existe!');
          //alert('ok');
          var data2 = {
            "id_ruta": id,
            "prefecta": prefecta,
            "cupos": cupos,
            "fecha":fecha,
            "summit": 1
          };

          //alert();
          //return;
          $.ajax({
            //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
            url: 'common/post_update_ruta_dia.php',
            type: 'POST',
            data: data2,
            beforeSend: function () {
              //  $("#loading").fadeIn("slow");
            },
            success: function (res) {
              //alert(res);
              res = JSON.parse(res);
              if (res.estatus === true) {
                  alert('Altualización exitosa.');
                  desabilitar_inputs();
              }else{
                  alert('Ha ocurrido un error, Verifique los datos');
                  $("#btn_enviar_formulario").prop("disabled", false);
              }
            }
          });
        // $("#btn_enviar_formulario").prop("disabled", false);
      }
    }
  });

// var data = {
//     "id_ruta" : id,
//     "nombre_ruta": nombre_ruta,
//     "prefecta": prefecta,
//     "camion": camion,
//     "cupos": cupos,
//     "summit": 1
//   };

  // //alert();
  // //return;
  // $.ajax({
  //   //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
  //   url: 'common/post_update_ruta.php',
  //   type: 'POST',
  //   data: data,
  //   beforeSend: function () {
  //     // $("#btn_enviar_formulario").prop("disabled", true);
  //     //  $("#loading").fadeIn("slow");
  //   },
  //   success: function (res) {
  //     //alert(res);
  //     res = JSON.parse(res);
  //     if (res.estatus === true) {
  //       alert('Altualización exitosa.');
  //       desabilitar_inputs();
  //         // window.location = "./Prutas.php";
  //     }else{
  //       alert('Ha ocurrido un error, Verifique que los datos sean correctos');
  //       // $("#btn_enviar_formulario").prop("disabled", false);
  //     }
  //   }
  // });

}


function mostrar_timepicker_ma(el, id) {
  // mañana
    hora_maxima_del_dia = '12:00';
    $('#hora_m' + id).timepicker({
      'step': 1,
      'minTime': '06:00',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_m' + id).timepicker('show');
  // ids.push(el.id);
}

function mostrar_timepicker_re(el, id) {

  //de lunes a jueves
  hora_maxima_del_dia = '16:00';
    $('#hora_re' + id).timepicker({
      'step': 1,
      'minTime': '12:00',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_re' + id).timepicker('show');
  // ids.push(el.id);
  }

  function solo_select(e){
   var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
  }

// function ordenar(id){
//  var id_old=id;
// //Encuentra tabla
// var $table = $("#lista_alumnos");
// var $rows = $table.children('tr');
// //organizar tabla
// var sortList = Array.prototype.sort.bind($rows);
// sortList(function (a,b){
//    let id_a = $(a).data('id');
//    let id_b = $(b).data('id');
//    //coseguir la Hora
//    let hora_a = $('#hora_m'+id_a).val();
//    let hora_b = $('#hora_m'+id_b).val();
//    //analizo la hora y obtengo hora y minutos
//    let elements_a = hora_a.split(':');
//    let elements_b = hora_b.split(':');
//    //Llevo a minutos las horas y obtengo los minutos totales
//    let min_a= parseInt(elements_a[1]) + parseInt(elements_a[0])*60;
//    let min_b= parseInt(elements_b[1]) + parseInt(elements_b[0])*60;
//    //obtengo la difeencia de los minutos
//    let value = min_a - min_b;
//    //Verfico que no sea NaN
//    return  isNaN(value) ? 1 : value;
//      });

// $table.append($rows);

// //cambiar las posiciones
// var array_orden = [];

// $(".hora_m").each(function(){
//      let hora = $(this).val() ;
//      let id = $(this).data('id');
//      let orden = $(this).data('orden');
//      // alert("hora-"+hora+" id-"+id);
//      //agregar a un array
//      let data = {"id" : id, "hora" : hora, "orden": orden };
//      array_orden.push(data);
// });
//       array_orden.sort(function (a,b){
//       let element_a = a.hora.split(':');
//       let element_b = b.hora.split(':');
//       let hora_a = element_a[0];
//       let hora_b = element_b[0];
//       let min_a= parseInt(element_a[1]) + parseInt(hora_a)*60;
//       let min_b= parseInt(element_b[1]) + parseInt(hora_b)*60;
//       let value = min_a - min_b;
//         return isNaN(value) ? 1 : value;
//      });

//     // ordenar las posiciones
//     var pos =0;
//      for (var item in array_orden) {
//            //cambiar las posiciones
//           pos++;
//           let id = array_orden[item].id;
//           let orden =array_orden[item].orden;
//           if(orden<900 || id===id_old){
//               $("#hora_m"+id).data('orden', pos);
//               $("#orden_"+id).text(pos);
//           }else{
//               $("#orden_"+id).text(orden_old);
//           }

//     }
//   }


function ordenar_m(id){
var id_edit = id;
//Encuentra tabla
var $table = $("#lista_alumnos_m");
var $rows = $table.children('tr');
//organizar tabla
var vista =  $("select#view").val();
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


function ordenar_t(id){
var id_edit = id;
//Encuentra tabla
var $table = $("#lista_alumnos_t");
var $rows = $table.children('tr');
//organizar tabla
var sortList = Array.prototype.sort.bind($rows);
sortList(function (a,b){
   let id_a = $(a).data('id');
   let id_b = $(b).data('id');
   //coseguir la Hora
   var hora_a = $('#hora_re'+id_a).val();
   var hora_b = $('#hora_re'+id_b).val();

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

//cambiar las posiciones

//Ordena orden_out
var array_orden_out = [];

$(".hora_r").each(function(){
     let hora = $(this).val() ;
     let id = $(this).data('id');
     let orden = $(this).data('orden_out');
     // alert("hora-"+hora+" id-"+id);
     //agregar a un array
     let data = {"id" : id, "hora" : hora, "orden": orden };
     array_orden_out.push(data);
});
      array_orden_out.sort(function (a,b){
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
    var pos = 0;
     for (var item in array_orden_out) {
           //cambiar las posiciones
          pos++;
          let id = array_orden_out[item].id;
          let orden = array_orden_out[item].orden;
           // if (id<900){
              $("#hora_r"+id).attr('data-orden_out', pos);
              $("#orden_out"+id).text(pos);
            // }
    }

  }



$(".cambio_ruta").click(function (){
  //tomar la data
   var id_alumno =  $(this).attr('data-id');
   var nombre_alumno   =  $(this).attr('data-nombre_alumno');
   var domicilio   =  $(this).attr('data-domicilio');
   var turno   =  $(this).attr('data-turno');
  //enviarla al modal
  $("#id_alumno").val(id_alumno );
  $("#nombre_alumno").text(nombre_alumno);
  $("#domicilio_alumno").text(domicilio );
  $("#modal_turno").val(turno);
  if(turno==='manana'){
    $("#titulo_turno").text('Mañana');
  }else if (turno==='tarde'){
    $("#titulo_turno").text('Tarde');
  }


});

function cambiar_ruta(id_ruta,fecha){
  //conseguir id_alumno a cambiar
  var id_alumno = $("#id_alumno").val();
  //busco el Turno a cambiar
  var turno = $("#modal_turno").val();
  if(turno==='tarde'){
    turno = 't';
  }else{
    turno = 'm';
  }
  // Solicitar cambio mediante ajax
 var data = {
    "id_ruta": id_ruta,
    "id_alumno": id_alumno,
    "turno": turno,
    "summit": 1
  };

 $.ajax({
    url: 'common/post_cambio_ruta_dia.php',
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
        //depende del turno
        if(turno=='m'){
        //Hay en lista
        $("#selected_m" + id_alumno ).remove();
        //Disminuye el numero de alumnos y mostrarlo
        let n_alumnos=parseInt($("#n_alumnos_m").text());
        n_alumnos--;
        $("#n_alumnos_m").text(n_alumnos);
        //incrementar cupos en
        let cupos_d = parseInt($("#cupos_disponibles_m"+id_ruta).text());
        cupos_d++;
        $("#cupos_disponibles_m"+ id_ruta).text(cupos_d);
        //ordenar - mañana
        ordenar_m(0);
        }else if ( turno=='t'){
          //Hay en lista
        $("#selected_t" + id_alumno ).remove();
        //Disminuye el numero de alumnos y mostrarlo
        let n_alumnos=parseInt($("#n_alumnos_t").text());
        n_alumnos--;
        $("#n_alumnos_t").text(n_alumnos);
        //incrementar cupos en
        let cupos_d = parseInt($("#cupos_disponibles_t"+id_ruta).text());
        cupos_d++;
        $("#cupos_disponibles_t"+ id_ruta).text(cupos_d);
        //ordenar - tarde
        ordenar_t(0);
        }
        //Almacenar Cambios de orden y ocupacion de espacios.
        enviar_formulario(id_ruta,fecha)
        // location.reload();
      }else{
        alert('Ha ocurrido un Error.');
      }
    }
  });
}

function view_table(){
  var vista =  $("select#view").val();
  // alert(vista);
  if (vista==='1'){
    //mañana
    $('.view_m').show();
    $('.view_t').hide();
    // ordenar(0);
  }else if(vista==='2'){
    $('.view_m').hide();
    $('.view_t').show();
    // ordenar(0);
  }else{
    //mañana- tarde
    $('.view_m').show();
    $('.view_t').show();
    $('.m_t').hide();
    // ordenar(0);
  }
}
