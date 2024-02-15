<?php

namespace App\Http\Controllers;

use App\Models\LineInformation;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LineNotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_line = LineInformation::where('user_id', $user->id)->first();
        return view('line.index', compact('user_line'));
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
        try {
            $response = $client->post('https://api.line.me/oauth2/v2.1/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $request['code'],
                    'redirect_uri' => config('services.line_login.redirect'),
                    'client_id' => config('services.line_login.client_id'),
                    'client_secret' => config('services.line_login.client_secret')
                ]
            ]);
        } catch (GuzzleException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return json_decode($response->getBody()->getContents(), false)->access_token;
    }

    public function getProfile($accessToken)
    {
        $client = new Client();
        try {
            $response = $client->get('https://api.line.me/v2/profile', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken
                ]
            ]);
        } catch (GuzzleException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return json_decode($response->getBody()->getContents(), false);
    }

    public function callback(Request $request)
    {
        $accessToken = $this->getAccessToken($request);
        $profile = $this->getProfile($accessToken);

        if (LineInformation::where('line_user_id', $profile->userId)->exists()) {
            $user_line = LineInformation::where('line_user_id', $profile->userId)->first();
            return redirect(route('line.index'))->with(compact('user_line'));
        }

        $lineInformation = new LineInformation();
        $lineInformation->line_user_id = $profile->userId;
        $lineInformation->line_user_name = $profile->displayName;
        $lineInformation->line_user_picture = $profile->pictureUrl;
        $lineInformation->user_id = Auth::id();
        $lineInformation->save();

        $user_line = LineInformation::where('line_user_id', $profile->userId)->first();

        return redirect(route('line.index'))->with(compact('user_line'));
    }

    public function lineLogout()
    {
        $user = Auth::user();
        $line = LineInformation::where('user_id', $user->id)->first();
        $line->delete();
        return redirect(route('line.index'));
    }
}
