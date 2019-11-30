<?php
require '../../conexion.php';

$error=false;
$error_doc ='sin error';
if (isset($_POST['id_ruta'] )){
$id_ruta = $_POST['id_ruta'];
   if ($conexion) {
   //Actualizar e insertar alumnos en la mañana
      if (isset($_POST['alumnos_m'])){
        $alumnos_m = $_POST['alumnos_m'];
        foreach ($alumnos_m as $key => $alumno) {
            $id_alumno = $alumno['id_alumno'];
            //verifico si existe el alumno
            $sql = "SELECT COUNT(*) FROM rutas_pase_ano_alumnos WHERE id_alumno='$id_alumno'";
            $query_existe = mysqli_query($conexion, $sql);
            if ($r = mysqli_fetch_array($query_existe) ){
              $existe = $r[0];
            }

            if ($existe>0){
              //existe - Actualizar alumno
              $sql = "UPDATE rutas_pase_ano_alumnos SET id_ruta_base_m='".$alumno['id_ruta']."' , domicilio_m='".$alumno['domicilio']."' , hora_manana ='".$alumno['hora_manana']."' , orden_in = '".$alumno['orden_in'] ."' WHERE id_alumno='".$alumno['id_alumno']."'";
            }else{
              //no existe - insertar alumno
              $sql = "INSERT INTO rutas_pase_ano_alumnos( id_alumno, id_ruta_base_m, domicilio_m, hora_manana,
              orden_in) VALUES ( '" . $alumno['id_alumno'] . "', '" . $alumno['id_ruta']  . "',
              '" . $alumno['domicilio']  . "', '" . $alumno['hora_manana']  . "',  '" . $alumno['orden_in']  . "' )";
            }
            //ejecutar instruccion
            mysqli_set_charset($conexion, "utf8");
            $insertar = mysqli_query($conexion, $sql);
            if (!$insertar) {
               die("error:" . mysqli_error($conexion));
              $error = true; $error_doc='01: Error al insertar/actualizar alumno en la mañana. ';
            }
        }
      }

      //Actualizar e insertar alumnos en la tarde
      if (isset($_POST['alumnos_t'])){
        $alumnos_t = $_POST['alumnos_t'];
        foreach ($alumnos_t as $key => $alumno) {
            $id_alumno = $alumno['id_alumno'];
            //verifico si existe el alumno
            $sql = "SELECT COUNT(*) FROM rutas_pase_ano_alumnos WHERE id_alumno='$id_alumno'";
            $query_existe = mysqli_query($conexion, $sql);
            if ($r = mysqli_fetch_array($query_existe) ){
              $existe = $r[0];
            }

            if ($existe>0){
              //existe - Actualizar alumno
              $sql = "UPDATE rutas_pase_ano_alumnos SET id_ruta_base_t='".$alumno['id_ruta']."' , domicilio_t='".$alumno['domicilio']."' , hora_lu_ju ='".$alumno['hora_lu_ju']."' , hora_vie ='".$alumno['hora_vie']."' , orden_out = '".$alumno['orden_out'] ."' WHERE id_alumno='".$alumno['id_alumno']."'";
            }else{
              //no existe - insertar alumno
              $sql = "INSERT INTO rutas_pase_ano_alumnos( id_alumno, id_ruta_base_t, domicilio_t,   hora_lu_ju,
              hora_vie, orden_out ) VALUES ( '" . $alumno['id_alumno'] . "', '" . $alumno['id_ruta']  . "',
              '" . $alumno['domicilio']  . "', '" . $alumno['hora_lu_ju']  . "', '" . $alumno['hora_vie']  . "',  '" . $alumno['orden_out']  . "' )";
            }
            //ejecutar instruccion
            mysqli_set_charset($conexion, "utf8");
            $insertar = mysqli_query($conexion, $sql);
            if (!$insertar) {
               die("error:" . mysqli_error($conexion));
              $error = true; $error_doc='01: Error al insertar/actualizar alumno en la tarde. ';
            }
        }
      }

     } else {
           $error = true;
          $error_doc='03: Error de Conexion. ';
    }
    mysqli_close($conexion);
}

//verificar error
if (!$error){
          echo json_encode(array ("estatus"=> true, "error"=>$error_doc) );
        }else{
          echo json_encode(array ("estatus"=> false , "error"=>$error_doc) );
        }

?>
