function obtener_calendario_escolar() {
    var calendario = [];
    $.ajax({
        async: false,
        url: "/pruebascd/icloud/Transportes/common/get_calendario_escolar.php",
        type: "GET"
    }).done(function (res) {
        res = JSON.parse(res);
        var response = [];
        for (var i = 0; i < res.length; i++) {
            var fecha_formato_mda = `${res[i].toString().split("-")[1]}/
                ${res[i].toString().split("-")[2]}/
                ${res[i].toString().split("-")[0]}`;
            fecha_formato_mda = new Date(fecha_formato_mda);
            response.push(fecha_formato_mda);
        }
        calendario = response;
    });
    return calendario;
}

function consultar_direcciones(id) {
    var data = [];
    $.ajax({
        url: "/pruebascd/icloud/Transportes/common/get_consultar_direcciones.php",
        type: "GET",
        data: {"id_usuario": id},
        success: function (res) {
            res = JSON.parse(res);
            var options = `<option selected value="0">Seleccione dirección</option><option value="1">Deportivo CDI</option>`;
            for (var key in res) {
                data.push(res[key]);
            }
            for (var key in data) {
                options += `<option value="${data[key].id_direccion}">${data[key].descripcion}</options>`;
            }
            $("#reside").html(options);
            $('select').formSelect();
        }
    });
    return data;
}

function formatear_fecha_calendario(fecha) {
    var dia = fecha.split(" ")[1];
    var mes = fecha.split(" ")[3];
    var anio = fecha.split(" ")[5];
    if (mes === "Enero" || mes === "enero")
        mes = "01";
    if (mes === "Febrero" || mes === "febrero")
        mes = "02";
    if (mes === "Marzo" || mes === "marzo")
        mes = "03";
    if (mes === "Abril" || mes === "abril")
        mes = "04";
    if (mes === "Mayo" || mes === "mayo")
        mes = "05";
    if (mes === "Junio" || mes === "junio")
        mes = "06";
    if (mes === "Julio" || mes === "julio")
        mes = "07";
    if (mes === "Agosto" || mes === "agosto")
        mes = "08";
    if (mes === "Septiembre" || mes === "septiembre")
        mes = "09";
    if (mes === "Octubre" || mes === "octubre")
        mes = "10";
    if (mes === "Noviembre" || mes === "noviembre")
        mes = "11";
    if (mes === "Diciembre" || mes === "diciembre")
        mes = "12";
    return `${mes}/${dia}/${anio}`;
}

function formatear_fecha_calendario_formato_m_d_a(fecha) {
    var dia = fecha.split(" ")[1];
    var mes = fecha.split(" ")[3];
    var anio = fecha.split(" ")[5];
    if (mes === "Enero")
        mes = "01";
    if (mes === "Febrero")
        mes = "02";
    if (mes === "Marzo")
        mes = "03";
    if (mes === "Abril")
        mes = "04";
    if (mes === "Mayo")
        mes = "05";
    if (mes === "Junio")
        mes = "06";
    if (mes === "Julio")
        mes = "07";
    if (mes === "Agosto")
        mes = "08";
    if (mes === "Septiembre")
        mes = "09";
    if (mes === "Octubre")
        mes = "10";
    if (mes === "Noviembre")
        mes = "11";
    if (mes === "Diciembre")
        mes = "12";
    return `${mes}-${dia}-${anio}`;
}

function formatear_fecha_calendario_formato_a_m_d_guion(fecha) {
    var dia = fecha.split(" ")[1];
    var mes = fecha.split(" ")[3];
    var anio = fecha.split(" ")[5];
    if (mes === "Enero" || mes === "enero")
        mes = "01";
    if (mes === "Febrero" || mes === "febrero")
        mes = "02";
    if (mes === "Marzo" || mes === "marzo")
        mes = "03";
    if (mes === "Abril" || mes === "abril")
        mes = "04";
    if (mes === "Mayo" || mes === "mayo")
        mes = "05";
    if (mes === "Junio" || mes === "junio")
        mes = "06";
    if (mes === "Julio" || mes === "julio")
        mes = "07";
    if (mes === "Agosto" || mes === "agosto")
        mes = "08";
    if (mes === "Septiembre" || mes === "septiembre")
        mes = "09";
    if (mes === "Octubre" || mes === "octubre")
        mes = "10";
    if (mes === "Noviembre" || mes === "noviembre")
        mes = "11";
    if (mes === "Diciembre" || mes === "diciembre")
        mes = "12";
    return `${anio}-${mes}-${dia}`;
}

function validar_regex(reg, val) {
    var regex = new RegExp(reg);
    if (regex.test(val)) {
        return true;
    }
    return false;
}

function validar_solo_numeros(num) {
    var charCode = (num.which) ? num.which : num.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    if ($("#cp").val().length > 4) {
        return false;
    }
    return true;
}

function validar_solo_numeros(num, id, limite) {
    var charCode = (num.which) ? num.which : num.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    if ($("#" + id).val().length > limite) {
        return false;
    }
    return true;
}

function validar_max_caracteres(id, limite) {
    if ($("#" + id).val().length > limite) {
        return false;
    }
    return true;
}

function validar_maxima_cantidad(id, cantidad) {
    if ($("#" + id).val() > cantidad) {
        return false;
    }
    return true;
}

function fecha_minusculas(val, id) {
    $(`#${id}`).val(`${val.charAt(0)}${val.slice(1).toLowerCase()}`);
}

function obtener_responsables(familia) {
    var responsables = [];
    $.ajax({
        async: false,
        url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/get_obtener_responsables.php',
        type: 'GET',
        data: {familia: familia},
        beforeSend: function () {
            $("#loading").fadeIn("slow");
        },
        success: function (res) {
            res = JSON.parse(res);
            responsables = res;
        }
    }).done(function () {
        $("#loading").fadeOut("slow");
    });
    return responsables;
}

