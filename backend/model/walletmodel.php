<?php
require_once __DIR__ ."/../database/csql.php";

/**
 * Checks if a wallet exists for a given user.
 */
function walletExists($user_id){
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM wallet WHERE user_id=?");
    if (!$stmt) return false;
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

/**
 * Creates a new wallet for a user.
 */
function createWallet($user_id, $balance = 0.00){
    global $conn;
    if (walletExists($user_id)){
        return false;
    }
    $stmt = $conn->prepare("INSERT INTO wallet(user_id, balance) VALUES(?, ?)");
    if (!$stmt) return false;
    $stmt->bind_param("id", $user_id, $balance);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Fetches the wallet details for a user.
 */
function getUserWallet($user_id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM wallet WHERE user_id=?");
    if (!$stmt) return false;
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $wallet = $result->fetch_assoc();
    $stmt->close();
    return $wallet;
}

/**
 * Updates the wallet balance.
 * SHOULD BE CALLED WITHIN A TRANSACTION.
 */
function updateWalletBalance($user_id, $balance){
    global $conn;
    $stmt = $conn->prepare("UPDATE wallet SET balance=? WHERE user_id=?");
    if (!$stmt) return false;
    $stmt->bind_param("di", $balance, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Logs a wallet transaction.
 * SHOULD BE CALLED WITHIN A TRANSACTION.
 */
function logWalletTransaction($wallet_id, $type, $amount, $description){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO wallet_transaction(wallet_id, type, amount, description) VALUES(?,?,?,?)");
    if (!$stmt) return false;
    $stmt->bind_param("isds", $wallet_id, $type, $amount, $description);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Fetches recent wallet transactions for a user.
 */
function getWalletTransactions($user_id){
    global $conn;
    $stmt = $conn->prepare("SELECT wt.type, wt.amount, wt.description, wt.created_at FROM wallet_transaction wt JOIN wallet w ON wt.wallet_id = w.id WHERE w.user_id=? ORDER BY wt.created_at DESC LIMIT 5");
    if (!$stmt) return [];
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $transactions = [];
    while ($row = $result->fetch_assoc()){
        $transactions[] = $row;
    }
    $stmt->close();
    return $transactions;
}

/**
 * Credits the user's wallet using a transaction to ensure atomicity.
 */
function creditWallet($user_id, $amount, $description = "Top-up"){
    global $conn;
    $conn->begin_transaction();
    try {
        $wallet = getUserWallet($user_id);
        if (!$wallet) {
            throw new Exception("Wallet not found");
        }
        $new_balance = $wallet['balance'] + $amount;
        if (!updateWalletBalance($user_id, $new_balance)) {
            throw new Exception("Failed to update balance");
        }
        if (!logWalletTransaction($wallet['id'], 'credit', $amount, $description)) {
            throw new Exception("Failed to log transaction");
        }
        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}

/**
 * Debits the user's wallet using a transaction to ensure atomicity.
 */
function debitWallet($user_id, $amount, $description = 'Payment'){
    global $conn;
    $conn->begin_transaction();
    try {
        $wallet = getUserWallet($user_id);
        if (!$wallet || $wallet['balance'] < $amount) {
            throw new Exception("Insufficient funds or wallet not found");
        }
        $new_balance = $wallet['balance'] - $amount;
        if (!updateWalletBalance($user_id, $new_balance)) {
            throw new Exception("Failed to update balance");
        }
        if (!logWalletTransaction($wallet['id'], 'debit', $amount, $description)) {
            throw new Exception("Failed to log transaction");
        }
        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}

/**
 * Special function for tuition payment.
 */
function payTuitionFromWallet($user_id, $amount, $acedemic_year){
    global $conn;
    $conn->begin_transaction();
    try {
        $wallet = getUserWallet($user_id);
        if (!$wallet || $wallet['balance'] < $amount) {
            return ['success' => false, 'message' => 'Insufficient wallet balance'];
        }

        $new_balance = $wallet['balance'] - $amount;
        if (!updateWalletBalance($user_id, $new_balance)) {
            throw new Exception("Failed to update wallet balance");
        }

        if (!logWalletTransaction($wallet['id'], 'debit', $amount, 'Tuition Payment')) {
            throw new Exception("Failed to log wallet transaction");
        }

        $reference = 'TUIT-' . strtoupper(bin2hex(random_bytes(5)));
        require_once __DIR__ . "/TransactionModel.php";
        if (!createTransaction($user_id, $amount, 'wallet', $reference, 'tuition', $acedemic_year)) {
            throw new Exception("Failed to create tuition record");
        }

        $conn->commit();
        return ['success' => true, 'message' => 'Tuition paid successfully', 'reference' => $reference];
    } catch (Exception $e) {
        $conn->rollback();
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

/**
 * Checks if a Chapa transaction has already been processed.
 */
function chapaTransactionExists($tx_ref){
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM chapa_transactions WHERE tx_ref=?");
    if (!$stmt) return false;
    $stmt->bind_param("s", $tx_ref);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

/**
 * Records a Chapa transaction.
 */
function recordChapaTransaction($tx_ref, $user_id, $amount){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO chapa_transactions(tx_ref, user_id, amount) VALUES(?,?,?)");
    if (!$stmt) return false;
    $stmt->bind_param("sid", $tx_ref, $user_id, $amount);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>