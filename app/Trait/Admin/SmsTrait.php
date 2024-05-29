<?php

namespace App\Trait\Admin;

use Exception;
use Twilio\Rest\Client;

trait SmsTrait
{
    public function sendSms($number, $title)
    {
        $receiverNumber = $number;
        $message = $title;
        $sid = config('twilio.sid');
        $token = config('twilio.token');
        $from = config('twilio.from');
        
        try {
            $client = new Client($sid, $token);
            $client->messages->create($receiverNumber, [
                'from' => $from,
                'body' => $message,
            ]);
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
