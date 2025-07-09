<?php
file_put_contents('chapa_log.txt', "RAW: " . file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
file_put_contents('chapa_log.txt', "GET: " . json_encode($_GET) . PHP_EOL, FILE_APPEND);
file_put_contents('chapa_log.txt', "REQUEST: " . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);

echo "Callback received<br>";

require_once dirname(__DIR__) . '/backend/model/walletmodel.php';
$config = require_once dirname(__DIR__). '/backend/config/chapa.php';
$chapaSecret =$config['secret_key'];//don't forget to change with the actual code
$tx_ref = $_REQUEST['tx_ref'] ??  $_REQUEST['trx_ref'] ??'';

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
if ($response === false){
    file_put_contents('chapa_log.txt', "Curl error:". curl_error($ch).PHP_EOL, FILE_APPEND);
}
curl_close($ch);


file_put_contents('chapa_log.txt', "Chapa API response: $response" . PHP_EOL, FILE_APPEND);


$data =json_decode($response, true);

if ($data['status']==='success'&& $data['data']['status']=='success'){
    $amount = floatval($data['data']['amount']);
    $email = $data['data']['email'];
    $tx_ref = $data['data']['tx_ref'];

    file_put_contents('chapa_log.txt',"Raw tx_ref: $tx_ref" . PHP_EOL, FILE_APPEND);
    $user_id=0;

    if(preg_match('/^bits-(\d+)_/',$tx_ref, $matches)){
        $raw_user_id = $matches[1];
        $user_id= intval($raw_user_id);
    }
    file_put_contents('chapa_log.txt',"Extracted user_id: $raw_user_id" . PHP_EOL,FILE_APPEND);

    };

    file_put_contents('chapa_log.txt', "Raw user ID part: '" . $raw_user_id . "'" . PHP_EOL, FILE_APPEND);

    file_put_contents('chapa_log.txt', "User ID: $user_id, Amount: $amount" . PHP_EOL, FILE_APPEND);


    if($user_id){
        file_put_contents('chapa_log.txt', "Looking for wallet for user $user_id". PHP_EOL, FILE_APPEND);

        $walletRow = getUserWallet($user_id);
        file_put_contents('chapa_log.txt', "Initial wallet lookup:" .print_r($walletRow, true). PHP_EOL, FILE_APPEND);

        if (!$walletRow) {
            file_put_contents('chapa_log.txt', "No wallet found . Creating wallet for user $user_id" .PHP_EOL, FILE_APPEND);
            createWallet($user_id, 0.00);
            $walletRowt = getUserWallet($user_id);
           file_put_contents('chapa_log.txt', "Wallet after creation: " . print_r($walletRow, true). PHP_EOL, FILE_APPEND);
        }

       if ($walletRow) {
        $new_balance = $walletRow['balance'] + $amount;
        file_put_contents('chapa_log.txt', "updating balance to $new_balance".PHP_EOL, FILE_APPEND);
        updateWalletBalance($user_id, $new_balance);
        logWalletTransaction($walletRow['id'], 'credit', $amount, 'Chapa Deposit');
        file_put_contents('chapa_log.txt', "Wallet updated successfully for user $user_id" . PHP_EOL, FILE_APPEND);
    } else {
        file_put_contents('chapa_log.txt', "Failed to fetch wallet for user $user_id" . PHP_EOL, FILE_APPEND);
       }

    }

?>