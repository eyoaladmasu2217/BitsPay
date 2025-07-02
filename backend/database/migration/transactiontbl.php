<?php
require "../csql.php";

$sql = "CREATE TABLE IF NOT EXISTS transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  amount DECIMAL(10,2)NOT NULL,
  method VARCHAR(100),
  reference VARCHAR(100),
  status VARCHAR(50),
  fee_type VARCHAR(50),
  acedemic_year VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) on delete CASCADE
  );"
;
if(mysqli_query($conn, $sql)) {
    echo "Table 'transactions' created successfully.<br>";
} else{
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

?>

