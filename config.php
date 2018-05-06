<?php
  $servername = 'localhost';
  $username = 'root';
  $password = 'admin';
  $dbName = 'webapp';

  $conn = new mysqli($servername, $username, $password, $dbName);

  if($conn->connect_error)
  {
    die("Connection failed: " . $conn->connect_error);
  }
?>
