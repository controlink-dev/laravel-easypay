<?php

namespace Controlink\LaravelEasypay\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EasypayCustomer extends Model
{
    use HasUuids;

    protected $table = 'easypay_customers';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID

    protected $fillable = [
        'id',        // UUID
        'name',      // Customer name
        'email',     // Customer email
        'phone',     // Customer phone number
        'language',  // Customer language (e.g., "PT")
    ];

    public function payByLinks()
    {
        return $this->belongsTo(EasypayPayByLink::class);
    }
}
