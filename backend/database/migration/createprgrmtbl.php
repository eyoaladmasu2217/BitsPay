<?php
require "../csql.php";

$sql ="CREATE TABLE IF NOT EXISTS programs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  program_name VARCHAR(100) NOT NULL UNIQUE,
  department VARCHAR(100) NOT NULL,
  duration INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";
  if ($conn->query($sql) === TRUE) {
    echo "Table 'programs' created successfully.<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }
?>