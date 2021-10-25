<?php
?>
<?php
if (!isset($_POST["nombre"]) || !isset($_POST["id"])) {
    exit("No data provided");
}
include_once "functions.php";
$nombre = $_POST["nombre"];
$id = $_POST["id"];
updateAlumno($nombre, $id);
header("Location: alumnos.php");

