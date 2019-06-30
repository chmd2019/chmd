<a class="waves-effect waves-light btn modal-trigger red  <?php echo $ver_btn_cancelar; ?>" href="#modal_cancelar_permiso_<?php echo "$id_permiso"; ?>">
    <i class="material-icons">clear</i>
</a>

<div id="modal_cancelar_permiso_<?php echo "$id_permiso"; ?>" class="modal">
    <div class="modal-content">
        <h4>Confirmación <?php echo $id_permiso;?></h4>
        <p>¿Confirma cancelar este permiso?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>    
        <a href="#!" class="waves-effect btn-flat b-azul white-text" onclick="cancelar_permiso('<?php echo "$id_permiso"; ?>')">Aceptar</a>
    </div>        
    <br>    
</div>

<script>
    function cancelar_permiso(id) {
        var modal_cancelar_permiso = M.Modal.getInstance($("#modal_cancelar_permiso_"+id));
        $.ajax({
            url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/common/post_cancela_permiso.php",
            type: "POST",
            data: {id_permiso: id},
            success: function (res) {
                if (res == 1) {                    
                    modal_cancelar_permiso.close();
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