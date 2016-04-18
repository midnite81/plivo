<?php
namespace Midnite81\Plivo\Facades;

use Illuminate\Support\Facades\Facade;

class Messaging extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'midnite81.plivo'; }
}