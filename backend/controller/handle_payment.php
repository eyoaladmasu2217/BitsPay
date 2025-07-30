<?php
session_start();
require_once "../model/TransactionModel.php";
require_once "../model/walletmodel.php";

if(!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}

$user_id = $_SESSION['user_id'];
$paymentType = $_POST['paymentType'];
$amount = floatval($_POST['makePayment']);
$acedemic_year = date('Y');

if($paymentType ==='TuitionFull'||$paymentType ==='Tuition60'||$paymentType==='Tuition40'){
    $result = payTuitionFromWallet($user_id, $amount, $acedemic_year);

  if($result['success']){
    echo "Tuition payment successfull ! Reference:".$result['reference'];
    header("Location: ../../home.php");
    exit();
   } else{
    echo "Tuition payment failed: ".$result['message'];
  }
} else {
    echo"this service is not available yet";
}
?>