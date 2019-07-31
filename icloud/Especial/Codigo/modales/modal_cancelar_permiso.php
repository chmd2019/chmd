<a class="waves-effect waves-light btn modal-trigger red  <?php echo $ver_btn_cancelar; ?>" href="#modal_cancelar_permiso_<?php echo "$id_permiso"; ?>">
    <i class="material-icons">clear</i>
</a>

<div id="modal_cancelar_permiso_<?php echo "$id_permiso"; ?>" class="modal">
    <div class="modal-content">
        <h4>Confirmación</h4>
        <p>¿Confirma cancelar este permiso?</p>
    </div>
    <div class="modal-footer" style="padding:1rem">
        <a href="#!" class="modal-close waves-effect btn-flat red white-text">Cancelar</a>    
        <button class="waves-effect btn-flat b-azul white-text" 
                id="btn_cancelar_inscripcion_evento_<?php echo "$id_permiso"; ?>"
                onclick="cancelar_permiso('<?php echo "$id_permiso"; ?>')">Aceptar</button>
    </div>        
    <br>    
</div>

<script>
    function cancelar_permiso(id) {
        var modal_cancelar_permiso = M.Modal.getInstance($("#modal_cancelar_permiso_"+id));
        $.ajax({
            url: "https://www.chmd.edu.mx/pruebascd/icloud/Especial/common/post_cancela_inscripcion_evento.php",
            type: "POST",
            data: {id_permiso: id},
            beforeSend:()=>{
                $("#btn_cancelar_inscripcion_evento_<?php echo "$id_permiso"; ?>").prop("disabled", true);
            },
            success: function (res) {
                if (res == 1) {                    
                    modal_cancelar_permiso.close();
                    M.toast({
                        html: 'Solicitud realizada con éxito',
                        classes: 'green accent-4 c-blanco'
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    M.toast({
                        html: 'Solicitud no realizada!',
                        classes: 'deep-orange c-blanco'
                    });
                }
            }
        });
    }
</script>