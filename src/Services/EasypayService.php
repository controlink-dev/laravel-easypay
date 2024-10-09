<?php

namespace Controlink\LaravelEasypay\Services;

use Controlink\LaravelEasypay\Http\Controllers\EasypayConfigurationController;

class EasypayService
{
    protected $configController;
    protected $payByLinkService;

    public function __construct(EasypayConfigurationController $configController, EasypayPayByLinkService $payByLinkService)
    {
        $this->configController = $configController;
        $this->payByLinkService = $payByLinkService;
    }

    public function config()
    {
        return $this->configController;
    }

    public function payByLink()
    {
        return $this->payByLinkService;
    }
}
