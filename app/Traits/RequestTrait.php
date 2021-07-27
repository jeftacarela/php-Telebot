<?php

namespace App\Traits;

trait RequestTrait
{
    private function apiRequest($method,$parameters = [])
    {
        $url = 'https://api.telegram.org/bot'.env(key:'TELEGRAM_TOKEN').'/'.$method;
        $handle = curl_init($url);
        curl_setopt($handle, option: CURLOPT_RETURNTRANSFER, value: true);
        curl_setopt($handle, option: CURLOPT_CONNECTTIMEOUT, value: 5);
        curl_setopt($handle, option: CURLOPT_TIMEOUT, value: 60);
        curl_setopt($handle, option: CURLOPT_POSTFIELDS, value: http_build_query($parameters));
        $response = curl_exec($handle);
        if($response === false){
            curl_close($handle);
            return false;
        }
        curl_close($handle);
        $response = json_decode($handle, true);
        if($response['ok'] == false){
            return false;
        }
        $response = $response['result'];
        return $response;
    }
}