<?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

require_once __DIR__ . '/../model/WalletModel.php';
require_once __DIR__ . '/../model/TransactionModel.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Invalid request method");
}

$user_id = $_SESSION['user_id'];
$amount = floatval($_POST['balance'] ?? 0);

if ($amount <= 0) {
    $_SESSION['error'] = 'Invalid top-up amount';
    header("Location: ../home.php");
    exit();
}

// Ensure wallet exists before topping up
if (!walletExists($user_id)) {
    createWallet($user_id, 0.00);
}

// Perform wallet credit
if (creditWallet($user_id, $amount, 'Manual Top-up')) {
    $_SESSION['success'] = "Wallet topped up successfully!";
    header("Location: ../home.php");
    exit();
} else {
    $_SESSION['error'] = "Failed to update wallet balance";
    header("Location: ../home.php");
    exit;
}
?>
