<?php

require_once "./models/Element.php";
require_once "./interfaces/IToJson.php";


$nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : "";
$descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : "";
$numeroSerie = !empty($_POST["numeroSerie"]) ? $_POST["numeroSerie"] : "";
$estado = !empty($_POST["estado"]) ? $_POST["estado"] : "Inactivo";
$prioridad = !empty($_POST["prioridad"]) ? $_POST["prioridad"] : "Indefinido";

$element = new Element($nombre, $descripcion, $numeroSerie, $estado, $prioridad);

$hola = $element->toJson();

echo $hola;
