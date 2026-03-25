<?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

require_once __DIR__ . "/../model/TransactionModel.php";
require_once __DIR__ . "/../model/WalletModel.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Invalid request method");
}

$user_id = $_SESSION['user_id'];
$paymentType = $_POST['paymentType'] ?? '';
$amount = floatval($_POST['makePayment'] ?? 0);

if ($amount <= 0) {
    $_SESSION['error'] = 'Invalid payment amount';
    header('Location: ../../home.php');
    exit();
}

$acedemic_year = date('Y');

// Handle Tuition Payments From Wallet
if (in_array($paymentType, ['TuitionFull', 'Tuition60', 'Tuition40'])) {
    $result = payTuitionFromWallet($user_id, $amount, $acedemic_year);

    if ($result['success']) {
        $_SESSION['success'] = "Tuition payment successful! Reference: " . $result['reference'];
        header("Location: ../../home.php");
        exit();
    } else {
        $_SESSION['error'] = 'Tuition payment failed: ' . $result['message'];
        header('Location: ../../home.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'This service is not available yet';
    header('Location: ../../home.php');
    exit();
}
?>
