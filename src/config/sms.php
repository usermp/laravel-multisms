<?php

return [
    'default' => env('MULTISMS_DEFAULT_PROVIDER', 'kavenegar'),

    'providers' => [
        'kavenegar' => [
            'class' => \Usermp\MultiSms\Providers\KavehnegarProvider::class,
            'config' => [
                'api_key'    => env('KAVENEGAR_API_KEY'),
                'secret_key' => env('KAVENEGAR_SECRET_KEY'),
                'template_Id'=> env('KAVENEGAR_TEMPLATE_ID'),
            ]
        ]
    ]
];