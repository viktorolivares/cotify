<?php

namespace App\Http\Services;

use App\Models\Catalogs\Configuration;
use GuzzleHttp\Client;


class PeruConsult
{
    public static function service($type, $number)
    {
        $configuration = Configuration::first();
        $token = $configuration->token_api;
        $url = $configuration->url_api;

        $client = new Client(['base_uri' => $url, 'verify' => false]);
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json',
            ],
        ];

        $res = $client->request('GET', '/api/'.$type.'/'.$number, $parameters);
        $response = json_decode($res->getBody()->getContents(), true);

        return $response;
    }
}
