<?php
require "csql.php";

$sql = "CREATE DATABASE IF NOT EXISTS bits_pay";
if (mysqli_query($connect, $sql)) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . mysqli_error($connect) . "<br>";
}
//this is a comment for testing
 
?>