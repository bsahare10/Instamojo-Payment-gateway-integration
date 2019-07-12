<?php

    namespace app\components;

    class Instamojo {

        const version = '1.1';

        private static $endpoint = 'https://www.instamojo.com/api/1.1/';    // base url
        private static $api_key = '';        // api key
        private static $auth_token = '';    // api token

        public static function send_request($payload) {
            //Make sure cURL is available
            if (function_exists('curl_init') && function_exists('curl_setopt')) {
                //The headers are required for authentication

                $ch = curl_init();
                $key = self::$api_key;
                $token = self::$auth_token;

                curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "X-Api-Key:$key",
                    "X-Auth-Token:$token",
                ]);

                /*$payload = Array(
                    'purpose' => 'FIFA 16',
                    'amount' => '2500',
                    'phone' => '9999999999',
                    'buyer_name' => 'John Doe',
                    'redirect_url' => 'https://www.akastidesigns.com/redirect/',
                    'send_email' => true,
                    'webhook' => 'https://www.akastidesigns.com/webhook/',
                    'send_sms' => true,
                    'email' => 'foo@example.com',
                    'allow_repeated_payments' => false
                );*/

                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
                $response = curl_exec($ch);
                curl_close($ch); 

                $decoded_responce = json_decode($response,true);
                return $decoded_responce;       // get response in a variable header('Location: '.$var['payment_request']['longurl']);
            }
        }
    }
?>