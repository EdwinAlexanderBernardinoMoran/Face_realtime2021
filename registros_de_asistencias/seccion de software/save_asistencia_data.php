<?php
?>
<?php
include_once "functions.php";
$cargaUtil = json_decode(file_get_contents("php://input"));
if (!$cargaUtil) exit("No data present");
$respuesta = saveAsistenciaData($cargaUtil->fecha, $cargaUtil->alumnos);
echo json_encode($respuesta);