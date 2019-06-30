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
