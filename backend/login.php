<?php
session_start();
require_once __DIR__ . '/database/csql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
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
        header("Location: ../home.php");
        exit();
    } else {
        header("Location: ../index.php?showLogin=1&error=invalid");
        exit();
    }
} else {
    header("Location: ../index.php?showLogin=1&error=notfound");
    exit();
}
}

?>