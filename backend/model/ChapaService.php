<?php
class ChapaService {
    private $secretKey;
    private $baseUrl = "https://api.chapa.co/v1";

    public function __construct() {
        $config = require __DIR__ . '/../config/chapa.php';
        $this->secretKey = $config['secret_key'];
    }

    /**
     * Initializes a Chapa transaction.
     */
    public function initializeTransaction($data) {
        $url = $this->baseUrl . "/transaction/initialize";
        $headers = [
            "Authorization: Bearer " . $this->secretKey,
            "Content-Type: application/json"
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) return ['status' => 'error', 'message' => $error];
        return json_decode($response, true);
    }

    /**
     * Verifies a Chapa transaction by its reference.
     */
    public function verifyTransaction($txt_ref) {
        $url = $this->baseUrl . "/transaction/verify/" . $txt_ref;
        $headers = ["Authorization: Bearer " . $this->secretKey];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) return ['status' => 'error', 'message' => $error];
        return json_decode($response, true);
    }
}
?>
