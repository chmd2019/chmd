<div class="modal fade" id="modalNuevoPermiso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo permiso</h5>
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
                        <input type="text" class="form-control" name="fecha" readonly value ="<?php echo $arrayDias[date('w')] . " , " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" />
                    </div>                                
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Solicitante</span>
                        </div>
                        <input type="text" class="form-control" name="correo" value="<?php echo " $correo "; ?>" readonly />
                    </div>                                
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Fecha del permiso</span>
                        </div>
                        <input type="text" class="form-control" id="fecha1" name="fecha1" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" <?php echo $enabled; ?> />
                    </div>   
                    <!--<div class="input-group mb-3">
                        <div class="card w-100">
                            <div class="card-header">
                                Alumnos para el permiso
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="input-group mb-3">

                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">Alumno x</label>
                                        </div>
                                    </div>  
                                </li>
                            </ul>
                        </div> 
                    </div> -->
                    <div class="input-group mb-3">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <!--<th bgcolor="#CDCDCD">Id</th>-->
                                    <th bgcolor="#CDCDCD">Alumno</th>
                                    <th bgcolor="#CDCDCD">Grupo</th>
                                    <!--<th bgcolor="#CDCDCD">Grado</th>-->
                                    <th bgcolor="#CDCDCD">Activar</th>
                                </tr>
                            </thead>
                            <?php
                            $consulta1 = $objCliente->mostrar_alumnos($familia);
                            if ($consulta1) {
                                $counter = 0;
                                // $numero = mysql_num_rows($consulta);
                                while ($cliente1 = mysqli_fetch_array($consulta1)) {
                                    $counter = $counter + 1;
                                    ?>
                                    <tr>
                                        <td><?php echo $cliente1['nombre']; ?></td>
                                        <td><?php echo $cliente1['grupo']; ?></td>
                                        <td>
                                            <div class="custom-control m-auto custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck<?php echo $cliente1['id']; ?>"/>
                                                <label class="custom-control-label" name="alumno<?php echo $counter ?>" for="customCheck<?php echo $cliente1['id']; ?>"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                $talumnos = $counter;
                            }
                            ?>
                        </table>
                    </div>

                    <div class="card w-100  mb-3">
                        <div class="card-header">
                            Dirección de casa
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Calle y Número</span>
                                    </div>
                                    <input type="text" class="form-control" name="calle1" value="<?php echo " $calle1 "; ?>" readonly/>
                                </div>  
                            </li>
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Colonia</span>
                                    </div>
                                    <input type="text" class="form-control" name="colonia1"  value="<?php echo " $colonia1 "; ?>" readonly/>
                                </div>  
                            </li>
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >CP</span>
                                    </div>
                                    <input type="text" class="form-control" name="cp1" value="<?php echo " $cp1 "; ?>" readonly />
                                </div>  
                            </li>
                        </ul>
                    </div>   
                    <div class="card w-100 mb-3">
                        <div class="card-header">
                            Dirección de cambio
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Dirección guardada</span>
                                    </div>
                                    <select class="custom-select" name="reside" id="reside">
                                        <option selected>Seleccione</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </select>
                                </div> 
                            </li>
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Calle y Número</span>
                                    </div>
                                    <input type="text" class="form-control" name="calle" value="" placeholder="Agrega calle y número" minlength="5" maxlength="40" onkeyup="this.value = this.value.toUpperCase()" required pattern="[A-Za-z ]+[0-9 ][A-Za-z0-9 ]{1,40}" title="Agrega calle y número:TECAMACHALCO 370, sin acentos ni signos especiales"/>
                                </div>  
                            </li>
                            <li class="list-group-item">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Colonia</span>
                                    </div>
                                    <input type="text" class="form-control" name="colonia" placeholder="Agrega colonia" onkeyup="this.value = this.value.toUpperCase()" minlength="5" maxlength="30" required pattern="[A-Za-z ]{5,30}" title="Agrega colinia sin acentos ni signos especiales"
                                           required />
                                </div>  
                            </li>
                        </ul>
                    </div>                             

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Ruta</span>
                        </div>
                        <select class="custom-select" name="ruta">
                            <option selected>Seleccione ruta</option>
                            <option value="General 2:50 PM">General 2:50 PM</option>
                            <option value="Taller 4:30 PM">Taller 4:30 PM</option>
                        </select>
                    </div>                               
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Comentarios</span>
                        </div>                                    
                        <textarea class="form-control" name="comentarios" onkeyup="this.value = this.value.toUpperCase()" ></textarea>
                    </div>    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-squared w-100" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>