<?php
require '../../conexion.php';
//si existe la conexion
$error = false;
$error_doc = 'Sin Errores';
if ($conexion) {
      // Conseguir fecha
      $fecha = date('Y-m-d');
      // echo $fecha;
      // validar si la bbdd fue copiada para esa fecha 
      $sql= "SELECT COUNT(*) FROM rutas_historica WHERE fecha = '$fecha'";
      $query =mysqli_query($conexion, $sql);
      While($r = mysqli_fetch_array($query)){
      	$zero = $r[0];
      }
      // if($zero==0){
	      //eliminar datos de la fecha actual
	      $sql="DELETE FROM rutas_historica WHERE fecha='$fecha';  ";
	      $sql2="DELETE FROM rutas_historica_alumnos WHERE fecha='$fecha';  ";
	      $query = mysqli_query($conexion,$sql);
	      $query2 = mysqli_query($conexion,$sql);
	      if(!$query and !$query2){
	        $error=true;
	        $error_doc="Error al eliminar datos de la fecha de Hoy";
	        die('Error al Eliminar');
	      }
      //copiar base de datos base
        // Verificar si es viernes ?
        $dia = date('w');
        if ($dia == '5'){
          //es viernes
          $sql= "INSERT INTO rutas_historica (id_alumno,id_ruta_base , nombre_ruta, domicilio, hora_manana, hora_regreso, prefecta, camion, orden, fecha, cupos ) SELECT rb.id_alumno, rb.id_ruta_base, r.nombre_ruta, rb.domicilio, rb.hora_manana, rb.hora_vie, r.prefecta,r.camion, rb.orden, '$fecha', r.cupos  FROM rutas_base_alumnos rb INNER JOIN rutas r ON r.id_ruta=rb.id_ruta_base WHERE r.camion>900";
        }else{
          $sql= "INSERT INTO rutas_historica (id_alumno,id_ruta_base , nombre_ruta, domicilio, hora_manana, hora_regreso, prefecta, camion, orden, fecha, cupos ) SELECT rb.id_alumno, rb.id_ruta_base, r.nombre_ruta, rb.domicilio, rb.hora_manana, rb.hora_lu_ju, r.prefecta,r.camion, rb.orden, '$fecha', r.cupos  FROM rutas_base_alumnos rb INNER JOIN rutas r ON r.id_ruta=rb.id_ruta_base WHERE r.camion>900";
        }
        $query = mysqli_query($conexion, $sql);
        if(!$query){
          $error=true;
          $error_doc="Error al Insertar los datos de la fecha de Hoy";
          die('Error al insertar Los datos');
        }

      // }

      //Leer y modificar Domocilio,ruta y camion por los Cambios Permanentes del dia
        // (1) Buscar permisos Permanente del dia.
        $sql='COMMIT';
        switch ($dia) {
          case '1': //lunes
          $sql= "SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas r ON vp.id_ruta=r.id_ruta WHERE vp.lunes='lunes' and vp.estatus=2 and vp.tipo_permiso=3;";
            break;
          case '2': //martes
          $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas r ON vp.id_ruta=r.id_ruta WHERE vp.martes='martes' and vp.estatus=2 and vp.tipo_permiso=3;";
            break;
          case '3': //miercoles
          $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas r ON vp.id_ruta=r.id_ruta WHERE vp.miercoles='miercoles' and vp.estatus=2 and vp.tipo_permiso=3;";
            break;
          case '4': //jueves
          $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas r ON vp.id_ruta=r.id_ruta WHERE vp.jueves='jueves' and vp.estatus=2 and vp.tipo_permiso=3;";
            break;
          case '5': //viernes
          $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas r ON vp.id_ruta=r.id_ruta WHERE vp.viernes='viernes' and vp.estatus=2 and vp.tipo_permiso=3;";
            break;
        }
        // (2) identifico id_alumnos con las respectivas modificaciones
        $query = mysqli_query($conexion,$sql);
        while($r = mysqli_fetch_array($query)){
          $id_alumno =$r['id_alumno'];
          $domicilio = $r['colonia'].', '.$r['calle_numero'];
          $id_ruta = $r['id_ruta'];
          $nombre_ruta =$r['nombre_ruta'];
          $prefecta =$r['prefecta'];
          $camion =$r['camion'];
          $orden='999';
          //realizar actualizacion
          $sql_update = "UPDATE rutas_historica SET nombre_ruta='$nombre_ruta', domicilio = '$domicilio', id_ruta_base='$id_ruta', prefecta= '$prefecta',  camion='$camion', orden='$orden'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
          $query_update = mysqli_query($conexion, $sql_update);
       	
	       	if($query_update){
	       		mysqli_query($conexion, 'COMMIT');
	       	}else{
	       		 $error=true;
        		 $error_doc="Error al actulizar datos de la fecha de Hoy en Permanente";
        		 die('Error en Permanente');
	       	}
        }


      //Leer y modificar Domicilio, ruta, y camion por los Cambios Temporales del dia
        //(1) Selecciono Todos los alumnos a modificar con los permisos Temporales
        $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_ruta, r.nombre_ruta, r.prefecta, r.camion,  vp.fecha_inicial, vp.fecha_final
			FROM Ventana_permisos_alumnos vpa 
			INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso
			INNER JOIN rutas r ON vp.id_ruta=r.id_ruta 
			WHERE vp.estatus=2 and vp.tipo_permiso=2;";
		$query = mysqli_query($conexion, $sql);
		while($r=mysqli_fetch_array($query)){
			$fecha_inicial = $r['fecha_inicial'];
			$fecha_final = $r['fecha_final'];
			//normalizo la fecha 	
		  $array1 = explode(',' , $fecha_inicial ); $array2= explode(' ',$array1[1]); $dia= $array2[1]; $mes= '';
		  $array1f = explode(',' , $fecha_final ); $array2f= explode(' ',$array1f[1]); $diaf= $array2f[1]; $mesf= '';
     	  $_mes= strtolower($array2[3]);
     	  $_mesf= strtolower($array2f[3]);
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
	      switch ($_mesf) {
	            case 'enero':
	            $mesf=1;
	            break;
	            case 'febrero':
	            $mesf=2;
	            break;
	            case 'marzo':
	            $mesf=3;
	            break;
	            case 'abril':
	            $mesf=4;
	            break;
	            case 'mayo':
	            $mesf=5;
	            break;
	            case 'junio':
	            $mesf=6;
	            break;
	            case 'julio':
	            $mesf=7;
	            break;
	            case 'agosto':
	            $mesf=8;
	            break;
	            case 'septiembre':
	            $mesf=9;
	            break;
	            case 'octubre':
	            $mesf=10;
	            break;
	            case 'noviembre':
	            $mesf=11;
	            break;
	            case 'diciembre':
	              $mesf=12;
	            break;
	            default:
	            $mesf = -1;
	          break;
	      }
      	  $anio= $array2[5] % 100;
      	  $aniof= $array2f[5] % 100;
      	  // fechas normalizadas
      	  $fecha_today = strtotime(date('d-m-Y', time()));
      	  $fecha_inicial=strtotime( $dia.'-'.$mes.'-'.$anio.' 00:00:00');	
      	  $fecha_final= strtotime($diaf.'-'.$mesf.'-'.$aniof.' 23:59:00');
		//(2) Identifico los permisos que Aplican para la fecha
      	  if ($fecha_today>$fecha_inicial and $fecha_today<$fecha_final){
      	  	//hacemos el cambio
      	   $id_alumno =$r['id_alumno'];
	       $domicilio = $r['colonia'].', '.$r['calle_numero'];
	       $id_ruta = $r['id_ruta'];
	       $nombre_ruta =$r['nombre_ruta'];
	       $prefecta =$r['prefecta'];
	       $camion =$r['camion'];
	       $orden='998';
	        //realizar actualizacion
          $sql_update = "UPDATE rutas_historica SET nombre_ruta='$nombre_ruta', domicilio = '$domicilio', id_ruta_base='$id_ruta', prefecta= '$prefecta',  camion='$camion', orden='$orden'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
          $query_update = mysqli_query($conexion, $sql_update);
	       	if($query_update){
	       		mysqli_query($conexion, 'COMMIT');
	       	}else{
	       		 $error=true;
        		 $error_doc="Error al actualizar datos de la fecha de Hoy en Temporales";
        		 die('Error en Temporales');
	       	}
      	  }
		}
      //Leer y modificar DOmicilio, ruta, y camion por los cambios diarios del dia
	  		// (1) Seleccionar los permisos del dia
	$arrayMeses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
	'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
	$year=date('Y');
	$mes=date('m');
	$dia = date('d');
	$mes_letras = $arrayMeses[(int)$mes - 1];
		//SQL
	$sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_ruta, r.nombre_ruta, r.prefecta, r.camion, vp.fecha_cambio
			FROM Ventana_permisos_alumnos vpa 
			INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso
			INNER JOIN rutas r ON vp.id_ruta=r.id_ruta 
			WHERE vp.estatus=2 and vp.tipo_permiso=1 and LOCATE('$year',vp.fecha_cambio )>0  and LOCATE( '$dia', vp.fecha_cambio )>0 and LOCATE( '$mes_letras', vp.fecha_cambio )>0 ;";
	$query=mysqli_query	($conexion, $sql);
	while($r=mysqli_fetch_array($query)){
			//hacemos el cambio
      	   $id_alumno =$r['id_alumno'];
	       $domicilio = $r['colonia'].', '.$r['calle_numero'];
	       $id_ruta = $r['id_ruta'];
	       $nombre_ruta =$r['nombre_ruta'];
	       $prefecta =$r['prefecta'];
	       $camion =$r['camion'];
	       $orden='997';
	        //realizar actualizacion
          $sql_update = "UPDATE rutas_historica SET nombre_ruta='$nombre_ruta', domicilio = '$domicilio', id_ruta_base='$id_ruta', prefecta= '$prefecta',  camion='$camion', orden='$orden'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
          $query_update = mysqli_query($conexion, $sql_update);
	       	if($query_update){
	       		mysqli_query($conexion, 'COMMIT');
	       	}else{
	       		 $error=true;
        		 $error_doc="Error al actualizar datos de la fecha de Hoy en DIARIOS";
        		 die('Error en DIARIOS');
	       	}
	}			
//fin de cambios por permisos. 
}
echo json_encode(array ("error"=>$error, "error_doc"=>$error_doc ));
?>
