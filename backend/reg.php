<?php
require 'csql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Make sure the form fields have names 'username' and 'password'
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $connect->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                // echo "Registration successful.";
                header("Location: ../home.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $connect->error;
        }
    } else {
        echo "Username and password are required.";
    }
} else {
    echo "Invalid request method.";
}

?>