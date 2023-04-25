<?php

namespace Usermp\MultiSms\Contracts;

use Usermp\MultiSms\Exceptions\SmsException;

interface SmsProviderInterface
{
    /**
     * Send a text message.
     *
     * @param string $to
     * @param string $text
     * @param string|null $from
     * @return bool|SmsException
     * @throws SmsException
     */
    public function send(string $to, string $text, string $from = null): bool|SmsException ;

    /**
     * Get the provider name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the provider configuration.
     *
     * @return array
     */
    public function getConfig(): array;

}