<?php
?>
<?php
include_once "functions.php";
$alumnos = getAlumnos();
echo json_encode($alumnos);
