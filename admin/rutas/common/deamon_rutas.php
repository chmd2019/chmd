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
      // validar si la bbdd fue copiada para esa fecha 
      $sql= "SELECT COUNT(*) FROM rutas_historica WHERE fecha = '$fecha'";
      $query =mysqli_query($conexion, $sql);
      While($r = mysqli_fetch_array($query)){
      	$zero = $r[0];
      }
      if($zero==0){
	      //eliminar datos de la fecha actual
	      $sql="DELETE FROM rutas_historica WHERE fecha='$fecha';  ";
	      $sql2="DELETE FROM rutas_historica_alumnos WHERE fecha='$fecha';  ";
	      $query = mysqli_query($conexion,$sql);
	      $query2 = mysqli_query($conexion,$sql2);
	      if(!$query and !$query2){
	        $error=true;
	        $error_doc="Error al eliminar datos de la fecha de Hoy";
	        die('Error al Eliminar');
	      }
      //copiar base de datos base
	    //copiar rutas
	    $sql= "INSERT INTO rutas_historica (id_ruta_h, nombre_ruta, camion, prefecta, cupos, fecha) SELECT id_ruta, nombre_ruta, camion, prefecta, cupos , '$fecha' FROM rutas WHERE camion<900";
	    $query = mysqli_query($conexion, $sql);
        if(!$query){
          $error=true;
          $error_doc="Error al Insertar las rutas del día";
          die('Error al insertar Los datos');
        }

        // Verificar si es viernes ?
        if ($dia == '5'){
          //es viernes
         
           $sql="INSERT INTO rutas_historica_alumnos (id_alumno, id_ruta_h,  domicilio, hora_manana, hora_regreso, orden_in, orden_out, fecha, estatus , domicilio_S, id_ruta_h_s) SELECT rb.id_alumno, rb.id_ruta_base, rb.domicilio, rb.hora_manana, rb.hora_vie, rb.orden_in,rb.orden_out, '$fecha' , '0' , rb.domicilio, rb.id_ruta_base FROM rutas_base_alumnos rb INNER JOIN rutas r ON r.id_ruta=rb.id_ruta_base";
        }else{
        
             $sql="INSERT INTO rutas_historica_alumnos (id_alumno, id_ruta_h,  domicilio, hora_manana, hora_regreso,  orden_in, orden_out, fecha, estatus , domicilio_S, id_ruta_h_s ) SELECT rb.id_alumno, rb.id_ruta_base, rb.domicilio, rb.hora_manana, rb.hora_lu_ju, rb.orden_in, rb.orden_out,  '$fecha', '0'  , rb.domicilio, rb.id_ruta_base FROM rutas_base_alumnos rb INNER JOIN rutas r ON r.id_ruta=rb.id_ruta_base";
        }
        $query = mysqli_query($conexion, $sql);
        if(!$query){
          $error=true;
          $error_doc="Error al Insertar los datos de la fecha de Hoy";
          die('Error al insertar Los datos');
        }

      }

      //Leer y modificar Domicilio,ruta y camion por los Cambios Permanentes del dia
        // (1) Buscar permisos Permanente del dia.
        $sql='COMMIT';
        // $dia=1;
        switch ($dia) {
          case '1': //lunes
          $sql= "SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_camion as id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas_historica r ON vp.id_camion=r.id_ruta_h and r.fecha='$fecha' WHERE vp.lunes='lunes' and vp.estatus=2 and vp.tipo_permiso=3;";
            break;
          case '2': //martes
          $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_camion as id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas_historica r ON vp.id_camion=r.id_ruta_h and r.fecha='$fecha' WHERE vp.martes='martes' and vp.estatus=2 and vp.tipo_permiso=3 ;";
            break;
          case '3': //miercoles
          $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_camion as id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas_historica r ON vp.id_camion=r.id_ruta_h and r.fecha='$fecha' WHERE vp.miercoles='miercoles' and vp.estatus=2 and vp.tipo_permiso=3 ;";
            break;
          case '4': //jueves
          $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_camion as id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas_historica r ON vp.id_camion=r.id_ruta_h and r.fecha='$fecha' WHERE vp.jueves='jueves' and vp.estatus=2 and vp.tipo_permiso=3 ;";
            break;
          case '5': //viernes
          $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_camion as id_ruta, r.nombre_ruta, r.prefecta, r.camion    FROM Ventana_permisos_alumnos vpa INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso INNER JOIN rutas_historica r ON vp.id_camion=r.id_ruta_h and r.fecha='$fecha' WHERE vp.viernes='viernes' and vp.estatus=2 and vp.tipo_permiso=3 ;";
            break;
        }
        //(2) Identifico id_alumnos con las respectivas modificaciones
        $query = mysqli_query($conexion,$sql);
        while($r = mysqli_fetch_array($query)){
          $id_alumno =$r['id_alumno'];
          $domicilio_s = $r['colonia'].', '.$r['calle_numero'];
          $id_ruta_s = $r['id_ruta'];

          //verifico su estatus
          $sql_estatus="SELECT estatus FROM rutas_historica_alumnos WHERE id_alumno='$id_alumno' and fecha ='$fecha' LIMIT 1";
          $query_estatus = mysqli_query($conexion, $sql_estatus);
          if ($r=mysqli_fetch_array($query_estatus)){
          	$estatus=$r[0];

          	if ($estatus<1){
          // $nombre_ruta =$r['nombre_ruta'];
          // $prefecta =$r['prefecta'];
          // $camion =$r['camion'];
          $orden='999';
          //realizar actualizacion
          $sql_update = "UPDATE rutas_historica_alumnos SET id_ruta_h_s='$id_ruta_s', orden_out='$orden' , domicilio_s='$domicilio_s', estatus='1'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
          $query_update = mysqli_query($conexion, $sql_update);
       	
		       	if($query_update){
		       		mysqli_query($conexion, 'COMMIT');
		       	}else{
		       		 $error=true;
	        		 $error_doc="Error al actulizar datos de la fecha de Hoy en Permanente";
	        		 die('Error en Permanente');
		       	}
          	}

          }
          
        }


      //Leer y modificar Domicilio, ruta, y camion por los Cambios Temporales del dia
        //(1) Selecciono Todos los alumnos a modificar con los permisos Temporales
        $sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_camion as id_ruta, r.nombre_ruta, r.prefecta, r.camion,  vp.fecha_inicial, vp.fecha_final, vp.turno
			FROM Ventana_permisos_alumnos vpa 
			INNER JOIN Ventana_Permisos vp ON vp.id_permiso = vpa.id_permiso
			INNER JOIN rutas_historica r ON  vp.id_camion = r.id_ruta_h and r.fecha ='$fecha'
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
      	  $fecha_inicial= strtotime( $mes. '/' .$dia. '/'.$anio);	
      	  $fecha_final= strtotime( $mesf. '/' .$diaf. '/'.$aniof);

      	   // echo  $mes. '/' .$dia. '/'.$anio. '<>br';
      	   // echo 'FI:'. $fecha_inicial. '<br>';
      	   // echo 'FT:'. $fecha_today . '<br>';
      	   // echo  $mesf. '/' .$diaf. '/'.$aniof. '<>br';
      	   // echo 'FF:'. $fecha_final. '<br>';


		// //(2) Identifico los permisos que Aplican para la fecha
      	  if ($fecha_today>$fecha_inicial and $fecha_today<$fecha_final){
        	  	//hacemos el cambio
      	   $id_alumno =$r['id_alumno'];
	       $id_ruta = $r['id_ruta'];
	       $domicilio = $r['colonia'].', '.$r['calle_numero'];
	       $turno = strtolower($r['turno']);
		   // echo 'ok: '. $turno ;
	       $orden='998';

	        //verifico su estatus
          $sql_estatus="SELECT estatus FROM rutas_historica_alumnos WHERE id_alumno='$id_alumno' and fecha ='$fecha' LIMIT 1";
          $query_estatus = mysqli_query($conexion, $sql_estatus);
          if ($r=mysqli_fetch_array($query_estatus)){
          	$estatus=$r[0];
          	if ($estatus<2){
		      
		    //turno - mañana 
			if ($turno == 'mañana'){

			  //realizar actualizacion
	          $sql_update = "UPDATE rutas_historica_alumnos SET id_ruta_h='$id_ruta', orden_in='$orden', domicilio='$domicilio', estatus='2'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;

			}else if ($turno == 'tarde'){

 			 $sql_update = "UPDATE rutas_historica_alumnos SET id_ruta_h_s='$id_ruta', orden_out='$orden', domicilio_s='$domicilio', estatus='2'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
			}
			   //decodifica Camiones 
		       // $array_ruta = explode("/", $id_ruta);
		       // $id_ruta = $array_ruta[0];
		       // $id_ruta_s = $array_ruta[0];
		    
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
	$sql="SELECT vpa.id_alumno, vp.colonia, vp.calle_numero, vp.id_camion as id_ruta, r.nombre_ruta, r.prefecta, r.camion, vp.fecha_cambio
			FROM Ventana_permisos_alumnos vpa 
			INNER JOIN Ventana_Permisos vp ON vp.id_permiso=vpa.id_permiso
			INNER JOIN rutas_historica r ON vp.id_camion=r.id_ruta_h and r.fecha = '$fecha'
			WHERE vp.estatus=2 and vp.tipo_permiso=1 and LOCATE('$year',vp.fecha_cambio )>0  and LOCATE( '$dia', vp.fecha_cambio )>0 and LOCATE( '$mes_letras', vp.fecha_cambio )>0  ;";
	$query=mysqli_query	($conexion, $sql);
	while($r=mysqli_fetch_array($query)){
			//hacemos el cambio
      	   $id_alumno =$r['id_alumno'];
	       $domicilio_s = $r['colonia'].', '.$r['calle_numero'];
	       $id_ruta_s = $r['id_ruta'];
	       $orden='997';


	        //verifico su estatus
          $sql_estatus="SELECT estatus FROM rutas_historica_alumnos WHERE id_alumno='$id_alumno' and fecha ='$fecha' LIMIT 1";
          $query_estatus = mysqli_query($conexion, $sql_estatus);
          if ($r=mysqli_fetch_array($query_estatus)){
          	$estatus=$r[0];
          	if ($estatus<3){
	       // $nombre_ruta =$r['nombre_ruta'];
	       // $prefecta =$r['prefecta'];
	       // $camion =$r['camion'];
	        //realizar actualizacion
          $sql_update = "UPDATE rutas_historica_alumnos SET id_ruta_h_s='$id_ruta_s', orden_out='$orden', domicilio_s='$domicilio_s',estatus='3'  WHERE id_alumno='$id_alumno' and fecha='$fecha'" ;
          $query_update = mysqli_query($conexion, $sql_update);
	       	if($query_update){
	       		mysqli_query($conexion, 'COMMIT');
	       	}else{
	       		 $error=true;
        		 $error_doc="Error al actualizar datos de la fecha de Hoy en DIARIOS";
        		 die('Error en DIARIOS');
	       	}

          	}
          }
	}			
//fin de cambios por permisos. 
}
echo json_encode(array ("error"=>$error, "error_doc"=>$error_doc ));
?>
