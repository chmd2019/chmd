<table border="0" WIDTH="100%">
  <tr>
    <td WIDTH="100%" colspan="4"><br>
      <h4><b>Choferes Cancelados</b></h4><br>
    </td>
  </tr>
  <tr>
    <td WIDTH="25%" colspan="1">Nombre:</td>
    <td WIDTH="25%" colspan="1">Estatus:</td>
    <td WIDTH="25%" colspan="1">Fecha de Cancelacion:</td>
  </tr>

<?php
$sql = mysqli_query ( $conexion,"SELECT id,nombre,numero,fecha, familia,estatus,tipo,correo  FROM usuarios WHERE tipo='7' and estatus=4 and numero=$familia ORDER BY  fecha DESC  ");
  while ( $chofer = mysqli_fetch_assoc ( $sql ) ){
    $nombre= $chofer['nombre'];
    $nfamilia= $chofer['numero'];
    $familia_letras= $chofer['familia'];
    $estatus= $chofer['estatus'];
    $fecha= $chofer['fecha'];
    if($estatus==1){$staus1="Pendiente";}
    if($estatus==2){$staus1="Autorizado";}
    if($estatus==3){$staus1="Declinado";}
    if($estatus==4){$staus1="Cancelado por el usuario";}
  ?>
  <tr style="margin-bottom:2px">
    <td WIDTH="33%" colspan="1">
      <input
      name="nombre" id="nombre" type="text"
      class="form-control" placeholder="Sin papa"   value="<?php echo $nombre ?>" readonly="" >
    </td>
    <td  WIDTH="33%" colspan="1">
      <input
      name="estatus" id="estatus" type="text"
      class="form-control" placeholder="Sin papa"   value="<?php echo $staus1 ?>" readonly="" >
    </td>
    <td  WIDTH="34%" colspan="1">
      <input
      name="fecha" id="fecha" type="text"
      class="form-control" placeholder="Sin papa"   value="<?php echo $fecha ?>" readonly="" >
    </td>
  </tr>
  <?php
  }
 ?>
  <tr>
    <td><br> </td>
  </tr>
</table>
