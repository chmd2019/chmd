<a class="waves-effect waves-light btn modal-trigger red  <?php echo $ver_btn_cancelar; ?>" href="#modal_cancelar_permiso_<?php echo "$Idpermiso"; ?>">
    <i class="material-icons">clear</i>
</a>

<div id="modal_cancelar_permiso_<?php echo "$Idpermiso"; ?>" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Confirma cancelar este permiso?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>    
        <a href="#!" class="waves-effect btn-flat b-azul white-text" onclick="cancelar_permiso_diario('<?php echo "$Idpermiso"; ?>')">Aceptar</a>
    </div>        
    <br>    
</div>

<script>
    function cancelar_permiso_diario(id) {
        var modal_cancelar_permiso = M.Modal.getInstance($("#modal_cancelar_permiso_"+id));
        $.ajax({
            url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/post_cancela_permiso_diario.php",
            type: "POST",
            data: {id_permiso_diario: id},
            success: function (res) {
                if (res == 1) {                    
                    modal_cancelar_permiso.close();
                    swal("Información", "Solicitud realizada con éxito!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 2500);
                } else {
                    swal("Información", "Solicitud no realizada!", "error");
                }
            }
        });
    }
</script>