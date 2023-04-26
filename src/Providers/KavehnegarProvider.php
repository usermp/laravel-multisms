<?php

namespace Usermp\MultiSms\Providers;

use Usermp\MultiSms\Contracts\SmsProviderInterface;
use Usermp\MultiSms\Exceptions\SmsException;
use Usermp\MultiSms\Utils\HttpClient;

class KavehnegarProvider implements SmsProviderInterface
{
    protected $httpClient;
    protected $config;
    protected $down = false;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClient([
            'base_uri' => 'https://api.kavenegar.com/v1/',
            'timeout' => 10,
            'headers' => [
                'apikey' => $this->config['api_key'],
            ],
        ]);
    }

    public function sendMessage($to, $message)
    {
        if ($this->down) {
            throw new SmsException('Provider is down');
        }

        $response = $this->httpClient->request('GET', 'sms/send.json', [
            'query' => [
                'receptor' => $to,
                'message' => $message,
                'sender' => $this->config['sender'],
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = json_decode($response->getBody(), true);

        if ($statusCode != 200 || $content['return']['status'] != 200) {
            $this->setDown();
            throw new SmsException($content['return']['message']);
        }

        return $content['entries'];
    }

    public function setDown()
    {
        $this->down = false;
    }
}