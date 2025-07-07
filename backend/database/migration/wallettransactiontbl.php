<?php
require_once __DIR__ ."/../csql.php";

$sql = "CREATE TABLE IF NOT EXISTS  wallet_transaction(
    id INT AUTO_INCREMENT PRIMARY KEY,
    wallet_id INT NOT NULL,
    type ENUM('credit', 'debit') NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (wallet_id) REFERENCES wallet(id) ON DELETE CASCADE
);";
 if ($conn->query($sql)=== TRUE){
    echo "Table 'wallet_transaction' created successfully.<br>";
 } else {
    echo "Error creating table: " . $conn->error . "<br>";
 }
?>