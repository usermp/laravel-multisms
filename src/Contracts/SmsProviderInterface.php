<?php

namespace Usermp\MultiSms\Contracts;

use Usermp\MultiSms\Exceptions\SmsException;

interface SmsProviderInterface
{
    public function sendMessage(mixed $number, string $message);
}