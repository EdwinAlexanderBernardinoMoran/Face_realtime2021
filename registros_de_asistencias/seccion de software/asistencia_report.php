<?php
?>
<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$start = date("Y-m-d");
$end = date("Y-m-d");
if (isset($_GET["start"])) {
    $start = $_GET["start"];
}
if (isset($_GET["end"])) {
    $end = $_GET["end"];
}
$alumnos = getAlumnosWithAsistenciaCount($start, $end);
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Reporte de asistencias de alumnos</h1>
    </div>
    <div class="col-12">

        <form action="asistencia_report.php" class="form-inline mb-2">
            <label for="start">Inicio:&nbsp;</label>
            <input required id="start" type="date" name="start" value="<?php echo $start ?>" class="form-control mr-2">
            <label for="end">Final:&nbsp;</label>
            <input required id="end" type="date" name="end" value="<?php echo $end ?>" class="form-control">
            <button class="btn btn-success ml-2">Mostrar datos</button>
        </form>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Cuenta de presencia</th>
                        <th>Cuenta de ausencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $alumno) { ?>
                        <tr>
                            <td>
                                <?php echo $alumno->nombre ?>
                            </td>
                            <td>
                                <?php echo $alumno->presence_count ?>
                            </td>
                            <td>
                                <?php echo $alumno->absence_count ?>
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
