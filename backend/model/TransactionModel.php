<?php
require_once __DIR__ . "/../database/csql.php";

function createTransaction($user_id, $amount,$method, $reference, $fee_type, $acedemic_year){
    global $conn;
    $stmt = $conn->prepare("INSERT INTO transactions(user_id,amount,mothod,reference,status,fee_type,acedemic_year) VALUES(?,?,?,?'pending',?,?)");
    $stmt->bind_param("idssss",$user_id,$amount,$method,$reference,$fee_type,$acedemic_year);
    return  $stmt->execute();
}
    function getUserTransaction($user_id){
     global $conn;
       $stmt =$conn->prepare("SELECT * FROM transactions WHERE user_id =?");
       $stmt->bind_param("i", $user_id);
       $stmt->execute();
       return $stmt->get_result(); 
    }
// a little bit of code is missing make sure u finish that
?>