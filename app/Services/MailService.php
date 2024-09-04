<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendEmail($mailable, $recipient)
    {
        // Mailer smtp / api
        $mailer = 'smtp';

        try {
            Mail::mailer($mailer)
                ->to($recipient)
                ->send($mailable);

            // logger()->info('Email from primary SMTP Sent');
        } catch (Exception $e) {
            // logger()->info('Email Sending failed from Primary SMTP');

            Mail::mailer($mailer)
                ->to($recipient)
                ->send($mailable);
            // logger()->info('Email Sending failed from backup SMTP');
            // logger()->info('Email Failed');
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
