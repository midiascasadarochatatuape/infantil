<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function index(Request $request){
        return view('notifications/whatsapp');
    }

    public function sendNotification(Request $request)
    {
        $phoneNumber = $request->input('phone');
        $token = env('WHATSAPP_ACCESS_TOKEN');
        $phoneId = "105184862680716"; // Update this with your correct Phone ID

        try {
            $formattedPhone = preg_replace('/[^0-9]/', '', $phoneNumber);
            if (!str_starts_with($formattedPhone, '55')) {
                $formattedPhone = '55' . $formattedPhone;
            }

            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $formattedPhone,
                'type' => 'template',
                'template' => [
                    'name' => 'notificacao_cliente',
                    'language' => ['code' => 'pt_BR'],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [
                                ['type' => 'text', 'text' => 'João'],
                                ['type' => 'text', 'text' => '10/04/2025']
                            ]
                        ]
                    ]
                ]
            ];

            \Log::info('WhatsApp API Request:', [
                'phoneId' => $phoneId,
                'payload' => $payload,
                'token_exists' => !empty($token)
            ]);

            $response = Http::withHeaders([
                'Authorization' => "Bearer $token",
                'Content-Type' => 'application/json',
            ])->post("https://graph.facebook.com/v17.0/$phoneId/messages", $payload);

            $responseData = $response->json();
            \Log::info('WhatsApp API Response:', $responseData);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Failed to send notification',
                    'details' => $responseData
                ], $response->status());
            }

            return response()->json($responseData);
        } catch (\Exception $e) {
            \Log::error('WhatsApp Exception:', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Failed to send notification',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function sendMessage()
    {

        //$token = env('WHATSAPP_ACCESS_TOKEN');
        //$phoneId = env('WHATSAPP_PHONE_ID');

        $url = "https://graph.facebook.com/v22.0/605184862680716/messages";

        $token = "EAAYQPsSiSjcBO0QltdDSdUFEZCt1ECqezErEQ1J3u41lKZAc6FT4SHgHy5O8UfI9fWHiiuKZBytUbvx4HPcoOQbRFDoWAXjZCg4n3DOIe0ZCwSytOQpptSAiEoIrKF3SyOJgWke1VRcnYLLD2Wa50whIpAkwSC3BY0eHUsr2e6gVvSLjhRWyOIN2l8vTkHFUEMBU63pKoESRTJi0CD8Juh9uWX60ZD";

        $response = Http::withHeaders([
            "Authorization" => "Bearer $token",
            "Content-Type" => "application/json",
        ])->post($url, [
            "messaging_product" => "whatsapp",
            "to" => "5511987624996",
            "type" => "template",
            "template" => [
                "name" => "notificacao_cliente",
                "language" => ["code" => "pt_BR"],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            ["type" => "text", "text" => "João"],
                            ["type" => "text", "text" => "10/04/2025"]
                        ]
                    ]
                ]
            ]
        ]);

        return response()->json($response->json());
    }
}
