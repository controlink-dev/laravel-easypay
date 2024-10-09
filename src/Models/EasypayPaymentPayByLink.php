<?php

namespace Controlink\LaravelArpoone\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EasypayPaymentPayByLink extends Model
{
    Use HasUuids;

    protected $table = 'easypay_payments_pay_by_link';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID


}
