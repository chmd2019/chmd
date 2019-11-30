<?php
require '../../conexion.php';
//si existe la conexion
$error = false;
$error_doc = 'Sin Errores';
if ($conexion) {
      // Conseguir fecha
      $fecha = date('Y-m-d');
      $dia = date('w');
      // echo $fecha;
      // validar que existe una salida programada pra hoy;
      $sql= "SELECT DISTINCT fecha_programada FROM rutas_generales_alumnos ";
      $query =mysqli_query($conexion, $sql);
      While($r = mysqli_fetch_array($query)){
        $fecha_programada = $r[0];
        if ($fecha_programada != ''){
          //normalizo la fecha
            $array1 = explode(',' , $fecha_programada ); $array2= explode(' ',$array1[1]);
            $dia= $array2[1]; $mes= '';
            $_mes= strtolower($array2[2]);
            switch ($_mes) {
                  case 'enero':
                  $mes=1;
                  break;
                  case 'febrero':
                  $mes=2;
                  break;
                  case 'marzo':
                  $mes=3;
                  break;
                  case 'abril':
                  $mes=4;
                  break;
                  case 'mayo':
                  $mes=5;
                  break;
                  case 'junio':
                  $mes=6;
                  break;
                  case 'julio':
                  $mes=7;
                  break;
                  case 'agosto':
                  $mes=8;
                  break;
                  case 'septiembre':
                  $mes=9;
                  break;
                  case 'octubre':
                  $mes=10;
                  break;
                  case 'noviembre':
                  $mes=11;
                  break;
                  case 'diciembre':
                    $mes=12;
                  break;
                  default:
                  $mes = -1;
                break;
            }
              $anio = $array2[3] % 100;
              // fechas normalizadas
              $_fecha_today = date('d/m/y', time());
              $_fecha_programada =   $dia.'/'. $mes.'/'.$anio;
              // $mgs= 'fecha hoy: '.$_fecha_today.' fecha programada: '.$_fecha_programada;
              if ($_fecha_today == $_fecha_programada){
                //es el dia de la salida general - Copio todas las
                // (1) elimino rutas historicas y de alumnos
                      //eliminar datos de la fecha actual
                     $sql="DELETE FROM rutas_historica WHERE fecha='$fecha'";
                     $sql2="DELETE FROM rutas_historica_alumnos WHERE fecha='$fecha'";
                     $query = mysqli_query($conexion,$sql);
                     $query2 = mysqli_query($conexion,$sql2);
                     if(!$query and !$query2){
                       $error=true;
                       $error_doc="Error al eliminar datos de la fecha de Hoy";
                       die('Error al Eliminar');
                     }
                // (2) Reconstruyó base de datos solo los de la mañana
                      //copiar rutas
                      $sql= "INSERT INTO rutas_historica (id_ruta_h, nombre_ruta, camion, auxiliar, cupos, fecha) SELECT id_ruta, nombre_ruta, camion, auxiliar, cupos , '$fecha' FROM rutas";
                      $query = mysqli_query($conexion, $sql);
                      if(!$query){
                        $error=true;
                        $error_doc="Error al Insertar las rutas del día";
                        die('Error al insertar Los datos');
                      }

                      $sql="INSERT INTO rutas_historica_alumnos (id_alumno, id_ruta_h,  domicilio, hora_manana, orden_in, fecha, estatus )
                      SELECT id_alumno, id_ruta_base_m, domicilio_m, hora_manana, orden_in, '$fecha' , '6' FROM rutas_base_alumnos";

                        $query = mysqli_query($conexion, $sql);
                        if(!$query){
                          $error=true;
                          $error_doc="Error al Insertar los datos de la fecha de Hoy";
                          die('Error al insertar Los datos');
                        }

              // (3) Asigno la salida general configurada.
                //(3.1) Verifico que todo los alumnos fueron revisados.
                $sql = "SELECT COUNT(*) FROM rutas_generales_alumnos WHERE isnull(orden) or isnull(hora_regreso)";
                $query_revision = mysqli_query($conexion, $sql);
                if ($w = mysqli_fetch_array($query_revision) ){
                  if ($w[0]==0){
                    //revision aprobada.
                    // (1) Buscar alumnos a configurar
                    $sql = "SELECT * FROM rutas_generales_alumnos";
                    $query_busqueda = mysqli_query($conexion, $sql );
                    while($x = mysqli_fetch_array($query_busqueda)){
                      $id_alumno = $x['id_alumno'];
                      $id_ruta_s = $x['id_ruta_general'];
                      $domicilio_s = $x['domicilio'];
                      $orden = $x['orden'];
                      $hora_regreso = $x['hora_regreso'];

                      // (2) Actualizar el regreso de los alumnos con las rutas de salida.
                      $sql_update = "UPDATE rutas_historica_alumnos SET id_ruta_h_s='$id_ruta_s', orden_out='$orden', domicilio_s='$domicilio_s',hora_regreso='$hora_regreso', estatus='6'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
                      $query_update = mysqli_query($conexion, $sql_update);
                      if($query_update){
                        mysqli_query($conexion, 'COMMIT');
                      }else{
                        $error=true;
                        $error_doc="Error al actualizar datos de la fecha de Hoy en DIARIOS";
                        die('Error en DIARIOS');
                      }

                    }

                  }else{
                    //revicion desaprobada.
                    $error=true;
                    $error_doc="Verifique que todas las rutas generales estan Aprobadas.";
                  }
                }


              }else{
                //El día de hoy no hay salida general
                $error=true;
                $error_doc="El día de Hoy no hay salida general.";
              }
            }else{
              //sin fecha programada configurada
              $error=true;
              $error_doc="No Hay Fecha programada.";
            }
//fin de cambios por permisos.
}
echo json_encode(array ("error"=>$error, "error_doc"=>$error_doc ));
}
?>
