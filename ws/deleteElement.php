<?php
header('Content-Type: application/json');

require_once __DIR__ . "/models/Element.php";
require_once __DIR__ . "/../inc/DBConnection.php";

$id = !empty($_GET["id"]) ? $_GET["id"] : "";

$success = false;
$message = "ERROR";
$data = [];

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    enviarResultado($data, $success, "Envialo por GET, por favor.");
    return;
}

if (empty($id)) {
    enviarResultado($data, $success, "Tienes que enviar un id, por favor.");
    return;
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

if ($data === [] && $message === "ERROR") {
    enviarResultado($data, $success, "Ese registro no existe, entonces, no lo he podido borrar.");
    return;
}

try {
    $sql = "DELETE FROM elementos WHERE id=:id";
    $sentencia = $connection->getPdo()->prepare($sql);
    $values = [
        ":id" => $id
    ];
    $sentencia->execute($values);
} catch (PDOException $e) {
    enviarResultado($data, $success, $e->getMessage());
    return;
}

enviarResultado($data, true, "He podido borrar el registro " . $id . ".");
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
