<?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

require_once __DIR__ . '/../model/ChapaService.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Invalid request method");
}

$user_id = $_SESSION['user_id'];
$amount = floatval($_POST['deposit_amount'] ?? 0);
$email = $_POST['user_email'] ?? '';

if ($amount <= 0 || empty($email)) {
    $_SESSION['error'] = 'Invalid deposit details';
    header('Location: ../home.php');
    exit();
}

$chapa = new ChapaService();
$tx_ref = "bits-" . $user_id . "_" . bin2hex(random_bytes(5));

$data = [
    'amount' => $amount,
    'currency' => 'ETB',
    'email' => $email,
    'tx_ref' => $tx_ref,
    'callback_url' => 'https://bitspay.example/backend/chapa_callback.php', // Replace with actual URL
    'return_url' => 'https://bitspay.example/home.php', // Replace with actual URL
    'customization' => [
        'title' => 'BitsPay Wallet Deposit',
        'description' => 'Top-up your campus payment wallet'
    ]
];

$initResponse = $chapa->initializeTransaction($data);

if (isset($initResponse['status']) && $initResponse['status'] === 'success') {
    // Redirect user to Chapa checkout page
    header("Location: " . $initResponse['data']['checkout_url']);
    exit();
} else {
    $_SESSION['error'] = 'Chapa initialization failed: ' . ($initResponse['message'] ?? 'Unknown error');
    header('Location: ../home.php');
    exit();
}
?>
