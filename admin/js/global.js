function upper(value) {
    return value.toUpperCase();
}
function spinnerIn() {
    $("#spinner").fadeIn();
}
function spinnerOut() {
    setInterval(function () {
        $("#spinner").fadeOut();
    }, 1500);
}
function success_alerta(msj) {
    $("#alerta_success_mensaje").text(msj);
    $('.alerta-success').fadeIn();
    setInterval(function () {
        $('.alerta-success').fadeOut();
    }, 5000);
}
function fail_alerta(msj) {
    $("#alerta_error_mensaje").text(msj);
    $('.alerta-error').fadeIn();
    setInterval(function () {
        $('.alerta-error').fadeOut();
    }, 7000);
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
function datepicker_es() {
    return $.fn.datepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Hoy",
        clear: "Limpiar",
        format: "yyyy-mm-dd",
        weekStart: 0,
    };
}
function set_menu_hamburguer() {

    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
    $.fn.selectpicker.defaults = {
        selectAllText: "Todos",
        deselectAllText: "Ninguno"
    };
}