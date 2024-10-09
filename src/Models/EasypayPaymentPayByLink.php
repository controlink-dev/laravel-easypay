<?php

namespace Controlink\LaravelEasypay\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EasypayPaymentPayByLink extends Model
{
    Use HasUuids;

    protected $table = 'easypay_payments_pay_by_link';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID
    protected $fillable = [
        'id',                          // UUID
        'expiration_time',              // Payment expiration time
        'methods',                      // Payment methods (e.g., "MBW")
        'capture_descriptive',          // Capture descriptive field
        'capture_key',                  // Capture key
        'single_requested_amount',      // Single payment requested amount
        'frequent_minimum_amount',      // Minimum amount for frequent payments
        'frequent_maximum_amount',      // Maximum amount for frequent payments
        'frequent_unlimited_payments',  // Whether unlimited frequent payments are allowed
        'subscription_frequency',       // Subscription payment frequency
        'subscription_maximum_captures',// Maximum captures for subscription
        'subscription_start_time',      // Subscription start time
        'subscription_capture_now',     // Whether to capture immediately
        'subscription_retries',         // Number of retries allowed
        'subscription_failover',        // Whether failover is enabled
    ];
    public function payByLink()
    {
        return $this->belongsTo(EasypayPayByLink::class);
    }
}
