<?php
require_once __DIR__ . '/model/WalletModel.php';
require_once __DIR__ . '/model/ChapaService.php';

// Log incoming request for debugging
$rawInput = file_get_contents('php://input');
file_put_contents('chapa_log.txt', date('[Y-m-d H:i:s] ') . "RAW: " . $rawInput . PHP_EOL, FILE_APPEND);

$tx_ref = $_REQUEST['tx_ref'] ?? $_REQUEST['trx_ref'] ?? '';
if (!$tx_ref) {
    http_response_code(400);
    exit('Missing tx_ref');
}

$chapa = new ChapaService();
$verifyResponse = $chapa->verifyTransaction($tx_ref);

file_put_contents('chapa_log.txt', date('[Y-m-d H:i:s] ') . "Verification response: " . json_encode($verifyResponse) . PHP_EOL, FILE_APPEND);

if (isset($verifyResponse['status']) && $verifyResponse['status'] === 'success') {
    $data = $verifyResponse['data'];
    $amount = floatval($data['amount']);
    $email = $data['email'];
    $tx_ref = $data['tx_ref'];

    // Extract user_id from tx_ref (format: bits-{user_id}_{random})
    $user_id = 0;
    if (preg_match('/^bits-(\d+)_/', $tx_ref, $matches)) {
        $user_id = intval($matches[1]);
    }

    if ($user_id) {
        // Prevent double processing
        if (!chapaTransactionExists($tx_ref)) {
            // Ensure wallet exists
            if (!walletExists($user_id)) {
                createWallet($user_id, 0.00);
            }

            // Credit the wallet using the refactored transaction-safe function
            if (creditWallet($user_id, $amount, 'Chapa Deposit')) {
                recordChapaTransaction($tx_ref, $user_id, $amount);
                file_put_contents('chapa_log.txt', date('[Y-m-d H:i:s] ') . "SUCCESS: Processed Chapa Deposit for User $user_id. Amount: $amount. Ref: $tx_ref" . PHP_EOL, FILE_APPEND);
                echo "Transaction processed successfully";
            } else {
                file_put_contents('chapa_log.txt', date('[Y-m-d H:i:s] ') . "ERROR: Failed to credit wallet for User $user_id. Amount: $amount." . PHP_EOL, FILE_APPEND);
                http_response_code(500);
                echo "Internal Error";
            }
        } else {
            file_put_contents('chapa_log.txt', date('[Y-m-d H:i:s] ') . "INFO: Transaction $tx_ref already exists. Skipping." . PHP_EOL, FILE_APPEND);
            echo "Transaction already processed";
        }
    } else {
        file_put_contents('chapa_log.txt', date('[Y-m-d H:i:s] ') . "ERROR: Could not extract user_id from reference: $tx_ref" . PHP_EOL, FILE_APPEND);
        http_response_code(400);
        echo "Invalid transaction reference";
    }
} else {
    file_put_contents('chapa_log.txt', date('[Y-m-d H:i:s] ') . "ERROR: Verification failed for reference: $tx_ref" . PHP_EOL, FILE_APPEND);
    http_response_code(400);
    echo "Transaction verification failed";
}
?>