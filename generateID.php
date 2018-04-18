<?php
  function generateID($column, $table, $min, $max)
  {
    include 'config.php';

    do
    {
      $id = rand($min, $max);

      $sql = "SELECT $column FROM $table WHERE $column = $id";
      $result = $conn -> query($sql);
    } while ($result -> num_rows > 0);

    return $id;
  }
?>
