<?php
require_once "../csql.php";

$sql = "CREATE TABLE IF NOT EXISTS chapa_transactions(
  id SERIAL PRIMARY KEY,
  tx_ref VARCHAR(191) UNIQUE NOT NULL,
  user_id INT NOT NULL,
  amount FLOAT NOT NULL,
  status VARCHAR(50) DEFAULT 'completed',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE);";
if (mysqli_query($conn, $sql)){
    echo "Table 'chapa_transactions' created successfully.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}
  
?>
