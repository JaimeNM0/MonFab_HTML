<?php
header('Content-Type: application/json');

require_once __DIR__ . "/models/Element.php";
require_once __DIR__ . "/../inc/DBConnection.php";

$id = !empty($_GET["id"]) ? $_GET["id"] : "";

$success = true;
$message = "Tu petición a funcionado. yuju";
$data = [];

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo 'Envialo por GET, por favor.';
    return '';
}

$connection = new DBConnection();

if (empty($id)) {
    try {
        $sql = "select * from elementos";
        $sentencia = $connection->getPdo()->prepare($sql);
        $sentencia->execute();
        $data = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $success = false;
        $message = $e->getMessage();
    }

    $resultado = maquetarResultado($data, $success, $message);

    echo json_encode($resultado, JSON_PRETTY_PRINT);
    return '';
}

try {
    $sql = "select * from elementos where id=:datos";
    $sentencia = $connection->getPdo()->prepare($sql);
    $sentencia->execute(array(':datos' => $id));
    $data = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $success = false;
    $message = $e->getMessage();
}

if ($data === []) {
    $success = false;
    $message = 'Ese registro no existe.';
}

$resultado = maquetarResultado($data, $success, $message);

echo json_encode($resultado, JSON_PRETTY_PRINT);
return '';

function maquetarResultado($data, $success, $message)
{
    $resultado = [
        "success" => $success,
        "message" => $message,
        "data" => $data
    ];

    return $resultado;
}
