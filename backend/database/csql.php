<?php
$dbhost="localhost:3306";
$dbuser="root";
$dbpass="";
$dbname="bits_pay";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    http_response_code(500);
    die("Connection failed: " . mysqli_connect_error());
    }
// echo "Connected successfully to the database server.<br>";

?>