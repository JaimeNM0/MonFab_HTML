<?php

/**
 * Mirar que hacen esta variables mágicas:
 * __FILE__
 * __DIR__
 */

require_once __DIR__ . "/models/Element.php";
//require_once "./interfaces/IToJson.php";

$nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : "";
$descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : "";
$numeroSerie = !empty($_POST["numeroSerie"]) ? $_POST["numeroSerie"] : "";
$estado = !empty($_POST["estado"]) ? $_POST["estado"] : "Inactivo";
$prioridad = !empty($_POST["prioridad"]) ? $_POST["prioridad"] : "Indefinido";

$estado = substr_replace($estado, strtoupper(substr($estado, 0, 1)), 0, 1);
$prioridad = substr_replace($prioridad, strtoupper(substr($prioridad, 0, 1)), 0, 1);

if (empty($nombre) && empty($numeroSerie)) {
    echo "Por favor, completa los campos nombre y número de serie del formulario.";
    return "";
}

$ruta_archivo = "./../elementos.txt";

$archivo_existe = file_exists($ruta_archivo);

$num_registros = 0;
if ($archivo_existe) {
    $lineas = file($ruta_archivo, FILE_SKIP_EMPTY_LINES);
    $num_registros = count($lineas) - 2;
}

$archivo = fopen($ruta_archivo, "a");
if (!$archivo) {
    echo "Error al abrir el archivo.";
    return "";
}

if (!$archivo_existe) {
    fwrite($archivo, "Id;Nombre;Descripción;Número de series;Estado;Prioridad" . PHP_EOL);
    fwrite($archivo, "\==================================================================================================/" . PHP_EOL);
}

fwrite($archivo, "$num_registros;$nombre;$descripcion;$numeroSerie;$estado;$prioridad" . PHP_EOL);

fclose($archivo);

$element = new Element($nombre, $descripcion, $numeroSerie, $estado, $prioridad);

$informacion = $element->toJson();
echo $informacion;
