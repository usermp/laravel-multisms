<?php

namespace Usermp\MultiSms\Utils;

use GuzzleHttp\Client;

class HttpClient
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function request($method, $url, $options = [])
    {
        try {
            $response = $this->client->request($method, $url, $options);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            throw new \Exception("HTTP request failed: " . $e->getMessage());
        }
    }
}