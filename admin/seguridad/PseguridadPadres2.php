<?php
include '../sesion_admin.php';
include '../conexion.php';

$root_imagenes=' http://chmd.chmd.edu.mx:65083';

if (!in_array('12', $capacidades)){
    header('Location: ../menu.php');
}

require_once ('../FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance ( true );
ob_start ();

$sql="SELECT id, nombre, numero, responsable, tipo, fotografia FROM usuarios WHERE ( responsable = 'PADRE' or responsable= 'MADRE' or responsable = 'CHOFER') and estatus!='4'  order by numero DESC";
$datos = mysqli_query ( $conexion,$sql );
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="img/favicon.png">
  <title>CHMD :: Seguridad padres</title>
  <link href="../dist/css/bootstrap.css" rel="stylesheet">

  <link href="../css/menu.css" rel="stylesheet">
      <!-- Dependencias Globales -->
  <?php include '../components/header.php'; ?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="../dist/js/bootstrap.js"></script>
<!-- jQuery Custom Scroller CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script type="text/javascript" src="js/PseguridadPadres.js"></script>

</head>
<body onload="ready()" >

   <div class="wrapper">
    <!-- Sidebar  -->
    <nav class="" id="sidebar">
      <div id="dismiss">
          <i class="fas fa-arrow-left"></i>
      </div>
        <div class="sidebar-header">
            <h3>SEGURIDAD</h3>
        </div>
        
        <?php $perfil_actual='22'; include ('../menus_dinamicos/perfiles_dinamicos_seguridad.php'); ?>
        
    </nav>

    <!-- Page Content  -->
    <div id="content">
  <?php include_once "../components/navbar.php"; ?>
  <div class="reload">

  </div>
<div class="container" id='principal'>
  <div class="masthead">

</div>
<br>
<center><?php echo isset($_POST['guardar'])?$verificar:''; ?></center>
<!-- Button trigger modal -->
<h2 class="text-center text-primary">Seguridad de Padres</h2>
<input type="text" class="form-control filter"
placeholder="Buscar Solicitud..."><br> <br>
 <div class="table-responsive-lg">
<table class="table" id="niveles_table" width="100%">
  <thead>
    <td width="10%" style="min-width: 100px"><b>Idusuario</b></td>
    <td width="10%" style="min-width: 100px"><b>Nfamilia</b></td>
    <td width="30%" style="min-width: 100px"><b>Responsable</b></td>
    <td width="20%" style="min-width: 100px"><b>Parentesco</b></td>
    <td style="text-align:center"><b>Fotografía</b></td>
  </thead>
  <tbody class="searchable" style="overflow: auto; max-height: 500px;">
    <?php while ( $dato = mysqli_fetch_assoc ( $datos ) )
    {

      $id_usuario= $dato['id'];
      $nfamilia= $dato['numero'];
      $responsable= $dato['nombre'];
      $nombre_usuario = $dato['nombre'];
      $tipo= $dato['tipo'];
      $parentesco= $dato['responsable'];
      $foto= $dato['fotografia'];
/*
      switch ($tipo) {
        case '3': $parentesco='Papá';
        break;
        case '4': $parentesco='Mamá';
        break;
        case '7': $parentesco='Chofer';
        break;
      }
*/
      //fotografia
      $foto = str_replace("C:\IDCARDDESIGN\CREDENCIALES\padres\\", '', $foto);
      //$foto = urlencode($foto);
      $mostrar=true;
      if ($foto == ''){
        $mostrar=false;
        $foto_alt ='sin foto';
      }else if($foto=='vencido'){
        $foto_alt ='foto Vencida';
        $foto="../images/vencido.png";
      }else{
        $foto_alt='con foto';
        $foto="$root_imagenes/CREDENCIALES/padres/$foto";
        try {

               if( empty( $foto ) ){
                   $mostrar = false;
               }

               $options['http'] = array(
                   'method' => "HEAD",
                   'ignore_errors' => 1,
                   'max_redirects' => 0
               );
               $body = @file_get_contents( urlencode($foto), NULL, stream_context_create( $options ) );

               // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php
               if( isset( $http_response_header ) ) {
                   sscanf( $http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode );

                   // Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
                   $accepted_response = array( 200, 301, 302 );
                   if( in_array( $httpcode, $accepted_response ) ) {
                    //   $mostrar = true;

                   } else {
                      //$mostrar = false;
                   }
                } else {
                  //$mostrar = false;
                }

        } catch (Exception $e) {
            // Handle exception
            echo ('Ha ocurrido un error');
        }

      }


    if ($mostrar){
      ?>
      <tr class="fila_alumnos" id="fila_<?=$id_usuario?>" data-link ="<?=$foto?>" >
        <td ><?php echo $id_usuario ?></td>
        <td ><?php echo $nfamilia?></td>
        <td><?php echo $responsable?></td>
        <td><?php echo $parentesco?></td>
        <td style="text-align:center" id="img_<?=$id_usuario?>" onclick="mostrar_familia(<?=$nfamilia?>,<?=$id_usuario?>);">
          <img style="border: 1px solid #aaa; padding: 2px" src='<?php echo $foto ?>'  onerror="no_mostrar(<?=$id_usuario?>)" alt="<?=$foto_alt?>" width="150px">
        </td>
      </tr>
      <?php
        }
      }?>
</tbody>
</table>
</div>
</div>
 <!-- Site footer -->
<?php include_once '../components/footer.php'; ?>
</div>
    <div class="overlay"></div>
  </div>


<!--  <script type="text/javascript" src="../js/1min_inactivo.js" ></script> -->

 <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript">
  $(document).ready(function () {
      $("#sidebar").mCustomScrollbar({
          theme: "minimal"
      });

      $('#dismiss, .overlay').on('click', function () {
          $('#sidebar').removeClass('active');
          $('.overlay').removeClass('active');
      });

      $('#sidebarCollapse').on('click', function () {
          $('#sidebar').addClass('active');
          $('.overlay').addClass('active');
          $('.collapse.in').toggleClass('in');
          $('a[aria-expanded=true]').attr('aria-expanded', 'false');
      });



  });

  function ready(){
    //Cargar Todas las imagenes primero
      alert('Listo, Cambio de tabla');

        $(".filter").css("display","none");
       // agregar paginacion
          $('#niveles_table').DataTable( {
              "order": [[ 1, "desc" ]],
              paging:true,
              ordering:  true,
              searching:true,
              language: {
                  search: "Buscar:",
                  lengthMenu: "Se muestran _MENU_ registros por pagina",
                  zeroRecords: "No hay registros",
                  info: "Mostrando _PAGE_ de _PAGES_",
                  infoEmpty: "No hay registros",
                    paginate: {
                          first:      "Primero",
                          previous:   "Anterior",
                          next:       "Proximo",
                          last:       "Ultimo"
                                },
                  infoFiltered: "(filtrados de _MAX_ total de registros)"

              }
          } );
  }
</script>
</body>
</html>
