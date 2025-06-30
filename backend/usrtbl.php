<?php
require "csql.php";

$sql="CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);"
;
if(mysqli_query($connect, $sql)) {
    echo "Table 'users' created successfully.<br>";
} else{
    echo "Error creating table: " . mysqli_error($connect) . "<br>";
}

?>