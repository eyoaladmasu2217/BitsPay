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
// $wallet=getUserWallet($user_id);
// echo $wallet['balance'];
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
    $stmt = $conn->prepare("INSERT INTO wallet_transaction(wallet_id, type, amount, description) VALUES(?,?,?,?)");
    $stmt->bind_param("isds", $wallet_id, $type, $amount, $description);
    return $stmt->execute();
}
function getWalletTransactions($user_id){
    global $conn;
    $stmt = $conn->prepare("SELECT wt.type, wt.amount, wt.description, wt.created_at FROM wallet_transaction wt JOIN wallet w ON wt.wallet_id = w.id WHERE w.user_id=? ORDER BY wt.created_at DESC LIMIT 5");
if (!$stmt) return [];
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result=$stmt->get_result();
$transactions = [];
while ($row = $result->fetch_assoc()){
    $transactions[]=$row;
}
$stmt->close();
return $transactions;
}
function creditWallet($user_id, $amount, $description="Top-up"){
    global $conn;
    $wallet = getUserWallet($user_id);
    if (!$wallet) return false;
    $new_balance =$wallet['balance']+$amount;
    if (!updateWalletBalance($user_id, $new_balance)){
        return false;
    }
    return logWalletTransaction($wallet['id'], 'credit',$amount,$description);
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

function payTuitionFromWallet($user_id, $amount ,$acedemic_year){
    $wallet = getUserWallet($user_id);
    if (!$wallet || $wallet['balance']<$amount){
        return ['success'=>false, 'message'=>'Insufficient wallet balance'];

    }
    $new_balance = $wallet['balance']-$amount;
    updateWalletBalance($user_id, $new_balance);

    logWalletTransaction($wallet['id'], 'debit', $amount, 'Tuition Payment');

    $reference = 'TUIT-'. strtoupper(uniqid());
    createTuitionTransaction($user_id, $amount,'wallet',$reference,'paid','tuition',$acedemic_year);

    return ['success'=>true, 'message'=>'Tuition paid successfully', 'reference'=>$reference];

}
function chapaTransactionExists($tx_ref){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM chapa_transactions WHERE tx_ref=?");
    $stmt->execute([$tx_ref]);
    return $stmt->fetch()!==false;
}
function recordChapaTransaction($tx_ref, $user_id, $amount){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO chapa_transactions(tx_ref, user_id, amount) VALUES(?,?,?)");
    $stmt->execute([$tx_ref, $user_id, $amount]);
}
?>