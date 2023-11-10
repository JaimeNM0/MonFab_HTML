<?php
header('Content-Type: text/html; charset=utf-8');

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

if (empty($id)) {
    $connection = new DBConnection();

    try {
        $sql = "select * from elementos";
        $sentencia = $connection->getPdo()->prepare($sql);
        $sentencia->execute();
        $data = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $success = false;
        $message = $e->getMessage();
    }
    $resultado = [
        "success" => $success,
        "message" => $message,
        "data" => $data
    ];
    echo json_encode($resultado);
}
