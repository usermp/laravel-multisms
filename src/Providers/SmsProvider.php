<?php

namespace Usermp\MultiSms\Providers;

use Usermp\MultiSms\Contracts\SmsProviderInterface;
use Usermp\MultiSms\Exceptions\SmsException;

class SmsProvider implements SmsProviderInterface
{
    protected string $name;
    protected array $config;

    public function __construct($name, $config)
    {
        $this->name = $name;
        $this->config = $config;
    }

    public function send($to, $text, $from = null) : bool|SmsException
    {
        throw new SmsException('This method should be implemented in a child class.');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}