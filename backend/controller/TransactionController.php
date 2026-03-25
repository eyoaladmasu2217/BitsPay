<?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

require_once __DIR__ . "/../model/TransactionModel.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Invalid request method");
}

$user_id = $_SESSION['user_id'];
$amount  = floatval($_POST['amount'] ?? 0);
$method = htmlspecialchars(trim($_POST['method'] ?? ''));
$fee_type = htmlspecialchars(trim($_POST['fee_type'] ?? ''));
$acedemic_year = htmlspecialchars(trim($_POST['acedemic_year'] ?? ''));
$reference = strtoupper('TXN' . bin2hex(random_bytes(8)));

if ($amount <= 0 || empty($method) || empty($fee_type) || empty($acedemic_year)) {
    $_SESSION['error'] = 'Invalid transaction details';
    header('Location: ../../home.php');
    exit();
}

if (createTransaction($user_id, $amount, $method, $reference, $fee_type, $acedemic_year)) {
    $_SESSION['txn_ref'] = $reference;
    $_SESSION['success'] = "Transaction recorded successfully!";
    header("Location: ../../home.php");
    // header("Location: ../views/transaction_success.php"); // In case success view is needed
    exit();
} else {
    $_SESSION['error'] = 'Failed to record transaction';
    header('Location: ../../home.php');
    exit();
}
?>
