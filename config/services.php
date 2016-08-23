<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => 'pk_test_u1rzoofoIjrheKfwT8xcmAaj',
        'secret' => 'sk_test_oZ04cQGpXNXlDg2XUuvDDle0',
    ],
    'paypal' => [

        'client_id' => 'AYq68ODDCcUXBtHkw_WDIm0Zt3FtNSk3bkzdFVvpPWpywj5FfuxuEq-Q-9iiPJB6GDjm7m6vh6H5QBfz',

        'secret' => 'EOvH2tybpNLik_huHPRoWoDQ_VYq7bfBiIOd172Q2tsoJ5SUe19flyCrXMGIMgPjYbWPdQ7ZEz7EBSNR'

    ],
];
