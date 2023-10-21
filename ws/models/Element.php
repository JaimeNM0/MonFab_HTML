<?php

require_once "./interfaces/IToJson.php";

class Element implements IToJson {
    private $nombre;
    private $descripcion;
    private $numeroSerie;
    private $estado;
    private $prioridad;

    public function __construct($nombre, $descripcion, $numeroSerie, $estado, $prioridad) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->numeroSerie = $numeroSerie;
        $this->estado = $estado;
        $this->prioridad = $prioridad;
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    public function getNumeroSerie() {
        return $this->numeroSerie;
    }
    public function setNumeroSerie($numeroSerie) {
        $this->numeroSerie = $numeroSerie;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }
    public function getPrioridad() {
        return $this->prioridad;
    }
    public function setPrioridad($prioridad) {
        $this->prioridad = $prioridad;
    }

    public function toJson() {
        $json = [
            "nombre" => $this->getNombre(),
            "descripcion" => $this->getDescripcion(),
            "numeroSerie" => $this->getNumeroSerie(),
            "estado" => $this->getEstado(),
            "prioridad" => $this->getPrioridad()
        ];
        return json_encode($json);
    }
}
