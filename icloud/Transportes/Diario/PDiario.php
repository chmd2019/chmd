<?php
include '../components/layout_top.php';
include '../components/sesion.php';
$user = $service->userinfo->get(); //get user info
$correo = $user->email;
$objCliente = new Login();
$consulta = $objCliente->Acceso($correo);
//zona horaria para America/Mexico_city 
require '../../Helpers/DateHelper.php';
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
$fecha_actual = date('m-d-Y');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
        . "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
        . "fecha = fecha.toLocaleDateString('es-MX', options);"
        . "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
        . "document.write(fecha)</script>";
if (isset($authUrl)) {
    //show login url
    ?>
    <div class="caja-login" align="center">
        <h2 class="alert alert-light text-primary text-center" role="alert">Mi Maguen</h2>
        <br><br>
        <?php echo '<a href="' . $authUrl . '"><img src="../../images/google.png" id="total"/></a>' ?>
    </div>
<?php } else {
include '../components/navbar.php';
    ?>
    <div class="row"><br><br>
        <div class="col-sm-12 col-md-9 b-blanco" style="margin:auto;">
            <br>
            <br>
            <h2 class="alert alert-light text-center c-azul" role="alert">Cambio del dia</h2>

            <div class="row">
                <div class="col-sm-12" style="margin:auto">
                    <center>  
                        <div class="container">
                            <?php include('View_Diario.php'); ?> 
                        </div>
                    </center> 
                </div>                
            </div>
            <br>
            <?php
        }
        ?>
        <?php include('form_diario_alta.php'); ?> 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  EDWIN PRUEBA AQUI ESTE MODAL PORFA
</button>
            <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header blue-gradient">
        <h5 class="modal-title white-text" id="exampleModalLabel">Nuevo permiso diario</h5>
        <button type="button" class="close white-text" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h4 class="text-warning">Información importante</h4>
                Los cambios para el mismo día deberán solicitarse antes de las 11:30 horas,
                ya que el sistema no permitirá realizar solicitudes después del horario establecido,
                sin embargo podrá hacer solicitudes para fechas posteriores.<br>
                <strong>NOTA:!</strong> Todas las solicitudes están sujetas a disponibilidad.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="md-form mb-5">
                    <i class="fas fa-calendar-check prefix grey-text"></i>      
                    <input style="font-size: 1.4rem" type="text" class="form-control" name="fecha" readonly
                        value="<?php echo $arrayDias[date('w')] . " , " . date('d') . " de " . $arrayMeses[date('m') - 1] . " de " . date('Y') . ", " . date("h:i a"); ?>" />

                    <label data-error="wrong" data-success="right" for="form3">Fecha de solicitud</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input style="font-size: 1.4rem" type="text" class="form-control" name="correo" value="<?php echo " $correo "; ?>"
                           readonly autocomplete="off" />
                    <label data-error="wrong" data-success="right" for="form3">Solicitante</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-calendar-alt prefix grey-text"></i>
                    <input style="font-size: 1.4rem" type="text" class="form-control" id="fecha1" name="fecha1" autocomplete="off"
                           value="<?php echo $fecha_permiso; ?>" autocomplete="off" required />
                    <label data-error="wrong" data-success="right" for="form3">Fecha del permiso</label>
                </div>
                <div class="md-form mb-5">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th bgcolor="#CDCDCD">Alumno</th>
                                <th bgcolor="#CDCDCD">Grupo</th>
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
                                <tr id="fila-<?php echo $cliente['id'] ?>">
                                    <!--<td bgcolor="#ffffff"><?php echo $cliente1['id'] ?></td>-->
                                    <td bgcolor="#ffffff">
                                        <?php echo $cliente1['nombre'] ?>
                                    </td>
                                    <td bgcolor="#ffffff">
                                        <?php echo $cliente1['grupo'] ?>
                                    </td>
                                    <!--<td bgcolor="#ffffff"><?php echo $cliente1['grado'] ?></td>-->
                                    <td>
                                        <input type="checkbox" id="alumno<?php echo $counter ?>"
                                               name="alumno[]" value="<?php echo $cliente1[id]; ?> " required
                                               title="Selecciona un alumno"/></center>
                                        <div class="invalid-feedback">Campo obligatorio</div>
                                    </td>
                                </tr>
                                <?php
                            }
                            $talumnos = $counter;
                        }
                        ?>
                    </table>
                </div>
                
                <div class="card border-primary mb-3">
                    <div class="card-header">Direcciín de la casa</div>
                    <div class="card-body text-primary">
                        <span class="card-text">
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                <input style="font-size: 1.4rem" type="text" class="form-control" name="calle1"
                                       value="<?php echo " $calle1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="form3">Calle y número</label>
                            </div>
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                        <input style="font-size: 1.4rem" type="text" class="form-control" name="colonia1"
                                            value="<?php echo " $colonia1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="form3">Colonia</label>
                            </div>
                            <div class="md-form">
                                <i class="fas fa-home prefix grey-text"></i>
                                        <input style="font-size: 1.4rem" type="text" class="form-control" name="cp1"
                                            value="<?php echo " $cp1 "; ?>" readonly autocomplete="off" />
                                <label data-error="wrong" data-success="right" for="form3">CP</label>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input type="text" id="form3" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="form3">CAMPO DE PRUEBA</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input type="text" id="form3" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="form3">CAMPO DE PRUEBA</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input type="text" id="form3" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="form3">CAMPO DE PRUEBA</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input type="text" id="form3" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="form3">CAMPO DE PRUEBA</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input type="text" id="form3" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="form3">CAMPO DE PRUEBA</label>
                </div>
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input type="text" id="form3" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="form3">CAMPO DE PRUEBA</label>
                </div>

            </div>
      <div class="modal-footer">
          <button type="button" class="btn peach-gradient white-text" data-dismiss="modal" style="border-radius:30px">Cancelar</button>
        <button type="button" class="btn blue-gradient white-text" style="border-radius:30px">Enviar</button>
      </div>
    </div>
  </div>
</div>
    </div>
</div>
<?php include '../components/layout_bottom.php'; ?>