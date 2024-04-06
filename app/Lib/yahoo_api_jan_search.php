<?php

namespace App\Lib;

class yahoo_api_jan_search
{
    public function search($jan)
    {
        try {
            $url = "https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid=" . config('services.yahoo_api.client_id') ."&jan_code=" . $jan;
            $json = file_get_contents($url, false, stream_context_create(['http' => ['ignore_errors' => true]]));
            $response = json_decode($json, true);

            $statusCode = $this->getHttpStatusCode($http_response_header);

            if ($statusCode >= 400) {
                return null;
            }

            return $response;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getHttpStatusCode($http_response_header)
    {
        if(is_array($http_response_header)){
            $parts = explode(' ', $http_response_header[0]);
            if(count($parts) > 1) {
                return (int)$parts[1];
            }
        }
        return 0;
    }
}
