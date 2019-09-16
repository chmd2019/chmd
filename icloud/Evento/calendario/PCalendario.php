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

          document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
              plugins: [ 'interaction', 'dayGrid' ],
              header: {   left:   'prev', center: 'title', right:  'next' }, // buttons for switching between views
              defaultDate: '<?=$fecha_actual?>', //colocar la fecha actual
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
                  color: '#f6871f',    // an option!
                  textColor: '#fff'  // an option!
                },

                // your event source
                {
                  url: 'common/get-ensayos.php', // use the `url` property
                  //  color: '#6ACAF3',    // an option! clear blue
                  color: '#EF4545',    // an option! red
                  textColor: '#fff'  // an option!
                }


                // any other sources...

              ],
              displayEventEnd: true,
              eventTimeFormat: { // like '7pm'
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
              },
            eventClick: function(info) {
            //  var fecha = new Date(info.event.start.getUTCFullYear(), info.event.start.getUTCMonth(), info.event.start.getUTCDate()) ;
            //  alert(fecha);
            //var  fecha = "2019-09-09";
            var anio = info.event.start.getUTCFullYear();
            var mes = info.event.start.getUTCMonth() + 1;
            var dia = info.event.start.getUTCDate();
            if (mes<=9) { mes = '0' + mes; }
            if (dia<=9) { dia = '0' + dia; }

            var  fecha = anio + '-' + mes + '-' + dia ;
          //  alert(fecha); //solicitar los eventos de ese Dia
              $.get('common/get_eventos_dia.php', { fecha_actual : fecha }, function(res){
                    var data = JSON.parse(res);
                    let text ='';
                    if (data.length>0){
                      //alert('Mas de un evento');
                      for ( var i =0; i<data.length ; i++){
                          var titulo = data[i].title;
                          var hora_inicial = data[i].start_hour;
                          var hora_final = data[i].end_hour;
                          var lugar = data[i].place;
                          var tipo = data[i].type_event;
                          var img = '';
                          if (tipo == 'Servicio de café') img ='../../images/Sevicio Cafe.svg' ;
                          if (tipo == 'Montaje de evento interno')  img = '../../images/Evento interno.svg' ;
                          if (tipo == 'Montaje de evento combinado o externo')  img = '../../images/Evento externo.svg' ;
                          if (tipo == 'Montaje de evento especial')  img = '../../images/Montaje especial.svg';


                        //  alert('titulo:'+ titulo + ':'+ hora_inicial+':'+hora_final);
                        text = text + '<li class="item_evento"><div class="collapsible-header" style="align-items: center"><img src = "'+img+'" alt="Event" style = "width:2rem" >&nbsp;&nbsp;&nbsp;'+hora_inicial+' - '+titulo+'</div><div class="collapsible-body"><span>Inicio del Evento: '+hora_inicial+' <br>Final del Evento: '+hora_final+' <br><br>Lugar: '+lugar+ '</span></div></li>';
                      }
                    }else{
                      //alert('Sin evento');
                      text ='<li class="item_evento"><div class="collapsible-header"><i class="material-icons">info</i>Sin Eventos</div><div class="collapsible-body"><span>No exiten eventos registrados para este día</span></div></li>';
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
            <a class="waves-effect waves-light"
            href="../menu.php">
            <svg width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 600 209.54" style="enable-background:new 0 0 600 209.54;" xml:space="preserve">
            <style type="text/css">
            .sth0{fill:#6DC1EC;}
            .sth1{fill:#0E497B;stroke:#0C4A7B;stroke-miterlimit:10;}
            .sth2{fill-rule:evenodd;clip-rule:evenodd;fill:#0E497B;}
            </style>
            <path class="sth0" d="M559.25,192.49H45.33c-16.68,0-30.33-13.65-30.33-30.33V50.42c0-16.68,13.65-30.33,30.33-30.33h513.92
            c16.68,0,30.33,13.65,30.33,30.33v111.74C589.58,178.84,575.93,192.49,559.25,192.49z"/>
            <g>
              <path class="sth1" d="M228.72,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
              c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
              c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C228,130.45,228.27,129.64,228.72,128.74z M270.07,110.86l-11.11-25.55
              l-11.1,25.55H270.07z"/>
              <path class="sth1" d="M313.14,83.05h-15.35c-2.89,0-5.15-2.35-5.15-5.15s2.26-5.15,5.15-5.15h41.98c2.8,0,5.06,2.35,5.06,5.15
              s-2.26,5.15-5.06,5.15h-15.44v47.85c0,3.07-2.53,5.51-5.6,5.51c-3.07,0-5.6-2.44-5.6-5.51V83.05z"/>
              <path class="sth1" d="M351.6,78.36c0-3.16,2.44-5.6,5.6-5.6h22.57c7.95,0,14.17,2.35,18.24,6.32c3.34,3.43,5.24,8.12,5.24,13.63
              v0.18c0,10.11-5.87,16.25-14.36,18.87l12.1,15.26c1.08,1.35,1.81,2.53,1.81,4.24c0,3.07-2.62,5.15-5.33,5.15
              c-2.53,0-4.15-1.17-5.42-2.89l-15.35-19.59h-13.99v16.97c0,3.07-2.44,5.51-5.51,5.51c-3.16,0-5.6-2.44-5.6-5.51V78.36z
              M378.96,104.09c7.95,0,13-4.15,13-10.56v-0.18c0-6.77-4.88-10.47-13.09-10.47h-16.16v21.22H378.96z"/>
              <path class="sth1" d="M408.75,128.74l23.47-52.37c1.26-2.8,3.52-4.51,6.68-4.51h0.54c3.16,0,5.33,1.72,6.59,4.51l23.47,52.37
              c0.45,0.81,0.63,1.62,0.63,2.35c0,2.98-2.26,5.33-5.24,5.33c-2.62,0-4.42-1.53-5.42-3.88l-5.15-11.83h-30.7l-5.33,12.19
              c-0.9,2.26-2.8,3.52-5.15,3.52c-2.89,0-5.15-2.26-5.15-5.15C408.03,130.45,408.3,129.64,408.75,128.74z M450.1,110.86L439,85.31
              l-11.1,25.55H450.1z M436.02,65.18c0-0.63,0.36-1.44,0.72-1.99l5.15-7.95c0.99-1.62,2.44-2.62,4.33-2.62c2.89,0,6.5,1.81,6.5,3.52
              c0,0.99-0.63,1.9-1.53,2.71l-6.05,5.78c-2.17,1.99-3.88,2.44-6.41,2.44C437.19,67.07,436.02,66.35,436.02,65.18z"/>
              <path class="sth1" d="M476.01,128.92c-1.26-0.9-2.17-2.44-2.17-4.24c0-2.89,2.35-5.15,5.24-5.15c1.54,0,2.53,0.45,3.25,0.99
              c5.24,4.15,10.83,6.5,17.7,6.5c6.86,0,11.2-3.25,11.2-7.95v-0.18c0-4.51-2.53-6.95-14.26-9.66c-13.45-3.25-21.04-7.22-21.04-18.87
              v-0.18c0-10.83,9.03-18.33,21.58-18.33c7.95,0,14.36,2.08,20.04,5.87c1.26,0.72,2.44,2.26,2.44,4.42c0,2.89-2.35,5.15-5.24,5.15
              c-1.08,0-1.99-0.27-2.89-0.81c-4.88-3.16-9.57-4.79-14.54-4.79c-6.5,0-10.29,3.34-10.29,7.49v0.18c0,4.88,2.89,7.04,15.08,9.93
              c13.36,3.25,20.22,8.04,20.22,18.51v0.18c0,11.83-9.3,18.87-22.57,18.87C491.18,136.86,483.05,134.15,476.01,128.92z"/>
            </g>
            <g>
              <path class="sth2" d="M81.84,94.54h97.68c14.9,0,14.9,23.73,0,23.73H81.84l26.49,27.04c11.04,11.04-5.52,27.59-16.56,16.56
              l-47.46-46.91c-4.41-4.97-4.41-12.69,0-17.11l47.46-46.91c11.04-11.59,27.59,5.52,16.56,16.56L81.84,94.54z"/>
            </g>
          </svg>
          <!--
          <i class="material-icons left">keyboard_backspace</i>Atrás
          -->
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
      text = text.substr(0,1).toUpperCase()+text.substr(1);
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

      $(".fc-next-button").click(function(){
    //    alert('Hola');
    var text = $('.fc-center h2').text();
    text = text.substr(0,1).toUpperCase()+text.substr(1);
    $('.fc-center h2').text(text);

        $('.fc-day-header.fc-widget-header.fc-mon').html('<span>L</span>');
        $('.fc-day-header.fc-widget-header.fc-tue').html('<span>M</span>');
        $('.fc-day-header.fc-widget-header.fc-wed').html('<span>M</span>');
        $('.fc-day-header.fc-widget-header.fc-thu').html('<span>J</span>');
        $('.fc-day-header.fc-widget-header.fc-fri').html('<span>V</span>');
        $('.fc-day-header.fc-widget-header.fc-sat').html('<span>S</span>');
        $('.fc-day-header.fc-widget-header.fc-sun').html('<span>D</span>');


      });

      $(".fc-prev-button").click(function(){
        var text = $('.fc-center h2').text();
        text = text.substr(0,1).toUpperCase()+text.substr(1);
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
