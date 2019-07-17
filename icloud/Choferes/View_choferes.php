<?php
$root_icloud = $_SERVER['DOCUMENT_ROOT'] . "/pruebascd/icloud";
include ("$root_icloud/Choferes/common/ControlChoferes.php");
//zona horaria para America/Mexico_city
$consulta = mysqli_fetch_array($consulta);
$familia = str_pad($consulta[2], 4, 0, STR_PAD_LEFT);
 ?>
<span>
    <div style="text-align: right">
        <a class="waves-effect waves-light btn b-azul c-blanco"
        href="https://www.chmd.edu.mx/pruebascd/icloud/index.php">
            <i class="material-icons left">keyboard_backspace</i>Atrás
        </a>
        <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
            <i class="material-icons left">lock</i>Salir
        </a>
    </div>
</span>
<br>
<h4><font color="#124A7B">CHOFERES </font></h4>
<table id="gradient-style" summary="Meeting Results">
  <thead class="b-azul white-text">
      <th >Chofer</th>
      <th >Estatus</th>
      <th >Acciones</th>
    </thead>
<?php
$ctrol=new ControlChoferes();
$consulta1=$ctrol->listado_choferes($familia);
while($chofer = mysqli_fetch_array($consulta1))
{
  $id_chofer = $chofer['id'];
  $nombre = $chofer['nombre'];
  $estatus = $chofer['estatus'];

  //Estatus
  $status_detalle = "ERROR";
  $badge = "badge red c-blanco";
  switch ($estatus) {
    case 1:
    $status_detalle = "Pendiente";
    $badge = "badge blue c-blanco";
      break;
      case 2:
      $status_detalle = "Autorizado";
      $badge = "badge green c-blanco";
        break;
        case 3:
        $status_detalle = "Declinado";
        $badge = "badge orange c-blanco";
          break;
          case 4:
          $status_detalle = "Cancelado por usuario";
          $badge = "badge red c-blanco";
            break;
  }
//pregunto si el chofer fue cancelado y si la fecha de hoy es mayor  a la fecha de actualizacion
$mostrar_cancelado=false;
if ($estatus==4){
  //chofer cancelado
  $fecha_mod = $chofer['fecha'];
  $fecha_mod=  date("d-m-Y",strtotime ($fecha_mod));
  $fecha_actual=  date("d-m-Y");
//  echo "Fecha Actual: $fecha_actual, Fecha modificacion: $fecha_mod <br>";
  $fecha_mod = strtotime ($fecha_mod);
  $fecha_actual =  strtotime ($fecha_actual);
  //echo "Fecha Actual: $fecha_actual, Fecha modificacion: $fecha_mod <br>";
  //saber si la fecha fue modificada ese dia.
  if($fecha_actual==$fecha_mod){
    $mostrar_cancelado=true;
  }
}

if($estatus!=4){
  ?>
  <tr>
    <td><?=$nombre?></td>
    <td><span class="<?=$badge?>"><?=$status_detalle?></span></td>
    <td>
         <?php include './modales/modal_pdf_chofer.php'; ?>
          <?php include './modales/modal_cancelar_chofer.php'; ?>
    </td>
  </tr>
  <?php
}
else{
  if($mostrar_cancelado==true){
    ?>
    <tr>
      <td><?=$nombre?></td>
      <td><span class="<?=$badge?>"><?=$status_detalle?></span></td>
      <td></td>
    </tr>
    <?php
    }
  }

}
 ?>
  </table>
  <br>
  <h4><font color="#124A7B">AUTOMOVILES</font></h4>
  <p align='center'>
  </p>
  <table id="gradient-style" summary="Meeting Results">
    <thead class="b-azul white-text">
        <th >Marca</th>
        <th >Modelo</th>
        <th >Color</th>
        <th >Placas</th>
        <th >Modifcar</th>
  </thead>
<?php
$consulta2=$ctrol->listado_autos($familia);
while($auto = mysqli_fetch_array($consulta2))
{
  $id_auto=$auto['idcarro'];
  ?>
  <tr>
    <td><?=$auto['marca']?></td>
    <td><?=$auto['modelo']?></td>
    <td><?=$auto['color']?></td>
    <td><?=$auto['placas']?></td>
    <td>
      <a class="waves-effect waves-light btn green accent-3"
         href="./vistas/vista_editar_auto.php?idcarro=<?php echo $id_auto;?>">
          <i class="material-icons">edit</i>
      </a>
      <?php include './modales/modal_cancelar_auto.php'; ?>
    </td>
  </tr>
  <?php
}
 ?>
  </table>
  <h4><font color="#124A7B">PADRES</font></h4>
  <table id="gradient-style" summary="Meeting Results">
    <thead class="b-azul white-text">
        <th >Familiar</th>
        <th >Parentesco</th>
        <th >Foto</th>
    </thead>
    <?php
    $consulta3=$ctrol->get_padres($familia);
    while($padres = mysqli_fetch_array($consulta3)){
      $nombre= $padres['nombre'];
      $tipo= $padres['tipo'];
      $tipo_usuario='';
      switch ($tipo) {
        case 3:
          $tipo_usuario='Papá';
          break;
          case 4:
          $tipo_usuario='Mamá';
            break;
        default:
          $tipo_usuario='Otro';
          break;
      }

      $foto= $padres['fotografia'];
      if($foto==null){$foto="sinfoto.png"; $foto1="Sin foto";} else {$foto="../../CREDENCIALES/padres/$foto"; $foto1="Con Foto";}

      ?>
      <tr>
        <td><?=$nombre?></td>
        <td><?=$tipo_usuario?></td>
        <td><img src='../images/<?=$foto?>' width='60px' height='60px'  ><br></td>
      </tr>
      <?php
    }
     ?>

  </table>
