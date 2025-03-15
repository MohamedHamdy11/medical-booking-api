<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppNotificationService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $this->client = new Client(config('twilio.TWILIO_SID'), config('twilio.TWILIO_AUTH_TOKEN'));
        $this->from = 'whatsapp:'.config('twilio.TWILIO_PHONE_NUMBER');
    }

    public function send($to, $message)
    {
        $this->client->messages->create(
            'whatsapp:'.$to,
            array(
                'from' => $this->from,
                'body' => $message,
            )
        );
    }

} // end of WhatsAppNotificationService