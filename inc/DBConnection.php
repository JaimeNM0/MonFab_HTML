<?php

require_once __DIR__ . "/../config.php";
class DBConnection
{
    protected $pdo;

    public function __construct()
    {
        try {
            //se crea el objeto de tipo conexión
            $this->pdo = new PDO('mysql:host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET CHARACTER SET utf8");
            //return $this->pdo;
        } catch (Exception $e) {
            echo "Error: " . $e->getline();
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
    /*public function get_productos($datos)
	{
		$sql = "select * from ARTÍCULOS where PAISDEORIGEN=:datos";
		$sentencia = $this->pdo->prepare($sql);
		$sentencia->execute(array(':datos' => $datos));
		$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}*/
}
