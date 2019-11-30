<?php
require '../../conexion.php';
$error_doc='Sin Errores';
$error=0;
if (isset($_POST["migracion"] )){
  if ($conexion) {
      // Cambio de ciclo escolar
      $sql ="SELECT id , ciclo FROM Ciclo_escolar WHERE estatus = 1 LIMIT 1";
      $query = mysqli_query($conexion, $sql);
      if ($w = mysqli_fetch_array($query)){
        $id_ciclo_escolar=$w[0];
        $ciclo_escolar=$w[1];

        $sql_update="UPDATE Ciclo_escolar SET estatus=0 WHERE id='$id_ciclo_escolar'";
        $consulta_update = mysqli_query($conexion,$sql_update);
        if( !$consulta_update) {
        $error ++;
        $error_doc= 'Error al actualizar ciclo escolar. ';
        }
        //inserto nuevo año escolar
        $array_ciclo = explode("-",$ciclo_escolar);
        $new_ciclo = $array_ciclo[1].'-'.( $array_ciclo[1] + 1 );
        $sql_insert ="INSERT INTO Ciclo_escolar (ciclo,estatus) VALUES('$new_ciclo', 1)";
        $insert = mysqli_query($conexion, $sql_insert);
        if(!$insert){
          $error ++;
          $error_doc= 'Error al insertar el nuevo ciclo escolar. ';
        }
      }


      // verificar que existe paso de Año configurado.
      $sql = "SELECT COUNT(*) FROM rutas_pase_ano_alumnos";
      $query = mysqli_query($conexion, $sql);
      if ($r = mysqli_fetch_array($query)){
        if ($r[0]> 0){
          //Trunca la tabla de rutas_pase_ano_alumnos
          $sql_delete="TRUNCATE TABLE rutas_base_alumnos;";
          mysqli_set_charset($conexion, "utf8");
          $consulta = mysqli_query($conexion, $sql_delete);
          if( !$consulta) {
          $error ++;
          $error_doc= 'Error al Truncar tabla. ';
          }

          //Copia de ruta de pase de año a ruta base.
          $sql = "INSERT INTO rutas_base_alumnos (id_alumno, id_ruta_base_m , domicilio_m, hora_manana , orden_in, id_ruta_base_t, domicilio_t, orden_out, hora_lu_ju, hora_vie)
          SELECT rb.id_alumno, rb.id_ruta_base_m, rb.domicilio_m, rb.hora_manana, rb.orden_in, rb.id_ruta_base_t, rb.domicilio_t, rb.orden_out, rb.hora_lu_ju, rb.hora_vie
          FROM rutas_pase_ano_alumnos rb";

          mysqli_set_charset($conexion, "utf8");
          $consulta = mysqli_query($conexion, $sql);
          if( !$consulta) {
            $error ++;
            $error_doc= 'Error al INsertar tabla. ';

          }

          //Trunca la tabla de rutas_pase_ano_alumnos
          $sql_delete="TRUNCATE TABLE rutas_historica;";
          mysqli_set_charset($conexion, "utf8");
          $consulta = mysqli_query($conexion, $sql_delete);
          if( !$consulta) {
          $error ++;
          $error_doc= 'Error al Truncar tabla. ';
          }

          //Trunca la tabla de rutas_pase_ano_alumnos
          $sql_delete="TRUNCATE TABLE rutas_historica_alumnos;";
          mysqli_set_charset($conexion, "utf8");
          $consulta = mysqli_query($conexion, $sql_delete);
          if( !$consulta) {
          $error ++;
          $error_doc= 'Error al Truncar tabla. ';
          }
        }}


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
