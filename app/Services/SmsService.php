<?php

namespace App\Services;

class SmsService {

    public function sendSms($mobileNumber = null, $message = null) {
        try {
            $returnResponse = [];
            $smsConfigurations = \config('sms');
            $userName = $smsConfigurations['username'];
            $password = $smsConfigurations['password'];
            $senderId = $smsConfigurations['sender_id'];
            if ($smsConfigurations['is_enable']) {
                $ch = curl_init();
                $apiUrl = $smsConfigurations['host_url'] . 'vendorsms/pushsms.aspx?user=' . $userName . '&password=' . $password . '&msisdn=91' .
                        $mobileNumber . '&sid=' . $senderId . '&msg=' . urlencode($message) . '&fl=0&gwid=2';
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);
                $result = json_decode($response);
                curl_close($ch);
                $returnResponse['response'] = $response;
                if($result && isset($result->ErrorCode) && $result->ErrorCode == "000") {
                    $returnResponse['status'] = true;
                }
                else{
                    $returnResponse['status'] = false;
                }
            }
            else{
                $returnResponse['status'] = false;
                $returnResponse['response'] = "SMS service not enable";
            }
            return $returnResponse;
        } catch (\Exception $ex) {
            echo $ex;
            die;
        }
    }

}
