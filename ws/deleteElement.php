<?php
header('Content-Type: application/json');

require_once __DIR__ . "/models/Element.php";
require_once __DIR__ . "/others/Function.php";
require_once __DIR__ . "/../inc/DBConnection.php";

$id = !empty($_GET["id"]) ? $_GET["id"] : null;

$success = false;
$message = "ERROR";
$data = [];

if (!validateSentGet($data, $success)) {
    return;
}

$connection = new DBConnection();
$element = new Element(null, null, null, null, null);

if (!validateSentId($id, $data, $success)) {
    return;
}

$data = $element->queryOneRecord($success, $connection, $id);

if (!validateRecordExists($data, $success, "Ese registro no existe, entonces, no lo he podido borrar.")) {
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
