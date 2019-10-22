<?php
session_start();
$root = dirname(dirname(dirname(__DIR__)));
require_once "{$root}/components/sesion.php";
require_once "{$root}/libraries/Google/autoload.php";
require_once "{$root}/Model/Login.php";
require_once "{$root}/Model/DBManager.php";
require_once "{$root}/Model/Config.php";
require_once "{$root}/Helpers/DateHelper.php";
include_once "{$root}/components/layout_top.php";

if (isset($_GET['logout'])) {
    unset($_SESSION['access_token']);
}
$service = new Google_Service_Oauth2($client);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit;
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else {
    $authUrl = $client->createAuthUrl();
}
if (isset($authUrl)) :
    header("Location: $redirect_uri?logout=1");
else :
    $user = $service->userinfo->get();
    $correo = $user->email;
    $objCliente = new Login();
    $consulta = $objCliente->acceso_login($correo);
    $date_helper = new DateHelper();
    $date_helper->set_timezone();
    $idseccion = $_GET['idseccion'];
    //consultas en db
    require_once "../../common/ControlMinutas.php";
    $controlMinutas = new ControlMinutas();
    $comite = mysqli_fetch_array($controlMinutas->consultar_comite($idseccion))[1];
    $id_comite = mysqli_fetch_array($controlMinutas->consultar_comite($idseccion))[0];
    $nombre_usuario = mysqli_fetch_array($controlMinutas->consultar_usuario_nombre_tipo($correo))[0];
    $usuario = mysqli_fetch_array($controlMinutas->consultar_usuario_nombre_tipo($correo));
    $director = mysqli_fetch_array($controlMinutas->consultar_director($idseccion))[0];
    $id_session = session_id();
    $id_usuario = $usuario[2];
    //inclusion de navbar
    include "{$root}/components/navbar.php";
    ?>
    <div class="row">
        <div class="col s12 l8 border-azul" style="float: none;margin: 0 auto;">
            <div class="row">
                <br>
                <div class="right" style="margin-right: 1rem;">
                    <a class="waves-effect waves-light"
                       href="../Eventos.php?idseccion=1">
                        <img src='../../../images/Atras.svg' style="width: 110px">
                    </a>
                </div>
                <h5 class="col s12 c-azul text-center">Nuevo evento</h5> 
                <div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">person</i>
                        <input 
                            id="id_convocado_por"
                            type="text" 
                            class="validate" 
                            value="<?php echo $nombre_usuario; ?>">
                        <label>Convocado por</label>
                    </div>                                
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">meeting_room</i>
                        <input 
                            id="id_comite"
                            type="text" 
                            class="validate" 
                            value="<?php echo $comite; ?>">
                        <label>Para el comité</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">record_voice_over</i>
                        <input 
                            id="id_director"
                            type="text" 
                            class="validate" 
                            value="<?php echo $director; ?>">
                        <label>Director</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">work</i>
                        <input 
                            id="id_titulo_evento"
                            type="text" 
                            class="validate" 
                            placeholder="Título del evento"
                            onkeyup="capitaliza_primer_letra(this.id)"
                            autocomplete="off"
                            autofocus>
                        <label>Título del evento</label>
                    </div>
                    <div class="col s12 s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="id_fecha_evento" 
                                autocomplete="off"
                                placeholder="Para el día"
                                onchange="fecha_minusculas(this.value, 'fecha_evento')">     
                            <label>Fecha del evento</label>       
                        </div>
                        <script>
                            //obtiene el calendario escolar en db
                            var calendario_escolar = obtener_calendario_escolar();
                            //deshabilita el día 6 de la semana, es decir, el día sábado
                            calendario_escolar.push(6);
                            //asigna en el objeto del calendario dias sabados y domigos para deshabilitar
                            var fecha_minima = new Date('<?php echo date('Y-m-d'); ?>');
                            //fix de error al mostrar calendario (se oculta inmediatamente se abre)
                            $(".datepicker").on('mousedown', function (event) {
                                event.preventDefault();
                            });
                            $('.datepicker').pickadate({
                                format: 'dddd, dd De mmmm De yyyy',
                                today: false,
                                clear: false,
                                close: 'Aceptar',
                                closeOnSelect: false,
                                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'],
                                weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                                weekdaysLetter: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                //disable: calendario_escolar,
                                firstDay: 1,
                                disableWeekends: true,
                                min: fecha_minima
                            });
                        </script>  
                    </div>   
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">access_time</i>
                        <input id="id_horario_minuta"
                               type="text" 
                               placeholder="Horario del evento"
                               class="validate timepicker"
                               onkeypress="return validar_solo_numeros(event, this.id, 1)"
                               autocomplete="off"
                               onfocus="blur();">
                        <label>Hora del evento</label>
                    </div>     
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">group_add</i>
                        <input type="search" 
                               placeholder="Buscar invitado" 
                               onkeyup ="consultar_invitado(this.value, false);"
                               onchange="add_invitados(this.value, '<?php echo $usuario[2]; ?>');this.value = '';"
                               id="key_invitado">
                        <label>Invitados</label>
                        <div id="resultado"></div>
                    </div>
                    <div class="input-field col s12 l6">
                        <table class="display nowrap" id="tabla_invitados" style="margin-top: 6px;">
                            <thead>
                                <tr>
                                    <th>Invitado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <h5 class="col s12 c-azul text-center">Temas</h5> 
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">assignment</i>
                        <input type="text" 
                               id="id_tema"
                               placeholder="Añadir tema" 
                               onchange="add_tema(this.value);this.value = '';"
                               onkeyup="capitaliza_primer_letra(this.id)"
                               autocomplete="off">
                        <label>Añadir tema</label>
                        <div id="resultado"></div>
                    </div>                    
                    <div class="input-field col s12 l6">
                        <table class="display nowrap" id="tabla_temas" style="margin-top: 6px;">
                            <thead>
                                <tr>
                                    <th>Tema</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div> 
                    <h5 class="col s12 c-azul text-center">Archivos adjuntos</h5> 
                    <div class="input-field col s12">
                        <input type="file" name="filepond" data-max-files="10" multiple>
                    </div>        
                    <div class="input-field col s12 l6">
                        <a class="waves-effect waves-light btn red col s12 modal-trigger" href="#modal_alerta_salir_sin_guardar">
                            <i class="material-icons left">arrow_back_ios</i>&nbsp;Regresar
                        </a>
                    </div>
                    <div class="input-field col s12 l6">
                        <button id="btn_guardar"
                                class="waves-effect waves-light btn b-azul c-blanco col s12" 
                                onclick="guardar_minuta()">
                            <i class="material-icons right">save</i>&nbsp;Guardar
                        </button>
                    </div>
                </div>     
            </div>
        </div>
    </div>
    <div class="loading" id="loading" >
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal advertencia -->
    <div id="modal_alerta_salir_sin_guardar" class="modal">
        <div class="modal-content">
            <div>
                <h6 class="">Alerta</h6>
                <p>¿Deseas regresar sin guardar el evento?</p>
            </div>  
        </div>
        <div class="modal-footer grey lighten-3">
            <a href="#!" class="modal-close waves-effect waves-light btn-flat red white-text" onclick="x();"><b>Cancelar</b></a>
            <a href="../Eventos.php?idseccion=<?php echo $idseccion; ?>" class="modal-close waves-effect waves-blue btn-flat b-azul white-text"><b>Aceptar</b></a>
        </div>
    </div>

    <script>
        //input files
        var pond = null;
        var coleccion_invitados = [];
        var coleccion_temas = [];
        var table = null;
        var table_temas = null;
        var id_session = '<?php echo $id_session; ?>';
        var id_usuario = <?php echo $id_usuario; ?>;
        var id_comite = <?php echo $id_comite; ?>;
        $(document).ready(function () {
            $('.timepicker').timepicker({
                'step': 30,
                'minTime': '06:00',
                'maxTime': '23:59',
                'timeFormat': 'H:i:s'
            });
            $('select').formSelect();
            $("#loading").fadeOut();
            consultar_invitado(null, true);
            //input file
            const inputElement = document.querySelector('input[type="file"]');
            pond = FilePond.create(inputElement);

            $('.modal').modal();
            pond.setOptions({
                multiple: true,
                maxFileSize: '1MB',
                instantUpload: true,
                server: {
                    url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/',
                    process: {
                        url: './post_nuevo_archivo.php',
                        method: 'POST',
                        withCredentials: false,
                        onload: (response) => console.log(response),
                        onerror: (response) => response.data,
                        ondata: (formData) => {
                            formData.append('id_usuario', id_usuario);
                            formData.append('id_session', id_session);
                            return formData;
                        }
                    },
                    revert: './post_quitar_archivo.php',
                    restore: './restore.php?id=',
                    fetch: './fetch.php?data='
                }
            });
            //escucha peticion parar remover archivo
            pond.on('removefile', (error, file) => {
                $.ajax({
                    url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_quitar_archivo.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {id_session: id_session, archivo: file.filename}
                }).done((res) => {
                    if (res) {
                        M.toast({
                            html: '<i class="material-icons prefix">done</i> &nbsp; Se ha eliminado el archivo correctamente.',
                            classes: 'blue accent-3 c-blanco',
                        });
                    } else {
                        M.toast({
                            html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Ssolicitud no realizada.',
                            classes: 'red c-blanco',
                        });
                    }
                });
            });
        });

        function consultar_invitado(nombre, todos) {
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/get_consultar_invitado.php',
                type: 'GET',
                dataType: 'json',
                data: {key: nombre, todos: todos}
            }).done((res) => {
                $("#key_invitado").jqxInput({
                    opened: true,
                    searchMode: 'containsignorecase',
                    theme: 'energyblue',
                    placeHolder: 'Añadir invitado',
                    source: res
                });
            });
        }
        function add_invitados(value, id_creador) {
            if (value === "")
                return;
            for (var item in coleccion_invitados) {
                if (coleccion_invitados[item] === value) {
                    return;
                }
            }
            var invitado = null;
            var correo = null;
            if (!validaCorreo(value)) {
                correo = null;
                invitado = value;
            } else {
                invitado = null;
                correo = value;
            }
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_guardar_invitado_tmp.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_creador: id_creador,
                    invitado: invitado,
                    correo: correo,
                    id_session: id_session
                }
            }).done((res) => {
                if (res) {
                    coleccion_invitados.push(value);
                    coleccion_invitados = [...new Set(coleccion_invitados)];
                    M.toast({
                        html: '<i class="material-icons prefix">done</i> &nbsp; Invitado añadido correctamente.',
                        classes: 'blue accent-3 c-blanco',
                    });

                    if ($.fn.dataTable.isDataTable('#tabla_invitados')) {
                        table.row.add([
                            `<span id='value_${coleccion_invitados.length + 1}'>${value}</span>`,
                            `<a href='#!' onclick='quitar_invitado("tr_${coleccion_invitados.length + 1}", "value_${coleccion_invitados.length + 1}", "<?php echo $usuario[2]; ?>")'>Quitar</a>`
                        ]).draw().node().id = `tr_${coleccion_invitados.length + 1}`;
                    } else {
                        table = $("#tabla_invitados").DataTable({
                            paging: false,
                            searching: false,
                            "language": {
                                "lengthMenu": "_MENU_",
                                "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
                                "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
                                "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
                                "infoFiltered": "(filtrado de _MAX_ total de registros)",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando..."
                            },
                            retrieve: true,
                            rowReorder: {
                                rowOrder: true
                            }
                        });

                        if ($(`#value_${coleccion_invitados.length + 1}`).length === 0) {
                            table.row.add([
                                `<span id='value_${coleccion_invitados.length + 1}'>${value}</span>`,
                                `<a href='#!' onclick='quitar_invitado("tr_${coleccion_invitados.length + 1}", "value_${coleccion_invitados.length + 1}", "<?php echo $usuario[2]; ?>")'>Quitar</a>`
                            ]).draw().node().id = `tr_${coleccion_invitados.length + 1}`;
                        }
                    }
                }
            });
        }
        function quitar_invitado(tr, id_value, id_creador) {
            var value = $("#" + id_value).text();
            var invitado = null;
            var correo = null;
            if (!validaCorreo(value)) {
                correo = null;
                invitado = value;
            } else {
                invitado = null;
                correo = value;
            }
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_eliminar_invitado_tmp.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_creador: id_creador,
                    invitado: invitado,
                    correo: correo,
                    id_session: id_session
                }
            }).done((res) => {
                if (res) {
                    coleccion_invitados = new Set(coleccion_invitados);
                    coleccion_invitados.delete(value);
                    coleccion_invitados = [...coleccion_invitados];
                    table.row($("#" + tr)).remove().draw();
                }
            });
        }
        function add_tema(value) {
            if (value === "")
                return;
            for (var item in coleccion_temas) {
                if (coleccion_temas[item] === value) {
                    return;
                }
            }
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_guardar_tema_tmp.php',
                type: 'POST',
                dataType: 'json',
                data: {id_usuario: id_usuario, id_session: id_session, tema: value}
            }).done((res) => {
                if (res) {
                    coleccion_temas.push(value);
                    coleccion_temas = [...new Set(coleccion_temas)];
                    M.toast({
                        html: '<i class="material-icons prefix">done</i> &nbsp; Tema añadido correctamente.',
                        classes: 'blue accent-3 c-blanco'
                    });
                    if ($.fn.dataTable.isDataTable('#tabla_temas')) {
                        table_temas.row.add([
                            `<span id='value_${coleccion_temas.length + 1}'>${value}</span>`,
                            `<a href='#!' onclick='quitar_tema("tr_${coleccion_temas.length + 1}", "value_${coleccion_temas.length + 1}")'>Quitar</a>`
                        ]).draw().node().id = `tr_${coleccion_temas.length + 1}`;
                    } else {
                        table_temas = $("#tabla_temas").DataTable({
                            paging: false,
                            searching: false,
                            "language": {
                                "lengthMenu": "_MENU_",
                                "zeroRecords": "<span class='chip red white-text'>Sin registros para mostrar</span>",
                                "info": "<span class='chip blue white-text'>Mostrando colección _PAGE_ de _PAGES_</span>",
                                "infoEmpty": "<span class='chip red white-text'>Sin registros disponibles</span>",
                                "infoFiltered": "(filtrado de _MAX_ total de registros)",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando..."
                            },
                            retrieve: true,
                            rowReorder: {
                                rowOrder: true
                            }
                        });
                        table_temas.row.add([
                            `<span id='value_${coleccion_temas.length + 1}'>${value}</span>`,
                            `<a href='#!' onclick='quitar_tema("tr_${coleccion_temas.length + 1}", "value_${coleccion_temas.length + 1}")'>Quitar</a>`
                        ]).draw().node().id = `tr_${coleccion_temas.length + 1}`;
                    }
                } else {
                    M.toast({
                        html: '<i class="material-icons prefix">highlight_off</i>&nbsp; Solicitud no realizada.',
                        classes: 'red c-blanco'
                    });
                }
            });
        }
        function quitar_tema(tr, id_value) {
            var value = $("#" + id_value).text();

            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_eliminar_tema_tmp.php',
                type: 'POST',
                dataType: 'json',
                data: {id_usuario: id_usuario, id_session: id_session, tema: value}
            }).done((res) => {
                if (res) {
                    coleccion_temas = new Set(coleccion_temas);
                    coleccion_temas.delete(value);
                    coleccion_temas = [...coleccion_temas];
                    table_temas.row($("#" + tr)).remove().draw();
                }
            });
        }
        function validaciones() {
            var id_convocado_por = $("#id_convocado_por").val();
            var id_comite = $("#id_comite").val();
            var id_director = $("#id_director").val();
            var id_titulo_evento = $("#id_titulo_evento").val();
            var id_fecha_evento = $("#id_fecha_evento").val();
            var id_horario_minuta = $("#id_horario_minuta").val();

            if (id_convocado_por === "") {
                M.toast({
                    html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Debe ingresar quien convoca el evento.',
                    classes: 'amber darken-4 c-blanco'
                });
                return false;
            }
            if (id_comite === "") {
                M.toast({
                    html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Debe ingresar un comité válido.',
                    classes: 'amber darken-4 c-blanco'
                });
                return false;
            }
            if (id_director === "") {
                M.toast({
                    html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Debe ingresar un director válido.',
                    classes: 'amber darken-4 c-blanco'
                });
                return false;
            }
            if (id_titulo_evento === "") {
                M.toast({
                    html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Debe ingresar un título válido.',
                    classes: 'amber darken-4 c-blanco'
                });
                return false;
            }
            if (id_fecha_evento === "") {
                M.toast({
                    html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Debe ingresar una fecha válida.',
                    classes: 'amber darken-4 c-blanco'
                });
                return false;
            }
            if (id_horario_minuta === "") {
                M.toast({
                    html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Debe ingresar un horario válido.',
                    classes: 'amber darken-4 c-blanco'
                });
                return false;
            }
            if (coleccion_invitados.length === 0) {
                M.toast({
                    html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Debe ingresar al menos un invitado válido.',
                    classes: 'amber darken-4 c-blanco'
                });
                return false;
            }
            if (coleccion_temas.length === 0) {
                M.toast({
                    html: '<i class="material-icons prefix">highlight_off</i> &nbsp; Debe ingresar al menos un tema válido.',
                    classes: 'amber darken-4 c-blanco'
                });
                return false;
            }
            return true;
        }
        function guardar_minuta() {
            if (!validaciones())
                return;

            var id_convocado_por = $("#id_convocado_por").val();
            var id_director = $("#id_director").val();
            var id_titulo_evento = $("#id_titulo_evento").val();
            var id_fecha_evento = $("#id_fecha_evento").val();
            var id_horario_minuta = $("#id_horario_minuta").val();
            $.ajax({
                url: 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/common/post_guardar_minuta.php',
                type: 'POST',
                dataType: 'json',
                beforeSend: () => {
                    $("#loading").fadeIn();
                    $("#btn_guardar").prop("disabled", true);
                },
                data: {
                    titulo_evento: id_titulo_evento,
                    fecha: formatear_fecha_calendario_formato_a_m_d_guion(id_fecha_evento),
                    horario_minuta: id_horario_minuta,
                    fecha_evento: id_fecha_evento,
                    convocado_por: id_convocado_por,
                    director: id_director,
                    id_comite: id_comite,
                    id_session: id_session,
                    id_usuario: id_usuario
                }
            }).done((res) => {
                if (res) {
                    M.toast({
                        html: '<i class="material-icons prefix">done</i> &nbsp; Solicitud realizada correctamente.',
                        classes: 'green accent-4 c-blanco'
                    });
                    var url = 'https://www.chmd.edu.mx/pruebascd/icloud/Minutas/Eventos/Eventos.php?idseccion=<?php echo $idseccion; ?>';
                    setInterval(() => window.location.href = url,
                            1000);
                }
            }).always(() => $("#loading").fadeOut());
        }
        function x() {
            console.log(pond.getMetadata());
        }
    </script>

<?php
endif;
include "{$root}/components/layout_bottom.php";
?>