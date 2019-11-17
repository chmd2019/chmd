<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include_once "$root_icloud/Transportes/components/sesion.php";
include_once "$root_icloud/components/layout_top.php";
$idseccion = $_GET['idseccion'];

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
            <div>
                <br>
                <h4 class="c-azul" style="text-align: center;">Solicitudes de montajes</h4>
                <div>                    
                    <?php include './View_montajes.php'; ?> 
                </div>
                <?php
            }
            ?>               
        </div>
    </div>
</div>

<script>
    var id_montaje = null, flag_archivar = null;
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        $('.modal').modal();
        set_table_desordenada('tabla_no_archivados');
        set_table_desordenada('tabla_archivados');
        $("select").formSelect();
        $("#loading").fadeOut();
        /*setInterval(function () {
         window.location.reload();
         }, 30000);*/
        //obtiene el calendario escolar en db
        //var calendario_escolar = obtener_calendario_escolar();
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
            //min: new Date()
        });
        $('.tooltipped').tooltip();
    });

    function consultar_reporte() {
        if ($("#fecha_reporte").val() === "") {
            M.toast({
                html: 'Debe seleccionar una fecha válida!',
                classes: 'deep-orange c-blanco',
            });
            return;
        }
        var fecha_reporte = formatear_fecha_calendario_formato_a_m_d_guion(`${$("#fecha_reporte").val()}`);
        window.open(`https://www.chmd.edu.mx/pruebascd/icloud/Evento/montajes/vistas/vista_reporte_montaje.php?fecha_reporte=${fecha_reporte}`, "Reporte de montajes");
    }
    function modal_archivo(flag_archivo) {
        var modal_modal_archivo = M.Modal.getInstance($("#confirmar_archivo"));
        var modal_modal_desarchivo = M.Modal.getInstance($("#confirmar_desarchivo"));
        if (flag_archivo) {
            modal_modal_archivo.open();
        } else {
            modal_modal_desarchivo.open();
        }
    }
    function archivar() {
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Evento/common/post_archivar.php',
            type: 'POST',
            dataType: 'json',
            beforeSend: () => {
                $("#loading").fadeIn();
            },
            data: {id_montaje: id_montaje, flag_archivar: flag_archivar}
        }).done((res) => {
            if (res) {
                id_montaje = null;
                flag_archivar = null;
                M.toast({
                    html: '¡Solicitud realizada con éxito!',
                    classes: 'green accent-4 c-blanco'
                });
                setInterval(() => {
                    window.location.reload();
                }, 500);
            } else {
                M.toast({
                    html: '¡Solicitud no realizada!',
                    classes: 'red c-blanco'
                });
            }
        }).always(() => {
            M.Modal.getInstance($("#confirmar_archivo")).close();
            M.Modal.getInstance($("#confirmar_desarchivo")).close();
            $("#loading").fadeOut();
        });
    }
</script>
<style>
    #modal_reporte{
        height: 700px;
    }
</style>

<?php include "$root_icloud/components/layout_bottom.php"; ?>
