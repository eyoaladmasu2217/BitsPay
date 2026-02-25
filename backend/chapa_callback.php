<?php
file_put_contents('chapa_log.txt', "RAW: " . file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
file_put_contents('chapa_log.txt', "GET: " . json_encode($_GET) . PHP_EOL, FILE_APPEND);
file_put_contents('chapa_log.txt', "REQUEST: " . json_encode($_REQUEST) . PHP_EOL, FILE_APPEND);

echo "Callback received<br>";

require_once dirname(__DIR__) . '/backend/model/WalletModel.php';
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
    file_put_contents('chapa_log.txt',"Extracted user_id: $raw_user_id" . PHP_EOL,FILE_APPEND); };

    file_put_contents('chapa_log.txt', "Raw user ID part: '" . $raw_user_id . "'" . PHP_EOL, FILE_APPEND);

    file_put_contents('chapa_log.txt', "User ID: $user_id, Amount: $amount" . PHP_EOL, FILE_APPEND);


    if ($user_id) {
        // Check if transaction already processed
        if (!chapaTransactionExists($tx_ref)) {
            // Ensure wallet exists
            if (!getUserWallet($user_id)) {
                createWallet($user_id, 0.00);
            }

            // Credit the wallet using the model function
            if (creditWallet($user_id, $amount, 'Chapa Deposit')) {
                // Record the transaction to prevent double-crediting
                recordChapaTransaction($tx_ref, $user_id, $amount);
                file_put_contents('chapa_log.txt', "Successfully processed Chapa Deposit: $tx_ref for User: $user_id" . PHP_EOL, FILE_APPEND);
            } else {
                file_put_contents('chapa_log.txt', "Failed to credit wallet for User: $user_id" . PHP_EOL, FILE_APPEND);
            }
        } else {
            file_put_contents('chapa_log.txt', "Transaction $tx_ref already exists. Skipping." . PHP_EOL, FILE_APPEND);
        }
    }

?>