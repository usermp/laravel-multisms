<?php

namespace Usermp\MultiSms\Facades;

use Illuminate\Support\Facades\Facade;

class MultiSms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'multisms';
    }
}