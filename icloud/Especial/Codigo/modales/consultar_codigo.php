<!-- Modal advertencia -->
<div id="modal_consultar_codigo" class="modal">
    <div class="modal-content">
        <div>
            <h5 class="c-azul">Debe ingresar un código válido</h5>
            <br>
            <div class="input-field">
                <input id="codigo" type="text" class="c-azul" onkeypress="return (this.value.length <= 5);" autofocus>
                <label for="codigo" class="light-blue-text accent-3-text">Código</label>
            </div>            
        </div>  
    </div>
    <div class="modal-footer light-blue accent-3">
        <a href="Codigo/vistas/PCodigo.php" class="waves-effect waves-blue btn-flat c-blanco text-left" >
            <b>Listar eventos</b>
        </a>
        <a href="#!" class="waves-effect waves-blue btn-flat c-blanco" onclick="buscar_codigo('<?php echo $familia; ?>')">
            <b>Buscar</b>
        </a>
    </div>
</div>

<div class="loading" id="loading">
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

<script>
    $(document).ready(function () {
        $("#loading").hide();
        $("#codigo").focus();
    });
    $(document).on('keypress', function (e) {
        var value = $("#codigo").val().toUpperCase();
        $("#codigo").val(value);
    });

    function validar_codigo() {
        if ($("#codigo").val() === "") {
            M.toast({
                html: 'Debe ingresar un código válido!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        if ($("#codigo").val().length < 6) {
            M.toast({
                html: 'El código debe ser de 6 dígitos!',
                classes: 'deep-orange c-blanco'
            });
            return false;
        }
        return true;
    }

    function buscar_codigo(familia) {
        if (!validar_codigo())
            return;
        var codigo = $("#codigo").val();
        $.ajax({
            url: 'https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/get_buscar_codigo.php',
            type: 'GET',
            data: {"codigo": codigo, "familia": familia},
            beforeSend: () => {
                $("#loading").fadeIn("slow");
            }
        }).done((res) => {
            res = JSON.parse(res);
            if (res === "2") {
                M.toast({
                    html: 'El evento ya ha sido autorizado',
                    classes: 'deep-orange c-blanco'
                });
                $("#codigo").focus();
                return;
            }
            if (res === "3") {
                M.toast({
                    html: 'El evento ha sido declinado',
                    classes: 'deep-orange c-blanco'
                });
                $("#codigo").focus();
                return;
            }
            if (res === "4") {
                M.toast({
                    html: 'El evento ha sido cancelado',
                    classes: 'deep-orange c-blanco'
                });
                $("#codigo").focus();
                return;
            }

            if (Number.isInteger(res)) {
                var url = "https://www.chmd.edu.mx/pruebascd/icloud/Especial/Codigo/vistas/vista_inscritos_evento.php";
                window.location.href = `${url}?familia=${familia}&&codigo_evento=${codigo}`;
                return;
            }
            if (!res) {
                M.toast({
                    html: '¡El código ingresado no ha sido encontrado!',
                    classes: 'deep-orange c-blanco'
                });
                $("#codigo").focus();
                return;
            }
            var url = "https://www.chmd.edu.mx/pruebascd/icloud/Especial/Codigo/vistas/vista_inscripcion_evento.php";
            window.location.href = `${url}?id_permiso=${res.id_permiso}&&fecha_invitacion=${res.fecha_invitacion}&&familia=${res.familia}&&tipo_evento=${res.tipo_evento}&&codigo_invitacion=${res.codigo_invitacion}`;
        }).always(() => {
            $("#loading").fadeOut("slow");
        });
    }
</script>