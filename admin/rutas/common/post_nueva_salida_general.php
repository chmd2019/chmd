<?php
require '../../conexion.php';

if (isset($_POST["fecha_salida_general"], $_POST["hora_salida_general"] )){
  //Datos POST
  $fecha = $_POST['fecha_salida_general'];
  $hora = $_POST['hora_salida_general'];
  // echo $hora;

  if ($conexion) {
      //eliminar ajustes de Ruta anterior
      // $sql_delete = "DELETE FROM rutas_generales_alumnos";
      // $query_delete = mysqli_query($conexion, $sql_delete);
      // if (!$query_delete){
      //   echo json_encode(array ("estatus"=> false) );
      // }

      // verificar queno existe salida general previa
      $sql = "SELECT COUNT(*) FROM rutas_generales_alumnos";
      $query = mysqli_query($conexion, $sql);
      if ($r = mysqli_fetch_array($query)){
        if ($r[0] == 0){
          //Copia de ruta base de mañana
          $sql = "INSERT INTO rutas_generales_alumnos (id_alumno, id_ruta_general , domicilio, hora_regreso , fecha_programada, orden)
          SELECT rb.id_alumno, rb.id_ruta_base_m, rb.domicilio_m, '$hora', '$fecha', rb.orden_in  FROM rutas_base_alumnos rb
          INNER JOIN  rutas r ON r.id_ruta = rb.id_ruta_base_m WHERE r.tipo_ruta = 1 ;";

          mysqli_set_charset($conexion, "utf8");
          $consulta = mysqli_query($conexion, $sql);
          if( $consulta) {
            echo json_encode(array ("estatus"=> true) );
          }else{
            echo json_encode(array ("estatus"=> false) );
          }
        }else {
          //actualiza las existentes
          $error=0;
          $sql ="SELECT rb.id_alumno, rb.id_ruta_general, rb.domicilio, rb.orden  FROM rutas_generales_alumnos rb
          INNER JOIN  rutas r ON r.id_ruta = rb.id_ruta_general;";
          mysqli_set_charset($conexion, "utf8");
          $query = mysqli_query($conexion, $sql);
          while($r = mysqli_fetch_assoc($query) ){
            $id_alumno = $r['id_alumno'];
            $id_ruta = $r['id_ruta_general'];
            $domicilio =$r['domicilio'];
            $orden = $r['orden'];

            $sql2 = "UPDATE rutas_generales_alumnos SET id_ruta_general='$id_ruta', domicilio = '$domicilio',  hora_regreso = '$hora', orden = '$orden', fecha_programada = '$fecha' WHERE id_alumno='$id_alumno';";
            mysqli_set_charset($conexion, "utf8");
            $query2 = mysqli_query($conexion, $sql2);
            if(!$query2) {
              $error++;
            }
          }
          if( $error>0) {
            echo json_encode(array ("estatus"=> false) );
          }else{
            echo json_encode(array ("estatus"=> true) );
          }

        }
      }
    } else {
          echo json_encode(array ("estatus"=> false) );
    }
        mysqli_close($conexion);
}else{
  echo json_encode(array ("estatus"=> false) );
}

?>
