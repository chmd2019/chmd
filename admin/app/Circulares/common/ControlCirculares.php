<?php

$root = dirname(dirname(dirname(__DIR__)));
require "{$root}/DBManager.php";

class ControlCirculares
{

    public $conexion;

    public function __construct()
    {
        $dbManager = new DBManager();
        $this->conexion = $dbManager->conectar1();
    }

    public function select_catalogo_estatus()
    {
        $sql = "SELECT * FROM App_catalogo_estatus;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_catalogo_nivel()
    {
        $sql = "SELECT * FROM Catalogo_nivel;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_catalogo_grado()
    {
        $sql = "SELECT * FROM catalogo_grado_cursar;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_catalogo_grupos()
    {
        $sql = "SELECT * FROM catalago_grupos_cch;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_grupos_especiales()
    {
        $sql = "SELECT * FROM App_grupos_especiales;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_grupos_administrativos()
    {
        $sql = "SELECT * FROM App_grupos_administrativos;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function listado_circulares()
    {
        $sql = "SELECT a.id, a.titulo, a.descripcion, a.envia_todos, b.descripcion AS estatus, b.color, b.id as id_estatus "
            . "FROM App_Circulares a "
            . "INNER JOIN App_catalogo_estatus b ON b.id = a.id_estatus ORDER BY id DESC;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_usuarios()
    {
        $sql = "SELECT id, nombre, numero, correo FROM usuarios;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function nueva_circular($titulo, $contenido, $descripcion, $envia_todos, $estatus,
                                   $usuarios, $grupos_especiales, $grupos_administrativos, $coleccion_nivel_grado_grupo,
                                   $fecha_programada, $coleccion_padres_camiones, $coleccion_padres_camiones_tarde, $id_ciclo_escolar,
                                   $adjunto, $tema_ics, $fecha_ics, $hora_inicial_ics, $hora_final_ics, $ubicacion_ics, $hora_programada)
    {
        try {
            mysqli_autocommit($this->conexion, false);
            mysqli_set_charset($this->conexion, "utf8");
            $sql_insert = "INSERT INTO `App_Circulares` ("
                . "`titulo`, "
                . "`contenido`, "
                . "`descripcion`, "
                . "`envia_todos`, "
                . "`id_estatus`, "
                . "`fecha_programada`, "
                . "`ciclo_escolar_id`, "
                . "`adjunto`, "
                . "`tema_ics`, "
                . "`fecha_ics`, "
                . "`hora_inicial_ics`, "
                . "`hora_final_ics`, "
                . "`ubicacion_ics`, "
                . "`hora_programada`) VALUES ("
                . "'{$titulo}', "
                . "'{$contenido}', "
                . "'{$descripcion}', "
                . "'{$envia_todos}', "
                . "{$estatus}, "
                . "'{$fecha_programada}', "
                . "'{$id_ciclo_escolar}', "
                . "{$adjunto}, "
                . "{$tema_ics}, "
                . "{$fecha_ics}, "
                . "{$hora_inicial_ics}, "
                . "{$hora_final_ics}, "
                . "{$ubicacion_ics}, "
                . "{$hora_programada});";

            if (!mysqli_query($this->conexion, $sql_insert)) {
                throw new Exception(mysqli_error($this->conexion));
            }
            $id_app_circulares = mysqli_insert_id($this->conexion);
            foreach ($usuarios as $value) {
                $sql_insert_usuario = "INSERT INTO `App_usuarios_circulares` "
                    . "(`id_circular`, "
                    . "`id_usuario`, "
                    . "`usuarios_sin_grupo`) "
                    . "VALUES ("
                    . "{$id_app_circulares}, "
                    . "{$value}, "
                    . "TRUE);";
                if (!mysqli_query($this->conexion, $sql_insert_usuario)) {
                    throw new Exception(mysqli_error($this->conexion));
                }
            }
            foreach ($grupos_especiales as $value) {
                $sql_alumnos_grupo_especial = "SELECT alumno_id FROM App_grupos_especiales_alumnos WHERE grupo_id = $value;";
                $alumnos_grupo_especial = mysqli_query($this->conexion, $sql_alumnos_grupo_especial);
                if (!$alumnos_grupo_especial) {
                    throw new Exception(mysqli_error($this->conexion));
                } else {
                    while ($alumno_grupo_especial = mysqli_fetch_array($alumnos_grupo_especial)) {
                        $sql_insert_alumno_especial = "INSERT INTO `App_usuarios_circulares` "
                            . "(`id_circular`, "
                            . "`id_alumno`, "
                            . "`id_grupo_espepcial`) "
                            . "VALUES ("
                            . "{$id_app_circulares}, "
                            . "{$alumno_grupo_especial[0]}, "
                            . "{$value});";
                        if (!mysqli_query($this->conexion, $sql_insert_alumno_especial)) {
                            throw new Exception(mysqli_error($this->conexion));
                        }
                    }
                }
            }
            foreach ($grupos_administrativos as $value) {
                $sql_usuarios_grupo = "SELECT id_usuario FROM App_usuarios_administrativos WHERE id_grupo = $value;";
                $usuarios_grupos = mysqli_query($this->conexion, $sql_usuarios_grupo);
                if (!$usuarios_grupos) {
                    throw new Exception(mysqli_error($this->conexion));
                } else {
                    while ($usuario_grupo = mysqli_fetch_array($usuarios_grupos)) {
                        $sql_insert_usuario = "INSERT INTO `App_usuarios_circulares` "
                            . "(`id_circular`, "
                            . "`id_usuario`, "
                            . "`id_grupo_administrativo`) "
                            . "VALUES ("
                            . "{$id_app_circulares}, "
                            . "{$usuario_grupo[0]}, "
                            . "{$value});";
                        if (!mysqli_query($this->conexion, $sql_insert_usuario)) {
                            throw new Exception(mysqli_error($this->conexion));
                        }
                    }
                }
            }

            foreach ($coleccion_nivel_grado_grupo as $value) {
                foreach ($value as $value_conjunto) {
                    //se consultan los id de nivel, grado y grupo
                    $sql_select_id_nivel = "SELECT id FROM Catalogo_nivel WHERE nivel = '{$value_conjunto['td_nivel']}';";
                    $id_nivel = mysqli_fetch_array(mysqli_query($this->conexion, $sql_select_id_nivel))[0];
                    $sql_select_id_grado = "SELECT idcursar FROM catalogo_grado_cursar WHERE grado = '{$value_conjunto['td_grado']}';";
                    $id_grado = mysqli_fetch_array(mysqli_query($this->conexion, $sql_select_id_grado))[0];
                    $sql_select_id_grupo = "SELECT id FROM catalago_grupos_cch WHERE grupo = '{$value_conjunto['td_grupo']}';";
                    $id_grupo = mysqli_fetch_array(mysqli_query($this->conexion, $sql_select_id_grupo))[0];
                    $sql_insert_nivel_grado_grupo = "INSERT INTO `App_nivel_grado_grupo_circulares` ("
                        . "`id_circular`, `id_nivel`, `id_grado`, `id_grupo`) "
                        . "VALUES ({$id_app_circulares}, "
                        . var_export($id_nivel, TRUE) . " , "
                        . var_export($id_grado, TRUE) . " , "
                        . var_export($id_grupo, TRUE) . ");";
                    $sql_ids_papa_alumno = "";
                    if ($id_nivel != null && $id_grado == null && $id_grupo == null) {
                        $sql_ids_papa_alumno = "SELECT a.id AS id_padre, b.id AS id_alumno "
                            . "FROM usuarios a "
                            . "INNER JOIN alumnoschmd b ON b.idfamilia = a.numero "
                            . "WHERE b.id_nivel = {$id_nivel};";
                    } else if ($id_nivel != null && $id_grado != null && $id_grupo == null) {
                        $sql_ids_papa_alumno = "SELECT a.id AS id_padre, b.id AS id_alumno "
                            . "FROM usuarios a "
                            . "INNER JOIN alumnoschmd b ON b.idfamilia = a.numero "
                            . "WHERE b.id_nivel = {$id_nivel} AND b.idcursar = {$id_grado};";
                    } else {
                        $sql_ids_papa_alumno = "SELECT a.id AS id_padre, b.id AS id_alumno "
                            . "FROM usuarios a "
                            . "INNER JOIN alumnoschmd b ON b.idfamilia = a.numero "
                            . "INNER JOIN catalago_grupos_cch c ON c.grupo = b.grupo "
                            . "WHERE b.id_nivel = {$id_nivel} AND b.idcursar = {$id_grado} AND c.id = {$id_grupo}";
                    }
                    $consulta_papa_alumno = mysqli_query($this->conexion, $sql_ids_papa_alumno);
                    if (!$consulta_papa_alumno) {
                        throw new Exception(mysqli_error($this->conexion));
                    } else {
                        while ($row = mysqli_fetch_array($consulta_papa_alumno)) {
                            $id_papa = $row[0];
                            $id_alumno = $row[1];
                            $insert_id_papa_alumno = "INSERT INTO `App_usuarios_circulares` "
                                . "(`id_circular`, `id_usuario`, `id_alumno`, `por_curso`) "
                                . "VALUES ({$id_app_circulares}, {$id_papa}, {$id_alumno}, true);";
                            if (!mysqli_query($this->conexion, $insert_id_papa_alumno)) {
                                throw new Exception(mysqli_error($this->conexion));
                            }
                        }
                    }
                    if (!mysqli_query($this->conexion, $sql_insert_nivel_grado_grupo)) {
                        throw new Exception(mysqli_error($this->conexion));
                    }
                }
            }
            foreach ($coleccion_padres_camiones as $value) {
                $sql_insert_padre_camion = "INSERT INTO `App_usuarios_circulares` "
                    . "(`id_circular`, `id_usuario`, `id_alumno`) "
                    . "VALUES ({$id_app_circulares}, {$value['id_alumno']}, {$value['id_papa']});";
                if (!mysqli_query($this->conexion, $sql_insert_padre_camion)) {
                    throw new Exception(mysqli_error($this->conexion));
                }
            }
            foreach ($coleccion_padres_camiones_tarde as $value) {
                $sql_insert_padre_camion = "INSERT INTO `App_usuarios_circulares` "
                    . "(`id_circular`, `id_usuario`, `id_alumno`) "
                    . "VALUES ({$id_app_circulares}, {$value['id_alumno']}, {$value['id_papa']});";
                if (!mysqli_query($this->conexion, $sql_insert_padre_camion)) {
                    throw new Exception(mysqli_error($this->conexion));
                }
            }
            return mysqli_commit($this->conexion);
        } catch (Exception $ex) {
            mysqli_rollback($this->conexion);
            return $ex->getMessage();
        }
    }

    public function select_administrativos($id_circular)
    {
        $sql = "SELECT a.id_usuario, GROUP_CONCAT(UPPER(c.grupo)) AS grupos, b.nombre, a.leido, a.favorito, "
            . "a.eliminado, a.notificado "
            . "FROM App_usuarios_circulares a "
            . "INNER JOIN usuarios b ON b.id = a.id_usuario "
            . "INNER JOIN App_grupos_administrativos c ON c.id = a.id_grupo_administrativo "
            . "WHERE a.id_circular = $id_circular AND a.id_grupo_administrativo IS NOT NULL "
            . "AND a.id_grupo_administrativo IS NOT NULL GROUP BY a.id_usuario;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_usuarios_circular($id_circular)
    {
        $sql = "SELECT a.id_usuario, b.nombre, a.leido, a.favorito, a.eliminado, a.notificado "
            . "FROM App_usuarios_circulares a "
            . "INNER JOIN usuarios b ON b.id = a.id_usuario "
            . "WHERE a.id_circular = $id_circular AND a.usuarios_sin_grupo = TRUE;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_padres($id_circular)
    {
        $sql = "SELECT DISTINCT a.id_usuario, c.nombre AS padre, c.responsable AS parentesco, a.leido, "
            . "a.favorito, a.eliminado, a.notificado "
            . "FROM App_usuarios_circulares a "
            . "INNER JOIN usuarios c ON c.id = a.id_usuario "
            . "WHERE a.id_circular = $id_circular AND a.id_alumno IS NOT NULL "
            . "GROUP BY a.id_usuario ORDER BY a.id;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    //rutas de la mañana
    public function select_camiones($fecha)
    {
        $sql = "SELECT a.id_ruta_h, d.camion, d.nombre_ruta "
            . "FROM rutas_historica_alumnos a "
            . "INNER JOIN rutas_historica d ON d.id_ruta_h = a.id_ruta_h "
            . "WHERE a.fecha = '$fecha' AND a.id_ruta_h != 999 AND a.id_ruta_h != 0 "
            . "GROUP BY a.id_ruta_h ORDER BY d.camion;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    //rutas de la tarde
    public function select_camiones_tarde($fecha)
    {
        $sql = "SELECT a.id_ruta_h_s, d.camion, d.nombre_ruta "
            . "FROM rutas_historica_alumnos a "
            . "INNER JOIN rutas_historica d ON d.id_ruta_h = a.id_ruta_h_s "
            . "WHERE a.fecha = '$fecha' AND a.id_ruta_h_s != 999 AND a.id_ruta_h_s != 0 "
            . "GROUP BY a.id_ruta_h_s ORDER BY d.camion;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    //alumnos incluidos en la ruta de la mañana
    public function select_alumnos_ruta($fecha)
    {
        $sql = "SELECT a.id_ruta_h, a.id_alumno, c.id AS id_papa, d.camion, d.nombre_ruta "
            . "FROM rutas_historica_alumnos a "
            . "INNER JOIN alumnoschmd b ON b.id = a.id_alumno "
            . "INNER JOIN usuarios c ON c.numero = b.idfamilia "
            . "INNER JOIN rutas_historica d ON d.id_ruta_h = a.id_ruta_h "
            . "WHERE a.fecha = '$fecha' AND a.id_ruta_h != 999 AND a.id_ruta_h != 0 GROUP BY c.id ORDER BY d.camion;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    //alumnos incluidos en la ruta de la tarde
    public function select_alumnos_ruta_tarde($fecha)
    {
        $sql = "SELECT a.id_ruta_h_s, a.id_alumno, c.id AS id_papa, d.camion, d.nombre_ruta "
            . "FROM rutas_historica_alumnos a "
            . "INNER JOIN alumnoschmd b ON b.id = a.id_alumno "
            . "INNER JOIN usuarios c ON c.numero = b.idfamilia "
            . "INNER JOIN rutas_historica d ON d.id_ruta_h = a.id_ruta_h_s "
            . "WHERE a.fecha = '$fecha' AND a.id_ruta_h_s != 999 AND a.id_ruta_h_s != 0 "
            . "GROUP BY c.id, a.id_ruta_h_s ORDER BY d.camion;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function select_circular($id_circular)
    {
        $sql = "SELECT a.titulo, a.descripcion, a.contenido, b.descripcion AS estatus, "
            . "b.color, b.id AS id_estatus, c.ciclo, a.fecha_programada, a.hora_programada,"
            . "a.tema_ics, a.fecha_ics, a.hora_inicial_ics, a.hora_final_ics, a.ubicacion_ics "
            . "FROM App_Circulares a "
            . "INNER JOIN App_catalogo_estatus b ON b.id = a.id_estatus "
            . "INNER JOIN Ciclo_escolar c ON c.id = a.ciclo_escolar_id "
            . "WHERE a.id = $id_circular;";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }

    public function cancelar_circular($id_circular)
    {
        $sql = "UPDATE App_Circulares a SET a.id_estatus = 4 WHERE a.id = $id_circular;";
        mysqli_query($this->conexion, $sql);
        return mysqli_affected_rows($this->conexion);
    }

    public function select_nivel_circular($id_circular)
    {
        $sql = "SELECT a.id_nivel, b.nivel, a.id_grado, c.grado, a.id_grupo, d.grupo "
            . "FROM App_nivel_grado_grupo_circulares a "
            . "INNER JOIN Catalogo_nivel b ON b.id = a.id_nivel "
            . "LEFT JOIN catalogo_grado_cursar c ON c.idcursar = a.id_grado "
            . "LEFT JOIN catalago_grupos_cch d ON d.id = a.id_grupo "
            . "WHERE a.id_circular = $id_circular;";
        return mysqli_query($this->conexion, $sql);
    }

    public function select_niveles_edicion($id_circular)
    {
        $sql = "SELECT a.id_nivel, b.nivel, a.id_grado, c.grado, a.id_grupo, d.grupo "
            . "FROM App_nivel_grado_grupo_circulares a "
            . "LEFT JOIN Catalogo_nivel b ON b.id = a.id_nivel "
            . "LEFT JOIN catalogo_grado_cursar c ON c.idcursar = a.id_grado "
            . "LEFT JOIN catalago_grupos_cch d ON d.id = a.id_grupo "
            . "WHERE a.id_circular = $id_circular;";
        return mysqli_query($this->conexion, $sql);
    }

    public function select_ciclo_escolar()
    {
        $sql = "SELECT a.id AS id_ciclo FROM Ciclo_escolar a WHERE a.estatus = TRUE;";
        return mysqli_fetch_assoc(mysqli_query($this->conexion, $sql))['id_ciclo'];
    }

    public function select_ciclo_escolar_ciclo()
    {
        $sql = "SELECT a.ciclo FROM Ciclo_escolar a WHERE a.estatus = TRUE;";
        return mysqli_fetch_assoc(mysqli_query($this->conexion, $sql))['ciclo'];
    }

    public function actualizar_estado_circular($id_estatus, $id_circular)
    {
        $sql = "UPDATE `App_Circulares` SET `id_estatus`= $id_estatus WHERE `id`=$id_circular;";
        mysqli_query($this->conexion, $sql);
        return mysqli_affected_rows($this->conexion);
    }

    public function update_circular($titulo, $descripcion, $contenido, $tema_ics, $fecha_ics, $hora_inicial_ics,
                                    $hora_final_ics, $ubicacion_ics, $adjunto, $id_circular, $niveles)
    {
        try {
            mysqli_autocommit($this->conexion, false);
            $sql_update_circular = "UPDATE App_Circulares 
                                    SET titulo='{$titulo}', contenido='{$contenido}', descripcion='{$descripcion}', 
                                    adjunto = '{$adjunto}', tema_ics = '{$tema_ics}', fecha_ics = '{$fecha_ics}', hora_inicial_ics = '{$hora_inicial_ics}', hora_final_ics = '{$hora_final_ics}', ubicacion_ics = '{$ubicacion_ics}' 
                                    WHERE id={$id_circular};";
            $sql_delete_padres = "DELETE FROM App_usuarios_circulares WHERE id_circular = {$id_circular} AND por_curso = TRUE";
            $sql_del_nivel_grado_grupo = "DELETE FROM App_nivel_grado_grupo_circulares WHERE id_circular = {$id_circular}";

            if (!mysqli_query($this->conexion, $sql_update_circular) ||
                !mysqli_query($this->conexion, $sql_delete_padres) ||
                !mysqli_query($this->conexion, $sql_del_nivel_grado_grupo)) {
                throw new Exception(mysqli_error($this->conexion));
            }

            foreach ($niveles as $value) {
                $sql_select_padres = null;
                //consulta de padres
                //{$value['id_nivel']}-{$value['id_grado']}-{$value['id_grupo']}

                if ($value['id_nivel'] != 0 && $value['id_grado'] != 0 && $value['id_grupo'] != 0) {
                    $sql_select_padres = "SELECT a.id AS id_padre, b.id AS id_alumno
                                            FROM usuarios a
                                            INNER JOIN alumnoschmd b
                                                ON b.idfamilia = a.numero
                                            INNER JOIN catalago_grupos_cch c
                                                ON c.grupo = b.grupo
                                            WHERE b.id_nivel = '{$value['id_nivel']}'
                                                    AND b.idcursar = {$value['id_grado']}
                                                    AND c.id = {$value['id_grupo']}
                                            ORDER BY  a.id;";
                    $sql_insert_nivel_grado_grupo = "INSERT INTO `App_nivel_grado_grupo_circulares` 
                                                    (`id_circular`, `id_nivel`, `id_grado`, `id_grupo`) 
                                                    VALUES ({$id_circular}, {$value['id_nivel']}, {$value['id_grado']}, {$value['id_grupo']});";

                } else if ($value['id_nivel'] != 0 && $value['id_grado'] != 0 && $value['id_grupo'] == 0) {
                    $sql_select_padres = "SELECT a.id AS id_padre, b.id AS id_alumno
                                            FROM usuarios a
                                            INNER JOIN alumnoschmd b
                                                ON b.idfamilia = a.numero
                                            INNER JOIN catalago_grupos_cch c
                                                ON c.grupo = b.grupo
                                            WHERE b.id_nivel = {$value['id_nivel']}
                                                    AND b.idcursar = {$value['id_grado']}
                                            ORDER BY  a.id;";
                    $sql_insert_nivel_grado_grupo = "INSERT INTO `App_nivel_grado_grupo_circulares` 
                                                    (`id_circular`, `id_nivel`, `id_grado`) 
                                                    VALUES ({$id_circular}, {$value['id_nivel']}, {$value['id_grado']});";

                } else {
                    $sql_select_padres = "SELECT a.id AS id_padre, b.id AS id_alumno
                                            FROM usuarios a
                                            INNER JOIN alumnoschmd b
                                                ON b.idfamilia = a.numero
                                            INNER JOIN catalago_grupos_cch c
                                                ON c.grupo = b.grupo
                                            WHERE b.id_nivel = {$value['id_nivel']}
                                            ORDER BY  a.id;";
                    $sql_insert_nivel_grado_grupo = "INSERT INTO `App_nivel_grado_grupo_circulares` 
                                                    (`id_circular`, `id_nivel`) 
                                                    VALUES ({$id_circular}, {$value['id_nivel']});";

                }

                //insert nivel grado grupo
                if (!mysqli_query($this->conexion, $sql_insert_nivel_grado_grupo)) {
                    throw new Exception(mysqli_error($this->conexion));
                }

                $padres = mysqli_query($this->conexion, $sql_select_padres);

                if (!$padres) {
                    throw new Exception(mysqli_error($this->conexion));
                }
                //insert de padres
                while ($row = mysqli_fetch_assoc($padres)) {
                    $sql_insert_padres = "INSERT INTO App_usuarios_circulares 
                                            (id_circular, id_usuario, id_alumno, por_curso) 
                                            VALUES ({$id_circular}, {$row['id_padre']}, {$row['id_alumno']}, TRUE);";
                    if (!mysqli_query($this->conexion, $sql_insert_padres)) {
                        throw new Exception(mysqli_error($this->conexion));
                    }
                }
            }
        } catch (Exception $ex) {
            mysqli_rollback($this->conexion);
            return $ex->getMessage();
        }
        return mysqli_commit($this->conexion);;
    }

    public function select_grupos_especiales_x_circular($id_circular)
    {
        $sql = "SELECT DISTINCT a.id_grupo_espepcial, b.grupo
                                    FROM App_usuarios_circulares a
                                    INNER JOIN App_grupos_especiales b ON b.id = a.id_grupo_espepcial
                                    WHERE a.id_circular = {$id_circular}";
        mysqli_set_charset($this->conexion, "utf8");
        return mysqli_query($this->conexion, $sql);
    }
}
