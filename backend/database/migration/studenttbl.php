<?php
require "../csql.php";

$sql ="CREATE TABLE IF NOT EXISTS students(
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 student_id VARCHAR(20) UNIQUE NOT NULL,
 full_name VARCHAR(100) NOT NULL,
 program_id INT NOT NULL,
 year_of_study INT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
 FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE CASCADE);"
 ;
if(mysqli_query($conn, $sql)) {
    echo "Table 'users' created successfully.<br>";
} else{
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}
?>