<?php
header('Content-Type: application/json');

require_once __DIR__ . "/models/Element.php";
require_once __DIR__ . "/others/Function.php";
require_once __DIR__ . "/../inc/DBConnection.php";

$id = !empty($_GET["id"]) ? $_GET["id"] : null;
$nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : null;
$descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : null;
$nserie = !empty($_POST["nserie"]) ? $_POST["nserie"] : null;
$estado = !empty($_POST["estado"]) ? $_POST["estado"] : "Inactivo";
$prioridad = !empty($_POST["prioridad"]) ? $_POST["prioridad"] : "Indefinido";

$success = false;
$message = "ERROR";
$data = [];

if (!validateSentId($id, $data, $success)) {
    return;
}

$element = new Element(null, null, null, null, null);
$connection = new DBConnection();

$nserie = $element->UpperLettersFormat($nserie);
$estado = $element->firstUpperLetterFormat($estado);
$prioridad = $element->firstUpperLetterFormat($prioridad);

$data = $element->queryOneRecord($success, $connection, $id);

if (!validateRecordExists($data, $success, "Ese registro no existe.")) {
    return;
}

$sql = "UPDATE elementos SET";
$sql_set = "";
$sql_where = " WHERE id=:id";

$values = [":id" => $id];

if (!empty($nombre)) {
    $sql_set .= " nombre = :nombre,";
    $values[":nombre"] = $nombre;
}

if (!empty($descripcion)) {
    $sql_set .= " descripcion = :descripcion,";
    $values[":descripcion"] = $descripcion;
}

if (!empty($nserie)) {
    $sql_set .= " nserie = :nserie,";
    $values[":nserie"] = $nserie;
}

if (!empty($estado)) {
    $sql_set .= " estado = :estado,";
    $values[":estado"] = $estado;
}

if (!empty($prioridad)) {
    $sql_set .= " prioridad = :prioridad,";
    $values[":prioridad"] = $prioridad;
}

$sql_set = substr($sql_set, 0, strlen($sql_set) - 1);

try {
    $sentencia = $connection->getPdo()->prepare($sql . $sql_set . $sql_where);
    $sentencia->execute($values);
} catch (PDOException $e) {
    enviarResultado($data, $success, $e->getMessage());
    return;
}

$data = $element->queryOneRecord($success, $connection, $id);

enviarResultado($data, true, "Se ha podido modificar correctamente.");
return;
