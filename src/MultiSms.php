<?php

namespace Usermp\MultiSms;

use Illuminate\Support\Facades\Config;
use Usermp\MultiSms\Exceptions\SmsException;
use Usermp\MultiSms\Contracts\SmsProviderInterface;

class MultiSms
{
    protected SmsProviderInterface $provider;
    protected array $providers;
    protected string $defaultProviderName;

    public function __construct()
    {
        $this->providers = Config::get('multisms.providers');
        $this->defaultProviderName = Config::get('multisms.default');
        $this->setProvider($this->defaultProviderName);
    }

    public function via(string $providerName): MultiSms
    {
        $this->setProvider($providerName);
        return $this;
    }

    public function to(array $numbers, string $message): void
    {
        $errors = [];
        foreach ($numbers as $number) {
            try {
                $this->provider->sendMessage($number, $message);
            } catch (SmsException $e) {
                $errors[] = $e->getMessage();
                $this->setProviderDown($this->provider);
            }
        }

        if (count($errors) > 0) {
            throw new SmsException(implode(PHP_EOL, $errors));
        }
    }

    protected function setProvider(string $providerName): void
    {
        $provider = $this->providers[$providerName];
        $className = $provider['class'];
        $this->provider = new $className($provider['config']);
    }

    protected function setProviderDown(SmsProviderInterface $provider): void
    {
        if (method_exists($provider, 'setDown')) {
            $provider->setDown();
        }
    }
}