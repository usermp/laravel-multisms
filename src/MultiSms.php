<?php

namespace Usermp\MultiSms;

use Exception;
use Illuminate\Support\Facades\Log;
use Usermp\MultiSms\Exceptions\SmsException;

class MultiSms
{
    private $config;
    private $providers;

    public function __construct()
    {
        $this->config = config('Multisms');
        $this->providers = config('Multisms.providers');
    }

    /**
     * Send an SMS message.
     *
     * @param string $to
     * @param string $message
     * @return bool
     * @throws SmsException
     */
    public function send(string $to, string $message): bool
    {
        $defaultProvider = $this->config['default_provider'];

        // If there is no default provider set or the provider is not available, throw an exception.
        if (!$defaultProvider || !isset($this->providers[$defaultProvider])) {
            throw new SmsException('Default provider is not available.');
        }

        $providers = $this->providers;

        // Shuffle providers to randomize the order of attempts.
        // shuffle($providers);

        foreach ($providers as $providerName => $provider) {
            if (!isset($provider['class'])) {
                throw new SmsException('SMS provider class not defined.');
            }

            $providerClass = $provider['class'];

            if (!class_exists($providerClass)) {
                throw new SmsException('SMS provider class not found.');
            }

            if (!isset($provider['config'])) {
                throw new SmsException('SMS provider config not defined.');
            }

            $providerConfig = $provider['config'];

            try {
                $sms = new $providerClass($providerConfig);

                $response = $sms->send($to, $message);

                if ($response) {
                    return true;
                }
            } catch (Exception $e) {
                Log::error('Error sending SMS through provider ' . $providerName . ': ' . $e->getMessage());
            }
        }

        throw new SmsException('Could not send SMS through any provider.');
    }
}