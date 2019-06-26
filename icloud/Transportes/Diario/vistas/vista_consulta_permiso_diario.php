<?php
$Idpermiso = $_GET['id'];
$familia = $_GET['familia'];
include '../../components/layout_top.php';
include '../../components/navbar.php';
?>
<div class="row">
    <div class="col s12 l8 border-azul b-blanco" style="float: none;margin: 0 auto;padding:1rem">
        <div id="loading" hidden>
            <div class="progress light-blue lighten-3">
                <div class="indeterminate white"></div>
            </div>
        </div>
        <div>
            <h4 class="c-azul center-align">Consulta de permiso</h4>
            <br>
            <div class="row"> 
                <div class="col s12 l6">
                    <label for="fecha_solicitud_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Fecha de solicitud</label>
                    <div class="input-field">
                        <i class="material-icons prefix c-azul">calendar_today</i>
                        <input readonly  id="fecha_solicitud_consulta_<?php echo "$Idpermiso"; ?>" style="font-size: 1rem" type="text" >               
                    </div>
                </div>
                <div class="col s12 l6">
                    <label for="correo_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Solicitante</label>
                    <div class="input-field">
                        <i class="material-icons prefix c-azul">person</i>
                        <input readonly  id="correo_consulta_<?php echo "$Idpermiso"; ?>" type="text"  style="font-size: 1rem"  >               
                    </div>
                </div>
                <div>
                    <label for="fecha_permiso_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Fecha del permiso</label>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">calendar_today</i>
                        <input readonly  id="fecha_permiso_consulta_<?php echo "$Idpermiso"; ?>" type="text" style="font-size: 1rem"  >               
                    </div>
                </div>
                <div>
                    <h4 class="c-azul text-center">Dirección guardada</h4>
                    <label for="calle_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Calle y número</label>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">person_pin</i>
                        <textarea readonly  id="calle_consulta_<?php echo "$Idpermiso"; ?>" class="materialize-textarea" style="font-size: .9rem">   </textarea>            
                    </div>
                    <br>
                    <label for="colonia_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Colonia</label>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">person_pin</i>
                        <textarea readonly  id="colonia_consulta_<?php echo "$Idpermiso"; ?>" class="materialize-textarea" style="font-size: .9rem">   </textarea>            
                    </div>
                    <br>
                    <div>
                        <label for="cp_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">CP</label>
                        <div class="input-field col s12">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly  id="cp_consulta_<?php echo "$Idpermiso"; ?>" type="text" style="font-size: 1rem"  >               
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="c-azul text-center">Alumnos</h4>
                    <div style="padding:.9rem">
                        <span>
                            <div>
                                <input type="text" class="input-field" 
                                       id="alumnos_consulta_1_<?php echo "$Idpermiso"; ?>" readonly hidden  style="font-size: 1rem" />
                                <br>
                            </div>
                            <div> 
                                <input type="text" class="input-field" 
                                       id="alumnos_consulta_2_<?php echo "$Idpermiso"; ?>" readonly hidden  style="font-size: 1rem" />
                                <br>
                            </div>
                            <div>
                                <input type="text" class="input-field" 
                                       id="alumnos_consulta_3_<?php echo "$Idpermiso"; ?>" readonly hidden style="font-size: 1rem"  />
                                <br>
                            </div>
                            <div>
                                <input type="text" class="input-field" 
                                       id="alumnos_consulta_4_<?php echo "$Idpermiso"; ?>" readonly hidden  style="font-size: 1rem" />
                                <br>
                            </div>
                            <div>
                                <input type="text" class="input-field" 
                                       id="alumnos_consulta_5_<?php echo "$Idpermiso"; ?>" readonly hidden  style="font-size: 1rem" />
                                <br>
                            </div>
                        </span>
                    </div>
                </div>
                <div>
                    <h4 class="c-azul text-center">Dirección de permiso</h4>
                    <label for="ncalle_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Calle y número</label>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">person_pin</i>
                        <textarea readonly  id="ncalle_consulta_<?php echo "$Idpermiso"; ?>" class="materialize-textarea" style="font-size: .9rem">   </textarea>            
                    </div>
                    <br>
                    <label for="ncolonia_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Colonia</label>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">person_pin</i>
                        <textarea readonly  id="ncolonia_consulta_<?php echo "$Idpermiso"; ?>" class="materialize-textarea" style="font-size: .9rem">   </textarea>            
                    </div>
                    <br>
                    <div>
                        <label for="ncp_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">CP</label>
                        <div class="input-field col s12">
                            <i class="material-icons prefix c-azul">person_pin</i>
                            <input readonly  id="ncp_consulta_<?php echo "$Idpermiso"; ?>" type="text" >               
                        </div>
                    </div>
                </div>
                <div>
                    <label for="comentarios_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Comentarios</label>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">comment</i>
                        <textarea readonly  id="comentarios_consulta_<?php echo "$Idpermiso"; ?>" class="materialize-textarea" style="font-size: .9rem">   </textarea>            
                    </div>
                </div>
                <div >
                    <label for="ruta_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Ruta</label>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">hourglass_full</i>
                        <input readonly  id="ruta_consulta_<?php echo "$Idpermiso"; ?>" type="text" >               
                    </div>
                </div>
                <div>
                    <label for="respuesta_consulta_<?php echo "$Idpermiso"; ?>" style="margin-left: 1rem">Respuesta</label>
                    <div class="input-field col s12">
                        <i class="material-icons prefix c-azul">comment</i>
                        <textarea readonly  id="respuesta_consulta_<?php echo "$Idpermiso"; ?>" class="materialize-textarea" style="font-size: .9rem">   </textarea>            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fixed-action-btn">
    <a class="btn-floating btn-large b-azul" href="javascript:history.back(0)">
        <i class="large material-icons">keyboard_backspace</i>
    </a>
