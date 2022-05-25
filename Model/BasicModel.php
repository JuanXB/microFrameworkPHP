<?php
class BasicModel extends BasicEntity
{

  public function __construct($table, $adapter)
  {

    $this->table = (string) $table;
    parent::__construct($table, $adapter);
  }

  //Realiza una consulta a la base de datos.
  public function runSql(string $query, string $type, array $parameters)
  {
    $statment = $this->db()->prepare($query);
    if (!$statment) {
      throw new Exception('Fallo la query...');
    }
    $statment->bind_param($type, ...$parameters);
    $statment->execute();
    $result = $statment->get_result();

    $statment->close();

    if (!isset($result)) {
      $result = array();
    } elseif ($result == true) {
      if ($result->num_rows > 1) {

        while ($row =  $result->fetch_assoc()) {
          $resultSet[] = (object) $row;
        }
      } elseif ($result->num_rows == 1) {

        if ($row = $result->fetch_assoc()) {
          $resultSet[] = (object)$row;
        }
      } else {
        $resultSet = true;
      }
    } else {
      $resultSet = false;
    }

    return $resultSet;
  }
}
