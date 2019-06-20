
<div class="modal fade" id="modalInformacionPermiso" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Información de permiso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">          
                <div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Fecha de solicitud</span>
                        </div>
                        <input type="text" class="form-control" id="fecha_solicitud" readonly>
                    </div>                                
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Solicitante</span>
                        </div>
                        <input type="text" class="form-control" id="solicitante" readonly>
                    </div>                                
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Fecha programada</span>
                        </div>
                        <input type="text" class="form-control" id="fecha_permiso" readonly>
                    </div>                                
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Alumnos para el permiso</span>
                        </div>
                        <input type="text" class="form-control" id="" readonly>
                    </div>   
                    <div class="card w-100">
                        <div class="card-header">
                            Dirección de cambio
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Calle y Número</span>
                                    </div>
                                    <input type="text" class="form-control" id="calle" readonly>
                                </div>  
                            </li>
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Colonia</span>
                                    </div>
                                    <input type="text" class="form-control" id="colonia" readonly>
                                </div>  
                            </li>
                        </ul>
                    </div>
                    <br>    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Ruta</span>
                        </div>
                        <input type="text" class="form-control" id="ruta" readonly>
                    </div>                               
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Comentarios</span>
                        </div>                                    
                        <textarea class="form-control" id="comentarios" readonly></textarea>
                    </div>                             
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Respuesta</span>
                        </div>
                        <textarea class="form-control" id="respuesta" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success w-100" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

