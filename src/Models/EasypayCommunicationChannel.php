<?php

namespace Controlink\LaravelArpoone\Models;

use Illuminate\Database\Eloquent\Model;

class EasypayPayByLink extends Model
{
    protected $table;
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID

    public function __construct(array $attributes = [])
    {
        // Set the table name dynamically from the config
        $this->table = config('easypay.table_name', 'easypay_pay_by_link');

        // Call the parent constructor
        parent::__construct($attributes);
    }

    public function customer()
    {
        return $this->belongsTo(EasypayCustomer::class);
    }

    public function payment()
    {
        return $this->belongsTo(EasypayPayment::class);
    }

    public function communicationChannels()
    {
        return $this->hasMany(EasypayCommunicationChannel::class);
    }
}
