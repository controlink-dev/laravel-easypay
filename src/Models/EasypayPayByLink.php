<?php

namespace Controlink\LaravelArpoone\Models;

use Illuminate\Database\Eloquent\Model;

class EasypayPayByLink extends Model
{
    protected $table = 'easypay_pay_by_link';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID

    public function customer()
    {
        return $this->hasOne(EasypayCustomer::class);
    }

    public function payment()
    {
        return $this->HasOne(EasypayPaymentPayByLink::class);
    }

    public function communicationChannels()
    {
        return $this->hasMany(EasypayCommunicationChannel::class);
    }
}
