<?php
class Connect
{
  private $driver;
  private $host, $user, $password, $dataBase, $charset;

  public function __construct()
  {
    //Se extraen los datos de configuracion para conectarse a la base de datos.
    $db_config = require_once 'config/database.php';
    $this->driver = $db_config["driver"];
    $this->host = $db_config["host"];
    $this->user = $db_config["user"];
    $this->password = $db_config["password"];
    $this->dataBase = $db_config["dataBase"];
    $this->charset = $db_config["charset"];
  }

  public function conexion()
  {
    if ($this->driver == "mysql" || $this->driver == NULL) {
      $conn = new mysqli($this->host, $this->user, $this->password, $this->dataBase);

      if ($conn->connect_errno) {
        die('Error de conexion: ' . $conn->connect_error);
      }
      //Se establecen el formato de caracteres que se usaran para hacer las sentencias sql al servidor.
      $conn->query("SET NAMES '" . $this->charset . "'");
    }

    return $conn;
  }

  public function close()
  {
    //TODO: Funcion para cerrar conexion.
  }
}
