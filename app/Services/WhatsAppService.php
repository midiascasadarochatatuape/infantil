<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $token;
    protected $phoneNumberId;

    public function __construct()
    {
        $this->token = env('WHATSAPP_TOKEN');
        $this->phoneNumberId = env('WHATSAPP_PHONE_ID');
    }

    public function sendMessage($to, $message)
    {
        $url = "https://graph.facebook.com/v22.0/{$this->phoneNumberId}/messages";

        $response = Http::withToken($this->token)->post($url, [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => ['body' => $message],
        ]);

        //dd($url);

        return $response->json();
    }
}
