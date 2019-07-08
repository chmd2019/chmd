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
    if (mes === "Enero" || mes === "enero")
        mes = "01";
    if (mes === "Febrero" || mes === "febrero")
        mes = "02";
    if (mes === "Marzo" || mes === "marzo")
        mes = "03";
    if (mes === "Abril" || mes === "abril")
        mes = "04";
    if (mes === "Mayo" || mes === "mayo")
        mes = "05";
    if (mes === "Junio" || mes === "junio")
        mes = "06";
    if (mes === "Julio" || mes === "julio")
        mes = "07";
    if (mes === "Agosto" || mes === "agosto")
        mes = "08";
    if (mes === "Septiembre" || mes === "septiembre")
        mes = "09";
    if (mes === "Octubre" || mes === "octubre")
        mes = "10";
    if (mes === "Noviembre" || mes === "noviembre")
        mes = "11";
    if (mes === "Diciembre" || mes === "diciembre")
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

function validar_regex(reg, val) {
    var regex = new RegExp(reg);
    if (regex.test(val)) {
        return true;
    }
    return false;
}

function validar_solo_numeros(num) {
    var charCode = (num.which) ? num.which : num.keyCode;
    if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
        return false;

    if ($("#cp").val().length > 4) {
        return false;
    }
    return true;
}

function fecha_minusculas(val, id){
    $(`#${id}`).val(`${val.charAt(0)}${val.slice(1).toLowerCase()}`);
}