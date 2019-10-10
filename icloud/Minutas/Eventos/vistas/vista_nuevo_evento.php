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
                        <i class="material-icons prefix c-azul">work</i>
                        <input type="text" class="validate">
                        <label>Título del evento</label>
                    </div>
                    <div class="col s12 s12 l6">
                        <div class="input-field">
                            <i class="material-icons prefix c-azul">calendar_today</i>
                            <input 
                                type="text" 
                                class="datepicker" 
                                id="fecha_evento" 
                                autocomplete="off"
                                placeholder="Para el día"
                                onchange="fecha_minusculas(this.value, 'fecha_evento')">     
                            <label  style="margin-left: 1rem">Fecha del evento</label>       
                        </div>
                        <script>
                            //obtiene el calendario escolar en db
                            var calendario_escolar = obtener_calendario_escolar();
                            //deshabilita el día 6 de la semana, es decir, el día sábado
                            calendario_escolar.push(7);
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
                        <input type="text" class="validate timepicker"
                               onkeypress="return validar_solo_numeros(event, this.id, 1)"
                               autocomplete="off"
                               onfocus="blur();">
                        <label>Hora del evento</label>
                    </div>                                     
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">meeting_room</i>
                        <select></select>
                        <label>Para el comité</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">person</i>
                        <input type="text" class="validate">
                        <label>Convocado por</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">group_add</i>
                        <input type="text" class="validate">
                        <label>Invitados</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <i class="material-icons prefix c-azul">record_voice_over</i>
                        <input type="text" class="validate">
                        <label>Director</label>
                    </div>
                    <h5 class="col s12 c-azul text-center">Temas</h5>                     
                    <div class="input-field col s12 l6" style="display: flex;">
                        <i class="material-icons c-azul" style="margin: 1rem 1rem 0rem 0rem;">assignment</i>
                        <input name="tags" placeholder="Añadir tema" id="tags" type="text"/>
                    </div>
                    <div class="col s12">
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.timepicker').timepicker({
                'step': 10,
                'minTime': '06:00',
                'maxTime': '04:00',
                'timeFormat': 'H:i:s'
            });
            $('select').formSelect();
            $('#tags').tagsInput({
                'height': '80px',
                'width': '28rem',
                'padding': '0px',
                'interactive': true,
                'defaultText': 'Añadir tema',
                'delimiter': [',', ';'], // Or a string with a single delimiter. Ex: ';'
                'removeWithBackspace': true,
                'minChars': 0,
                'maxChars': 0, // if not provided there is no limit
                'placeholderColor': '#666666'
            });
        });
    </script>

<?php endif; ?>
<?php include "{$root}/components/layout_bottom.php"; ?>