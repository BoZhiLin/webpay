<?php

namespace App\Packages;

use Exception;
use Ixudra\Curl\Facades\Curl;

class FCMPackage
{
    public static function index(array $data)
    {
        if (!env('FCM_API_ACCESS_KEY')) {
            throw new Exception('FCM_API_ACCESS_KEY not defined');
        }

        $msg = [
            'title' => $data['title'],
            'body' => $data['body']
        ];

        $fields = [
            'registration_ids' => $data['ids'],
            'notification' => $msg
        ];

        $headers = [
            'Authorization: key='.env('FCM_API_ACCESS_KEY'),
            'Content-Type: application/json'
        ];

        $response = Curl::to('https://fcm.googleapis.com/fcm/send')
            ->withData($fields)
            ->withHeaders($headers)
            ->asJson()
            ->post();
        
        if (!$response) {
            throw new Exception('Push Notification was failed!');
        }
    }
}
