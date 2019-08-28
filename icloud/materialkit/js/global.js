
var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
var monthsShort = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
var weekdays = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
var weekdaysShort = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
var weekdaysAbbrev = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
var day = new Date("<?php echo "$fecha_disabled"; ?>");
        real_day = day.getDate();
var disbaleDays = function (day) {
    var dates = [
        new Date(day.getFullYear(), day.getMonth(), real_day).toDateString()
    ];
    if (dates.indexOf(day.toDateString()) >= 0) {
        return true; // Disables date.
    }
    return false; // Date is availble.
}
$('.datepicker').datepicker({
    firstDay: true,
    disableWeekends: true,
    minDate: new Date(),
    format: 'dddd, dd De mmmm De yyyy',
    disableDayFn: disbaleDays,
    i18n: {
        cancel: 'Cancelar',
        clear: 'Limpar',
        done: 'Aceptar',
        months,
        monthsShort,
        weekdays,
        weekdaysShort,
        weekdaysAbbrev,
    }
});