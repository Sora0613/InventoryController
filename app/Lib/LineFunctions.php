<?php

namespace App\Lib;

use GuzzleHttp\Client;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\ApiException;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;

class LineFunctions
{
    // USER IDからLINEにメッセージを送る
    public function sendMessage($line_user_id, $text)
    {
        $client = new Client();
        $config = new Configuration();
        $config->setAccessToken(config('services.line_message_api.access_token'));
        $messagingApi = new MessagingApiApi(
            client: $client,
            config: $config,
        );

        $message = new TextMessage(['type' => 'text', 'text' => $text]);
        $data = new PushMessageRequest([
            'to' => $line_user_id,
            'messages' => [$message],
        ]);

        try {
            $messagingApi->pushMessage($data);
        } catch (ApiException $e) {
            $res = $e->getCode() . ' ' . $e->getResponseBody();
            return response()->json(['error' => $res], 500);
        }
        return response()->json(['message' => 'success'], 200);
    }
}
