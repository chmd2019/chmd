<a class="waves-effect waves-light btn modal-trigger red"  href="#modal_cancelar_auto_<?php echo "$id_auto"; ?>">
    <i class="material-icons">clear</i>
</a>

<div id="modal_cancelar_auto_<?php echo "$id_auto"; ?>" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Confirma cancelar este auto?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>
        <a href="#!" class="waves-effect btn-flat b-azul white-text" onclick="cancelar_auto('<?php echo "$id_auto";?>')">Aceptar</a>
    </div>
    <br>
</div>

<script>
    function cancelar_auto(id) {
        var modal_cancelar_auto = M.Modal.getInstance($("#modal_cancelar_auto_"+id));
        $.ajax({
            url: "./common/post_cancela_auto.php",
            type: "POST",
            data: {id_auto: id},
            success: function (res) {
                if (res == 1) {
                    modal_cancelar_auto.close();
                    //  swal("Información", "Solicitud realizada con éxito!", "success");
                    M.toast({html: 'Solicitud realizada con éxito!', classes: 'green accent-4'});
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    //swal("Información", "Solicitud no realizada!", "error");
                    M.toast({html: 'Ha Ocurrido un Error, Solicitud no realizada!', classes: 'red accent-4'});
                }
            }
        });
    }
</script>
