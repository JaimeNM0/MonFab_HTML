<?php
header('Content-Type: application/json');

require_once __DIR__ . "/models/Element.php";
require_once __DIR__ . "/../inc/DBConnection.php";

$nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : null;
$descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : null;
$nserie = !empty($_POST["nserie"]) ? $_POST["nserie"] : null;
$estado = !empty($_POST["estado"]) ? $_POST["estado"] : "Inactivo";
$prioridad = !empty($_POST["prioridad"]) ? $_POST["prioridad"] : "Indefinido";

$success = false;
$message = "ERROR";
$data = [];

if (empty($nombre) || empty($descripcion) || empty($nserie)) {
    enviarResultado($data, $success, "Tienes que rellenar el nombre, la descripción y el número de serie.");
    return;
}

$nserie = strtoupper($nserie);

$estado = strtolower($estado);
$estado = substr_replace($estado, strtoupper(substr($estado, 0, 1)), 0, 1);

$prioridad = strtolower($prioridad);
$prioridad = substr_replace($prioridad, strtoupper(substr($prioridad, 0, 1)), 0, 1);

$connection = new DBConnection();

try {
    $sql = "INSERT INTO elementos VALUES (null, :nombre, :descripcion, :nserie, :estado, :prioridad)";
    $sentencia = $connection->getPdo()->prepare($sql);
    $values = [
        ":nombre" => $nombre,
        ":descripcion" => $descripcion,
        ":nserie" => $nserie,
        ":estado" => $estado,
        ":prioridad" => $prioridad
    ];
    $sentencia->execute($values);
} catch (PDOException $e) {
    enviarResultado($data, $success, $e->getMessage());
    return;
}

try {
    $sql = "SELECT * FROM elementos WHERE nombre=:nombre AND descripcion=:descripcion AND nserie=:nserie AND estado=:estado AND prioridad=:prioridad";
    $sentencia = $connection->getPdo()->prepare($sql);
    $values = [
        ":nombre" => $nombre,
        ":descripcion" => $descripcion,
        ":nserie" => $nserie,
        ":estado" => $estado,
        ":prioridad" => $prioridad
    ];
    $sentencia->execute($values);
    $data = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    enviarResultado($data, $success, $e->getMessage());
    return;
}

if ($data === [] && $message === "ERROR") {
    enviarResultado($data, $success, "Ha habido un error al insertar.");
    return;
}

if (count($data) > 1) {
    $data = $data[count($data) - 1];
}

enviarResultado($data, true, "Se ha podido insertar correctamente.");
return;

function enviarResultado($data, $success, $message)
{
    $resultado = [
        "success" => $success,
        "message" => $message,
        "data" => $data
    ];

    echo json_encode($resultado, JSON_PRETTY_PRINT);
}
