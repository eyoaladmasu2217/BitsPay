<?php
session_start();
require_once __DIR__ . '/database/csql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

$sql = "SELECT id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
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