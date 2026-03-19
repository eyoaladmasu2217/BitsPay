<?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
require_once "../model/TransactionModel.php";

if (!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}
$user_id =$_SESSION['user_id'];
$amount  =floatval($_POST['amount']);
$method = htmlspecialchars(trim($_POST['method']));
$reference=strtoupper('TXN'.bin2hex(random_bytes(8)));
$fee_type = htmlspecialchars(trim($_POST['fee_type']));
$acedemic_year = htmlspecialchars(trim($_POST['acedemic_year']));

if ($amount <=0 || !$method || !$fee_type || !$acedemic_year){ <?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
require_once "../model/TransactionModel.php";

if (!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}
$user_id =$_SESSION['user_id'];
$amount  =floatval($_POST['amount']);
$method = htmlspecialchars(trim($_POST['method']));
$reference=strtoupper('TXN'.bin2hex(random_bytes(8)));
$fee_type = htmlspecialchars(trim($_POST['fee_type']));
$acedemic_year = htmlspecialchars(trim($_POST['acedemic_year']));

if ($amount <=0 || !$method || !$fee_type || !$acedemic_year){
    die("invalis input submitted");
}
if (createTransaction($user_id,$amount,$method,$reference,$fee_type,$acedemic_year)){
    $_SESSION['txn_ref']=$reference;
    header("Location: ../views/transaction_success.php");
    exit();
}else{
    <?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
require_once "../model/TransactionModel.php";

if (!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}
$user_id =$_SESSION['user_id'];
$amount  =floatval($_POST['amount']);
$method = htmlspecialchars(trim($_POST['method']));
$reference=strtoupper('TXN'.bin2hex(random_bytes(8)));
$fee_type = htmlspecialchars(trim($_POST['fee_type']));
$acedemic_year = htmlspecialchars(trim($_POST['acedemic_year']));

if ($amount <=0 || !$method || !$fee_type || !$acedemic_year){ <?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
require_once "../model/TransactionModel.php";

if (!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}
$user_id =$_SESSION['user_id'];
$amount  =floatval($_POST['amount']);
$method = htmlspecialchars(trim($_POST['method']));
$reference=strtoupper('TXN'.bin2hex(random_bytes(8)));
$fee_type = htmlspecialchars(trim($_POST['fee_type']));
$acedemic_year = htmlspecialchars(trim($_POST['acedemic_year']));

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
SESSION['error'] = 'Invalid input submitted'; header('Location: ../../home.php'); exit(); }
if (createTransaction($user_id,$amount,$method,$reference,$fee_type,$acedemic_year)){
    $_SESSION['txn_ref']=$reference;
    header("Location: ../views/transaction_success.php");
    exit();
}else{
    echo "failed to record transaction";
}
?>

SESSION['error'] = 'Failed to record transaction'; header('Location: ../../home.php'); exit();
}
?>
SESSION['error'] = 'Invalid input submitted'; header('Location: ../../home.php'); exit(); }
if (createTransaction($user_id,$amount,$method,$reference,$fee_type,$acedemic_year)){
    $_SESSION['txn_ref']=$reference;
    header("Location: ../views/transaction_success.php");
    exit();
}else{
    <?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
require_once "../model/TransactionModel.php";

if (!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}
$user_id =$_SESSION['user_id'];
$amount  =floatval($_POST['amount']);
$method = htmlspecialchars(trim($_POST['method']));
$reference=strtoupper('TXN'.bin2hex(random_bytes(8)));
$fee_type = htmlspecialchars(trim($_POST['fee_type']));
$acedemic_year = htmlspecialchars(trim($_POST['acedemic_year']));

if ($amount <=0 || !$method || !$fee_type || !$acedemic_year){ <?php
session_set_cookie_params([
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
require_once "../model/TransactionModel.php";

if (!isset($_SESSION['user_id'])){
    die("Unauthorized access");
}
$user_id =$_SESSION['user_id'];
$amount  =floatval($_POST['amount']);
$method = htmlspecialchars(trim($_POST['method']));
$reference=strtoupper('TXN'.bin2hex(random_bytes(8)));
$fee_type = htmlspecialchars(trim($_POST['fee_type']));
$acedemic_year = htmlspecialchars(trim($_POST['acedemic_year']));

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
SESSION['error'] = 'Invalid input submitted'; header('Location: ../../home.php'); exit(); }
if (createTransaction($user_id,$amount,$method,$reference,$fee_type,$acedemic_year)){
    $_SESSION['txn_ref']=$reference;
    header("Location: ../views/transaction_success.php");
    exit();
}else{
    echo "failed to record transaction";
}
?>

SESSION['error'] = 'Failed to record transaction'; header('Location: ../../home.php'); exit();
}
?>


