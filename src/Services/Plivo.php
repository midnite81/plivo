<?php

namespace Midnite81\Plivo\Services;

use Plivo\RestAPI as PlivoClass;
use Plivo\PlivoError;

class Plivo extends PlivoClass
{

    protected $auth_id; 
    
    protected $auth_token; 
    
    protected $url; 
    
    protected $api; 
    
    protected $version; 

    /**
     * Plivo constructor.
     * This is an extra layer to support dependency injection.
     */
    public function __construct()
    {
        $this->auth_id = config('plivo.auth-id');
        $this->auth_token = config('plivo.auth-token');
        $this->url = config('plivo.api-url');
        $this->version = config('plivo.api-version');
        $this->api = $this->url."/".$this->version."/Account/".$this->auth_id;

        parent::__construct($this->auth_id, $this->auth_token, $this->url, $this->version);
    }
}



