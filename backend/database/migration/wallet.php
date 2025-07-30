<?php
require_once '../csql.php';

$sql = "CREATE TABLE IF NOT EXISTS  wallet (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE ,
  balance DECIMAL(10,2) NOT NULL ,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE 
  );"
;
if(mysqli_query($conn,$sql)){
    http_response_code(200);
    echo"Table 'wallet'created successfully<br>";

}else {
    http_response_code(500);
    echo "Error creating table ". mysqli_error($conn)."<br>";
}


?>