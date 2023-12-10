<?php
header('Content-Type: application/json');

require_once __DIR__ . "/models/Element.php";
require_once __DIR__ . "/others/Function.php";
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

$element = new Element($nombre, $descripcion, $nserie, $estado, $prioridad);
$connection = new DBConnection();

$nserie = $element->UpperLettersFormat($nserie);
$estado = $element->firstUpperLetterFormat($estado);
$prioridad = $element->firstUpperLetterFormat($prioridad);

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
    $sql = "SELECT * FROM elementos ORDER BY id DESC LIMIT 1;";
    $sentencia = $connection->getPdo()->prepare($sql);
    $sentencia->execute();
    $data = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    enviarResultado($data, $success, $e->getMessage());
    return;
}

if (!validateRecordExists($data, $success, "Ha habido un error al insertar.")) {
    return;
}

enviarResultado($data, true, "Se ha podido insertar correctamente.");
return;