</div>
<script>
    $(document).ready(function () {
        $('.fixed-action-btn').floatingActionButton({
            hoverEnabled: false
        });
        var id = '<?php echo "$Idpermiso"; ?>';
        var familia = '<?php echo "$familia"; ?>';
        var data = {id: id, familia: familia};
        $.ajax({
            url: "https://www.chmd.edu.mx/pruebascd/icloud/Transportes/Diario/posts_gets/get_consultar_diario.php",
            type: "GET",
            data: data,
            beforeSend: function () {
                $("#loading").show();
            },
            success: function (res) {
                res = JSON.parse(res);
                $("#fecha_solicitud_consulta_" + id).val(res.fecha_solicitud);
                $("#correo_consulta_" + id).val(res.correo);
                $("#fecha_permiso_consulta_" + id).val(res.fecha_permiso);
                $("#calle_consulta_" + id).val(res.calle);
                $("#colonia_consulta_" + id).val(res.colonia);
                $("#cp_consulta_" + id).val(res.cp);
                $("#ncalle_consulta_" + id).val(res.ncalle);
                $("#ncolonia_consulta_" + id).val(res.ncolonia);
                $("#ncp_consulta_" + id).val(res.ncp);
                $("#comentarios_consulta_" + id).val(res.comentarios);
                $("#ruta_consulta_" + id).val(res.ruta);
                $("#respuesta_consulta_" + id).val(res.mensaje);
                //autoresize del textarea

                M.textareaAutoResize($('#calle_consulta_' + id));
                M.textareaAutoResize($('#colonia_consulta_' + id));
                M.textareaAutoResize($('#ncalle_consulta_' + id));
                M.textareaAutoResize($('#ncolonia_consulta_' + id));
                M.textareaAutoResize($('#calle_consulta_' + id));
                M.textareaAutoResize($('#comentarios_consulta_' + id));
                M.textareaAutoResize($('#respuesta_consulta_' + id));

                if (res.alumnos.alumno1 != null) {
                    $("#alumnos_consulta_1_" + id).show();
                    $("#alumnos_consulta_1_" + id).val(res.alumnos.alumno1);
                }
                if (res.alumnos.alumno2 != null) {
                    $("#alumnos_consulta_2_" + id).show();
                    $("#alumnos_consulta_2_" + id).val(res.alumnos.alumno2);
                }
                if (res.alumnos.alumno3 != null) {
                    $("#alumnos_consulta_3_" + id).show();
                    $("#alumnos_consulta_3_" + id).val(res.alumnos.alumno3);
                }
                if (res.alumnos.alumno4 != null) {
                    $("#alumnos_consulta_4_" + id).show();
                    $("#alumnos_consulta_4_" + id).val(res.alumnos.alumno4);
                }
                if (res.alumnos.alumno5 != null) {
                    $("#alumnos_consulta_5_" + id).show();
                    $("#alumnos_consulta_5_" + id).val(res.alumnos.alumno5);
                }
            },
            complete: function () {
                $("#loading").hide();
            }
        });
    });
</script>

<?php include '../../components/layout_bottom.php'; ?>