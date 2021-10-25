<?php
?>
<?php
if (!isset($_POST["nombre"])) {
    exit("No data provided");
}
include_once "functions.php";
$nombre = $_POST["nombre"];
saveAlumno($nombre);
header("Location: alumnos.php");
