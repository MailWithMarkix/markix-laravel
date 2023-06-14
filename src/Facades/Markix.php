<?php

namespace Markix\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Markix extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'markix';
    }
}
