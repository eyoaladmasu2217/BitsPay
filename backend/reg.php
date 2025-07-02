<?php
require 'csql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        try {
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss", $email, $password);
                $stmt->execute();
              
                header("Location: ../home.php");
                exit();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
            if (isset($stmt)) {
                $stmt->close();
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                header("Location: ../index.php?error=exists");
                exit();
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        echo "Email and password are required.";
    }
} else {
    echo "Invalid request method.";
}

?>