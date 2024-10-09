<?php

namespace Controlink\LaravelArpoone\Models;

use Illuminate\Database\Eloquent\Model;

class EasypayCommunicationChannel extends Model
{
    protected $table = 'easypay_communication_channels';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID

    protected $fillable = [
        'easypay_pay_by_link_id',
        'channel',
    ];

    public function payByLink()
    {
        return $this->belongsTo(EasypayPayByLink::class);
    }
}
