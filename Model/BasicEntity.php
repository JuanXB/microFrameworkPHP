<?php

// De esta clase heredarán los modelos que representen entidades.
class BasicEntity
{
  private $table;
  private $db;
  private $connect;

  public function __construct($table, $adapter)
  {
    $this->table = (string) $table;

    //conexion por defecto = null.
    $this->connect = null;
    // Se le pasa directamente la conexion a la base de datos por medio de $adapter.
    $this->db = $adapter;
  }

  public function getConnect()
  {
    return $this->connect;
  }

  public function db()
  {
    return $this->db;
  }

  public function getAll()
  {
    $query = $this->db()->query("SELECT * FROM $this->table ORDER BY id DESC");
    //Devolvemos el result set en forma de array de objetos. 

    while ($row = $query->fetch_object()) {
      $resultSet[] = $row;
    }
    if (!isset($resultSet)) {
      $resultSet = array();
    }
    return $resultSet;
  }

  public function getAllByColumDesc($column)
  {
    $column = $this->db()->real_escape_string($column);
    $query = "SELECT * FROM $this->table ORDER BY $column DESC";
    $query = $this->db()->query($query);

    //Devolvemos el result set en forma de array de objetos. 

    while ($row = $query->fetch_object()) {
      $resultSet[] = $row;
    }
    if (!isset($resultSet)) {
      $resultSet = array();
    }
    return $resultSet;
  }



  public function getById($id)
  {

    $query = $this->db()->query("SELECT * FROM $this->table WHERE id=$id");

    if ($row = $query->fetch_object()) {
      $resultSet = $row;
    }

    return $resultSet;
  }

  public function getBy($column, $value)
  {
    $value = $this->db->real_escape_string($value);
    $query = "SELECT * FROM $this->table WHERE $column = ?";
    $statment = $this->db()->prepare($query);

    if (is_numeric($value)) {
      $statment->bind_param("d", $value);
    } else {
      $statment->bind_param("s", $value);
    }
    $statment->execute();

    if ($row = $statment->fetch()) {
      $resultSet = $row;
    }

    return $resultSet;
  }

  public function deleteById($id)
  {
    $id = $this->db->real_escape_string($id);
    $query = $this->db->query("DELETE FROM $this->table WHERE id=$id");
    return $query;
  }

  public function deleteBy($column, $value)
  {
    $value = $this->db()->real_escape_string($value);
    $query = "DELETE FROM $this->table WHERE $column = ?";
    $statment = $this->db()->prepare($query);

    if (is_numeric($value)) {
      $statment->bind_param("d", $value);
    } else {
      $statment->bind_param("s", $value);
    }
    return $statment->execute();
  }


  public function setDataToModify($originalData, $newData)
  {
    if (isset($newData) && !empty($newData)) {
      return $newData;
    } else return $originalData;
  }


  //TODO: se pueden agregar mas metodos de consulta.
}
