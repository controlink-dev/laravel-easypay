<?php

namespace Controlink\LaravelEasypay\Facades;

use Controlink\LaravelEasypay\Http\Controllers\EasypayConfigurationController;
use Controlink\LaravelEasypay\Services\EasypayPayByLinkService;
use Controlink\LaravelEasypay\Services\EasypayService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Controlink\LaravelEasypay\Http\Controllers\EasypayConfigurationController config()
 * @method static \Controlink\LaravelEasypay\Services\EasypayPayByLinkService payByLink()
 */
class Easypay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'easypay';
    }
}