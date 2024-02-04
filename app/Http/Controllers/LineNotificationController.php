<?php

namespace App\Http\Controllers;

use App\Models\LineInformation;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use LINE\Clients\MessagingApi;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\ApiException;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;


class LineNotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_line = LineInformation::where('user_id', $user->id)->first();
        return view('line.index', compact('user_line'));
    }

    // USER IDからLINEにメッセージを送る
    public function sendMessage(Request $request, $line_user_id, $broadcast_message)
    {
        $replyToken = $request->input('events.0.replyToken');
        $text = $request->input('events.0.message.text');

        // typeがtextの時のみしか返信できない。
        $client = new Client();
        $config = new Configuration();
        $config->setAccessToken(config('services.line_message_api.access_token'));
        $messagingApi = new MessagingApiApi(
            client: $client,
            config: $config,
        );

        $message = new TextMessage(['type' => 'text', 'text' => $broadcast_message]);
        $data = new PushMessageRequest([
            'to' => $line_user_id,
            'messages' => [$message],
        ]);

        try {
            $messagingApi->pushMessage($data);
            // Success
        } catch (ApiException $e) {
            // Failed
            $res = $e->getCode() . ' ' . $e->getResponseBody();
            return response()->json(['error' => $res], 500);
        }
        return response()->json(['message' => 'success'], 200);
    }

    public function repeatMessage(Request $request)
    {
        $replyToken = $request->input('events.0.replyToken');
        $text = $request->input('events.0.message.text');

        // typeがtextの時のみしか返信できない。
        $client = new Client();
        $config = new Configuration();
        $config->setAccessToken(config('services.line_message_api.access_token'));
        $messagingApi = new MessagingApiApi(
            client: $client,
            config: $config,
        );

        $message = new TextMessage(['type' => 'text', 'text' => $text]);
        $data = new ReplyMessageRequest([
            'replyToken' => $replyToken,
            'messages' => [$message],
        ]);

        try {
            $messagingApi->pushMessage($data);
            // Success
        } catch (ApiException $e) {
            // Failed
            $res = $e->getCode() . ' ' . $e->getResponseBody();
            return response()->json(['error' => $res], 500);
        }
        return response()->json(['message' => 'success'], 200);
    }

    public function lineLogin()
    {
        $state = Str::random(32);
        $nonce = Str::random(32);

        $uri = "https://access.line.me/oauth2/v2.1/authorize?";
        $response_type = "response_type=code";
        $client_id = "&client_id=" . config('services.line_login.client_id');
        $redirect_uri = "&redirect_uri=" . config('services.line_login.redirect');
        $state_uri = "&state=" . $state;
        $scope = "&scope=openid%20profile";
        $prompt = "&prompt=consent";
        $nonce_uri = "&nonce=" . $nonce;

        $uri = $uri . $response_type . $client_id . $redirect_uri . $state_uri . $scope . $prompt . $nonce_uri;

        return redirect($uri);
    }

    public function getAccessToken(Request $request)
    {
        $client = new Client();
        $response = $client->post('https://api.line.me/oauth2/v2.1/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $request['code'],
                'redirect_uri' => config('services.line_login.redirect'),
                'client_id' => config('services.line_login.client_id'),
                'client_secret' => config('services.line_login.client_secret')
            ]
        ]);

        return json_decode($response->getBody()->getContents(), false)->access_token;
    }

    public function getProfile($accessToken)
    {
        $client = new Client();
        $response = $client->get('https://api.line.me/v2/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        return json_decode($response->getBody()->getContents(), false);
    }

    public function callback(Request $request)
    {
        // リダイレクト先はローカルホストにしておく。TODO: デプロイ時に変更
        $accessToken = $this->getAccessToken($request);
        $profile = $this->getProfile($accessToken);

        if (LineInformation::where('line_user_id', $profile->userId)->exists()) {
            $user_line = LineInformation::where('line_user_id', $profile->userId)->first();
            return redirect('http://localhost:8080/line')->with(compact('user_line'));
        }

        $lineInformation = new LineInformation();
        $lineInformation->line_user_id = $profile->userId;
        $lineInformation->line_user_name = $profile->displayName;
        $lineInformation->line_user_picture = $profile->pictureUrl;
        $lineInformation->user_id = Auth::id();
        $lineInformation->save();

        $user_line = LineInformation::where('line_user_id', $profile->userId)->first();

        return redirect('http://localhost:8080/line')->with(compact('user_line'));
    }
}