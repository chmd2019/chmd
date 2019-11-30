<?php
//Codigo de familia
$familia=$_GET["nfamilia"];
//Cantidad de choferes registrados
$sql = "SELECT count(*) as nchoferes from usuarios WHERE tipo=7 and estatus>=1 and estatus<=3 and numero=$familia   ;";
mysqli_set_charset($conexion, 'utf8');
$query=mysqli_query($conexion, $sql);
if ($chofer=mysqli_fetch_array( $query)) { $nchoferes= $chofer['nchoferes'];}
//Cantidad de choferes canceador
$sql = "SELECT count(*) as nchoferes from usuarios WHERE tipo=7 and estatus=4 and numero=$familia ;";
mysqli_set_charset($conexion, 'utf8');
$query=mysqli_query($conexion, $sql);
if ($chofer=mysqli_fetch_array( $query)) { $nchoferes_cancelados= $chofer['nchoferes'];}
//Cantidad de autos
$sql = "SELECT count(*) as nautos from tarjeton_automoviles where  idfamilia=$familia limit 2;";
mysqli_set_charset($conexion, 'utf8');
$query=mysqli_query($conexion, $sql);
if ($auto=mysqli_fetch_array( $query)) { $nautos= $auto['nautos'];}
?>

<center>
  <form id="chofer"  name="chofer" class="form-signin save-nivel" method='post'   onsubmit='enviar_formulario(<?=$nchoferes?>,<?=$nautos?>,<?=$familia?> ); return false'>
    <div class="alert-save"></div>
    <div class="modal-body">

      <?php
      include './componentes/show_padres.php' ;

      if ($nautos==0){
        ?>
        <br>
        <h6><b>No Existen Automoviles Registrados</b></h6><br>
        <?php
      }else{
        include './componentes/show_autos.php' ;
      }
      if ($nchoferes==0){
        ?>
        <h6><b>No Existen Choferes Registrados</b></h6><br>
        <?php
      }else{
        include './componentes/show_choferes.php' ;
      }
      if ($nchoferes_cancelados==0){
          ?>
          <h6><b>No Existen Choferes Cancelados</b></h6><br>
          <?php
      }else{
        include './componentes/show_choferes_cancelados.php' ;
      }
      ?>

        <input type="hidden" name="nchoferes" id="nchoferes"  value="<?php echo $nchoferes ?>" />
      <input type="hidden" name="nfamilia" id="nfamilia"  value="<?php echo $familia ?>" />
    </div>
    <div class="modal-footer">
      <button type="button" onclick="limpiar(); return false;" class="btn btn-danger" data-dismiss="modal">LIMPIAR BUSQUEDA</button>
    </div>
  </form>
</center>
<script type="text/javascript">
  function limpiar(){
      window.location = "./PChoferesPorFamilia.php";
      return true;
  }
</script>
