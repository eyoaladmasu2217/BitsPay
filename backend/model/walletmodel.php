<?php
require_once __DIR__ ."/../database/csql.php";

function walletExists($user_id){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM wallet WHERE user_id=?");
    if (!$stmt) return false;
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}
function createWallet($user_id, $balance){
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
$wallet=getUserWallet($user_id);
echo $wallet['balance'];
function updateWalletBalance($user_id, $balance){
    global $conn;
    $stmt = $conn->prepare("UPDATE wallet SET balance=? WHERE user_id=?");
    if (!$stmt) return false;
    $stmt->bind_param("di", $balance, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
function logWalletTransaction($wallet_id,$type, $amount, $description){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO wallet_transaction(wallet_id, type, amoune, description) VALUES(?,?,?,?");
    $stmt->bind_param("isds", $wallet_id, $type, $amount, $description);
    return $stmt->execute();
}

function debitWallet($user_id, $amount, $description ='Payment'){
    global $conn;
    $wallet=getUserWallet($user_id);
    if (!$wallet || $wallet['balance']<$amount){
        return false;
    }
    $new_balance= $wallet['balance']-$amount;
    if (!updateWalletBalance($user_id, $new_balance)){
        return false;
    }
    return logWalletTransaction($wallet['id'], 'debit', $amount, $description);
}
?>