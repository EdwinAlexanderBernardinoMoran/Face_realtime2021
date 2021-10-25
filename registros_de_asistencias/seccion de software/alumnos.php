<?php
?>
<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$alumnos = getAlumnos();
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Alumnos</h1>
    </div>
    <div class="col-12">
        <a href="alumno_add.php" class="btn btn-info mb-2">Agregar alumno <i class="fa fa-plus"></i></a>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre completo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $alumno) { ?>
                        <tr>
                            <td>
                                <?php echo $alumno->id ?>
                            </td>
                            <td>
                                <?php echo $alumno->nombre ?>
                            </td>
                            <td>
                                <a class="btn btn-warning" href="alumno_edit.php?id=<?php echo $alumno->id ?>">
                                Editar <i class="fa fa-edit"></i>
                            </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="alumno_delete.php?id=<?php echo $alumno->id ?>">
                                Borrar<i class="fa fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
