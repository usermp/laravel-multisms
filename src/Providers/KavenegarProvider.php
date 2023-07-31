<?php

namespace Usermp\MultiSms\Providers;

use Usermp\MultiSms\Contracts\SmsProviderInterface;
use Usermp\MultiSms\Exceptions\SmsException;
use Usermp\MultiSms\Utils\HttpClient;

class KavenegarProvider implements SmsProviderInterface
{
    protected HttpClient $httpClient;
    protected array $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->httpClient = new HttpClient([
            'base_uri' => 'https://api.kavenegar.com/v1/',
            'timeout' => 10,
            'headers' => [
                'apikey' => $this->config['api_key'],
                'Accept: application/json',
                'charset: utf-8'
            ],
        ]);
    }

    /**
     * @param string|int $number
     * @param string $message
     * @return mixed
     * @throws SmsException
     */
    public function sendMessage(string|int $number, string $message): mixed
    {
        $response = $this->httpClient->request('GET', 'sms/send.json', [
            'query' => [
                'receptor' => $number,
                'message' => $message,
                'sender' => $this->config['sender'],
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $content = json_decode($response->getBody(), true);

        if ($statusCode != 200 || $content['return']['status'] != 200) {
            throw new SmsException($content['return']['message']);
        }
        return $content['entries'];
    }
}