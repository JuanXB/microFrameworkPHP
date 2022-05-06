<?php
class BasicModel extends BasicEntity
{

  public function __construct($table, $adapter)
  {

    $this->table = (string) $table;
    parent::__construct($table, $adapter);
  }

  //Realiza una consulta a la base de datos.
  public function runSql($query)
  {
    $query = $this->db()->query($query);

    if ($query == true) {
      if ($query->num_rows > 1) {

        while ($row = $query->fetch_object()) {
          $resultSet[] = $row;
        }
      } elseif ($query->num_rows == 1) {

        if ($row = $query->fetch_object()) {
          $resultSet[] = $row;
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
