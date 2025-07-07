<?php
session_start();
require_once '../models/walletmodel.php';
require_once '../models/TransactionModel.php';
if (!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}
if ($_SERVER['REQUEST_METHOD'] !=='POST'){
    die("Invalid request method");
}
if (!isset($_POST['balance'])|| !is_numeric($_POST['balance'])){
    die("Invalid balance input");
}
$user_id=$_SESSION['user_id'];
$balance=floatval($_POST['balance']);
if($balance <= 0){
    die("balance can't be less than 0");
}

$wallet=getUserWallet($user_id);
if(!$wallet){
    createWallet($user_id, 0.00);
    $wallet=getUserWallet($user_id);
}
$new_balance = $wallet['balance']+ $balance;
$success = updateWalletBalance($user_id, $new_balance);
if ($success){
    logWalletTransaction($wallet['id'],'credit',$balance,'Manual Top-up');
    header("Location: ../home.php");
    exit;
} else{
    die("Failed to update wallet balance");
}
?>