function opciones_select(val, id) {
    var select = $(`#${id}`);
    var options = "";
    for (var key in val) {
        options += `<option value="${val[key].id}">${val[key].nombre}</option>`;
    }
    select.html(options);
}

function nuevo_responsable(nombre, parentesco, familia) {
    $.ajax({
        async: false,
        url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_nuevo_responsable.php',
        type: 'POST',
        beforeSend: function () {
            $("#loading").fadeIn("slow");
        },
        data: {nombre: nombre, familia: familia, parentesco: parentesco},
        success: function (res) {
            res = JSON.parse(res);
            console.log(res);
            if (res === 1) {
                swal("Información", "Registro exitoso!, puedes seleccionar el responsable en la lista desplegable", "success");
            } else {
                swal("Error", "No es posible realizar registro", "error");
            }
        }
    }).always(function () {
        $("#loading").fadeOut("slow");
    });
}

function capitaliza_primer_letra(id) {
    var palabra = $("#" + id).val();
    $("#" + id).val(`${palabra.charAt(0).toUpperCase()}${palabra.slice(1).toLowerCase()}`);
}

function validar_horario_final_ensayo(el, id_hora_inicial) {
    var hora_inicial = $("#" + id_hora_inicial).val();
    var hora_final = el.value;
    hora_inicial = hora_inicial.split(":");
    hora_final = hora_final.split(":");
    hora_inicial = (parseInt(hora_inicial[0]) * 60 * 60) + parseInt(hora_inicial[1] * 60);
    hora_final = (parseInt(hora_final[0]) * 60 * 60) + parseInt(hora_final[1] * 60);
    if (hora_inicial >= hora_final || $("#" + id_hora_inicial).val() === "") {
        $("#" + el.id).timepicker('remove');
        el.value = '';
        $("#" + el.id).timepicker({
            'step': 60,
            'minTime': '00:00',
            'maxTime': '23:59',
            'timeFormat': 'H:i:s'
        });
        M.toast({
            html: 'Debe elegir una hora final posterior a la hora inicial!',
            classes: 'deep-orange c-blanco',
        }, 5000);
        return;
    }
}

function calcular_position_time_picker() {
    var timepicker = $(".ui-timepicker-positioned-top");
    /*if (timepicker.length > 0) {
     var alto_ventana = parseInt(window.screen.height);
     var ancho_ventana = parseInt(window.screen.width);
     var alto_timepicker = parseInt(timepicker.height());
     var ancho_timepicker = parseInt(timepicker.width());
     var y = (alto_ventana / 2) - (alto_timepicker / 2);
     var x = (ancho_ventana / 2) - (ancho_timepicker / 2);
     timepicker.animate({
     'top': y + 'px',
     'left': x + 'px'
     });
     }*/
}

$(document).ready(function () {
    $(".modal-chmd-close").on('click', function () {
        $(".modal-chmd").fadeOut();
        $(".modal-chmd-fondo").fadeOut();
    });
});

function mostrar_modal_chmd() {
    $(".modal-chmd").fadeIn();
    $(".modal-chmd-fondo").fadeIn();
}

function ocultar_modal_chmd() {
    $(".modal-chmd").fadeOut();
    $(".modal-chmd-fondo").fadeOut();
}

/*function descargarPDF(nombre_pdf) {
 var elemento = document.getElementById("imprimir");
 html2canvas(elemento, {
 onrendered: function (canvas) {
 var img = canvas.toDataURL("image/png");
 var doc = new jsPDF();
 doc.addImage(img, 'JPEG', 0, 0);
 doc.save(nombre_pdf);
 }
 
 });
 }*/
function validaCorreo(correo) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(correo);
}

function validaNombre(nombre) {
    var regex = /^([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\']+[\s])+([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])+[\s]?([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])?$/g;
    return regex.test(nombre);
}

function set_table(id_table) {
    $('#' + id_table).DataTable({
        "processing": true,
        "language": {
            "lengthMenu": "_MENU_",
            "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
            "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
            "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
            "infoFiltered": "(filtrado de _MAX_ total de registros)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
}

function set_table_desordenada(id_table) {
    $('#' + id_table).DataTable({
        "processing": true,
        "order": [],
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false,
        }],
        "language": {
            "lengthMenu": "_MENU_",
            "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
            "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
            "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
            "infoFiltered": "(filtrado de _MAX_ total de registros)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
}

function set_table_sin_paginacion(id_table) {
    $('#' + id_table).DataTable({
        "paging": false,
        "processing": true,
        "order": [],
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false
        }],
        "language": {
            "lengthMenu": "_MENU_",
            "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
            "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
            "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
            "infoFiltered": "(filtrado de _MAX_ total de registros)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
}

function set_table_sin_paginacion_sin_buscar(id_table) {
    $('#' + id_table).DataTable({
        "paging": false,
        "processing": true,
        "order": [],
        "columnDefs": [{
            "targets": 'no-sort',
            "orderable": false
        }],
        "language": {
            "lengthMenu": "_MENU_",
            "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
            "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
            "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
            "infoFiltered": "(filtrado de _MAX_ total de registros)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando..."
        }
    });
}

var setearPickerRangoFechas = function () {
    $('input[name="datefilter"]').daterangepicker({
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Ok",
            "cancelLabel": "Limpiar",
            "fromLabel": "desde",
            "toLabel": "hasta",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        },
        "buttonClasses": "btn",
        "applyButtonClasses": "green accent-4 c-blanco",
        "cancelClass": "red c-blanco",
    }, (start, end) => {
        setearRango(start, end);
    });
};