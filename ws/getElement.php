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

if (empty($id)) {
    $data = $element->queryAllRecords($success, $connection);

    enviarResultado($data, true, "Se ha podido enviar todos los registros.");
    return;
}

$data = $element->queryOneRecord($success, $connection, $id);

if (!validateRecordExists($data, $success, "Ese registro no existe.")) {
    return;
}

enviarResultado($data, true, "Se ha podido encontrar ese registro.");
return;
