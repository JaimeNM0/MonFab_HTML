<?php

require_once __DIR__ . "/../interfaces/IToJson.php";
require_once __DIR__ . "/../others/Function.php";

class Element implements IToJson
{
    private $nombre;
    private $descripcion;
    private $numeroSerie;
    private $estado;
    private $prioridad;

    public function __construct($nombre, $descripcion, $numeroSerie, $estado, $prioridad)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->numeroSerie = $numeroSerie;
        $this->estado = $estado;
        $this->prioridad = $prioridad;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }
    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function getPrioridad()
    {
        return $this->prioridad;
    }
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
    }

    public function toJson()
    {
        $json = [
            "nombre" => $this->getNombre(),
            "descripcion" => $this->getDescripcion(),
            "numeroSerie" => $this->getNumeroSerie(),
            "estado" => $this->getEstado(),
            "prioridad" => $this->getPrioridad()
        ];
        return json_encode($json);
    }

    public function UpperLettersFormat($nserie)
    {
        $nserie = strtoupper($nserie);

        return $nserie;
    }

    public function firstUpperLetterFormat($word)
    {
        $word = strtolower($word);
        $word = substr_replace($word, strtoupper(substr($word, 0, 1)), 0, 1);

        return $word;
    }

    public function queryAllRecords($success, $connection)
    {
        try {
            $sql = "SELECT * FROM elementos";
            $sentencia = $connection->getPdo()->prepare($sql);
            $sentencia->execute();
            $data = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            enviarResultado($data, $success, $e->getMessage());
            return;
        }

        return $data;
    }

    public function queryOneRecord($success, $connection, $id)
    {
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

        return $data;
    }
}
