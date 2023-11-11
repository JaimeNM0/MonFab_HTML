<?php
header('Content-Type: application/json');

require_once __DIR__ . "/models/Element.php";
require_once __DIR__ . "/../inc/DBConnection.php";

$id = !empty($_GET["id"]) ? $_GET["id"] : "";
$nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : null;
$descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : null;
$nserie = !empty($_POST["nserie"]) ? $_POST["nserie"] : null;
$estado = !empty($_POST["estado"]) ? $_POST["estado"] : null;
$prioridad = !empty($_POST["prioridad"]) ? $_POST["prioridad"] : null;

$success = false;
$message = "ERROR";
$data = [];

if (empty($id)) {
    enviarResultado($data, $success, "Tienes que enviar un id, por favor.");
    return;
}

if (!empty($nserie)) {
    $nserie = strtoupper($nserie);
}

if (!empty($estado)) {
    $estado = strtolower($estado);
    $estado = substr_replace($estado, strtoupper(substr($estado, 0, 1)), 0, 1);
}

if (!empty($prioridad)) {
    $prioridad = strtolower($prioridad);
    $prioridad = substr_replace($prioridad, strtoupper(substr($prioridad, 0, 1)), 0, 1);
}

$connection = new DBConnection();

try {
    $sql = "SELECT * FROM elementos WHERE id=:id";
    $sentencia = $connection->getPdo()->prepare($sql);
    $values = [
        ":id" => $id
    ];
    $sentencia->execute($values);
    $data = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    enviarResultado($data, $success, $e->getMessage());
    return;
}

if ($data === []) {
    enviarResultado($data, $success, "Ese registro no existe.");
    return;
}

if (empty($nombre)) {
    $nombre = $data[0]["nombre"];
}

if (empty($descripcion)) {
    $descripcion = $data[0]["descripcion"];
}

if (empty($nserie)) {
    $nserie = $data[0]["nserie"];
}

if (empty($estado)) {
    $estado = $data[0]["estado"];
}

if (empty($prioridad)) {
    $prioridad = $data[0]["prioridad"];
}

try {
    $sql = "UPDATE elementos SET nombre=:nombre, descripcion=:descripcion, nserie=:nserie, estado=:estado, prioridad=:prioridad WHERE id=:id";
    $sentencia = $connection->getPdo()->prepare($sql);
    $values = [
        ":nombre" => $nombre,
        ":descripcion" => $descripcion,
        ":nserie" => $nserie,
        ":estado" => $estado,
        ":prioridad" => $prioridad,
        ":id" => $id
    ];
    $sentencia->execute($values);
} catch (PDOException $e) {
    enviarResultado($data, $success, $e->getMessage());
    return;
}

try {
    $sql = "SELECT * FROM elementos WHERE id=:id";
    $sentencia = $connection->getPdo()->prepare($sql);
    $values = [
        ":id" => $id
    ];
    $sentencia->execute($values);
    $data = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    enviarResultado($data, $success, $e->getMessage());
    return;
}

enviarResultado($data, true, "Se ha podido modificar correctamente.");
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
