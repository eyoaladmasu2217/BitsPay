<?php
session_start();
require_once __DIR__ . '/database/csql.php';


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
        http_response_code(200);
        header("Location: ../home.php");
        exit();
    } else {
        http_response_code(401);
        echo "Invalid username or password";
    }
} else {
    http_response_code(404);
    echo "No user found with that username.";
}


?>