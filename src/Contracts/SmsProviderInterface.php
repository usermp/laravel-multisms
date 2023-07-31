<?php

namespace Usermp\MultiSms\Contracts;

use Usermp\MultiSms\Exceptions\SmsException;

interface SmsProviderInterface
{
    public function sendMessage(string|int $number, string $message);
}