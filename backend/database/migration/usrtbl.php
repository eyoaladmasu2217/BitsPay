<?php
require "../csql.php";

$sql="CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('student','admin','finance_officer') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);"
;
if(mysqli_query($conn, $sql)) {
    http_response_code(200);
    echo "Table 'users' created successfully.<br>";
} else{
    http_response_code(500);
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

?>