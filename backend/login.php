<?php
session_start();
require 'csql.php';

$username = $_POST['login_username'];
$password = $_POST['login_password'];

// Only select the columns you need
$sql = "SELECT id, password FROM users WHERE username = ?";
$stmt = $connect->prepare($sql);   
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    
    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        // echo "Login successful. Welcome, " . htmlspecialchars($db_username) . "!";
        header("Location: ../home.php");
        exit();
    } else {
        echo "Invalid username or password";
    }
} else {
    echo "No user found with that username.";
}


?>