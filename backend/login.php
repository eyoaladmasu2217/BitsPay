<?php
require_once __DIR__ . '/config/csrf.php';
require_once __DIR__ . '/database/csql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die("CSRF validation failed.");
    }
    if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    if (strlen($email) > 255) {
        header("Location: ../index.php?showLogin=1&error=invalid");
        exit();
    }
    $password = $_POST['password'];
    if (strlen($password) > 72) {
        header("Location: ../index.php?showLogin=1&error=invalid");
        exit();
    }

    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $db_email, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $id;
            $_SESSION['user_email'] = $db_email;
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