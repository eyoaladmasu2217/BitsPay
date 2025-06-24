<?php
$dbhost="localhost:3306";
$dbuser="root";
$dbpass="";
$dbname="bits_pay";
$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully to the database server.<br>";

?>