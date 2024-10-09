<?php

namespace Controlink\LaravelArpoone\Models;

use Illuminate\Database\Eloquent\Model;

class EasypayConfiguration extends Model
{
    protected $table;
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        // Set the table name dynamically from the config
        $this->table = config('arpoone.table_name', 'easypay_configuration');

        $this->fillable = [
            'url',
            'api_key',
            'account_id',
            'verify_ssl',
            config('arpoone.tenant_column_name', 'tenant_id')
        ];

        // Call the parent constructor
        parent::__construct($attributes);
    }

    protected $casts = [
        'verify_ssl' => 'boolean'
    ];


    public function tenant()
    {
        if (config('easypay.use_tenant_column', false)) {
            $tenantModel = config('easypay.tenant_model', null);
            $tenantColumn = config('easypay.tenant_column_name', 'tenant_id');

            return $tenantModel ? $this->belongsTo($tenantModel, $tenantColumn) : null;
        }

        throw new \Exception('Multi-tenant mode is not enabled in the Easypay configuration.');
    }
}
