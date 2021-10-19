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
function getEmployeesWithAttendanceCount($start, $end)
{
    $query = "select alumnos.nombre, 
sum(case when status = 'presente' then 1 else 0 end) as presence_count,
sum(case when status = 'ausente' then 1 else 0 end) as absence_count 
 from alumnos_asistencias
 inner join alumnos on alumnos.id = alumnos_asistencias.alumno_id
 where date >= ? and date <= ?
 group by alumno_id;";
    $db = getDatabase();
    $statement = $db->prepare($query);
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
}

function saveAttendanceData($fecha, $alumnos)
{
    deleteAttendanceDataByDate($fecha);
    $db = getDatabase();
    $db->beginTransaction();
    $statement = $db->prepare("INSERT INTO alumnos_asistencias(alumno_id, date, status) VALUES (?, ?, ?)");
    foreach ($alumnos as $alumno) {
        $statement->execute([$alumno->id, $fecha, $alumno->status]);
    }
    $db->commit();
    return true;
}

function deleteAttendanceDataByDate($fecha)
{
    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM alumnos_asistencias WHERE date = ?");
    return $statement->execute([$fecha]);
}
function getAttendanceDataByDate($fecha)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT alumno_id, status FROM alumnos_asistencias WHERE date = ?");
    $statement->execute([$fecha]);
    return $statement->fetchAll();
}


function deleteEmployee($id)
{
    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM alumnos WHERE id = ?");
    return $statement->execute([$id]);
}

function updateEmployee($nombre, $id)
{
    $db = getDatabase();
    $statement = $db->prepare("UPDATE alumnos SET nombre = ? WHERE id = ?");
    return $statement->execute([$nombre, $id]);
}
function getEmployeeById($id)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT id, nombre FROM alumnos WHERE id = ?");
    $statement->execute([$id]);
    return $statement->fetchObject();
}

function saveEmployee($nombre)
{
    $db = getDatabase();
    $statement = $db->prepare("INSERT INTO alumnos(nombre) VALUES (?)");
    return $statement->execute([$nombre]);
}

function getEmployees()
{
    $db = getDatabase();
    $statement = $db->query("SELECT id, nombre FROM alumnos");
    return $statement->fetchAll();
}

function getVarFromEnvironmentVariables($key)
{
    if (defined("_ENV_CACHE")) {
        $vars = _ENV_CACHE;
    } else {
        $file = "env.php";
        if (!file_exists($file)) {
            throw new Exception("The environment file ($file) does not exists. Please create it");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE", $vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("The specified key (" . $key . ") does not exist in the environment file");
    }
}

function getDatabase()
{
    $password = getVarFromEnvironmentVariables("MYSQL_PASSWORD");
    $user = getVarFromEnvironmentVariables("MYSQL_USER");
    $dbName = getVarFromEnvironmentVariables("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}
