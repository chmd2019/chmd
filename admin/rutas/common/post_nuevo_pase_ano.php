<?php
require '../../conexion.php';
$error_doc='Sin Errores';
$error=0;
if (isset($_POST["generar"] )){
  if ($conexion) {
      // verificar queno existe pase de años previos
      $sql = "SELECT COUNT(*) FROM rutas_pase_ano_alumnos";
      $query = mysqli_query($conexion, $sql);
      if ($r = mysqli_fetch_array($query)){
        if ($r[0]> 0){
          //Trunca la tabla de rutas_pase_ano_alumnos
          $sql_delete="TRUNCATE TABLE rutas_pase_ano_alumnos;";
          mysqli_set_charset($conexion, "utf8");
          $consulta = mysqli_query($conexion, $sql_delete);
          if( !$consulta) {
          $error ++;
          $error_doc= 'Error al Truncar tabla. ';
          }
        }}

          //Copia de ruta base
          $sql = "INSERT INTO rutas_pase_ano_alumnos (id_alumno, id_ruta_base_m , domicilio_m, hora_manana , orden_in, id_ruta_base_t, domicilio_t, orden_out, hora_lu_ju, hora_vie)
                  SELECT rb.id_alumno, rb.id_ruta_base_m, rb.domicilio_m, rb.hora_manana, rb.orden_in, rb.id_ruta_base_t, rb.domicilio_t, rb.orden_out, rb.hora_lu_ju, rb.hora_vie
                  FROM rutas_base_alumnos rb
                  LEFT JOIN alumnoschmd a ON a.id= rb.id_alumno
                  WHERE a.idcursar != 16 and a.idcursar != 4";

          mysqli_set_charset($conexion, "utf8");
          $consulta = mysqli_query($conexion, $sql);
          if( !$consulta) {
          $error ++;
          $error_doc= 'Error al INsertar tabla. ';

          }

      if( $error>0) {
        echo json_encode(array ("estatus"=> false, "error_doc"=>$error_doc) );
      }else{
        echo json_encode(array ("estatus"=> true, "error_doc"=>$error_doc) );
      }
    } else {
        $error_doc = 'Error ';
        echo json_encode(array ("estatus"=> false, "error_doc"=>$error_doc) );
    }
        mysqli_close($conexion);
}else{
  $error_doc = 'Error de POST ';
  echo json_encode(array ("estatus"=> false, "error_doc"=>$error_doc) );
}

?>
