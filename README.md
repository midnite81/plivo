# Plivo [![Latest Stable Version](https://poser.pugx.org/midnite81/plivo/version)](https://packagist.org/packages/midnite81/plivo) [![Total Downloads](https://poser.pugx.org/midnite81/plivo/downloads)](https://packagist.org/packages/midnite81/plivo) [![Latest Unstable Version](https://poser.pugx.org/midnite81/plivo/v/unstable)](https://packagist.org/packages/midnite81/plivo) [![License](https://poser.pugx.org/midnite81/plivo/license.svg)](https://packagist.org/packages/midnite81/plivo)
A Plivo SMS integration for Laravel

#Installation

This package requires PHP 5.6+, and includes a Laravel 5 Service Provider and Facade.

To install through composer include the package in your `composer.json`.

    "midnite81/plivo": "0.1.*"

Run `composer install` or `composer update` to download the dependencies or you can run `composer require midnite81/plivo`.

## Refresh Autoloader

At this point some users may need to run the command `composer dump-autoload`. Alternatively, you can run `php artisan optimize`
which should include the dump-autoload command.

##Laravel 5 Integration

To use the package with Laravel 5 firstly add the Messaging service provider to the list of service providers 
in `app/config/app.php`.

    'providers' => [

      Midnite81\Plivo\MessagingServiceProvider::class
              
    ];
    
Add the `Messaging` facade to your aliases array.

    'aliases' => [

      'Messaging' => Midnite81\Plivo\Facades\Messaging::class,
      
    ];
    
Publish the config and migration files using 
`php artisan vendor:publish --provider="Midnite81\Plivo\MessagingServiceProvider"`

To access Plivo/Messaging you can either use the Facade or the Messaging instance is bound to the IOC container and you can 
then dependency inject it via its contract.


    Messaging::get('foo');
    
    public function __construct(Midnite81\Plivo\Contracts\Services\Messaging $messaging)
    {
        $this->messaging = $messaging;
    }
    
#Configuration File

Once you have published the config files, you will find a `Plivo.php` file in the `config` folder. You should 
look through these settings and update these where necessary. 

# Env

You will need to add the following to your `.env` file and update these with your own settings

    PLIVO_AUTH_ID=<auth_id>
    PLIVO_AUTH_TOKEN=<auth_token>
    PLIVO_SOURCE_NUMBER=<default_sms_number>

# Example Usage

    use Midnite81\Plivo\Contracts\Services\Messaging;
    
    public function sendMessage(Messaging $messaging) 
    {
        $msg = $messaging->msg('Hello World!')->to('0123456789')->sendMessage(); 
    }
