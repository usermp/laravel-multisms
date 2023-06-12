<?php

return [
    'default' => env('MULTISMS_DEFAULT_PROVIDER', 'kavenegar'),

    'providers' => [
        'kavenegar' => [
            'class' => \Usermp\MultiSms\Providers\KavehnegarProvider::class,
            'config' => [
                'apikey' => env('KAVENEGAR_API_KEY'),
                'linenumber' => env('KAVENEGAR_LINE_NUMBER'),
            ]
        ],
        'smsir' => [
            'class' => \Usermp\MultiSms\Providers\SmsIrProvider::class,
            'config' => [
                'apikey' => env('SMSIR_API_KEY'),
                'secretkey' => env('SMSIR_SECRET_KEY'),
                'linenumber' => env('SMSIR_LINE_NUMBER'),
            ]
        ]
    ]
];