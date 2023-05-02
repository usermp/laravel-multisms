Laravel Multisms
================

Laravel Multisms is a Laravel package for sending SMS messages using multiple SMS providers.

Installation
------------

You can install the package using Composer:

    composer require usermp/laravel-multisms

open your config/app.php and add this line in providers section

    Usermp\MultiSms\MultiSmsServiceProvider::class

Publish the configuration file:

    php artisan vendor:publish --provider="Usermp\MultiSms\MultiSmsServiceProvider" --tag="config"

Update the `config/multisms.php` file with your SMS provider settings.

Usage
-----

You can use the `MultiSms` facade to send SMS messages:

    use Usermp\MultiSms\Facades\MultiSms;
    
    MultiSms::to('09123456789')->send('Hello, World!');

By default, the package will use the first SMS provider specified in the `config/multisms.php` file. If that provider fails to send the SMS message, the package will automatically try the next provider until the message is sent successfully.

You can also specify the SMS provider to use by calling the `via` method on the `MultiSms` facade:

    MultiSms::via('smsir')->to('09123456789')->send('Hello, World!');

In this example, the `via` method specifies that the SMS message should be sent using the `smsir` provider.

Supported Providers
-------------------

Laravel Multisms currently supports the following SMS providers:

*   Sms.ir
*   KavehNegar
*   Ghasedak

You can add more providers by implementing the `SmsProviderInterface` interface and adding the provider to the `config/multisms.php` file.

License
-------

Laravel Multisms is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).