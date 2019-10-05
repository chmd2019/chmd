<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/Transportes/components/sesion.php";
$fecha_actual = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSS Dependencies -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="/pruebascd/icloud/materialkit/css/global.css">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="/pruebascd/icloud/Transportes/common/js/common.js"></script>
        <!-- Calendario -->
        <link href='./packages/core/main.css' rel='stylesheet' />
        <script src='./packages/core/locales/es.js'></script>
        <link href='./packages/daygrid/main.css' rel='stylesheet' />
        <script src='./packages/core/main.js'></script>
        <script src='./packages/interaction/main.js'></script>
        <script src='./packages/daygrid/main.js'></script>


        <script>

            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['interaction', 'dayGrid'],
                    header: {left: 'prev', center: 'title', right: 'next'}, // buttons for switching between views
                    defaultDate: '<?= $fecha_actual ?>', //colocar la fecha actual
                    //defaultDate: '2019-12-01', //colocar la fecha actual
                    editable: false,
                    height: 500,
                    locale: 'es',
                    timeZone: 'America/Mexico_city',
                    eventLimit: true,
                    eventSources: [
                        // your event source
                        {
                            url: 'common/get-events.php', // use the `url` property
                            color: '#f6871f', // an option!
                            textColor: '#fff'  // an option!
                        },

                        // your event source
                        {
                            url: 'common/get-ensayos.php', // use the `url` property
                            //  color: '#6ACAF3',    // an option! clear blue
                            color: '#EF4545', // an option! red
                            textColor: '#fff'  // an option!
                        }


                        // any other sources...

                    ],
                    displayEventEnd: true,
                    eventTimeFormat: {// like '7pm'
                        hour: 'numeric',
                        minute: '2-digit',
                        meridiem: 'short'
                    },
                    eventClick: function (info) {
                        //  var fecha = new Date(info.event.start.getUTCFullYear(), info.event.start.getUTCMonth(), info.event.start.getUTCDate()) ;
                        //  alert(fecha);
                        //var  fecha = "2019-09-09";
                        var anio = info.event.start.getUTCFullYear();
                        var mes = info.event.start.getUTCMonth() + 1;
                        var dia = info.event.start.getUTCDate();
                        if (mes <= 9) {
                            mes = '0' + mes;
                        }
                        if (dia <= 9) {
                            dia = '0' + dia;
                        }

                        var fecha = anio + '-' + mes + '-' + dia;
                        //  alert(fecha); //solicitar los eventos de ese Dia
                        $.get('common/get_eventos_dia.php', {fecha_actual: fecha}, function (res) {
                            var data = JSON.parse(res);
                            let text = '';
                            if (data.length > 0) {
                                //alert('Mas de un evento');
                                for (var i = 0; i < data.length; i++) {
                                    var titulo = data[i].title;
                                    var hora_inicial = data[i].start_hour;
                                    var hora_final = data[i].end_hour;
                                    var lugar = data[i].place;
                                    var tipo = data[i].type_event;
                                    var img = '';
                                    if (tipo == 'Servicio de café')
                                        img = '../../images/Sevicio Cafe.svg';
                                    if (tipo == 'Montaje de evento interno')
                                        img = '../../images/Evento interno.svg';
                                    if (tipo == 'Montaje de evento combinado o externo')
                                        img = '../../images/Evento externo.svg';
                                    if (tipo == 'Montaje de evento especial')
                                        img = '../../images/Montaje especial.svg';


                                    //  alert('titulo:'+ titulo + ':'+ hora_inicial+':'+hora_final);
                                    text = text + '<li class="item_evento"><div class="collapsible-header" style="align-items: center"><img src = "' + img + '" alt="Event" style = "width:2rem" >&nbsp;&nbsp;&nbsp;' + hora_inicial + ' - ' + titulo + '</div><div class="collapsible-body"><span>Inicio del Evento: ' + hora_inicial + ' <br>Final del Evento: ' + hora_final + ' <br><br>Lugar: ' + lugar + '</span></div></li>';
                                }
                            } else {
                                //alert('Sin evento');
                                text = '<li class="item_evento"><div class="collapsible-header"><i class="material-icons">info</i>Sin Eventos</div><div class="collapsible-body"><span>No exiten eventos registrados para este día</span></div></li>';
                            }
                            //Remover Los eventos anteriores
                            $('.item_evento').remove();
                            //añadir text de eventos
                            $("#eventos_dia").append(text);
                            //Abro el modal
                            $('.modal').modal('open');
                        }, 'text');

                    }

                });

                calendar.render();


            });



        </script>
        <style >

            #calendar {
                max-width: 900px;
                margin: 40px auto;
                padding: 0 10px;
                font-size: 12px;
                font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
                border: none;
            }
            tr{ border: none;}
            a{ color: #4ea3d8;}
            .fc th{
                font-size: 1.4em;
            }
            .fc-button{
                background: #12487E;
                border-radius: 2px;
                color: $fff;
                font-size: 18px;
                -webkit-box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
                box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
            }
            .fc-button:focus{
                background: #12487E;
            }
            .fc-button:hover{
                position: relative;
                cursor: pointer;
                display: inline-block;
                overflow: hidden;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                -webkit-tap-highlight-color: transparent;
                vertical-align: middle;
                z-index: 1;
                -webkit-transition: .3s ease-out;
                transition: .3s ease-out;
            }

            .fc-sat,.fc-sun {
                background: #03497b;
                color: #fff;
            }
            .fc-toolbar h2{
                font-size: 2em;
                font-weight: bold;
                color: #12487e
            }

            .fc-unthemed th, .fc-unthemed td, .fc-unthemed thead, .fc-unthemed tbody, .fc-unthemed .fc-divider, .fc-unthemed .fc-row, .fc-unthemed .fc-content, .fc-unthemed .fc-popover, .fc-unthemed .fc-list-view, .fc-unthemed .fc-list-heading td{
                border-color: #fff;
                border-radius: 5px;
            }
            .fc th{
                background-color: #fff;
                color: #111;
            }
            .fc-unthemed td{
                border-color: white;
            }
            .fc-head-container.fc-widget-header{
                border:none;
            }

            .fc-unthemed td.fc-today {
                background: #eee;
                color: #949494;
            }


            tr:first-child > td > .fc-day-grid-event {
                margin-top: 2px;
                cursor: pointer;
            }

            .fc-ltr .fc-dayGrid-view .fc-day-top .fc-day-number {
                float: initial;
                /* padding: 4px; */
                margin: 3px;
                font-size: 1.3em;
                font-weight: 600;
                font-family: auto;
            }

            .fc , td{
                text-align: center;
            }

            td.fc-day.fc-widget-content.fc-sat {
                box-shadow: 0 0 4px black;
            }

            td.fc-day.fc-widget-content.fc-sat.fc-other-month.fc-future {
                box-shadow: 0 0 4px black;
            }

        </style>
    </head>
    <body>
        <?php
//$idseccion = $_GET['idseccion'];
//zona horaria para America/Mexico_city
        require "$root_icloud/Helpers/DateHelper.php";
        $objDateHelper = new DateHelper();
        $objDateHelper->set_timezone();
        $fecha_actual = date('m-d-Y');
        $fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
                . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
                . "fecha = fecha.toLocaleDateString('es-MX', options);"
                . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
                . "document.write(fecha)</script>";
        if (isset($authUrl)) {
            header("Location: $redirect_uri?logout=1");
        } else {
            $user = $service->userinfo->get();
            $correo = $user->email;
            $objCliente = new Login();
            $consulta = $objCliente->acceso_login($correo);
            include_once "$root_icloud/components/navbar.php";
            ?>
            <div class="row">
                <div class="col s12 m12 l9 b-blanco border-azul" style="float: none;margin: 0 auto;">
                    <h4 class="c-azul" style="text-align: center;">Calendario de Disponibilidad</h4>
                    <div class="row" style="text-align: right;margin:1rem 1rem 0 0">
                        <a class="waves-effect waves-light" href="../menu.php">
                            <img src='../../images/Atras.svg' style="width: 110px"> 
                        </a>              
                        <a class="waves-effect waves-light" href="../montajes/vistas/vista_nueva_solicitud_montaje.php?idseccion=<?php echo $idseccion; ?>">
                            <img src='../../images/Nuevo.svg' style="width: 110px">       
                        </a> 
                    </div>
                    <div>
    <?php include './View_calendario.php'; ?>
                    </div>
                        <?php
                    }
                    ?>
            </div>
        </div>

        <div id="modal_evento" class="modal">
            <div class="modal-content">
                <h4>Eventos Del Dia</h4>
                <ul class="collapsible" id="eventos_dia" >
                    <!--AGregar nuevos eventos-->
                </ul>
            </div>
            <div class="modal-footer" style="padding:1rem">
                <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>
            </div>
            <br>
        </div>

        <!--
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large waves-effect waves-light b-azul"
               href="../menu.php">
                <i class="large material-icons">keyboard_backspace</i>
            </a>
        </div>
        --->
        <script>

            $(document).ready(function () {
                $('.collapsible').collapsible();

                var text = $('.fc-center h2').text();
                text = text.substr(0, 1).toUpperCase() + text.substr(1);
                $('.fc-center h2').text(text);

                $('.fixed-action-btn').floatingActionButton({
                    hoverEnabled: false
                });
                $('.modal').modal();

                $('.fc-day-header.fc-widget-header.fc-mon').html('<span>L</span>');
                $('.fc-day-header.fc-widget-header.fc-tue').html('<span>M</span>');
                $('.fc-day-header.fc-widget-header.fc-wed').html('<span>M</span>');
                $('.fc-day-header.fc-widget-header.fc-thu').html('<span>J</span>');
                $('.fc-day-header.fc-widget-header.fc-fri').html('<span>V</span>');
                $('.fc-day-header.fc-widget-header.fc-sat').html('<span>S</span>');
                $('.fc-day-header.fc-widget-header.fc-sun').html('<span>D</span>');

                $(".fc-next-button").click(function () {
                    //    alert('Hola');
                    var text = $('.fc-center h2').text();
                    text = text.substr(0, 1).toUpperCase() + text.substr(1);
                    $('.fc-center h2').text(text);

                    $('.fc-day-header.fc-widget-header.fc-mon').html('<span>L</span>');
                    $('.fc-day-header.fc-widget-header.fc-tue').html('<span>M</span>');
                    $('.fc-day-header.fc-widget-header.fc-wed').html('<span>M</span>');
                    $('.fc-day-header.fc-widget-header.fc-thu').html('<span>J</span>');
                    $('.fc-day-header.fc-widget-header.fc-fri').html('<span>V</span>');
                    $('.fc-day-header.fc-widget-header.fc-sat').html('<span>S</span>');
                    $('.fc-day-header.fc-widget-header.fc-sun').html('<span>D</span>');


                });

                $(".fc-prev-button").click(function () {
                    var text = $('.fc-center h2').text();
                    text = text.substr(0, 1).toUpperCase() + text.substr(1);
                    $('.fc-center h2').text(text);
                    //  alert('Hola');
                    $('.fc-day-header.fc-widget-header.fc-mon').html('<span>L</span>');
                    $('.fc-day-header.fc-widget-header.fc-tue').html('<span>M</span>');
                    $('.fc-day-header.fc-widget-header.fc-wed').html('<span>M</span>');
                    $('.fc-day-header.fc-widget-header.fc-thu').html('<span>J</span>');
                    $('.fc-day-header.fc-widget-header.fc-fri').html('<span>V</span>');
                    $('.fc-day-header.fc-widget-header.fc-sat').html('<span>S</span>');
                    $('.fc-day-header.fc-widget-header.fc-sun').html('<span>D</span>');

                });


            });




        </script>


<?php include "$root_icloud/components/layout_bottom.php"; ?>
