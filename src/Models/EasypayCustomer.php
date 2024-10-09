<?php

namespace Controlink\LaravelArpoone\Models;

use Illuminate\Database\Eloquent\Model;

class EasypayCustomer extends Model
{
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
