function consultar_registro(id, familia) {
    $("document").ready(function () {
        url = `../Diario/Ver_diario.php`;
        data = `id=${id}&familia=${familia}`;
        $.ajax({
            url: url,
            type: "post",
            data: data,
            success: function (response) {
                response = JSON.parse(response);
                //formato de fecha
                var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
                var fecha_permiso = new Date(`${response.fecha_permiso}`);
                fecha_permiso = fecha_permiso.toLocaleDateString("es-MX", options);
                fecha_permiso = `${fecha_permiso.charAt(0).toUpperCase()}${fecha_permiso.slice(1).toLowerCase()}`;
                $('#fecha_solicitud').val(response.fecha_solicitud);
                $('#solicitante').val(response.correo);
                $('#fecha_permiso').val(fecha_permiso);
                $('#calle').val(response.calle);
                $('#colonia').val(response.colonia);
                $('#ruta').val(response.ruta);
                $('#comentarios').val(response.comentarios);
                $('#respuesta').val(response.mensaje);
                console.log(response);
                $('#botonModalInformacionPermiso').click();
            }
        });
    });
}
//Selectores de fechas
$('#fecha1').datepicker({
    language: 'es',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startDate: '+0d',
    daysOfWeekDisabled: [0, 6],
    //datesDisabled: calendario_escolar,
    forceParse: 0,
});