<?php
?>
<?php
if (!isset($_GET["date"])) {
    exit("[]");
}
include_once "functions.php";
$fecha = $_GET["date"];
$datos = getAsistenciaDataByDate($fecha);
echo json_encode($datos);
