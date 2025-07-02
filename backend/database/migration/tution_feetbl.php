<?php
require "../csql.php";

$sql= "CREATE TABLE IF NOT EXISTS tuition_fee (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  fee_type VARCHAR(50),
  academic_year VARCHAR(20),
  program_id INT ,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE SET NULL
);"
;if(mysqli_query($conn, $sql)) {
    echo "Table 'fee' created successfully.<br>";
} else{
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}
?>