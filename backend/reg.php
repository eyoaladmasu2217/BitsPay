<?php
require_once __DIR__ .'/database/csql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../index.php?error=invalid_email");
            exit();
        }
        
        $plain_password = $_POST['password'];

        // Password complexity check
        if (strlen($plain_password) < 8 || !preg_match("/[0-9]/", $plain_password)) {
            header("Location: ../index.php?error=password_weak");
            exit();
        }

        $password = password_hash($plain_password, PASSWORD_DEFAULT);
        try {
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
              
                header("Location: ../index.php?showLogin=1");
                exit();
            } else {
                http_response_code(500);
                echo "Error preparing statement. Please try again later.";
            }
            if (isset($stmt)) {
                $stmt->close();
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                header("Location: ../index.php?error=exists");
                exit();
            } else {
                echo "An unexpected error occurred.";
            }
        }
    } else {
        echo "Email and password are required.";
    }
} else {
    echo "Invalid request method.";
}

?>