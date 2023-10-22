<?php

require_once "./models/Element.php";
require_once "./interfaces/IToJson.php";


$nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : "";
$descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : "";
$numeroSerie = !empty($_POST["numeroSerie"]) ? $_POST["numeroSerie"] : "";
$estado = !empty($_POST["estado"]) ? $_POST["estado"] : "Inactivo";
$prioridad = !empty($_POST["prioridad"]) ? $_POST["prioridad"] : "Indefinido";

$estado = substr_replace($estado, strtoupper(substr($estado, 0, 1)), 0, 1);
$prioridad = substr_replace($prioridad, strtoupper(substr($prioridad, 0, 1)), 0, 1);

if(!empty($nombre) && !empty($numeroSerie)) {
    $ruta_archivo = "./../elementos.txt";

    $archivo_existe = file_exists($ruta_archivo);

    $num_registros = 0;
    if ($archivo_existe) {
        $lineas = file($ruta_archivo, FILE_SKIP_EMPTY_LINES);
        foreach ($lineas as $linea) {
            $num_registros++;
        }
        $num_registros = $num_registros - 2;
    }

    $archivo = fopen($ruta_archivo, "a");
    if ($archivo) {
        if (!$archivo_existe) {
            fwrite($archivo, "Id;Nombre;Descripción;Número de series;Estado;Prioridad" . PHP_EOL);
            fwrite($archivo, "\==================================================================================================/" . PHP_EOL);
        }

        fwrite($archivo, "$num_registros;$nombre;$descripcion;$numeroSerie;$estado;$prioridad" . PHP_EOL);

        fclose($archivo);
    } else {
        echo "Error al abrir el archivo.";
    }

    $element = new Element($nombre, $descripcion, $numeroSerie, $estado, $prioridad);
    
    $informacion = $element->toJson();
    echo $informacion;

} else {
    echo "Por favor, completa los campos nombre y número de serie del formulario.";
}