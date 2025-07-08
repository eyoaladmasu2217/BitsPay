<?php
require_once '../models/walletmodel.php';
$config = require_once '../config/chapa.php';
$chapaSecret =$config['secret_key'];//don't forget to change with the actual code
$tx_ref = $_GET['tx_ref'] ?? '';

if(!$tx_ref){
    http_response_code(400);
    exit('Missing tx_ref');
}
$ch =curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.chapa.co/v1/transaction/verify/$tx_ref");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_HTTPHEADER,[
    "Authorization: Bearer $chapaSecret"
]);
$response = curl_exec($ch);
curl_close($ch);

$data =json_decode($response, true);

if ($data['status']==='success'&& $data['data']['status']=='success'){
    $amount = floatval($data['data']['amount']);
    $email = $data['data']['email'];
    $parts= explode('_', $tx_ref);
    $user_id = intval($parts[1]);

    if($user_id){
        $wallet = getUserWallet($user_id);
        if (!$wallet) {
            createWallet($user_id, 0.00);
            $wallet = getUserWallet($user_id);
        }

        $new_balance = $wallet['balance'] + $amount;
        updateWalletBalance($user_id, $new_balance);
        logWalletTransaction($wallet['id'],'credit',$amount,'Chapa Deposit');
    }
}
?>