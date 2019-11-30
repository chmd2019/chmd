var camion_old;
var cupos_old;
$(function(){
  //Tomar valores de las inputs
  camion_old = $("#camion").val();
  cupos_old = $("#cupos").val();
});

function  archivar_alumno(id , turno ){
  let  nombre = $("td#nombre_"+turno+id).text();
  let  domicilio = $("td#domicilio_"+turno+id).text();
  let  grupo = $("td#grupo_"+turno+id).text();
  let  grado = $("td#grado_"+turno+id).text();
//alert(nombre + grupo + grado + id);
  //agregar alumno al modal
  let text =
'<tr style="border-bottom: 1px solid #eee" id="tr_modal_'+turno+id+'">'+
'<td id="nombre_modal_'+turno+id+'">'+nombre+'</td>'+
'<td id="domicilio_modal_'+turno+id+'">'+domicilio+'</td>'+
'<td id="grado_modal_'+turno+id+'">'+grado+'</td>'+
'<td id="grupo_modal_'+turno+id+'">'+grupo+'</td>'+
'<td style="text-align:center">'+
'<button type="button" class="btn btn-primary" onclick="enlistar_alumno_'+turno+'('+id+')" style ="font-family: \'Varela Round\'" >'+
'<span class="glyphicon glyphicon-plus"></span> AÑADIR'+
'</button>'+
'</td>'+
'</tr>';
//alert(text);
$("#lista_alumnos_new_"+turno).append(text);
//Hay en lista
$("#selected_"+turno + id ).remove();
//Disminuye el numero de alumnos y mostrarlo
let n_alumnos=parseInt($("#n_alumnos_"+turno).text());
n_alumnos--;
$("#n_alumnos_"+turno).text(n_alumnos);
//ordenar
ordenar(1);
}

