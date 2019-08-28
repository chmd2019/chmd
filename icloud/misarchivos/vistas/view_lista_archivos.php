<?php
require_once "$root_icloud/Helpers/DateHelper.php";
require_once "$root_icloud/misarchivos/common/ControlMisArchivos.php";

//fecha actual
$objDateHelper = new DateHelper();
$objDateHelper->set_timezone();
$fecha_actual = date('m/d/Y');
$fecha_actual_impresa_script = "<script>var fecha = new Date('$fecha_actual');"
. "var options = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };"
. "fecha = fecha.toLocaleDateString('es-MX', options);"
. "fecha = `\${fecha.charAt(0).toUpperCase()}\${fecha.slice(1).toLowerCase()}`;"
. "document.write(fecha)</script>";
?>
<span>
  <h6><?php echo $fecha_actual_impresa_script; ?></h6>
  <div style="text-align: right;margin:1rem 1rem 0 0">
    <a class="waves-effect waves-light btn b-azul c-blanco"
    href="<?php echo $redirect_uri; ?>">
    <i class="material-icons left">keyboard_backspace</i>Atrás
  </a>
  <a class="waves-effect waves-light btn red" href="#!" onclick="logout()">
    <i class="material-icons left">lock</i>Salir
  </a>
</div>
</span>
<br>
<?php
$control_archivos= new ControlArchivos();
$lista_archivos = $control_archivos->listado_archivos();
$contador = mysqli_num_rows($lista_archivos);
if ($contador==0){
  ?>
  <br>
  <span class="badge blue c-blanco col s12">Sin Archivos para mostrar</span>
  <?php
}
else{
  ?>
  <table id="gradient-style" summary="Meeting Results">
    <thead class="b-azul white-text">
      <th  width="10%" >Documento</th>
      <th>Nombre</th>
      <th>Descargar</th>
    </thead>
    <tbody>
      <?php
      while ($archivo= mysqli_fetch_array($lista_archivos)){
        $nombre = $archivo['nombre'];
        $link= $archivo['link'];
        ?>
        <tr>
          <td width="10%"><img src="../images/file_pdf.png" alt="Doc" width="100%"> </td>
          <td><?=$nombre?></td>
          <td>
            <a class="waves-effect waves-light btn modal-trigger  blue accent-3"  href="<?=$link?>">
              <i class="material-icons">file_download</i>
            </a>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
  <?php
}
?>
