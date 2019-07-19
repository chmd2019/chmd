<a class="waves-effect waves-light btn modal-trigger  red"  href="#modal_cancelar_chofer_<?php echo "$id_chofer"; ?>">
    <i class="material-icons">clear</i>
</a>

<div id="modal_cancelar_chofer_<?php echo "$id_chofer"; ?>" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Confirma cancelar este chofer?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>
        <a href="#!" class="waves-effect btn-flat b-azul white-text" onclick="cancelar_chofer('<?php echo "$id_chofer";?>')">Aceptar</a>
    </div>
    <br>
</div>

<script>
    function cancelar_chofer(id) {
        var modal_cancelar_chofer = M.Modal.getInstance($("#modal_cancelar_chofer_"+id));
        $.ajax({
            url: "https://www.chmd.edu.mx/pruebascd/icloud/Choferes/common/post_cancela_chofer.php",
            type: "POST",
            data: {
              id_chofer: id
              },
            success: function (res) {
                if (res == 1) {
                    modal_cancelar_chofer.close();
                    swal("Información", "Solicitud realizada con éxito!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    swal("Información", "Solicitud no realizada!", "error");
                }
            }
        });
    }
</script>
