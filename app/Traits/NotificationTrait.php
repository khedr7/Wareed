<?php

namespace App\Traits;

trait NotificationTrait
{
    public function send_notification($device_token, $data)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $SERVER_API_KEY = 'AAAAnBK6whQ:APA91bEdnwpJmExPk4ewu_0QCQx7AKRj8Zs7BEJ9D-jReXM-kNMQ17c7TFzkTxc_Nr1oo8pn1bo139TWSG0mqgsOxWq9jtYJonn09KZZphYg26lEzmy8hfNf7OalJNkLItSV76oHLRvM';

        $payload = [
            'to' => $device_token,
            'notification' => [
                'title' => $data['title'],
                'body' => $data['body'],
            ],
            'data' => [
                'service_id' => $data['service_id'],
                'service_type' => $data['service_type'],
            ]
        ];

        $headers = [
            'Authorization:key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $encodedPayload = json_encode($payload);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedPayload);

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);
    }
}
