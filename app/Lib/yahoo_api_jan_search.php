<?php

namespace App\Lib;

class yahoo_api_jan_search
{
    public function search($jan)
    {
        $url = "https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid=" . config('services.yahoo_api.client_id') ."&jan_code=" . $jan;
        $json = file_get_contents($url);
        return json_decode($json, true);
    }
}
