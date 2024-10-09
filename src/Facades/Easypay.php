<?php

namespace Controlink\LaravelEasypay\Facades;

use Controlink\LaravelEasypay\Http\Controllers\EasypayConfigurationController;
use Controlink\LaravelEasypay\Services\EasypayPayByLinkService;
use Controlink\LaravelEasypay\Services\EasypayService;
use Illuminate\Support\Facades\Facade;

class Easypay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'easypay';
    }
}