<?php

return [

    /*
     * Set the default API url
     */
    'api-url' => 'https://api.plivo.com',

    /*
     * Set the default API version
     */
    'api-version' => 'v1',

    /*
     * Set the auth ID from the .env file, or set it here.
     */
    'auth-id' => env('PLIVO_AUTH_ID', null),

    /*
     * Set the Auth Token from the .env file, or set it here.
     */
    'auth-token' => env('PLIVO_AUTH_TOKEN', null),

    /*
     * Set your SMS source number from the .env file, or set it here.
     */
    'source-number' => env('PLIVO_SOURCE_NUMBER', null),


];

