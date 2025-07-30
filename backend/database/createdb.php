<?php
require "csql.php";

$sql = "CREATE DATABASE IF NOT EXISTS bits_pay";
if (mysqli_query($connect, $sql)) {
    http_response_code(200);
    echo "Database created successfully.<br>";
} else {
    http_response_code(500);
    echo "Error creating database: " . mysqli_error($connect) . "<br>";
}
//this is a comment for testing
 
?>