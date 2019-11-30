<div class="table-responsive p-4">
    <h2 class="text-primary">Padres</h2>
    <br>
    <table class="table table-striped table-bordered" id="padres_table">
        <thead>
            <tr>
                <th >Id</th>
                <th>Nombre</th>
                <th>N° familia</th>
                <th>Familia</th>
                <th>Parentesco</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consulta_padres = $control_padres->consulta_padres();
            $familias = array();
            while ($row = mysqli_fetch_array($consulta_padres)):
                $id = $row['id'];
                $nombre = strtoupper($row['nombre']);
                $nfamilia = $row['numero'];
                $familia = strtoupper($row['familia']);
                $correo = strtoupper($row['correo']);
                $responsable = strtoupper($row['responsable']);
                if (!in_array($familia, $familias)) {
                    array_push($familias, $familia);
                }
                ?>
                <tr data-row="<?php echo $row['id_permiso']; ?>">
                    <td><?php echo $id ?></td>
                    <td><?php echo $nombre ?></td>
                    <td><?php echo $nfamilia ?></td>
                    <td><?php echo $familia ?></td>
                    <td><?php echo $responsable ?></td>
                    <td><?php echo $correo ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

