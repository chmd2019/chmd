
<div class="text-center">
    <button type="button"  class="btn btn-success ml-1" 
            data-toggle="modal" data-target="#modal_consulta_diario<?php echo "$Idpermiso"; ?>"
            onclick="consultar_diario('<?php echo "$Idpermiso"; ?>', '<?php echo "$familia"; ?>')">
        <i class="fas fa-binoculars ml-1"></i>
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_consulta_diario<?php echo "$Idpermiso"; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header white-text b-azul">
                <h5 class="modal-title white-text">Nuevo permiso diario</h5>
                <button type="button" class="close white-text" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>        

            <div class="modal-body">
                <div class="md-form mb-5">
                    <i class="fas fa-calendar-check prefix grey-text"></i>      
                    <input style="font-size: 1.4rem" type="text" class="form-control" 
                           id="fecha_solicitud_consulta_<?php echo "$Idpermiso"; ?>" />
                    <span class="ml-5">Fecha de solicitud</span>
                </div>

                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input style="font-size: 1.4rem" type="text" class="form-control" 
                           id="correo_consulta_<?php echo "$Idpermiso"; ?>" readonly />
                    <span class="ml-5">Solicitante</span>
                </div>

                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input style="font-size: 1.4rem" type="text" class="form-control" 
                           id="fecha_permiso_consulta_<?php echo "$Idpermiso"; ?>" readonly />
                    <span class="ml-5">Fecha de permiso</span>
                </div>

                <div class="card border-primary mb-3">
                    <div class="card-header">Dirección de la casa</div>
                    <div class="card-body text-primary">
                        <span class="card-text">
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" 
                                       id="calle_consulta_<?php echo "$Idpermiso"; ?>" readonly/>
                                <span class="ml-5">Calle y número</span>
                            </div>
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" 
                                       id="colonia_consulta_<?php echo "$Idpermiso"; ?>" readonly />
                                <span class="ml-5">Colonia</span>
                            </div>
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" readonly id="cp_consulta_<?php echo "$Idpermiso"; ?>" />
                                <span class="ml-5">CP</span>
                            </div>
                        </span>
                    </div>
                </div>

                <div class="card border-primary mb-3">
                    <div class="card-header">Alumnos</div>
                    <div class="card-body text-primary">
                        <span class="card-text">
                            <input style="font-size: 1.4rem" type="text" class="form-control d-none mb-1" 
                                   id="alumnos_consulta_1_<?php echo "$Idpermiso"; ?>" readonly />
                            <input style="font-size: 1.4rem" type="text" class="form-control d-none mb-1" 
                                   id="alumnos_consulta_2_<?php echo "$Idpermiso"; ?>" readonly />
                            <input style="font-size: 1.4rem" type="text" class="form-control d-none mb-1" 
                                   id="alumnos_consulta_3_<?php echo "$Idpermiso"; ?>" readonly />
                            <input style="font-size: 1.4rem" type="text" class="form-control d-none mb-1" 
                                   id="alumnos_consulta_4_<?php echo "$Idpermiso"; ?>" readonly />
                            <input style="font-size: 1.4rem" type="text" class="form-control d-none mb-1" 
                                   id="alumnos_consulta_5_<?php echo "$Idpermiso"; ?>" readonly />
                        </span>
                    </div>
                </div>

                <div class="card border-primary mb-3">
                    <div class="card-header">Dirección de permiso</div>
                    <div class="card-body text-primary">
                        <span class="card-text">
                            <div class="md-form mb-3">
                                <i class="fas fa-map prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" id="ncalle_consulta_<?php echo "$Idpermiso"; ?>" required />
                                <span class="ml-5">Calle y número</span>
                            </div>
                            <div class="md-form mb-3">
                                <i class="fas fa-map prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" id="ncolonia_<?php echo "$Idpermiso"; ?>" required />
                                <span class="ml-5">Colonia</span>
                            </div>
                            <div class="md-form mb-3">
                                <i class="fas fa-map prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" id="ncp_<?php echo "$Idpermiso"; ?>" required />
                                <span class="ml-5">CP</span>
                            </div>
                            <br>
                        </span>
                    </div>
                </div>

                <div class="md-form mb-3">
                    <div class="md-form amber-textarea active-amber-textarea">
                        <i class="fas fa-comment prefix grey-text"></i>
                        <textarea style="font-size: 1.4rem" class="md-textarea form-control" rows="2" 
                                  id="comentarios_consulta_<?php echo "$Idpermiso"; ?>" readonly></textarea>
                        <span class="ml-5">Comentarios</span>
                    </div>
                </div>
                <div class="md-form mb-3">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input style="font-size: 1.4rem" type="text" class="form-control" id="ruta_consulta_<?php echo "$Idpermiso"; ?>" readonly />
                    <span class="ml-5">Ruta</span>
                </div>

                <div class="md-form mb-3">
                    <div class="md-form amber-textarea active-amber-textarea">
                        <i class="fas fa-comment prefix grey-text"></i>
                        <textarea style="font-size: 1.4rem" class="md-textarea form-control" rows="2" 
                                  id="respuesta_consulta_<?php echo "$Idpermiso"; ?>" readonly></textarea>
                        <span class="ml-5">Respuesta</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn b-azul white-text w-100" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function consultar_diario(id, familia) {
        var data = {id: id, familia: familia};
        $.ajax({
            url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/get_consultar_diario.php",
            type: "GET",
            data: data,
            success: function (res) {
                console.log(res.alumno1);
                res = JSON.parse(res);
                $("#fecha_solicitud_consulta_" + id).val(res.fecha_solicitud);
                $("#correo_consulta_" + id).val(res.correo);
                $("#fecha_permiso_consulta_" + id).val(res.fecha_permiso);
                $("#calle_consulta_" + id).val(res.calle);
                $("#colonia_consulta_" + id).val(res.colonia);
                $("#cp_consulta_" + id).val(res.cp);
                $("#ncalle_consulta_" + id).val(res.ncalle);
                $("#ncolonia_" + id).val(res.ncolonia);
                $("#ncp_" + id).val(res.ncp);
                $("#comentarios_consulta_" + id).val(res.comentarios);
                $("#ruta_consulta_" + id).val(res.ruta);
                $("#respuesta_consulta_" + id).val(res.mensaje);
                if (res.alumnos.alumno1 != null) {
                    $("#alumnos_consulta_1_" + id).removeClass("d-none");
                    $("#alumnos_consulta_1_" + id).val(res.alumnos.alumno1);
                }
                if (res.alumnos.alumno2 != null) {
                    $("#alumnos_consulta_2_" + id).removeClass("d-none");
                    $("#alumnos_consulta_2_" + id).val(res.alumnos.alumno2);
                }
                if (res.alumnos.alumno3 != null) {
                    $("#alumnos_consulta_3_" + id).removeClass("d-none");
                    $("#alumnos_consulta_3_" + id).val(res.alumnos.alumno3);
                }
                if (res.alumnos.alumno4 != null) {
                    $("#alumnos_consulta_4_" + id).removeClass("d-none");
                    $("#alumnos_consulta_4_" + id).val(res.alumnos.alumno4);
                }
                if (res.alumnos.alumno5 != null) {
                    $("#alumnos_consulta_5_" + id).removeClass("d-none");
                    $("#alumnos_consulta_5_" + id).val(res.alumnos.alumno5);
                }

            }
        });
    }
</script>