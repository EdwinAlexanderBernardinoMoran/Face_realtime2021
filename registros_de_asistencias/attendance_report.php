<?php
/*

  ____          _____               _ _           _       
 |  _ \        |  __ \             (_) |         | |      
 | |_) |_   _  | |__) |_ _ _ __ _____| |__  _   _| |_ ___ 
 |  _ <| | | | |  ___/ _` | '__|_  / | '_ \| | | | __/ _ \
 | |_) | |_| | | |  | (_| | |   / /| | |_) | |_| | ||  __/
 |____/ \__, | |_|   \__,_|_|  /___|_|_.__/ \__, |\__\___|
         __/ |                               __/ |        
        |___/                               |___/         
    
____________________________________
/ Si necesitas ayuda, contáctame en \
\ https://parzibyte.me               /
 ------------------------------------
        \   ^__^
         \  (oo)\_______
            (__)\       )\/\
                ||----w |
                ||     ||
Creado por Parzibyte (https://parzibyte.me).
------------------------------------------------------------------------------------------------
Si el código es útil para ti, puedes agradecerme siguiéndome: https://parzibyte.me/blog/sigueme/
Y compartiendo mi blog con tus amigos
También tengo canal de YouTube: https://www.youtube.com/channel/UCroP4BTWjfM0CkGB6AFUoBg?sub_confirmation=1
------------------------------------------------------------------------------------------------
*/ ?>
<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$inicio = date("Y-m-d");
$final = date("Y-m-d");
if (isset($_GET["inicio"])) {
    $inicio = $_GET["inicio"];
}
if (isset($_GET["final"])) {
    $fin = $_GET["final"];
}
$alumnos = getEmployeesWithAttendanceCount($inicio, $final);
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Reporte de asistencias</h1>
    </div>
    <div class="col-12">

        <form action="attendance_report.php" class="form-inline mb-2">
            <label for="start">Inicio:&nbsp;</label>
            <input required id="start" type="date" name="start" value="<?php echo $inicio ?>" class="form-control mr-2">
            <label for="end">Final:&nbsp;</label>
            <input required id="end" type="date" name="end" value="<?php echo $final ?>" class="form-control">
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
