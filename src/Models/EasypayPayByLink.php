<?php

namespace Controlink\LaravelEasypay\Models;

use Illuminate\Database\Eloquent\Model;

class EasypayPayByLink extends Model
{
    protected $table = 'easypay_pay_by_link';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID

    protected $fillable = [
        'id',                      // UUID for the payment link
        'expiration_time',          // Expiration time of the payment link
        'type',                    // Type of the payment (e.g., SINGLE, RECURRING)
        'easypay_customer_id',              // Foreign key to the Customer table
        'easypay_payment_id',               // Foreign key to the Payment table
        'url',                     // Payment link URL
        'image',                   // QR code or image URL for the payment
        'status'                   // Status of the payment link (e.g., ACTIVE, EXPIRED)
    ];

    public function customer()
    {
        return $this->belongsTo(EasypayCustomer::class);
    }

    public function payment()
    {
        return $this->belongsTo(EasypayPaymentPayByLink::class);
    }

    public function communicationChannels()
    {
        return $this->hasMany(EasypayCommunicationChannel::class);
    }
}
