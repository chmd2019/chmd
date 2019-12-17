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
        "searching": false,
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
            "search":"Buscar"
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

if (CKEDITOR.env.ie && CKEDITOR.env.version < 9)
    CKEDITOR.tools.enableHtml5Elements(document);

// The trick to keep the editor in the sample quite small
// unless user specified own height.
CKEDITOR.config.height = 450;
CKEDITOR.config.width = 'auto';
CKEDITOR.config.extraPlugins = 'youtube,imagepaste,imageuploader';
CKEDITOR.config.filebrowserBrowseUrl = "https://www.chmd.edu.mx/pruebascd/admin/Secciones/ckeditor/plugins/imageuploader/imgbrowser.php";
CKEDITOR.config.youtube_responsive = true;

var ckeditor = (function () {
    var wysiwygareaAvailable = isWysiwygareaAvailable(),
        isBBCodeBuiltIn = !!CKEDITOR.plugins.get('bbcode');

    return function () {
        var editorElement = CKEDITOR.document.getById('editor');

        // :(((
        if (isBBCodeBuiltIn) {
            editorElement.setHtml(
                'Hello world!\n\n' +
                'I\'m an instance of [url=https://ckeditor.com]CKEditor[/url].'
            );
        }

        // Depending on the wysiwygarea plugin availability initialize classic or inline editor.
        if (wysiwygareaAvailable) {
            CKEDITOR.replace('editor');
        } else {
            editorElement.setAttribute('contenteditable', 'true');
            CKEDITOR.inline('editor');

            // TODO we can consider displaying some info box that
            // without wysiwygarea the classic editor may not work.
        }
    };

    function isWysiwygareaAvailable() {
        // If in development mode, then the wysiwygarea must be available.
        // Split REV into two strings so builder does not replace it :D.
        if (CKEDITOR.revision == ('%RE' + 'V%')) {
            return true;
        }

        return !!CKEDITOR.plugins.get('wysiwygarea');
    }
})();


(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    window.scroll(0, 0);
                } else {
                    switch (flag_guardar) {
                        case true:
                            //se envia el estatus 3 para guardad y 2 para enviada
                            enviar(3);
                            break;
                        case false:
                            enviar(2);
                            break;
                    }
                }
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();