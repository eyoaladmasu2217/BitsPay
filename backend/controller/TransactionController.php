<?php
session_start();
require_once "../models/TransactionModel.php";

if (!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}
$user_id =$_SESSION['user_id'];
$amount  =floatval($_POST['amount']);
$method =trim($_POST['method']);
$reference=strtoupper(uniqid('TXN'));
$fee_type =trim($_POST['fee_type']);
$acedemic_year =trim($_POST['acedemic_year']);

if ($amount <=0 || !$method || !$fee_type || !$acedemic_year){
    die("invalis input submitted");
}
if (createTransaction($user_id,$amount,$method,$reference,$fee_type,$acedemic_year)){
    $_SESSION['txn_ref']=$reference;
    header("Location: ../views/transaction_success.php");
    exit();
}else{
    echo "failed to record transaction";
}
?>
