<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Exception;

class WhatsAppController extends Controller
{

    public function index()
    {
    	return view('whatsapp');
    }

    function store(Request $request)
    {
	//Note : Both the form and to numbers should be defined like whatsapp:CountryCode+PhoneNumber
	//For example
	//whatsapp:+1234567
	    $otp = random_int(111111, 999999);
        $twilioSid = config('twilio.TWILIO_SID');
        $twilioAuthToken = config('twilio.TWILIO_AUTH_TOKEN');
        $twilioWhatsappNumber = 'whatsapp:'.config('twilio.TWILIO_PHONE_NUMBER');
        $to = 'whatsapp:'.$request->phone;
    	$message = $request->message;

    	$client = new Client($twilioSid, $twilioAuthToken);

    	try {
    		$message = $client->messages->create(
    			$to,
    			array(
    				'from' => $twilioWhatsappNumber,
    				'body' => $message
    			)
    		);
    		return "Message sent successfully! SID: " . $message->sid;
    	} catch (Exception $e) {
    		return "Error sending message: " . $e->getMessage();
    	}
    }
}