function enlistar_alumno_m(id){
  //Tomar cupos
  var n_alumnos = parseInt($("#n_alumnos_m").text());
  var cupos = $("#cupos_actual").val();
  if (n_alumnos>=cupos){
    alert('No existen mas cupos disponibles para esta ruta.')
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


function enlistar_alumno_t(id){
  //Tomar cupos
  var n_alumnos = parseInt($("#n_alumnos_t").text());
  var cupos = $("#cupos_actual").val();
  if (n_alumnos>=cupos){
    alert('No existen cupos disponible para esta ruta.')
    return;
  }
  //aumentar el numero de alumnos y mostrarlo
n_alumnos++;
$("#n_alumnos_t").text(n_alumnos);
//hay enlistados
    if ($("#selected_t" + id ).length){
      //Hay en lista
      // $("#selected_" + id ).remove();
//      $("#imagen_"+ id).css("background","white");
//      $("#imagen_"+ id).css("background","white");
    }else{
      //no existe en lista
      let nombre = $("#nombre_modal_t"+id).text();
      let domicilio = $("#domicilio_modal_t"+id).text();
      let grado = $("#grado_modal_t"+id).text();
      let grupo = $("#grupo_modal_t"+id).text();
      //$("#imagen_"+ id).css("background","#8aff8e");
      // $("#imagen_"+ id).css("background","#8aff8e");
      var text_button_archivar = '<a class="" id="btn_'+id+'" type="button" onclick="archivar_alumno('+ id +', \'t\')"></a>';
      var text = "<tr class='enlistado enlistado_t view_t' id='selected_t"+id+"' data-id='"+id+"' data-orden='"+n_alumnos+"' style='border-bottom: 1px solid #ddd;'>"+
      "<td  id='orden_out"+id+"'>"+n_alumnos+"</td>"+
      "<td hidden class='id_selected_t'  id='id_t"+id+"'>"+id+"</td>"+
      "<td colspan='2' id ='nombre_t"+id+"'>"+nombre+"</td>"+
      "<td colspan='3' id ='domicilio_t"+id+"'>"+ domicilio +"</td>"+
      "<td colspan='2' id ='grado_t"+id+"'>"+ grado +"</td>"+
      "<td colspan='2' id ='grupo_t"+id+"'>"+ grupo +"</td>"+
      "<td colspan='2' id ='hora_lu_ju_t"+id+"'>"+
      "<input id='hora_lu_ju"+id+"' type='text' class='form-control timepicker hora_r'  data-id='"+id+"' data-orden_out='"+n_alumnos+"'  placeholder='Lunes-Jueves' onclick='mostrar_timepicker_lu_ju(this,"+id+")'   onKeyPress='return solo_select(event)' onchange='ordenar_t("+id+")'  maxlength='5' value=''>"+
      "</td>"+
      "<td colspan='2' id ='hora_vie_t"+id+"'>"+
      "<input id='hora_vie"+id+"' type='text' class='form-control timepicker'   placeholder='Viernes' onclick='mostrar_timepicker_vi(this,"+id+")'  onKeyPress='return solo_select(event)'  maxlength='5' value=''>"+
      "</td>"+
      "<td colspan='1'>"+text_button_archivar+"</td>"+
      "</tr>";
      $("#lista_alumnos_t").append(text);
      }
      $.get('componentes/btn_cancelar.php', function (html){
        $("a#btn_"+id).html(html);
      });


//Eliminar de la Lista de adicion.
$('#tr_modal_t'+id).remove();

}

function cancelar() {
  //alert('ok');
   window.location = "../rutas/PpaseAno.php";
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
function enviar_formulario() {


var data = {
    "generar" : 1
  };

 $.ajax({
    url: 'common/post_nuevo_pase_ano.php',
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
        alert('Generación exitosa.');
        window.location="./PpaseAno.php";
      }else{
        var error = data.error_doc;
        alert('Ha ocurrido un error, Vuelva a intentarlo. Error: ' + error);
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
    if ($("#nombre_ruta").prop("disabled")){
      $("#nombre_ruta").prop("disabled", false);
      $("#prefecta").prop('disabled', false);
      $("#camion").prop('disabled', false);
      $("#cupos").prop('disabled', false);
      $("#button_editar").show();
    }else{
      $("#nombre_ruta").prop("disabled", true);
      $("#prefecta").prop('disabled', true);
      $("#camion").prop('disabled', true);
      $("#cupos").prop('disabled', true);
      $("#button_editar").hide();
    }
}

function editar_inputs(id){

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
            "nombre_ruta": nombre_ruta,
            "prefecta": prefecta,
            "camion": camion,
            "cupos": cupos,
            "summit": 1
          };

          //alert();
          //return;
          $.ajax({
            //url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_permiso_especial.php',
            url: 'common/post_update_ruta.php',
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

function mostrar_timepicker_lu_ju(el, id) {
  //de lunes a jueves
  hora_maxima_del_dia = '16:00';
    $('#hora_lu_ju' + id).timepicker({
      'step': 1,
      'minTime': '12:00',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_lu_ju' + id).timepicker('show');
  // ids.push(el.id);

  }


function mostrar_timepicker_vi(el, id) {
    //Los viernes
    hora_maxima_del_dia = '16:00';
    $('#hora_vie' + id).timepicker({
      'step': 1,
      'minTime': '12:00',
      'maxTime': hora_maxima_del_dia,
      'timeFormat': 'H:i'
    });
    $('#hora_vie' + id).timepicker('show');
  // ids.push(el.id);
  }

  function solo_select(e){
   var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
  }

function ordenar(id){

//Encuentra tabla
var $table = $("#lista_alumnos");
var $rows = $table.children('tr');
//organizar tabla
var sortList = Array.prototype.sort.bind($rows);
sortList(function (a,b){
   let id_a = $(a).data('id');
   let id_b = $(b).data('id');
   //coseguir la Hora
   let hora_a = $('#hora_m'+id_a).val();
   let hora_b = $('#hora_m'+id_b).val();
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
     let orden = $(this).data('orden');
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
          $("#hora_m"+id).data('orden', pos);
          $("#orden_in"+id).text(pos);
    }




//Ordena orden_out
var array_orden_out = [];

$(".hora_r").each(function(){
     let hora = $(this).val() ;
     let id = $(this).data('id');
     let orden = $(this).data('orden');
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
    var pos =0;
     for (var item in array_orden_out) {
           //cambiar las posiciones
          pos++;
          let id = array_orden_out[item].id;
          $("#hora_lu_ju"+id).data('orden', pos);
          $("#orden_out"+id).text(pos);
    }

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
   var hora_a = $('#hora_lu_ju'+id_a).val();
   var hora_b = $('#hora_lu_ju'+id_b).val();

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
              $("#hora_lu_ju"+id).attr('data-orden_out', pos);
              $("#orden_out"+id).text(pos);
            // }
    }

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

function cupos_disponibles_actual(){
  var cupos = $("#ruta_selected :checked").data('cupos');
  $("#cupos_actual").val(cupos);
  // alert('Cupos: '+cupos);

}
